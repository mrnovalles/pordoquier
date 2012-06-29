<?php
/*	app/controllers/commetns_controller.php
		* Contiene las acciones del controlador comments para agregar, eliminar y visualizar comentarios.
		* @authors: Pablo Herrera & Mariano Vallés
*/
App::import('Sanitize');
class CommentsController extends AppController{
    var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript','GoogleMap' ); 
	
	/*	afterFind
			* reaaliza las acciones que le indiquemos antes de realizar una búsqueda.
			@sets: -		
			@params: array de datos. -> ej $comments.
			@return: array de datos modifiados.
	*/    
	function afterFind($resultados) {
		foreach ($resultados as $clave => $valor) {
			if (isset($valor['Comment']['created'])) {
				$month = substr($valor['Comment']['created'],5,2);
				$day= substr($valor['Comment']['created'],8,2);
				$date = $day."/".$month;
				$time = substr($valor['Comment']['created'],11,5);

				$resultados[$clave]['Comment']['date'] = $date;
				$resultados[$clave]['Comment']['time'] = $time;
			}
		}
		return $resultados;
	}

	/*	index
			* busca todos los datos de los comments y se los envia a la vista.
			* note: si no posee comentearios se envia la variable comments con el valor 0.
			@sets: setea en una variales los datos de los comments y otro array con los datos del usuario y se los envia a la vista correspondiente.
			@params: - 
			@return: -
	*/	
	function index(){
		$this->layout = "default";
		$comments = $this->Comment->find('all',array('conditions'=>array('id_2user'=>$this->Session->read('uid')),'order'=>'Comment.created DESC'));
		if($comments != NULL){
			$fromUser = $this->Comment->User->find('all',array('conditions'=>array('User.id'=>$comments['0']['Comment']['user_id'])));
			$data = $this->afterFind($comments);
			$this->set('comments',$data);
        	$this->set('fromUser',$fromUser);
		}else{
			$this->set('comments',0);
		}
    }
	
	/*	add
			* agrega un nuevo comentario al usuario.
			* note: utiliza el id (almacenado en session) del usuario logueado.			
			@sets: -
			@params: - 
			@return: -
	*/	
	function add(){
        $this->layout = "ajax";
		if(!empty($this->data)){
			$this->data['Comment']['user_id'] = $this->Session->read('uid');
//			$this->data['Comment']['comment'] = Sanitize::clean($this->data['Comment']['comment'],true);
			if($this->Comment->save($this->data)){
		   		$this->Session->setFlash(__('comment-sent',true));
				$this->redirect(array('controller'=>'friends','action'=>'index'));
			}
		}
	}

	/*	delete
			* elimina un comentarios realizadio al usuario logueado.
			@sets: -
			@params: id del comentario a eliminar.
			@return: -
	*/		
	function delete($id){
		$this->layout = "ajax";
		if($this->Comment->deleteAll(array('Comment.id'=>$id))){
		   		$this->Session->setFlash(__('comment-deleted',true));
				$this->redirect(array('controller'=>'comments','action'=>'index'));			
		}
	}

	/*	view
			* muestra el detalle del comentario.
			@sets: envia una variable con los datos del comentario a la vista correspodiente.
			@params: id del comentario a ver.
			@return: -
	*/		
	function view($id){
        $this->layout = "ajax";
		$this->Comment->id = $id;
		$this->data = $this->Comment->read();
		$this->data['Comment']['read'] = 1;
		$this->Comment->save($this->data);
		$com_view = $this->Comment->read();
		$this->set('comments',$com_view);
	}
	
	function counter(){
		$counter = $this->Comment->find('count',array('conditions'=>array('read'=>'0','id_2user'=>$this->Session->read('uid'))));
		return $counter;
	}
}
?>
