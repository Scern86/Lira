<?php
namespace Scern\Lira\Classes;

defined('_DEXEC') or DIE;

class Object
{

    protected $db;
    protected $id;
    protected $title;
    protected $created;
    protected $params = [];

    public function __construct($id)
    {
        $this->db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        $object = $this->db->getRow('SELECT * FROM ?n WHERE `id`=?s', TBL_OBJECT, $id);
        if (!empty($object)) {
            $this->id = $object['id'];
            $this->title = $object['title'];
            $this->created = $object['created'];
        }
    }
    public function __get($key)
    {
        if (isset($this->$key) AND $key<>'db') {
            return $this->$key;
        } else {
            return $this->loadField($key);
        }
    }
    public function render($template='default', $params=[])
    {
        $this->params = $params;
        if ($template == 'default') $template = array_shift($this->loadField('type'))['title'];
        return \Scern\Lira\Helpers\Render::render('templates'.DS.'objects', $template, ['main'=>$this]);
    }
///// Базовые процедуры объекта
    public static function create(array $data)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        return $db->query('INSERT INTO ?n SET `id`=?s,`title`=?s,`created`=?s', TBL_OBJECT, $data['id'], $data['title'], $data['created']);
    }
    public static function update(array $data)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        return $db->query('UPDATE ?n SET `title`=?s,`created`=?s WHERE `id`=?s', TBL_OBJECT, $data['title'], $data['created'], $data['id']);
    }
    public static function remove($id)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        return $db->query('DELETE FROM ?n WHERE `id`=?s', TBL_OBJECT, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_TAG, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_STRING, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_NUMBER, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_SHORT_TEXT, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_LONG_TEXT, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object`=?s', TBL_EXT_DATE, $id)
         AND $db->query('DELETE FROM ?n WHERE `id_object_parent`=?s OR `id_object_child`=?s', TBL_EXT_OBJECT, $id, $id);
    }
    public function isHaveTag($tag)
    {
        $result = $this->_db->getOne('SELECT t.`id` FROM ?n o,?n ft,?n t WHERE ft.`id_object`=o.`id` AND ft.`id_tag`=t.`id` AND t.`title`=?s AND o.`id`=?s', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, $tag, $this->_id);
        if ($result) return TRUE;
        return FALSE;
    }
    public static function getIdByTitle($title)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        return  $db->getOne('SELECT `id` FROM ?n WHERE `title`=?s', TBL_OBJECT, $title);
    }
///// Работа с дополнительными полями (число,строка,текст,дата)
    public static function addField($id_object, $definition, $value, $order=0, $params=null)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        $type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s', TBL_DEFINITION, $definition);
        switch ($type) {
            case 'NUMBER':
                $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?i', TBL_EXT_NUMBER, $id_object, $definition, (int)$value);
                break;
            case 'STRING':
                $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s', TBL_EXT_STRING, $id_object, $definition, trim(htmlspecialchars($value)));
                break;
            case 'DATETIME':
                $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s', TBL_EXT_DATE, $id_object, $definition, $value);
                break;
            case 'TEXT':
                $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s', TBL_EXT_SHORT_TEXT, $id_object, $definition, $value);
                break;
            case 'LONGTEXT':
                $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s', TBL_EXT_LONG_TEXT, $id_object, $definition, $value);
                break;
            case 'TAG':
                if (!empty($value)) foreach ($value as $item) {
                    $result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`id_tag`=?s,`order`=?s', TBL_EXT_TAG, $id_object, $definition, $item, $order);
                }
                break;
            case 'OBJECT':
                if (!empty($value)) foreach ($value as $item) {
                    $result = $db->query('REPLACE ?n SET `id_object_parent`=?s,`id_object_child`=?s,`definition`=?s,`order`=?i,`params`=?s', TBL_EXT_OBJECT, $id_object, $item, $definition, (int)$order, json_encode($params));
                }
                break;
        }
        return $result;
    }
    public static function editField($id_object, $definition, $value, $type, $order=0, $params=null)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        switch ($type) {
            case 'field':
                $field_type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s', TBL_DEFINITION, $definition);
                switch ($field_type) {
                    case 'NUMBER':
                        return $db->query('UPDATE ?n SET `field`=?i WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_NUMBER, (int)$value, $id_object, $definition);
                        break;
                    case 'STRING':
                        return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_STRING, trim(htmlspecialchars($value)), $id_object, $definition);
                        break;
                    case 'DATETIME':
                        return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_DATE, $value, $id_object, $definition);
                        break;
                    case 'TEXT':
                        return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_SHORT_TEXT, $value, $id_object, $definition);
                        break;
                    case 'LONGTEXT':
                        return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_LONG_TEXT, $value, $id_object, $definition);
                        break;
                }
                break;
            case 'tag':
                return $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `id_tag`=?s', TBL_EXT_TAG, $id_object, $value)
                AND $db->query('INSERT INTO ?n SET `id_object`=?s,`definition`=?s,`id_tag`=?s,`order`=?i', TBL_EXT_TAG, $id_object, $definition, $value, (int)$order);
                break;
            case 'object':
                return $db->query('INSERT INTO ?n SET `id_object_parent`=?s,`definition`=?s,`id_object_child`=?s,`order`=?i,`params`=?s', TBL_EXT_OBJECT, $id_object, $definition, $value, (int)$order, json_encode($params));
                break;
        }
    }
    public static function removeField($id_object, $definition, $field=null)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        $type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s', TBL_DEFINITION, $definition);
        switch ($type) {
            case 'NUMBER':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_NUMBER, $id_object, $definition);
                break;
            case 'STRING':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_STRING, $id_object, $definition);
                break;
            case 'DATETIME':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_DATE, $id_object, $definition);
                break;
            case 'TEXT':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_SHORT_TEXT, $id_object, $definition);
                break;
            case 'LONGTEXT':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_LONG_TEXT, $id_object, $definition);
                break;
            case 'TAG':
                $result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s AND `id_tag`=?s', TBL_EXT_TAG, $id_object, $definition, $field);
                break;
            case 'OBJECT':
                $result = $db->query('DELETE FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s', TBL_EXT_OBJECT, $id_object, $field, $definition);
                break;
        }
        return $result;
    }
    protected function loadField($key)
    {
        $type = $this->db->getOne('SELECT `type` FROM ?n WHERE `title`=?s', TBL_DEFINITION, $key);
        switch ($type) {
            case 'NUMBER':
                $result = $this->db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_NUMBER, $this->id, $key);
                break;
            case 'STRING':
                $result = $this->db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_STRING, $this->id, $key);
                break;
            case 'DATETIME':
                $result = $this->db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_DATE, $this->id, $key);
                break;
            case 'TEXT':
                $result = $this->db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_SHORT_TEXT, $this->id, $key);
                break;
            case 'LONGTEXT':
                $result = $this->db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_LONG_TEXT, $this->id, $key);
                break;
            case 'TAG':
                $result = $this->db->getAll('SELECT * FROM ?n et,?n t WHERE et.`id_tag`=t.`id` AND `id_object`=?s AND `definition`=?s ORDER BY et.`order`', TBL_EXT_TAG, TBL_TAG, $this->id, $key);
                break;
            case 'OBJECT':
                $result = $this->db->getAll('SELECT eo.`id_object_child` `id`,eo.`definition`,eo.`order`,eo.`params` FROM ?n eo,?n o WHERE eo.`id_object_child`=o.`id` AND eo.`id_object_parent`=?s AND eo.`definition`=?s ORDER BY eo.`order`,o.`title`', TBL_EXT_OBJECT, TBL_OBJECT, $this->id, $key);
                break;
        }
        return $result;
    }
}