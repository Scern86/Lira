<?php
namespace Modules\Search;
defined('_DEXEC') or DIE;

class Search
{
	protected $db;
	protected $module;
	
	public function action()
    {
		return \Scern\Lira\Helpers\Render::render('modules'.DS.'Search', 'template', null);		
	}
}