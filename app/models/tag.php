<?php
class Tag extends AppModel {
    var $name = 'Tag';
    var $hasAndBelongsToMany = array(
	        'Place' => array(
            'className' => 'Place',
            'joinTable' => 'places_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'place_id',
        ),
    ); 
    var $actsAs = 'ExtendAssociations';     
    }
?>
