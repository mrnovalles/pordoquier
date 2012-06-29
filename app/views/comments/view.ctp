<div id="comments_view_menu" style="margin:20px;">
	    <?php echo '<div>'.$ajax->link(__('Reply',true),array('controller'=>'comments','action'=>'add',$comments['Comment']['user_id']),array('update'=>'comments_view_msj','class'=>'reply'));?>
    	<?php echo $ajax->link(__('Close',true),'',array('complete'=>'Effect.toggle("comments_view'.$comments['Comment']['id'].'", "blind", {duration: 0.4}); return false;','class'=>'close'),NULL,NULL); ?>		
</div>	
<div id="comments_view_msj">
	<div class="text"><?php echo $comments['Comment']['comment'];?></div>
</div>
