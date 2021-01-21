<?php
namespace Modules\Auth;
defined('_DEXEC') or DIE;

class Auth
{
    protected $user;

    public function __construct($id)
    {
        $this->user = \Scern\Lira\Core\User::getInstance();
    }
    public function action()
    {
        if ($this->user->isLoggedIn()) {
            return \Scern\Lira\Helpers\Render::render('modules'.DS.'Auth', 'template', null);
        } else {
            return \Scern\Lira\Helpers\Render::render('modules'.DS.'Auth', 'login', null);
        }
    }
}