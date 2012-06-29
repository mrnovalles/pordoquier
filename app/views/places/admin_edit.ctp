<div class="adminEdit">
    <div id="places_content">
	<?php echo $form->create('Place'); ?>
    <table border="0" class="admin">
      <th colspan="2"><h3>Edit your place</h3></th>
      <tr>
        <td>Name</td>
        <td><?php echo  $form->input('name',array('label'=>false, 'error'=>_('only-alphabets-and-numbers-allowed', true))); ?></td>
      </tr>
      <tr>
        <td>Address</td
        ><td><?php echo  $form->input('address',array('label'=>false,'error'=>_('only-alphabets-and-numbers-allowed', true))); ?></td>
      </tr>
      <tr>
        <td>Latitude</td>
        <td><?php echo  $form->input('latitude',array('label'=>false,'error'=> __('not-empty-search-first',true))); ?></td>
      </tr>
      <tr>
        <td>Longitude</td>
        <td><?php echo  $form->input('longitude',array('label'=>false,'error'=> __('not-empty',true))); ?></td>
      </tr>
      <tr>
        <td>Category</td>
        <td><?php echo  $form->input('Place.category_id',array('type'=>'select','options'=>$categories,'label'=>'Categories','label'=>false)); ?></td>
      </tr>
      <tr>
        <td>Tags</td>
        <td><?php echo  $form->input('tags',array('label'=>false)); ?></td>
      </tr>
      <tr>
	<td colspan="2"><?php
		foreach($place['Photo'] as $pic){
			echo $html->image('places/small/'.$pic['photo']);
			echo $html->link('Delete',array('controller'=>'places', 'action'=>'deleteImg/'.$pic['id']),false,'Sure?',false);
		}?>		
</td>
      </tr>
      <tr>
        <td colspan="2"><?php echo  $form->end('Edit'); ?></td>
      </tr>  
    </table>	
    </div>
</div>
