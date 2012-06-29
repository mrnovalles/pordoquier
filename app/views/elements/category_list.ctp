<div id="element_cat">
<h2><?php __('Categories') ?></h2>
<?php 
$categories = $this->requestAction('categories/index');
$options = array('id'=>'form1');
echo $form->create('form1',$options);
foreach($categories as $cat){
	if($cat['Category']['parent'] == $cat['Category']['id']){
		echo "<hr color=\"#CCCCCC\"><h3>".$cat['Category']['name']."</h3>";
	}else{
		 echo $html->image("categories/small/".$cat['Category']['photo'],array('width'=>'16px'));
		 echo $form->input('Place.Category'.$cat['Category']['id'],
						 array(	'type'=>'checkbox',
								'label'=>$cat['Category']['name'],
								'div'=>false,
								'options'=>array($cat['Category']['id']=>$cat['Category']['name']))); 
		echo "&nbsp;&nbsp;";		 
		 echo $ajax->observeField('PlaceCategory'.$cat['Category']['id'],
			array('url' => array( 'controller' => 'categories', 'action' => 'get', $cat['Category']['id']),
				  'frequency' => 1,
				  'update'=>'cat',
                  'loading' => "Element.show('loading')",
                  'complete' => "Element.hide('loading')")); 
	}
}
?>
</form>
</div>
<div id='cat'>
</div>
