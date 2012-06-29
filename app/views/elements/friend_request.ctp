<?php $req=$this->requestAction('friends/request'); ?>
<span id="count" class="blink"></span>
<?php
if(count($req)==0) echo "<script>Element.hide('requests')</script>"; ?>
<?php echo $html->link(__('friend requests',true),'#',array('onclick'=>"Element.show('element_friend_request');return false;",'id'=>'counter','class'=>'blink')); ?>
<div id="element_friend_request" style="display:none;">
		<?php foreach($req as $n=>$friend){ 
			   echo "<div id='confirm".$n."'>";
			   echo $friend['User']['name'].' '.$friend['User']['lastname']." | ";
			   echo $ajax->link(__('Confirm',true), array('controller'=>'friends','action'=>'confirm',$friend['User']['id']),
				   array('complete'=>"Element.hide('confirm".$n."');Element.hide('loading2');less()",'update'=>'footer','loading'=>'loading2'));   ?> 
				</div>	<?php }
		echo $html->link(__('Clear',true),'#', array('onclick'=>"Element.hide('element_friend_request');return false;",'id'=>'clear')); ?>
</div>
<script>
	c = <?php echo count($req); ?>;
	if(c == 0){
		document.getElementById("counter").style.display = 'none'
		document.getElementById("count").style.display = 'none'
	}else{
		document.getElementById("count").innerHTML = c;
	}
	function less(){
		c = c-1;
		document.getElementById("counter").innerHTML = c;
	}
</script>