<div class="adminEdit">
<?php echo $form->create('Category');?>
	<fieldset>
 		<legend><h3><?php __('Edit Category');?></h3></legend>
	<?php
		echo $form->input('id');
		echo $form->input('parent',array('options'=>$categories));
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Category.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Category.id'))); ?></li>
		<li><?php echo $html->link(__('List Categories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Places', true), array('controller'=> 'places', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Place', true), array('controller'=> 'places', 'action'=>'add')); ?> </li>
	</ul>
</div>
</div>