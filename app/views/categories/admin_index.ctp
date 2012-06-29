<div class="adminIndex">
<h2><?php __('Categories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0" class="admin">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('parent');?></th>
	<th><?php echo $paginator->sort('photo');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($categories as $category):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $category['Category']['id']; ?>
		</td>
		<td>
			<?php echo $category['Category']['name']; ?>
		</td>
		<td>
			<?php echo $category['Category']['description']; ?>
		</td>
		<td>
			<?php echo $category['Category']['parent']; ?>
		</td>
		<td>
			<?php echo $category['Category']['photo']; ?>
		</td>
		<td class="actions">
<?php echo $html->link($html->image('view.png',array('border'=>'0','title'=>__('View',true))),array('action'=>'view', $category['Category']['id']),false,false,false); ?>
<?php echo $html->link($html->image('edit.png',array('border'=>'0','title'=>__('Edit',true))), array('action'=>'edit', $category['Category']['id']),false,false,false); ?>
<?php echo $html->link($html->image('inbox/delete.png',array('border'=>'0','title'=>__('Delete',true))), array('action'=>'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id']),false,false,false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('div'=>false,'class'=>'disabled'));?>
 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled','div'=>false));?>
</div>
<br />
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Category', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Places', true), array('controller'=> 'places', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Place', true), array('controller'=> 'places', 'action'=>'add')); ?> </li>
	</ul>
</div>
</div>