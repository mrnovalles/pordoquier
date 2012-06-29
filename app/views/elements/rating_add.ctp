<div id="element_rating_add">
<?php
$options= array ('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4', '5'=>'5');

echo $form->create('Rating');
echo $form->input('value',array('type'=>'select','options'=>$options));
echo $ajax ->observeField('RatingValue', array(
                                               'url'=>array('controller'=>'ratings','action'=>'add',$place_id),
                                               'update'=>'result',
                                               'complete'=> 'alert("This Place has been rated. Thank U!")'
                                                ));

?>
</form>
</div>
