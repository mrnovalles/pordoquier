	<div id='map' align="center"><?php
		$avg_lat = -32.8917;
		$avg_lon = -68.8328;
		$default = array('type'=>'0','zoom'=> 14,'lat'=>$avg_lat,'long'=>$avg_lon);
		echo $googleMap->map($default);
		echo $googleMap->addMarkers($listPlaces);?>
    </div>
    
    <div id="sidebar">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="roundedTopLeft">&nbsp;</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td class="roundedTopRight">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td bgcolor="#DDDDDD">
				<h3><?php __('My Places'); ?></h3>
				<?php 
				if(empty($listPlaces)){
					echo '<h3>'.__('No places yet. ',true).$html->link(__('Add a new place',true),array('controller'=>'places', 'action'=>'add')).'<h3>';
				}
				else{ 
					foreach($listPlaces as $place):?>
					<div class="places">
							<?php echo $html->link($place['Place']['name'],"#",array('onclick'=>$googleMap->showInfoWindow($place)));?>
							<div class="places_details"><?php echo $place['Place']['address']?><br>
							<?php echo __('Category:',true)." ".$place['Category']['name']?><br>
							<?php echo __('Rating:',true)." ".$place['Place']['rating']?>
							</div>
							<?php foreach($place['Photo'] as $p):
							
echo $html->link($html->image('places/small/'.$p['photo']),'../img/places/big/'.$p['photo'],array('escape'=>false,'rel'=>'shadowbox['.$place['Place']['id'].']'));
							endforeach; ?>
						
						<div style="float:right; margin-top:17px;" id="actions">	
						<?php echo $html->link(__('View',true),'/places/view/' . $place['Place']['id'],false,false,false)?>
						<?php echo $html->link(__('Edit',true),'/places/edit/' . $place['Place']['id'],false,false,false)?>
						<?php echo $html->link(__('Delete',true),'/places/delete/' . $place['Place']['id'],false,__('Are you sure?',true),false)?>
						</div>
					</div>
						<?php
					endforeach;	
				}?>
				<div>
				<?php 
					echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
					echo $paginator->numbers();
					echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
				?>
				</div>
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
