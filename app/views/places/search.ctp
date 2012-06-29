<table cellpadding="10" cellspacing="10" width="100%" id="table">
<?php
if(!empty($search)){?>
	<th align="center"><h2><?php __("Name")?></h2></th>
	<th align="center"><h2><?php __("Address")?></h2></th>
	<th></th>
	<?php
	foreach ($search as $data):
    	echo $googleMap->addMarker($data,'false'); ?>
	<tr onclick="<?php echo  $googleMap->showInfoWindow($data);?>">
		<td><p><?php echo $data['Place']['name'] ?></p></td>
		<td><p><?php echo $data['Place']['address'] ?></p></td>
		<td><p><?php echo $html->link(__('more..',true),'/places/view/' . $data['Place']['id'])?></p></td>
	</tr><?php
	endforeach;
}else{
	echo $googleMap->clearMarkers();
?>
	<th><?php __('No Results')?></th><?php
}?>
</table>
