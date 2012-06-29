<div id="comments_index">
<table width="98%" border="0" cellpadding="0" cellspacing="0" style="margin-left:10px;">
	<tr>
		<td class="roundedTopLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedTopRightWhite">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">
			<table id="table_inbox">
			<tr>
				<th></th>
				<th><h3><?php __('From')?></h3></th>
				<th><h3><?php __('Description'); ?></h3></th>
				<th></th>
				<th></th>
				<th colspan="2" align="center"></th>
				<?php 
					$today = date("d/m");
					$todayHour = date("h:m");
					$read = 0;
					if($comments != NULL){
					foreach($comments as $n=>$view):
						if($view['Comment']['read'] != 0){
							$show = "bgcolor=\"#F7F7F7\"";
						}else{
							$show = "";
						}
					?>
			</tr>
			<tr <?php echo $show; ?> id="tr_<?=$n?>">
				<td><div align="center">
						<?php if($view['Comment']['read'] == 0){ 
								$read ++;
								echo $ajax->link($html->image('inbox/close.png',array('border'=>'0')),array('controller'=>'comments','action'=>'view',$view['Comment']['id']),array('update'=>'comments_view'.$view['Comment']['id']),NULL,NULL);
							   }else{
								echo $ajax->link($html->image('inbox/open.png',array('border'=>'0')),array('controller'=>'comments','action'=>'view',$view['Comment']['id']),array('update'=>'comments_view'.$view['Comment']['id']),NULL,NULL);
								}?>
				</div></td>
				<td><?php echo $ajax->link($fromUser['0']['User']['name']." ".$fromUser['0']['User']['lastname'], array('controller'=>'comments','action'=>'view',$view['Comment']['id']),array('update'=>'comments_view'.$view['Comment']['id']));?></td>
				<td><?php echo $ajax->link(substr(strip_tags($view['Comment']['comment']),0, 100)."...", array('controller'=>'comments','action'=>'view',$view['Comment']['id']),array('update'=>'comments_view'.$view['Comment']['id']));?></td>
				<td><?php 
						if($view['Comment']['date'] == $today)
							echo $view['Comment']['time']." hs.";
						else
							echo $view['Comment']['date'];
						?></td>
				<td><?php echo $ajax->link($html->image('inbox/delete.png',array('border'=>'0','title'=>__('Delete',true))),array('controller'=>'comments','action'=>'delete',$view['Comment']['id']),array('update'=>'tr_'.$n,'complete'=>'Element.hide(\'tr_'.$n.'\')'),__('Are you sure?',true),NULL);?></td>
			</tr>
			<tr <?php echo $show; ?>>
				<td colspan="5"><?php echo "<div id='comments_view".$view['Comment']['id']."'></div>"; ?></td>
			</tr>
			<?php endforeach; ?>
						<tr><td><div style="margin-top:50px; margin-left:250px; position:absolute;"><h3><?php
					if($read == 0)
						 __("No new messages");
					}
					if($read == 1){
						echo __("You have ",true).$read.' '. __(" unread messages",true);
					}?></h3></div>
					</td></tr>
		</table></td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF"><?= $html->image("inbox/inbox_03.png");?></td>
		<td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td class="roundedBottomLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedBottomRightWhite">&nbsp;</td>
	</tr>
</table>
</div>
