<h1><?php __('Add new Category');?></h1>
<?php
	echo $form->create(array('controller'=>'categories','action'=>'add','type'=>'file'));
	echo $form->input('parent',array('options'=>$categories,'label'=>__('parent',true)));
	echo $form->input('name',array('label'=>__('name',true)));
	echo $form->input('description',array('label'=>__('description',true)));
    echo $form->input('Category.pic', array('type'=>'file','label'=>__('Photo',true)));
	echo $form->end('Submit',array('label'=>__('Submit',true)));
?>