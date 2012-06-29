<div id="map">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#FFF;">
	<tr>
		<td class="roundedTopLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedTopRightWhite">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">
			<h3><?php  __('Your Friends are') ?></h3><br /><?php
			if($friends != 0){
				foreach($friends as $view=>$n){	?>
				<div class="friend_list">
				<?php echo $html->image('users/small/'.$n['0']['User']['photo']);?>
				<p><?php echo $html->link($n['0']['User']['name']." ".$n['0']['User']['lastname'], '/friends/view/'.$n['0']['User']['id']);?></p>
						<?php echo $ajax->link(__('Comment',true),array('controller'=>'comments','action'=>'add',$n['0']['User']['id']),
														 array('update'=>'friend_comment'.$view));?>
                                                                
						<?php echo $html->link(__('Delete',true),"/friends/delete/{$n['0']['User']['id']}",null,'Are you sure?')?>
				<?php echo "<div id='friend_comment".$view."'></div>"; ?>
				</div>
                 <?php 
				}
			}else{
				__('Isn\'t it sad. You have no friends. Search for some');
			}?>  
		</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
	<tr>
		<td class="roundedBottomLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedBottomRightWhite">&nbsp;</td>
	</tr>
</table>
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
			<form id="formSearch" name="formSearch" accept-charset="UNKNOWN" enctype="application/x-www-form-urlencoded" method="get">
			<h2><?php __('Search for friends') ?></h2><br />
			<input id="query" maxlength="256" name="query" size="25" type="text" />
			<div id="loading" style="display:none"><?php echo $html->image("spinner.gif") ?></div><?php
				$options = array(
					'update' => 'view',
					'loading'=> 'Element.show(\'loading\')',
					'complete' => 'Element.hide(\'loading\')',
					'url'    => '/friends/search/',
					'frequency' => 1);
				
				print $ajax->observeField('query', $options);?>
			</form>
			<div id="view"></div>
			<div style="margin-top:150px; margin-right:auto; margin-left:10px;"><?php echo $html->image("friends/friends.png")?></div>
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
