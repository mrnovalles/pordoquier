<?php
class Place extends AppModel {
	var $name = 'Place';
	/*Model Associations */
	var $hasAndBelongsToMany = array(
			'Tag' => array(
				'className' => 'Tag',
				'joinTable' => 'places_tags',
				'foreignKey' => 'place_id',
				'associationForeignKey' => 'tag_id',
				),
			); 
	var $belongsTo = array('Category','User');
    var $hasMany = array('Rating','Pcomment','Photo');
    /* Model validation */
    var $validate = array (
                    'name'=>array(
                                'ruleNotEmpty'=>array('rule'=>'notEmpty'),
                                'ruleMaxLength'=> array('rule' => array('maxLength',60),'required'=>true)
                            ),

			'address'=>array(
				'ruleMinLength'=> array( 'rule' => array('minLength',1) ),  
				'ruleMaxLength'=> array( 'rule' => array('maxLength',60))
				),
			'latitude'=>'notEmpty','longitude'=>'notEmpty','tags'=>array('rule'=>array('maxLength',30)));
	var $actsAs = array('Tag'=>array('table_label'=>'tags', 'tags_label'=>'tag', 'separator'=>','));
}
?>
