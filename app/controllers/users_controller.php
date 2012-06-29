<?php
/*	app/controllers/users_controller.php
 * Contiene las acciones del controlador users para agregar, eliminar, visualizar y editar usuarios.
 * @authors: Pablo Herrera & Mariano Vallés
 */
class UsersController extends AppController{
	var $name = 'Users';
		var $helpers = array('Html','Form','Javascript','Ajax','GoogleMap','CountryList','Time'); 
	var $components = array('RequestHandler','Cookie','Image');

	var $paginate = array (
			'limit' => 25,
			'order'=> array ('User.id'=> 'asc')
			);

	/*	beforeFilter
	 * determina cuales son las acciones permitidas a los usuarios.
	 @sets: -		
	 @params: -
	 @return: -
	 */
	function beforeFilter() {
		parent::beforeFilter();
			$this->Auth->allowedActions = array('login','add');
		if(isset($this->params['admin'])){
			$this->layout = 'admin_default';
		}
		else{
			$this->layout = 'default';	
		}

	}
	
		/*	afterFind
		 * reaaliza las acciones que le indiquemos antes de realizar una búsqueda.
		 @sets: -		
		 @params: array de datos. -> ej $data.
		 @return: array de datos modifiados.
		 */
		function afterFind($resultados) {
			foreach ($resultados as $clave => $valor) {
				if (isset($valor['User']['birthdate'])) {
					$date = substr($valor['User']['birthdate'],0,4);
						$resultados[$clave]['User']['birthdate'] = $date;
				}
			}
			return $resultados;
		}
	
		/*	add
		 * agrega un nuevo usuario en la base de datos.
		 * note: utiliza el id (almacenado en session) del usuario logueado.			
		 @sets: -
		 @params: - 
		 @return: -
		 */
		function add(){
			$this->layout="register";
			$this->pageTitle = __('Register',true);
			if($this->Session->read('uid')){
				$this->Session->setFlash(__('already-logged',true));
			}
			//Flags para ser usadas con el upload de imagenes.
			$uploaded = false;
			$saved = false; 
			$needupload = false; 
			if(!empty($this->data)){
			if($this->data['User']['accept']== 1){
				if($this->User->save($this->data)){
					$saved = true;
					$this->Session->setFlash(__('user-created',true));
					if(!empty($this->data['User']['pic']['name'])) {
						$needupload = true;
						$image_path = $this->Image->upload_image_and_thumbnail($this->data['User']['pic'],200,200,50,50, "users");
						if(isset($image_path)) {
							$this->User->saveField('photo',$image_path);
							$uploaded = true;
						}
					}
				}
		
				if($saved && ($uploaded || !$needupload)) {
					$this->Session->setFlash(__('user-saved', true));
					$this->redirect(array('controller'=>'places','action'=>'index'));
				}
				else if($saved && !$uploaded && $needupload) {
					// User was saved but we needed to upload and the saving failed
					$this->Session->setFlash(__('image-4-user-not-saved', true));
						$this->User->del($this->User->id);
				}
				else {
					$this->Session->setFlash(__('user-not-saved', true));
				}
			}else{
				$this->Session->setFlash(__('You have to agree to the terms and conditions',true));	
			}
		}
		}
	
		/*	edit
		 * edita el perfil del usuario actualmente logueado.
		 * note: utiliza el id (almacenado en session) del usuario logueado.
		 @sets: -
		 @params: - 
		 @return: -
		 */
		function edit(){
			$uploaded = false;
			$saved = false; 
			$needupload = false; 
			$this->User->id = $this->Session->read('uid');
			$old_user = $this->User->read();
			$old_photo = $old_user['User']['photo'];
			if(empty($this->data)){
				$this->data = $old_user;
			} else {
				if($this->User->save($this->data)){
					$saved = true;    
					if($this->data['User']['pic']['size'] > 0) {
						$needupload = true;
						$image_path = $this->Image->upload_image_and_thumbnail($this->data['User']['pic'],200,200,50,50, "users");
						if(isset($image_path)) {
							if($this->User->saveField('photo',$image_path)){
								if(!empty($old_photo)){
									unlink(IMAGES.'users'.DS.'big'.DS.$old_photo);
									unlink(IMAGES.'users'.DS.'small'.DS.$old_photo);
									unlink(IMAGES.'users'.DS.'home'.DS.$old_photo);
								}
								$uploaded = true;
							}
						}
					}
				}
				if($saved && ($uploaded || !$needupload)) {
					$this->Session->setFlash(__('user-information-edited', true));
					$this->redirect(array('action'=>'view'), null, true);
				}
				else if($saved && !$uploaded && $needupload) {
					$this->Session->setFlash(__('image-4-user-not-saved', true));
				}
				else {
					$this->Session->setFlash(__('user-not-saved', true));
				}
			}		   		
		}
	/*admin_index
	 * busca todos los datos de los usuarios y se los envia a la vista.
	 @sets: setea en una variales los datos del usuario y se los envia a la vista correspondiente.
	 @params: - 
	 @return: -
	 */
	function admin_index() {
		$result = $this->paginate('User');
		//$data = $this->afterFind($result);
		$this->set('users', $result);
	}

	/*	admin_edit
	 * edita un usuario existente en la base de datos.
	 * note: permite editar a cualquier usuario.
	 @sets: -
	 @params: id del usuario a editar.
	 @return: -
	 */
	function admin_edit($id= null){
		$uploaded = false;
		$saved = false; 
		$needupload = false; 
		$this->User->id = $id;
		$old_user = $this->User->read();
		$old_photo = $old_user['User']['photo'];
		if(empty($this->data)){
			$this->data = $old_user;
		} else {
			if($this->User->save($this->data)){
				$saved = true;    
				if($this->data['User']['pic']['size'] > 0) {
					$needupload = true;
					$image_path = $this->Image->upload_image_and_thumbnail($this->data['User']['pic'],200,200,50,50, "users");
					if(isset($image_path)) {
						if($this->User->saveField('photo',$image_path)){
							if(!empty($old_photo)){
								unlink(IMAGES.'users'.DS.'big'.DS.$old_photo);
								unlink(IMAGES.'users'.DS.'small'.DS.$old_photo);
								unlink(IMAGES.'users'.DS.'home'.DS.$old_photo);
							}
							$uploaded = true;
						}
					}
				}
			}
			if($saved && ($uploaded || !$needupload)) {
				$this->Session->setFlash(__('user-information-edited', true));
				$this->redirect(array('action'=>'index'), null, true);
			}
			else if($saved && !$uploaded && $needupload) {
				$this->Session->setFlash(__('image-4-user-not-saved', true));
			}
			else {
				$this->Session->setFlash(__('user-not-saved', true));
			}
		}		   		
	}
	/*
	   admin_change_pass
	 *Permite modificar al admin modificar el password de un usuario 

	 */
	function admin_change_pass($id = null){
		$this->User->unbindValidation('password','password_confirm');
		$this->User->id = $id;
		$this->User->read();
		if(!empty($this->data)){
			$this->User->save($this->data, array('validates'=>false));
		}
		else{
			//			$this->Session->setFlash(__('Id not provided',true));
		}


	}

	/*	admin_delete
	 * elimina un usuario existente en la base de datos
	 * note: permite eliminar a cualquier usuario.
	 @sets: -
	 @params: id del usuario a eliminar.
	 @return: -
	 */	
	function admin_delete($id){
		$this->User->del($id);
			$this->Session->setFlash(__('user-deleted',true));
			$this->redirect("index");
	}
	/*admi_view
	 * muestra el detalle del usuario actualmente logueado
	 * note: utiliza el id (almacenado en session) del usuario logueado.
	 @sets: envia una variable con los datos del usuario a la vista correspodiente.
	 @params: - 
	 @return: -
	 */	
	function admin_view($id){
		$this->User->id = $id;
		$user_view = $this->User->read();
		$this->set('users_view',$user_view);
	}

	/*	view
	 * muestra el detalle del usuario actualmente logueado
	 * note: utiliza el id (almacenado en session) del usuario logueado.
	 @sets: envia una variable con los datos del usuario a la vista correspodiente.
	 @params: - 
	 @return: -
	 */	
	function view(){
		$this->User->id = $this->Session->read('uid');
			$user_view = $this->User->read();
			$this->set('users_view',$user_view);
	}
	
		/*	login
		 * permite que un usuario valide su sesion permitiendole el ingreso a contenidos
		 * note: permite la utilizacion de cookies para recordad al usuario.
		 @sets: -
		 @params: - 
		 @return: -
		 */	
		function login() {
			//-- code inside this function will execute only when autoRedirect was set to false (i.e. in a beforeFilter).
			if ($this->Auth->user()) {
				if (!empty($this->data) && $this->data['User']['remember_me']) {
					$cookie = array();
						$cookie['username'] = $this->data['User']['username'];
						$cookie['password'] = $this->data['User']['password'];
						$this->Cookie->write('Auth.User', $cookie,true, '+2 weeks');
						unset($this->data['User']['remember_me']);
				}
				$this->redirect($this->Auth->redirect());
			}
			if (empty($this->data)) {
				$cookie = $this->Cookie->read('Auth.User');
					if (!is_null($cookie)) {
						if ($this->Auth->login($cookie)) {
							// Clear auth message, just in case we use it.
							$this->Session->del('Message.auth');
								$this->redirect($this->Auth->redirect());
						} else { // Delete invalid Cookie
							$this->Cookie->del('Auth.User');
						}
					}
			}
		}   
	
		/*	logout
		 * permite que un usuario haga logout del sitio eliminado las variables de sesion.
		 * note: luego de eliminar las variables de sesion, redirecciona.
		 @sets: -
		 @params: - 
		 @return: -
		 */	
		function logout() {
			$this->Cookie->del('Auth.User');
				$this->redirect($this->Auth->logout());
		}	
	/*	lastLogin
	 * determina cuando fue la ultima vez que el usuario inicio la session.
	 * note: utiliza la funcion date de php
	 @sets: -
	 @params: - 
	 @return: -
	 */		
	function lastLogin(){
		$this->layout ='default';	
			$date = date('Y-m-d h:m:s');
			$this->User->id = $id;
			$result=$this->User->read();
			$result['User']['last_login'] = $date;
			$this->User->save($result);
	}
	function recaptcha(){
		$this->Recaptcha->render();
	}
}
?>
