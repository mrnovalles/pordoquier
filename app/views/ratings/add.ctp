<div id="ratings_add">
<?php
if(isset($total_value)){
	echo __('Rating: ',true).$total_value;
}else{
	$options= array ('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4', '5'=>'5');

echo $form->create('Rating');
echo $form->input('value',array('type'=>'select','options'=>$options,'label'=>__('Select a value',true)));
echo '</form>';
echo $ajax ->observeField('RatingValue', array(
                                               'url'=>array('controller'=>'ratings','action'=>'add',$this->params['pass'][0]),
                                               'update'=>'result',
                                                'complete'=> 'alert("This Place has been rated. Thank U !")'
                                                ));


}
?>
</div>
