<?php
 /*app/controllers/pcomments_controller.php
  * Contiene las acciones del controlador pcomments (Places Comments) para interactuar con el modelo
  * @authors: Mariano Vallés & Pablo Herrera

  */
App::import('Sanitize');
    class PcommentsController extends AppController {
	var $name = 'Pcomments';
	var $components = array('RequestHandler');

    /*add
     * Guarda un registro (comentario) en la tabla de pcomments para un determinado lugar.
     *note: es llamado desde la vista de places/view a través de una $ajax-link
     * @sets void
     */
    function add(){
        if($this->data){
        $allowed = array(' ','@','.','&','!','á','é','í','ó','ú');
	$this->data['Pcomment']['comment']= Sanitize::paranoid($this->data['Pcomment']['comment'], $allowed);
            if($this->Pcomment->save($this->data)){
                $this->Session->setFlash(__('comment-saved',true));
		$this->redirect( '/places/view/'.$this->data['Pcomment']['place_id']);               
                }           
            else{
                $this->Session->setFlash(__('comment-error',true));
                }
            }    
    }
      /*delete
     * Borra un comentario desde la vista de places/view
     * note: es llamado desde la vista de places/view a través de una $ajax-link
     * @sets void
     */

    function delete($id=null){
	$this->Pcommnet->id= $id;
	$this->Pcomment->read();
        if($this->Pcomment->del($id)){
                $this->Session->setFlash(__('comment-deleted',true));
                }           
            else{
                $this->Session->setFlash(__('comment-error',true));
                }
                
        } 
    }
?>
