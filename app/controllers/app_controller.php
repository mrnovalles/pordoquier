<?php
class AppController extends Controller{
	var $components = array('Auth','P28n');
	var $helpers = array('Bookmark','Html', 'Form', 'Ajax', 'Javascript');
	
    function beforeFilter(){
        
        $this->Auth->autoRedirect = false;
        $this->Session->write('uid',$this->Session->read('Auth.User.id'));
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'places', 'action' => 'index');
		$this->Auth->logoutRedirect = array('controller' => 'places', 'action' => 'index');
        $this->Auth->allow = array('display');

        $this->Auth->authorize = 'controller';
    }
   function isAuthorized() {
		if (isset($this->params[Configure::read('Routing.admin')])) {
			//  Usage: $this->Auth->user('field_in_user_model');
			if ($this->Auth->user('group_id') != 1) {
				return false;
			}
		}
		return true;
   }
}
?>
