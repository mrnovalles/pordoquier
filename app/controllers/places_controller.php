<?php
 /*app/controllers/places_controller.php
  * Contiene las indacciones del controlador places para interactuar con el modelo
  * Place y los asociados a el.
  * @created: Mariano Vallés & Pablo Herrera
  */
App::import('Sanitize');
App::import('Xml');
class PlacesController extends AppController {
    var $name = 'Places';
    var $components = array('Auth','RequestHandler','Image');   
    var $helpers = array('GoogleMap','IpToCountry','Time');
    var $paginate = array(
        'limit' => 8,
        'order' => array(
            'Place.created' => 'desc'
        )
    );


    /*beforeFilter
    * define las acciones a las que se puede acceder sin iniciar sesión.
    * @param void
    * @return void
    */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('index','_setCategories','_setTags','view','search','last');
        $this->Auth->deny('list_places');
	if(isset($this->params['admin'])){
		$this->layout = 'admin_default';
	}
	else{
		$this->layout = 'default';	
	}

     }

    /*_setCategories
    * setea una array con la lista de categorias para ser usado en un select
    * @param void
    * @return void
    * @sets array mixed categories
    */
    function _setCategories(){
    	$categories = $this->Place->Category->find('list',array(  
								   'fields' => array('id', 'name','parent'),  
								   'order' => 'Category.name ASC',  
								   'recursive' => -1));  

		$arrayCat = array();
		foreach($categories as $n => $cat):
			if($categories[$n][$n] == $cat[$n]){
				$arrayCat[$cat[$n]] = $categories[$n];
			}
		endforeach;
		$this->set('categories',$arrayCat);
     }

     /*_setTags
    * setea una array con la lista de tags para ser usado en un select
    * @param void
    * @return void
    * @sets array mixed categories
    */
     function _setTags(){
		$tags = $this->Place->Tag->find('list',array(  
							   'fields' => array('id', 'tag'),  
							   'order' => 'Tag.tag ASC',  
							   'recursive' => -1));  
		$this->set(compact('tags'));     
     }
     /*last10
      *Trae una lista con los 10 lugares más recientes
	*nota: es uado por home page via requestAction
	*/	
	function last($cant=null){
	if($cant == null) $cant = 5;
	$places = $this->Place->find('all',array('order'=>'created DESC','limit'=>$cant));
	return $places;
	}
     /*index
    * Contiene la vista principal del sitio en places/index y setea un array de categorias,
    * nota: usar el layout map y setea el pageTitle
    * @param void
    * @return void
    */
    function index() {
	$isFeed = ife($this->RequestHandler->__renderType == 'rss', true, false);
	if($isFeed){
		$this->layout = 'xml';

		$place = $this->Place->find('all',array('order'=>'Place.created DESC', 'limit' => 10));
		$this->set('places',$place);
	}else{
		$this->pageTitle = 'Pordoquier.com.ar';  
        $this->layout ='map';
		$this->_setCategories();
	}
   }

    /*add
    * permite guardar en la tabla places un nuevo registro.
    * note: utiliza funciones del GoogleMap helper para obtener las coordenadas.
     *      utiliza el layout map y setea el titulo
    * @param void
    * @return void
    */
    function add() {
    $uploaded = false;
	$saved = false; 
	$needupload = false; 
		
    $this->pageTitle = __('Add new place to Pordoquier.com.ar',true);  
    $this->layout ='map';
    $this->_setCategories();
//	$this->data['Place']['user_id'] = $this->Session->read('uid');
	    if(!empty($this->data)) {
            $allowed = array(' ','@','.','&','!','á','é','í','ó','ú');
            $this->data['Place']['name'] = Sanitize::paranoid($this->data['Place']['name'],$allowed);
            $this->data['Place']['address'] = Sanitize::paranoid($this->data['Place']['address'],$allowed);
            $this->data['Place']['description'] = Sanitize::paranoid($this->data['Place']['description'],$allowed);
            $this->data['Place']['tags'] = Sanitize::paranoid($this->data['Place']['tags'],array(',',' ','á','é','í','ó','ú'));            
            $this->Place->create();
            if($this->Place->save($this->data)) {
				$saved = true;
                $this->Session->setFlash(__('place-saved',true));
				foreach($this->data['Place']['pic'] as $pic){
					if(!empty($pic['name'])) {
						$needupload = true;
						$image_path = $this->Image->upload_image_and_thumbnail($pic,600,450,50,33, "places");
						if(isset($image_path)) {
							$this->Place->Photo->create();
							$this->Place->Photo->data['place_id'] = $this->Place->id;
							$this->Place->Photo->data['photo'] = $image_path;
							$this->Place->Photo->save($this->Place->Photo->data);
							$this->Place->saveField('photo',$image_path);
							$uploaded = true;
						}
					}
				}
				$this->redirect(array('action'=>'view',$this->Place->id), null, true);
            } else {
                $this->Session->setFlash(__('place-not-saved',true));
            }
			if($saved && ($uploaded || !$needupload)) {
				$this->Session->setFlash(__('place-saved', true));
				//$this->redirect(array('action'=>'index'));
			}
			else if($saved && !$uploaded && $needupload) {
			// User was saved but we needed to upload and the saving failed
			// We have to rollback this, so we have to delete the gift that we just added
				$this->Session->setFlash(__('image-4-place-not-saved', true));
				$this->Place->del($this->Place->id);
			}
			else {
				$this->Session->setFlash(__('place-not-saved', true));
			}			
        } 
    }

    /*view
    * vista de un place con todos los detalles.
    * note: utiliza el layout map y setea el titulo
    * @param int id
    * @return void
    * @sets array mixed place con todos los modelos asociados.
    */
    function view($id=null){
        $this->layout ='map';
        $this->Place->id= $id;
        $place=$this->Place->read();
        if($place == false){
            $this->Session->setFlash(__('place-not-found',true));    
			$this->redirect("index");			
        }
        else{        
        	$this->set('place',$place);
		$this->Place->Pcomment->place_id = $id;
		$this->set('comments',$this->Place->Pcomment->read());
        	$this->pageTitle = $this->Place->data['Place']['name'].' '.__(' on Pordoquier.com.ar',true);    
        }
    }

	/*search
    * busca en places de acuerdo a los datos que trae params['form']['query']
    * note: utiliza el layout ajax. Es llamado por cada cambio de caracter.
    * Retorna solo el modelo de place, sin asociaciones.
    * @param void
    * @return void
    * @sets array mixed search (places sin modelos asociados)
$query = $this -> Sanitize -> paranoid($this->params['form']['query']); if (strlen($query) > 0) 
    */
	function search() {
    	if (!empty($this->data['Place']['query'])){
	        $query = Sanitize::clean($this->data['Place']['query']);
			$criteria = $this->data['Place']['criteria']; 	
            if(strlen($query) > 0){            
                $this->Place->unbindModel(array('hasMany' => array('Pcomment','Rating')));
			    $result = $this->Place->find('all',array('conditions'=>"Place.".$criteria." LIKE '%".$query."%'"));
			    $this->set('search',$result);
            }
            
		}
	}

    /*edit
    * Permite editar un place a partir de su id.
    * note: solo permite editar los places que pertenezcan al usuario logueado en el momento.
    * @param int id de places
    * @return void
    * @sets array mixed place para ser recuperado en la vista
    */
    function edit($id = null) {
        $this->layout ='map';       
        $this->_setCategories();

        $this->set('place', $this->Place->read());        
        if($this->Place->data['Place']['user_id'] != $this->Session->read('uid')){
             $this->Session->setFlash(__('not-allowed-edit-place',true));
	     $this->redirect(array('action'=>'view',$id));
        
        }           
        if (!empty($this->data)) { 
	        if (!$id) { //create
		        $this->Place->create();
	        }
	        if ($this->Place->save($this->data)) {
     	        $this->Session->setFlash(__('controllers-places-edit-success', true));
	 	$this->redirect(array('action'=>'view',$this->Place->id));
	        }
	        else {
		        $this->Session->setFlash(__('controllers-places-edit-failed', true));
	        }
        } else { 
	        $this->data = $this->Place->find();
        }
        $this->pageTitle = __('Edit',true).$this->Place->data['Place']['name'].__(' on Pordoquier.com.ar',true);  
    }
    /*delete
    * Elimina un determinado lugar siempre que pertenezca al user que ha iniciado sesion.
    * note: solo permite eliminar los places que pertenezcan al usuario logueado en el momento.
    * @param int id de places
    * @return void
    * @sets void
    */
    function delete($id=null){
        	$this->Place->id=$id;
            $this->Place->read();
            if($this->Place->data['Place']['user_id'] != $this->Session->read('uid')){
                 $this->Session->setFlash(__('not-allowed-delete-place',true));
				 $this->redirect("list_places");
            }
   	       else if($this->Place->delete())
		        $this->Session->setFlash(__('place-deleted',true));
				 $this->redirect("list_places");			
    }

function deleteimg($pic,$place_id){
	$this->Place->id = $place_id;
	$place = $this->Place->read('user_id');
	if($place['Place']['user_id'] == $this->Session->read('uid')){
		$this->Place->Photo->id = $pic;
		$photo = $this->Place->Photo->read();
		unlink(IMAGES.DS.'places'.DS.'big'.DS.$photo['Photo']['photo']);
		unlink(IMAGES.DS.'places'.DS.'small'.DS.$photo['Photo']['photo']);
		unlink(IMAGES.DS.'places'.DS.'home'.DS.$photo['Photo']['photo']);
		if($this->Place->Photo->del()){
			$this->Session->setFlash(__('image-deleted-from-place',true));
			$this->redirect('/places/edit/'.$place_id);
		}
	}
	
}
    /*list_places
    * Lista los lugares del usuario que ha iniciado sesion.
    * note: Utiliza el layout map.
    * @param void
    * @return void
    * @sets array mixed places con los modelos asociados en cada indice
    */
	function list_places(){
        $this->layout ='map';
		$places= $this->paginate('Place', array('Place.user_id' => $this->Session->read('uid')));
   
		//$places = $this->Place->find('all',array('conditions'=>array('Place.user_id' => $this->Session->read('uid'))));
		$this->set('listPlaces',$places);
        $this->pageTitle = $places['0']['User']['name'].' '.$places['0']['User']['lastname']." ".__('places in Pordoquier',true);
	}
/*Admin functions*/

    function admin_index(){
        // similar to findAll(), but fetches paged results
        $this->paginate['Place']['limit'] = 25; 
		$data = $this->paginate('Place');
        $this->set('data', $data);
    }


	function admin_deleteImg($pic){
		$this->Place->Photo->id = $pic;
		$photo = $this->Place->Photo->read();
		unlink(IMAGES.DS.'places'.DS.'big'.DS.$photo['Photo']['photo']);
		unlink(IMAGES.DS.'places'.DS.'small'.DS.$photo['Photo']['photo']);
		unlink(IMAGES.DS.'places'.DS.'home'.DS.$photo['Photo']['photo']);
		if($this->Place->Photo->del()){
			$this->Session->setFlash(__('image-deleted-from-place',true));
			$this->redirect(array('controller'=>'places','action'=>'index'));
		}
	}
	function admin_delete($id){
		$this->Place->del($id);
		$this->redirect("index");
	}
	function admin_edit($id) {
		$this->_setCategories();
		$this->Place->id = $id;
		$this->set('place', $this->Place->read());        
		if (!empty($this->data)) { 
			if (!$id) { //create
				$this->Place->create();
			}
			if ($this->Place->save($this->data)) {
				$this->Session->setFlash(__('controllers-places-edit-success', true));
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash(__('controllers-places-edit-failed', true));
			}
		} else { 
			$this->data = $this->Place->find();
		}
		$this->pageTitle = 'Admin edit';  
	}	
}
?>
