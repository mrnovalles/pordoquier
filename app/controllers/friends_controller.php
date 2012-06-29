<?php
/*	app/controllers/friends_controller.php
		* Contiene las acciones del controlador friend para agregar, eliminar, visualizar y editar amigos de un usuario.
		* @authors: Pablo Herrera & Mariano Vallés
*/
App::import('Sanitize');
class FriendsController extends AppController{
	var $name = 'Friends';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript','GoogleMap' ); 
	var $components = array('RequestHandler');
    	
	/*	request
			* busca los usuarios que han hecho peticiones a otros usuarios para ser sus amigos.
			* note: el campo status determina si un usuario ya ha comfirmado la solicitud de amigo de otro usuario.
			@sets: setea en una variale los datos del usuario y se los envia a la vista correspondiente.
			@params: - 
			@return: -
	*/	
    function request(){
		$requests=$this->Friend->find('all',array('conditions'=>array('Friend.friend_id'=>$this->Session->read('uid'),'status'=>'0')));
		if($this->params['requested']){
			return $requests;        
		}else{
			$this->set('resquests',$requests);    
		}
    } 

	/*	confirm
			* actualiza el estado de un usuario que realizo un "request" asignandolo como amigo del usuario acutalmente logueado.
			* note: utiliza el id de sesion del usuario actualmente logueado.
			@sets: -
			@params: - 
			@return: -
	*/	
    function confirm($user_id){
        $this->layout= 'ajax';
        if($this->Friend->updateAll(array('status'=>1),array('Friend.user_id'=>$user_id,'Friend.friend_id'=>$this->Session->read('uid')))){
             $this->data['Friend']['user_id']= $this->Session->read('uid');        
             $this->data['Friend']['friend_id']= $user_id ;
             $this->data['Friend']['status']= 1;
             $this->Friend->save($this->data);  
        }
    }
     
	/*	notify
			* notifica al usuario logueado si exiten solicitudes de otros usuario para ser su amigo.
			@sets: setea un array de datos de friends y otro de places a la vista correspondiente
			@params: - 
			@return: -
	*/		   
    function notify(){
        $this->layout= 'ajax';        
        $friends =  $this->Friend->find('all',array('conditions'=>array('Friend.user_id'=>$this->Session->read('uid'),'status'=>'1'),
	'fields'=>array('Friend.friend_id')));
	if($friends != NULL){        
	foreach($friends as $n=>$friend){
	$friendData = $this->Friend->User->find('all',array('recursive'=>-1,'conditions'=>array('User.id'=>$friend['Friend']['friend_id']),
    'fields'=>array('User.name','User.lastname')));  
	$this->Friend->User->bindModel(array('hasMany'=>array('Place')));        
	$places[$n] = $this->Friend->User->Place->find('all',array('conditions'=>array('Place.user_id'=> $friend['Friend']['friend_id'],
	'Place.created BETWEEN ? AND ?'=> array(date('Y-m-d',strtotime('-2 days')),date('Y-m-d')))));
            }
        }
        else{
            $friendData = null;
            $places= null;        
        }
        $this->set('friends',$friendData);
        $this->set('places',$places);
 
    }	

	/*	setFriends
		    * Genera una lista de friends para ser llamados desde form->select.
			* note: si el usuario no posee amigos le pasa a la vista un array de datos de friend con el valor array().
			@sets: setea un array de datos de friends a la vista correspondiente.
			@params: - 
			@return: -
	*/		   	
	function setFriends(){
		$friends =  $this->Friend->find('list',array('conditions'=>array('Friend.user_id'=>$this->Session->read('uid'),'status'=>'1'),
												     'fields'=>array('Friend.friend_id')));
	
		$values= array_values($friends);
		if(!empty($friends)){
			$arrFriend = $this->Friend->User->find('list',array('conditions'=>array('User.id'=>$values),
																'fields' => array('User.id','User.username')));
				if($this->params['requested']){
					return $arrFriend;            
				}else{
					$this->set(compact('arrFriends'));
				}
		}else{
					$arrFriend=array();                    
					return $arrFriend;            
					$this->set('arrFriends',array());
		}
	}   
 
	/*	index
			* busca todos los datos de friends y se los envia a la vista.
			* note: si el usuario no posee amigos le pasa a la vista un array de datos de friend con el valor 0.
			@sets: setea en una variales los datos de los amigos de el usuario logueado y se los envia a la vista correspondiente.
			@params: - 
			@return: -
	*/	
   function index() {
        $this->pageTitle = $this->Session->read('Auth.User.name').' friends on Pordoquier.com.ar';  
		$myFriends =  $this->Friend->find('all',array('conditions'=>array('Friend.user_id'=>$this->Session->read('uid'),'status'=>'1'),
													  'fields'=>array('Friend.friend_id')));
	
		if($myFriends != NULL){
			foreach($myFriends as $n=>$fid):
				$arrFriend[$n] = $this->Friend->User->find('all',array('conditions'=>array('User.id'=>$fid['Friend']['friend_id'])));
			endforeach;
			$this->set('friends', $arrFriend);
		}else{
			$this->set('friends',0);
		}
    }
	
	/*	search
			* realiza una busqueda de todos los usuarios que coincidan con el criterio de busqueda.
			* note: la busqueda se realiza por nombre y apellido del usuario.
			@sets: setea en una variales los datos de los usuarios que devuelve la busqueda y se los envia a la vista correspondiente.
			@params: - 
			@return: -
	*/	
	function search() {
		if (!empty($this->params['form']['query'])){
			$search = Sanitize::clean($this->params['form']);
			$result = $this->Friend->User->findAll("User.name LIKE '%".$search['query']."%' OR User.lastname LIKE '%".$search['query']."%' OR User.username LIKE '%".$search['query']."%'");
			$this->set('search',$result);
		}
	}
	
	/*	add
			* agrega un nuevo amigo al usuario logueado.
			* note: utiliza el id (almacenado en session) del usuario logueado.			
			@sets: -
			@params: id del ususario a agregar como amigo.
			@return: -
	*/
	function add($id){
		$this->Friend->user_id = $this->Session->read('uid');
		$this->data['Friend']['user_id'] = $this->Session->read('uid');
		$this->data['Friend']['friend_id'] = $id;
        $result = $this->Friend->find('all',array('conditions'=>array('Friend.user_id'=>$this->data['Friend']['user_id'],'Friend.friend_id'=>$id)));
	
		if(!empty($result)){
			$this->Session->setFlash(__("already-have-this-friend",true));
        	$this->redirect(array('controller'=>'friends','action'=>'index'));
		}else{
			if($this->Friend->save($this->data)){
				$this->Session->setFlash(__('friend-add',true));
	        	$this->redirect(array('controller'=>'friends','action'=>'index'));
			}
		}
	}
	
	/*	delete
			* elimina un amigo del usuario logueado.
			* note: utiliza el id (almacenado en session) del usuario logueado.			
			@sets: -
			@params: id del usuario a eliminar.
			@return: -
	*/		
	function delete($id){
		if($this->Friend->deleteAll(array('Friend.user_id'=>$this->Session->read('uid'),'Friend.friend_id'=>$id))){
			$this->Session->setFlash(__('fried-deleted',true));
			$this->redirect('index');			
		}
	}
	
	/*	view
			* muestra el detalle del amigo del usuario actualmente logueado
			* note: utiliza el id (almacenado en session) del usuario logueado.
			@sets: envia una variable con los datos del amigo a la vista correspodiente.
			@params: id del amigo a ver.
			@return: -
	*/		
	function view($id){
    	//traigo los resultados al reves.Ver que friend_id es el de la session.
        if($friend_view = $this->Friend->find('all',array('conditions'=>array('Friend.user_id'=>$id,'Friend.friend_id'=>$this->Session->read('uid'))))){          
         $this->set('view',$friend_view);
         $this->Friend->User->bindModel(array('hasMany'=>array('Place')));
         $this->set('places',$this->Friend->User->Place->find('all',array('conditions'=>array('Place.user_id'=>$id))));	
         $this->pageTitle = $friend_view[0]['User']['name'].'\'s info on Pordoquier.com.ar';          
        }else{
            $this->Session->setFlash(__('not-friend-of-guy',true));
			$this->redirect("index");			
        }    
    }
}
?>
