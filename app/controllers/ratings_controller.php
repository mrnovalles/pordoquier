<?php
 /*app/controllers/ratings_controller.php
  * Contiene las acciones del controlador ratings para dar puntaje a los sitios.
  * @authors: Mariano Vallés & Pablo Herrera
  */
class RatingsController extends AppController {
    var $helpers = array('Html','Form', 'Javascript','Ajax');
     /*add
     * Guarda un rating en la tabla de ratings para un determinado lugar.
     *note: es llamado desde la vista de places/view a través de una $ajax-link
     * @params int $place_id
     * @sets void
     */
    function add($place_id){
        $this->layout='ajax';
        if($this->data)
           {
           $this->data['Rating']['place_id']= $place_id;      
           $this->Rating->save($this->data);       
           $this->_calculate($place_id);

           }
    }
     /*private _calculate
     * Calcula el ratind de una determinado lugar en base a los registros de la tabla ratings
     *note: es llamado desde add rating, para recalcular el rating de un lugar cuando este cambia
     * @params int $place_id
     * @sets void
     */
    function _calculate($place_id)
    {
     $values= $this->Rating->find('list',array('conditions'=>array('place_id'=> $place_id),
                                                'fields'=>array('id','value')));
     $i=0;
     $total=0;
         foreach($values as $value){
                $total=$total+$value;      
                $i++;
          }
     $avg=$total/$i;
     $this->Rating->Place->id = $place_id;
     $this->Rating->Place->saveField('rating', $avg);
     $this->set('total_value', $avg);
    }
}
?>
