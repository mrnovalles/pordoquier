<?php   
 /*app/controllers/categories_controller.php
  * Contiene las acciones del controlador categories para interactuar con el modelo
  * @authors: Mariano Vallés & Pablo Herrera
  */
class CategoriesController extends AppController{
	var $name = 'Categories';
		var $helpers = array('Html', 'Form', 'Ajax', 'Javascript','GoogleMap' ); 
		var $components= array('Image');
		var $paginate = array(	'limit'=>25,
					'order'=>array('Category.id'=>'ASC')
					
				);
		 
	/*beforeFilter
	 * define las acciones a las que se puede acceder sin iniciar sesión.
	 * @param void
	 * @return void
	 */
	function beforeFilter() {
		parent::beforeFilter();
			$this->Auth->allowedActions = array('index','_setCategories','get','view');    
		if(isset($this->params['admin'])){
			$this->layout = 'admin_default';
		}
		else{
			$this->layout = 'default';	
		}
	}

	/*get
	 * Trae un array con categorias y sus lugares a partir del id de la categoría.
	 * nota: usa el layout de ajax y es llamado por element category_list
	 * en los checkboxes de la vista places/index
	 * @param int id (cagory)
	 * @sets array mixed categories(1 cat con modelos asociados), int show (usada en la vista)
	 */

	function get($id=null){
		$this->layout='ajax';
			$categories = $this -> Category->find('all', 
					array('recursive'=> '1', 
						'conditions'=>array('Category.id'=>$id)));
			$this->set('cats',$categories);    
			if($this->data){ $this->set('show',1);  }
			else {  $this->set('show',0); }
				
	}
	/*_setCategories
	 * setea una array con la lista de categorias para ser usado en un select
	 * @param void
	 * @return void
	 * @sets array mixed categories
	 */
	function _setCategories($parent = null){
		$options_arr = array(	'fields' => array('id','name'),
				'order'=>'Category.name ASC',
				'recursive'=> -1
				);
		if($parent != null){
			$options_arr = array(	'conditions'=> 'Category.parent = Category.id',
					'fields' => array('id','name'),
					'order'=>'Category.name ASC',
					'recursive'=> -1
					);

		}
		$categories = $this->Category->find ('list',$options_arr );  
		$this->set(compact('categories'));  
	}
	function admin_index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Category.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	/*admin_index
	 * setea una array con la lista de categorias usada en places/index.
	 * @param void
	 * @return void
	 * @sets array mixed categories, todas las categorias.
	 */
	function index(){
		$categories = $this->Category->find(
				'all',array (  
					'fields' => array('id', 'name','parent','photo'), 
					'order' => 'Category.parent, Category.id ASC',  
					'condition' => "parent != 0",
					'recursive' => -1)); 
			
			if(isset($this->params['requested'])){
				return $categories;
			}
			else{
				$this->set(compact('categories'));
			}  
	}
	/*admin_edit
	 * Editar un registro en la tabla de categories.
	 * nota: funcion solo a través del admin routing de Cake(group_id=1 en tabla users)
	 * @param int id (categoria)
	 * @return void
	 */
	function admin_edit($id = null){
		$this->Category->id = $id;
		$this->_setCategories(true);
			if(empty($this->data)){
				
				$this->data = $this->Category->read();
			} else {
				if($this->Category->save($this->data)){
					$this->Session->setFlash(__('category has been edited',true));
					 $this->redirect("index");
				}
			}
		
	}
	/*admin_delete
	 * Eliminar un registro en la tabla de categories.
	 * nota: funcion solo a través del admin routing de Cake(group_id=1 en tabla users)
	 * @param int id (categoria)
	 * @return void
	 */
	function admin_delete($id){
		$this->Category->del($id);
			$this->Session->setFlash(__('category-deleted',true));
			$this->redirect("index");
	}

	/*admin_add
	 * Añadir un nuevo registro en la base de datos de categorias.
	 * nota: funcion solo a través del admin routing.(group_id=1 en tabla users)
	 * @param void
	 * @return void
	 * @sets array mixed categories, todas las categorias.
	 */
	function admin_add() {
		$this->_setCategories(true);
		$uploaded = false; // to handle logic for displaying the success or failure
		$saved = false; // to handle logic for displaying the success or failure
		$needupload = false; // will be true if we actually want to upload something

		if (!empty($this->data)) {
			$this->Category->create();

			if ($this->Category->save($this->data)) {
				$saved = true;		
				if(!empty($this->data['Category']['pic']['name'])) {
					$needupload = true;
					$image_path = $this->Image->upload_image_and_thumbnail($this->data['Category']['pic'],200,200,32,32, "categories");

					if(isset($image_path)) {
						$this->Category->saveField('photo',$image_path);
						$uploaded = true;
					}
				}
			}

			if($saved && ($uploaded || !$needupload)) {
				$this->Session->setFlash(__('category-saved', true));
				$this->redirect(array('controller'=>'places','action'=>'index'));
			}
			else if($saved && !$uploaded && $needupload) {
				$this->Session->setFlash(__('image-4-category-not-saved', true));
				$this->Category->del($this->Category->id);
			}
			else {
				$this->Session->setFlash(__('category-not-saved', true));
			}
		}
	}


}
?>
