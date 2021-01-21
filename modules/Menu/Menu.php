<?php
namespace Modules\Menu;
defined('_DEXEC') or DIE;

class Menu
{
    protected $module;

    public function __construct($module)
    {
        $this->module = $module;
    }
    public function action()
    {
        $moduleParams = json_decode($this->module->ext_params, 1);
        $params = [
            'id'=>$moduleParams['id_menu'],
            'level'=>0,
            'css_id'=>$moduleParams['css_id'],
            'template'=>$moduleParams['template'],
            'module'=>$this->module,
        ];
        $tree = new Tree($params);
        $data['tree'] = $tree->render();
        $data['module'] = $this->module;
        return \Scern\Lira\Helpers\Render::render('modules'.DS.'Menu', 'template', $data);
    }
}