<?php
class Category extends AppModel{
    var $name = 'Category';
    var $hasMany = array('Place');
    /*var $actsAs = array(
		'Translate' => array(
			'name'
		)
	);
    */

}
?>
