<div id='map' align="center"><?php
        $avg_lat = $place['Place']['latitude'];
        $avg_lon = $place['Place']['longitude'];
        $default = array('type'=>'0','zoom'=> 14,'lat'=>$avg_lat,'long'=>$avg_lon);
        echo $googleMap->map($default);
        echo $googleMap->addMarker($place,"true");?>
</div>
<div id="sidebar">
	<?php echo $form->create('Place'); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="roundedTopLeft">&nbsp;</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td class="roundedTopRight">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td bgcolor="#DDDDDD">
		<table width="100%" border="0" id="table_listPlaces">
		  <th colspan="2"><p align="left"><h3>Edit your place</h3></p></th>
		  <tr>
			<td><?php __('Name') ?></td>
			<td><?php echo  $form->input('name',array('label'=>false, 'error'=>__('only-alphabets-and-numbers-allowed', true))); ?></td>
		  </tr>
		  <tr>
			<td><?php __('Address') ?></td>
			<td><?php echo  $form->input('address',array('label'=>false,'error'=>__('only-alphabets-and-numbers-allowed', true))); ?></td>
		  </tr>
		  <tr>
		  <td><?php __('Description')?></td>
		  <td><?php echo  $form->input('description',array('label'=>false,
					  'error'=> __('error-only-alphabets-and-numbers-allowed', true))); 
?></td>
</tr>

<tr>
			<td><?php __('Latitude') ?></td>
			<td><?php echo  $form->input('latitude',array('readonly'=>'readonly','onfocus'=>'alert("'.__('Drag the marker to a new position to set new position',true).'")','label'=>false,'error'=> __('not-empty-search-first',true))); ?></td>
		  </tr>
		  <tr>
			<td><?php __('Longitude') ?></td>
			<td><?php echo  $form->input('longitude',array('readonly'=>'readonly','label'=>false,'onfocus'=>'alert("'.__('Drag the marker to a new position to set new position',true).'")','error'=> __('not-empty-search-first',true))); ?></td>
		  </tr>
		  <tr>
			<td><?php __('Category')?></td>
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
				echo $html->link(__('Delete',true),'/places/deleteimg/'.$pic['id'].'/'.$pic['place_id']);
			}?>		
	</td>
		  </tr>
		  <tr>
			<td colspan="2"><?php echo  $form->end(__('Save new data',true)); ?></td>
		  </tr>  
		</table>	
		</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
	</tr>
	<tr>
		<td class="roundedBottomLeft">&nbsp;</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td class="roundedBottomRight">&nbsp;</td>
	</tr>
</table>
</div>
