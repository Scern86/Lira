<?php
namespace Components\Tag;
use \Scern\Lira\Helpers as Helper;
use \Scern\Lira\Core as Core;
use \Scern\Lira\Classes as Classes;
define('_DEXEC', 1);

class Tag extends Classes\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->component = 'tag';
        $this->path = 'components'.DS.$this->component;
        $this->text->addText(Core\Config::getInstance()->sys_lang,$this->component);
    }
    public function action()
    {
        switch ($this->request->task) {
            case 'ajax':
                if(in_array('tag_ajax',$this->userActions)){
                    $this->ajax();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'add':
                if(in_array('tag_add',$this->userActions)){
                    $this->add();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'edit':
                if(in_array('tag_edit',$this->userActions)){
                    $this->edit();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            case 'remove':
                if(in_array('tag_remove',$this->userActions)){
                    $this->remove();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
            default:
                if (in_array('tag_list',$this->userActions)){
                    $this->list();
                } else {
                    Core\Document::addHeader('Location: /');
                }
                break;
        }
    }
    protected function ajax(){
        switch($this->request->act){
            case 'load':
                $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT ?i,?i',TBL_TAG, (int)$this->request->post('offset'), (int)$this->request->post('limit'));
                echo Helper\Render::render($this->_path.DS.'templates','ajax_load',$data);
                exit();
                break;
            case 'search':
                $search = '%'.$this->request->post('search').'%';
                if (!empty($this->request->post('search')) AND mb_strlen($this->request->post('search')) >= 2) {
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `title`',TBL_TAG, $search);
                } else{
                    $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50', TBL_TAG);
                }
                echo Helper\Render::render($this->_path.DS.'templates','ajax_load',$data);
                exit();
                break;
        }
    }
    protected function add(){
        if ($this->request->post('action') == 'add') {
            $id = Helper\Generator::generateId(10);
            $data = [
                'id' => $id,
                'title' => htmlspecialchars($this->request->post('title')),
            ];
            if (Classes\Tag::create($data)) {
                switch ($this->request->type) {
                    case 'new':
                        Core\Document::addHeader('Location: /?com=tag&task=add');
                        break;
                    case 'save':
                        Core\Document::addHeader('Location: /?com=tag&task=edit&id='.$id);
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=tag&task=list');
                        break;
                }
            } else {
                Core\Document::addHeader('Location: /?com=tag&task=list');
            }
        } else {
            Core\Document::addString('title',$this->_text->add);
            $tbArray = [];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'add', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'add', $data));
        }
    }
    protected function edit(){
        if ($this->request->post('action') == 'edit') {
            $id = $this->request->id;
            $data = [
                'id' => $id,
                'title' => htmlspecialchars($this->request->post('title')),
            ];
            if (Classes\Tag::update($data)) {
                switch ($this->request->type) {
                    case 'new':
                        Core\Document::addHeader('Location: /?com=tag&task=add');
                        break;
                    case 'save':
                        Core\Document::addHeader('Location: /?com=tag&task=edit&id='.$id);
                        break;
                    default:
                        Core\Document::addHeader('Location: /?com=tag&task=list');
                        break;
                }
            } else{
                Core\Document::addHeader('Location: /?com=tag&task=list');
            }
        } else{
            Core\Document::addString('title',$this->text->edit);
            $data['main'] = new Classes\Tag($this->request->id);
            $tbArray = ['id'=>$this->request->id];
            Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'edit', $tbArray));
            Core\Document::addContent('content', 20, Helper\Render::render($this->path.DS.'templates', 'edit', $data));
        }
    }
    protected function remove(){
        if (Classes\Tag::remove($this->request->id)) {
            Core\Document::addHeader('Location: /?com=tag&task=list');
        } else {
            Core\Document::addHeader('Location: /?com=tag&task=list');
        }
    }
    protected function list()
    {
        Core\Document::addString('title', $this->text->list);
        $tbArray = [];
        Core\Document::addContent('content', 5, Helper\Render::render($this->path.DS.'toolbars', 'list', $tbArray));
        $data['list'] = $this->db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50', TBL_TAG);
        Core\Document::addContent('content', 10, Helper\Render::render($this->path.DS.'templates', 'list', $data));
    }
}