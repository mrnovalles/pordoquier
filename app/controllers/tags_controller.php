<?php
/*	app/controllers/tags_controller.php
		* Contiene las acciones del controlador tags para agregar, eliminar, visualizar y editar tags de un sitio.
		* @authors: Pablo Herrera & Mariano Vallés
*/
class TagsController extends AppController {
    var $name = 'Tags';
    var $helpers = array('Html','Form','IpToCountry','Ajax','Javascript','GoogleMap');
    var $components = array('Auth');   
    
	/*	beforeFilter
			* determina cuales son las acciones permitidas a los usuarios.
			@sets: -		
			@params: -
			@return: -
	*/    
	function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('index','view','count');    
     }    
    
	/*	index
			* busca todos los datos de los tags y se los envia a la vista.
			@sets: setea en una variales los datos de los tags y se los envia a la vista correspondiente.
			@params: - 
			@return: -
	*/	
    function index(){
   		$tags = $this->Tag->find('all');
    	$this->set('tags',$tags);    
    }

	/*	view
			* muestra los detalles del tag.
			@sets: envia una variable con los datos de tag a la vista correspodiente.
			@params: id del tag.
			@return: -
	*/	
    function view($id = null,$tagTitle= null){
		$this->layout='map';
        $title = $tagTitle;
        $this->set('TagTitle',$tagTitle);   	
        $this->Tag->id = $id;
		$this->Tag->Place->bindModel(array('hasOne'=>array('PlacesTag')));
		$this->set('tag',$this->Tag->Place->find('all', array('recursive'=>'1','conditions'=>array('PlacesTag.tag_id'=>$id))));
    }    
    
	/*	count
			* Cuenta la cantidad de tags que posee un lugar y se los envia a una vista.
			@sets: envia una variable con los datos de tag a la vista correspodiente.
			@params: -
			@return: -
	*/	
    function count(){
		$this->Tag->PlacesTag->bindModel(array('belongsTo' => array('Tag')));
		$tags = $this->Tag->PlacesTag->find('all', array('fields'=>array('COUNT(*) as count','Tag.tag','Tag.id'),
												   'group'=> 'PlacesTag.tag_id',
												   'limit' => 30,
													'order' => 'count DESC'
													)); 
		if(isset($this->params['requested'])){
			return $tags;
		}else{
			$this->set('tags',$tags);
		}
	}
}
?>
