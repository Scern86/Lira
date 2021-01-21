<?php
namespace Components\Definition;
use \Scern\Lira\Helpers as Helper;
use \Scern\Lira\Core as Core;
use \Scern\Lira\Classes as Classes;
define('_DEXEC', 1);

class Definition extends Classes\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->component = 'definition';
        $this->path = 'components'.DS.$this->component;
        $this->text->addText(Core\Config::getInstance()->sys_lang,$this->component);
    }
    public function action()
    {
        switch($this->request->task){
            case 'ajax':
                if(in_array('definition_ajax',$this->userActions)){
                    $this->ajax();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'add':
                if(in_array('definition_add',$this->userActions)){
                    $this->add();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'edit':
                if(in_array('definition_edit',$this->userActions)){
                    $this->edit();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'remove':
                if(in_array('definition_remove',$this->userActions)){
                    $this->remove();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            default:
                if(in_array('definition_list',$this->userActions)){
                    $this->list();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
        }
    }
    protected function ajax()
    {
        switch($this->request->act){
            case 'load':
                $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT ?i,?i', TBL_DEFINITION, (int)$this->request->post('offset'),( int)$this->request->post('limit'));
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load', $data);
                exit();
            break;
            case 'search':
                $search = '%'.$this->request->post('search').'%';
                if(!empty($search)){
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `type`,`title`', TBL_DEFINITION, $search);
                }
                else{
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT 0,50', TBL_DEFINITION);
                }
                echo Helper\Render::render($this->path.DS.'templates', 'ajax_load', $data);
                exit();
            break;
        }
    }
    protected function add()
    {
        if ($this->request->post('action') == 'add') {
            $data = [
                'title' => htmlspecialchars($this->request->post('title')),
                'type' => htmlspecialchars($this->request->post('type')),
                'description' => htmlspecialchars($this->request->post('description')),
            ];
            if (Classes\Definition::create($data)) {
                switch ($this->request->type) {
                    case 'new':
                        Core\Document::addHeader('Location: /?com=definition&task=add');
                        break;
                    case 'save':
                        Core\Document::addHeader('Location: /?com=definition&task=edit&title='.htmlspecialchars($this->request->post('title')));
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=definition&task=list');
                        break;
                }
            } else {
                Core\Document::addHeader('Location: /?com=definition&task=list');
            }
        } else {
            Core\Document::addString('title', $this->text->add);
            $data['types'] = ['NUMBER','STRING','DATETIME','TEXT','LONGTEXT','OBJECT','TAG'];
            $tbArray = [];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'add', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'add', $data));
        }
    }
    protected function edit()
    {
        if ($this->request->post('action') == 'edit') {
            $data = [
                'title' => htmlspecialchars($this->request->post('title')),
                'type' => htmlspecialchars($this->request->post('type')),
                'description' => htmlspecialchars($this->request->post('description')),
            ];
            if (Classes\Definition::update($data)) {
                switch ($this->request->type) {
                    case 'new':
                        Core\Document::addHeader('Location: /?com=definition&task=add');
                        break;
                    case 'save':
                        Core\Document::addHeader('Location: /?com=definition&task=edit&title='.htmlspecialchars($this->request->post('title')));
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=definition&task=list');
                        break;
                }
            } else {
                Core\Document::addHeader('Location: /?com=definition&task=list');
            }
        } else {
            Core\Document::addString('title', $this->text->edit);
            $data['main'] = new Classes\Definition($this->request->title);
            $data['types'] = ['NUMBER','STRING','DATETIME','TEXT','LONGTEXT','OBJECT','TAG'];
            $tbArray = ['title' => $this->request->title];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'edit', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit', $data));
        }
    }
    protected function remove()
    {
        if (Classes\Definition::remove($this->request->title)) {
            Core\Document::addHeader('Location: /?com=definition&task=list');
        } else {
            Core\Document::addHeader('Location: /?com=definition&task=list');
        }
    }
    protected function list()
    {
        Core\Document::addString('title',$this->text->list);
        $tbArray = [];
        Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'list', $tbArray));
        $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT 0,50',TBL_DEFINITION);
        Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'list', $data));
    }
}