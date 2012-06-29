<?php
    class Pcomment extends AppModel{
	var $name = 'Pcomment';
	var $belongsTo = 'Place';
	var $validate = array(
				'comment'=>'notEmpty'
	);

}
?>
