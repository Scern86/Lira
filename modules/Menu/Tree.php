<?php
namespace Modules\Menu;
defined('_DEXEC') or DIE;

class Tree
{
    protected $id;
    protected $title;
    protected $link;
    protected $target;
    protected $level;
    protected $template;
    protected $childs = [];
    protected $css_id;
    protected $module;

    public function __construct($params)
    {
        $db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
        $user = \Scern\Lira\Core\User::getInstance();
        $this->id = $params['id'];
        $link = new \Scern\Lira\Classes\Object($this->id);
        foreach ($link->access as $item) {
            $access[] = $item['id'];
        }
        if (in_array($user->getUser()->id, $access) OR in_array('efec8802f9a4fe29f344', $access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5', $access))) {
            $this->title = $db->getOne('SELECT `title` FROM ?n WHERE `id`=?s', TBL_OBJECT, $this->id);
            $this->level = $params['level'];
            $this->template = $params['template'];
            $this->css_id = $params['css_id'];
            $this->module = $params['module'];
            $this->link = $db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_STRING, $this->id, 'link');
            $this->target = $db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s', TBL_EXT_STRING, $this->id, 'target');
            $childs = $db->getAll('SELECT eo.* FROM ?n eo,?n ft,?n t WHERE eo.`id_object_parent`=?s AND eo.`id_object_child`=ft.`id_object` AND ft.`id_tag`=t.`id` AND eo.`definition`=?s AND ft.`definition`=?s AND t.`title`=?s ORDER BY eo.`order`',TBL_EXT_OBJECT, TBL_EXT_TAG, TBL_TAG, $this->id, 'attachment', 'type', 'Ссылка');
            $next_level = $this->level+1;
            if (!empty($childs)) foreach ($childs as $item) {
                $child_params = [
                    'id'=>$item['id_object_child'],
                    'level'=>$next_level,
                    'css_id'=>'',
                    'template'=>$this->template,
                ];
                $this->childs[$item['order'].rand(100,999)] = new Tree($child_params);
            }
        }
    }
    public function __get($key)
    {
        if (isset($this->$key)) return $this->$key;
        return false;
    }
    public function render()
    {
        return \Scern\Lira\Helpers\Render::render('modules'.DS.'Menu'.DS.'templates', $this->template, ['main'=>$this]);
    }
}