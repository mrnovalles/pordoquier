<div class='adminIndex'>
<?php $paginator->counter(array('format'=>__('Page %page% of %pages%, showing %current% of %count%',true)));?>
<table class="admin">
	<tr> 
		<th><?php echo $paginator->sort(__('ID',true), 'id'); ?></th> 
		<th><?php echo $paginator->sort(__('Name',true), 'name'); ?></th> 
		<th><?php echo $paginator->sort(__('Addres',true),'address')?> </th>
		<th><?php __('Category')?>
		<th><?php echo $paginator->sort(__('Created',true),'created') ?>
		<th><?php echo __('Photos',true); ?>
		<th><?php echo __('Actions',true) ?>
	</tr> 
	   <?php foreach($data as $place): ?> 
	<tr> 
		<td><?php echo $place['Place']['id']; ?> </td> 
		<td><?php echo $place['Place']['name']; ?> </td> 
		<td><?php echo $place['Place']['address']; ?> </td> 
		<td><?php echo $place['Category']['name']; ?> </td> 
		<td><?php echo $place['Place']['created']; ?> </td>
		<td><?php 
		foreach($place['Photo'] as $photo){
			echo $html->link($html->image("places/small/".$photo['photo'],array('border'=>0)), '/img/places/big/'.$photo['photo'],array('escape'=>false,'rel'=>'shadowbox['.$place['Place']['id'].']'));		
			echo $html->link(__('Delete',true),array('controller'=>'places','action'=>'deleteImg/'.$photo['id']),false,'Delete image?',false);
		}
		?>
		</td>
                <td>
<?php 
echo $html->link($html->image('edit.png',array('border'=>'0','alt'=>'edit','title'=>__('Edit',true))),'edit/' . $place['Place']['id'],array('title'=>'Edit place'),false,false)?>
<?php echo $html->link($html->image('inbox/delete.png',array('border'=>'0','title'=>__('Delete',true))),'delete/' . $place['Place']['id'],array('title'=>'Delete place'),'Are you sure?',false)?>
				</td>
 

	</tr> 
	<?php endforeach; ?> 
</table> 
<div class="paginator">
<?php 
echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
echo $paginator->numbers();
echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
?>
</div>
</div>