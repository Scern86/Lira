<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class App
{

    protected $config;
    protected $db;
    protected $session;
    protected $request;
    protected $user;
    protected $text;

    public function __construct()
    {
        $this->config = Config::getInstance();
        $db = Db::getInstance();
        $db->init('main', $this->config->database);
        $this->db = $db->getDatabase('main');
        $this->request = Request::getInstance();
        $this->session = Session::getInstance();
        $this->user = User::getInstance();
        $this->text = Text::getInstance()->addText($this->config->sys_lang, 'main');
    }
    public function start()
    {
        if($this->request->auth=='logout') $this->user->logout();
        $this->route();
        $this->redirect();
    }
    public function route()
    {
        $requestName = 'Components\\'.ucfirst($this->request->com).'\\'.ucfirst($this->request->com);
        if ($this->request->com AND class_exists($requestName) AND method_exists($requestName,'action')) {
            $component = new $requestName();
            $component->action();
        }
        else {
            $url = $this->config->main_page;
            $this->request->reload($url);
            $this->route();
        }
    }
    public function redirect()
    {
        Document::renderHeader();
    }
    public function render()
    {
        if (empty($_GET)) Document::addString('title', 'Главная');
        Document::addString('title', ' | '.$this->config->site_name, false);
        Document::addString('site_name', $this->config->site_name);
        $this->loadModules();
        $template = $this->config->template;
        return \Scern\Lira\Helpers\Render::render('templates', $template, Document::getContent());
    }
    protected function loadModules()
    {
        $listModules = $this->db->getCol('SELECT es.`id_object` FROM ?n es,?n en WHERE es.`id_object`=en.`id_object` AND es.`definition`=?s AND en.`definition`=?s ORDER BY en.`field`',TBL_EXT_STRING,TBL_EXT_NUMBER,'module','order');
        if (!empty($listModules)) foreach ($listModules as $item) {
            $objectModule = new \Scern\Lira\Classes\Object($item);
            if ($objectModule->link=='all' OR $objectModule->link==$_SERVER['REQUEST_URI']) {
                $moduleName = '\Modules\\'.$objectModule->module.'\\'.$objectModule->module;
                $module = new $moduleName($objectModule);
                Document::addContent($objectModule->position, $objectModule->order, $module->action());
            }
        }
    }
}