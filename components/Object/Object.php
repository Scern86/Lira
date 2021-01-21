<?php
namespace Components\Object;
use \Scern\Lira\Helpers as Helper;
use \Scern\Lira\Core as Core;
use \Scern\Lira\Classes as Classes;
define('_DEXEC', 1);

class Object extends Classes\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->component = 'object';
        $this->path = 'components'.DS.$this->component;
        $this->text->addText(Core\Config::getInstance()->sys_lang,$this->component);
    }
    public function action()
    {
        switch($this->request->task){
            case 'ajax':
                if(in_array('object_ajax',$this->userActions)){
                    $this->ajax();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'add':
                if(in_array('object_add',$this->userActions)){
                    $this->add();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'upload':
                if(in_array('object_upload',$this->userActions)){
                    $this->upload();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'edit':
                if(in_array('object_edit',$this->userActions)){
                    $this->edit();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'remove':
                if(in_array('object_remove',$this->userActions)){
                    $this->remove();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'add_field':
                if(in_array('object_add_field',$this->userActions)){
                    $this->add_field();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'edit_field':
                if(in_array('object_edit_field',$this->userActions)){
                    $this->edit_field();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'remove_field':
                if(in_array('object_remove_field',$this->userActions)){
                    $this->remove_field();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'list':
                if(in_array('object_list',$this->userActions)){
                    $this->list();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'show':
                $this->show();
                break;
        }
    }
    protected function ajax()
    {
        switch ($this->request->act) {
            case 'load':
                $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT ?i,?i', TBL_OBJECT, (int)$this->request->post('offset'), (int)$this->request->post('limit'));
                $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
                if (!empty($tags)) foreach ($tags as $t) {
                    $tagList[$t['id_object']][] = $t['tag'];
                }
                if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                    $data['list'][$item['id']] = $item;
                    $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load', $data);
                exit();
                break;
            case 'search':
                $search = '%'.$this->request->post('search').'%';
                if (!empty($search) AND mb_strlen($search) > 2) {
                    $list = $this->db->getAll('SELECT * FROM ?n o WHERE o.`title` LIKE ?s ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT, $search);
                    $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                    if (!empty($tags)) foreach ($tags as $t) {
                        $tagList[$t['id_object']][] = $t['tag'];
                    }
                    if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                        $data['list'][$item['id']] = $item;
                        $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                    }
                } else{
                    $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT);
                    $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                    if (!empty($tags)) foreach ($tags as $t) {
                        $tagList[$t['id_object']][] = $t['tag'];
                    }
                    if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                        $data['list'][$item['id']] = $item;
                        $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                    }
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load', $data);
                exit();
                break;
            case 'load_tags':
                $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT ?i,?i', TBL_TAG, (int)$this->request->post('offset'), (int)$this->request->post('limit'));
                echo Helper\Render::render($this->path.DS.'templates','ajax_load_tags', $data);
                exit();
                break;
            case 'search_tags':
                $search = '%'.$this->request->post('search').'%';
                if (!empty($search) AND mb_strlen($search) > 2) {
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `title` LIMIT 0,50', TBL_TAG, $search);
                } else {
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50', TBL_TAG);
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load_tags', $data);
                exit();
                break;
            case 'load_objects':
                $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT ?i,?i', TBL_OBJECT, (int)$this->request->post('offset'), (int)$this->request->post('limit'));
                $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                if (!empty($tags)) foreach ($tags as $t) {
                    $tagList[$t['id_object']][] = $t['tag'];
                }
                if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                    $data['list'][$item['id']] = $item;
                    $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load_objects', $data);
                exit();
                break;
            case 'search_objects':
                $search = '%'.$this->request->post('search').'%';
                if (!empty($search) AND mb_strlen($search) >= 2) {
                    $list = $this->db->getAll('SELECT * FROM ?n o WHERE o.`title` LIKE ?s ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT, $search);
                    $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                    if (!empty($tags)) foreach ($tags as $t) {
                        $tagList[$t['id_object']][] = $t['tag'];
                    }
                    if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                        $data['list'][$item['id']] = $item;
                        $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                    }
                } else {
                    $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT);
                    $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                    if (!empty($tags)) foreach ($tags as $t) {
                        $tagList[$t['id_object']][] = $t['tag'];
                    }
                    if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                        $data['list'][$item['id']] = $item;
                        $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
                    }
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load_objects', $data);
                exit();
                break;
            case 'load_attachments':
                $data['main'] = new Classes\Object($this->request->id);
                echo Helper\Render::render('templates'.DS.'objects'.DS.'ajax', $this->request->type, $data);
                exit();
                break;
        }
    }
    protected function add()
    {
        if ($this->request->post('action')=='add') {
            $id = Helper\Generator::generateId(10);
            $data = [
                'id' => $id,
                'title' => trim(htmlspecialchars($this->request->post('title'))),
                'created' => $this->request->post('created'),
            ];
            if (Classes\Object::create($data)) {
                Classes\Object::addField($id, 'access', ['5e1cc7832dcbd43148d5'], 0);
                switch ($this->request->type) {
                    case 'save':
                        Core\Document::addHeader('Location: /?com=object&task=edit&id='.$id);
                        break;
                    case 'new':
                        Core\Document::addHeader('Location: /?com=object&task=add');
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=object&task=list');
                        break;
                }
                //Log,Notify
            } else {
                //Log,Notify
                Core\Document::addHeader('Location: /?com=object&task=list');
            }
        } else {
            Core\Document::addString('title', $this->text->add);
            $tbArray = [];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'add', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'add', $data));
        }
    }
    protected function upload()
    {
        Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'upload', null));
        if(Helper\Upload::upload(true)) {
            //Log,Notify
            Core\Document::addHeader('Location: /?com=object&task=list');
        }
    }
    protected function edit()
    {
        if ($this->request->post('action')=='edit') {
            $id = $this->request->id;
            $data = [
                'id' => $id,
                'title' => trim(htmlspecialchars($this->request->post('title'))),
                'created' => $this->request->post('created'),
            ];
            if (Classes\Object::update($data)) {
                switch ($this->request->type) {
                    case 'save':
                        Core\Document::addHeader('Location: /?com=object&task=edit&id='.$id);
                        break;
                    case 'new':
                        Core\Document::addHeader('Location: /?com=object&task=add');
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=object&task=list');
                        break;
                }
                //Log,Notify
            } else {
                //Log,Notify
                Core\Document::addHeader('Location: /?com=object&task=list');
            }
        } else {
            Core\Document::addString('title', $this->text->edit);
            $data['main'] = new Classes\Object($this->request->id);

            $number = $this->db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_NUMBER, $this->request->id);
            $string = $this->db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_STRING, $this->request->id);
            $datetime = $this->db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_DATE, $this->request->id);
            $text = $this->db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_SHORT_TEXT, $this->request->id);
            $longtext = $this->db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_LONG_TEXT, $this->request->id);
            $data['list_fields'] = array_merge($number, $string, $datetime, $text, $longtext);
            $data['fields'] = Helper\Render::render($this->path.DS.'templates', 'fields', $data);

            $data['list_tags'] = $this->db->getAll('SELECT * FROM ?n et,?n t WHERE et.`id_tag`=t.`id` AND et.`id_object`=?s ORDER BY et.`order`', TBL_EXT_TAG, TBL_TAG, $this->request->id);
            $data['tags'] = Helper\Render::render($this->path.DS.'templates', 'tags', $data);

            $data['list_objects'] = $this->db->getAll('SELECT * FROM ?n eo,?n o WHERE eo.`id_object_child`=o.id AND eo.`id_object_parent`=?s ORDER BY eo.`order` ASC', TBL_EXT_OBJECT, TBL_OBJECT, $this->request->id);
            $data['objects'] = Helper\Render::render($this->path.DS.'templates', 'objects', $data);
            $tbArray = ['id' => $this->request->id];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'edit', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit', $data));
        }
    }
    protected function remove()
    {
        if(Classes\Object::remove($this->request->id)){
            //Log,Notify
            Core\Document::addHeader('Location: /?com=object&task=list');
        } else {
            //Log,Notify
            Core\Document::addHeader('Location: /?com=object&task=list');
        }
    }
    protected function add_field()
    {
        if ($this->request->post('action') == 'add_field' OR $this->request->post('action') == 'upload') {
            if ($this->request->type == 'upload' AND !empty($_FILES['upload']['name'][0])) {
                $upload_result = Helper\Upload::upload(TRUE);
                if ($upload_result['done']) {
                    foreach ($upload_result['success'] as $file) {
                        Classes\Object::addField($this->request->id, 'attachment', [$file], 0, ['type' => 'default', 'mode' => 'medium', 'show_title' => 0]);
                    }
                }
                //Log,Notify
            } else {
                if (Classes\Object::addField($this->request->id,$this->request->post('definition'),$this->request->post('value'))) {
                    //Log,Notify
                } else {
                    //Log,Notify
                }
            }
            Core\Document::addHeader('Location: /?com=object&task=edit&id='.$this->request->id);
        } else {
            switch ($this->request->type) {
                case 'number':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'NUMBER');
                    break;
                case 'string':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'STRING');
                    break;
                case 'datetime':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'DATETIME');
                    break;
                case 'text':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'TEXT');
                    break;
                case 'longtext':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'LONGTEXT');
                    break;
                case 'tag':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'TAG');
                    $data['tags'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50', TBL_TAG);
                    break;
                case 'object':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'OBJECT');
                    $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT);
                    $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
                    if (!empty($tags)) foreach ($tags as $t) {
                        $tagList[$t['id_object']][] = $t['tag'];
                    }
                    if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
                        $data['objects'][$item['id']] = $item;
                        $data['objects'][$item['id']]['tags'][] = $tagList[$item['id']];
                    }
                    break;
                case 'upload':
                    Helper\Upload::upload(true);
                    break;
            }
            $data['id'] = $this->request->id;
            $data['type'] = $this->request->type;
            $tbArray = ['id' => $this->request->id, 'type' => $this->request->type];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'add_field', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'add_'.$this->request->type, $data));
        }
    }
    protected function edit_field()
    {
        if ($this->request->post('action') == 'edit_field') {
            switch($this->request->type) {
                case 'field':
                    $result = Classes\Object::editField($this->request->id, key($this->request->post('field')), $this->request->post('field')[key($this->request->post('field'))], $this->request->type);
                    break;
                case 'tag':
                    $result = Classes\Object::editField($this->request->id, $this->request->post('definition'), $this->request->post('field'), $this->request->type, $this->request->post('order'));
                    break;
                case 'object':
                    $result = $this->db->query('DELETE FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s', TBL_EXT_OBJECT, $this->request->id, $this->request->post('field'), $this->request->definition)
                    AND Classes\Object::editField($this->request->id, $this->request->post('definition'), $this->request->post('field'), $this->request->type, $this->request->post('order'), $this->request->post('params'));
                    break;
            }
            if ($result) {
                //Log,Notify
                Core\Document::addHeader('Location: /?com=object&task=edit&id='.$this->request->id);
            } else {
                //Log,Notify
                Core\Document::addHeader('Location: /?com=object&task=edit&id='.$this->request->id);
            }
        } else {
            $data['main'] = new Classes\Object($this->request->id);
            $tbArray = ['id' => $this->request->id, 'type' => $this->request->type, 'definition' => $this->request->definition];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'edit_field', $tbArray));
            switch ($this->request->type) {
                case 'field':
                    Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit_field', $data));
                    break;
                case 'tag':
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'TAG');
                    $data['tag'] = $this->db->getRow('SELECT * FROM ?n WHERE `id_object`=?s AND `id_tag`=?s', TBL_EXT_TAG, $this->request->id, $this->request->field);
                    Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit_tag', $data));
                    break;
                case 'object':
                    $data['mode_list'] = ['small' => 'SMALL','medium' => 'MEDIUM','large' => 'LARGE'];
                    $data['type_list'] = $this->db->getCol('SELECT t.`title` FROM ?n ft,?n t WHERE ft.`definition`=?s AND ft.`id_tag`=t.`id` AND ft.`id_object`=?s', TBL_EXT_TAG,TBL_TAG, 'tag', '08d6de21890349aa24c9');
                    $data['fields'] = $this->db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`', TBL_DEFINITION, 'OBJECT');
                    $data['object'] = $this->db->getRow('SELECT * FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s', TBL_EXT_OBJECT, $this->request->id, $this->request->field, $this->request->definition);
                    Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit_object', $data));
                    break;
            }
        }
    }
    protected function remove_field()
    {
        if(Classes\Object::removeField($this->request->id, $this->request->definition, $this->request->field)) {
            //Log,Notify
            Core\Document::addHeader('Location: /?com=object&task=edit&id='.$this->request->id);
        } else {
            //Log,Notify
            Core\Document::addHeader('Location: /?com=object&task=edit&id='.$this->request->id);
        }
    }
    protected function list()
    {
        Core\Document::addString('title', $this->text->list);
        $list = $this->db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50', TBL_OBJECT);
        $tags = $this->db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC', TBL_OBJECT, TBL_EXT_TAG, TBL_TAG, 'type');
        if (!empty($tags)) foreach ($tags as $t) {
            $tagList[$t['id_object']][] = $t['tag'];
        }
        if (!empty($list) AND !empty($tagList)) foreach ($list as $item) {
            $data['list'][$item['id']] = $item;
            $data['list'][$item['id']]['tags'][] = $tagList[$item['id']];
        }
        $tbArray = [];
        Core\Document::addContent('content',5,Helper\Render::render($this->path.DS.'toolbars', 'list', $tbArray));
        Core\Document::addContent('content',10,Helper\Render::render($this->path.DS.'templates', 'list', $data));
    }
    protected function show()
    {
        if ($this->request->alias) {
            $idObject = $this->db->getOne('SELECT `id_object` FROM ?n WHERE `field`=?s AND `definition`=?s', TBL_EXT_STRING, $this->request->alias, 'alias');
            $object = new Classes\Object($idObject);
        } else $object = new Classes\Object($this->request->id);
        if ($object->access) foreach ($object->access as $item) {
            $access[] = $item['id'];
        }
        if (in_array($this->user->id, $access) OR in_array(Classes\Object::getIdByTitle('Все'), $access) OR (Core\User::getInstance()->isLoggedIn() AND in_array(Classes\Object::getIdByTitle('Зарегистрированные'), $access))) {
            Core\Document::addString('title', $object->title);

            if ($this->request->t AND file_exists('templates'.DS.'objects'.DS.$this->request->t.'.php')) $template = $this->request->t;
            else $template = array_shift ($object->type)['title'];
            $params = ['mode' => 'large','show_title' => 1];
            Core\Document::addContent('content', 10, $object->render($template, $params));
        } else {
            //Log,Notify
            Core\Document::addHeader('Location: /');
        }
    }
}
