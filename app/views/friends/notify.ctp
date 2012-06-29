<div id="friend_notify"><?php 
if($friends){
	foreach($friends as $n=>$friend){
		if($c=count($places[$n]) > 0){
			echo $friend['User']['name'].' '.$friend['User']['lastname'].  __('has added',true).' '. $c.' '. __('places',true);
			foreach($places[$n] as $place){
				echo $html->link($place['Place']['name'],'/places/view/'.$place['Place']['id']);    
			}
		}
		else{
			__('No updates');
		}

	}
}
echo $html->link(__('Clear',true),'#', array('onclick'=>"Element.hide('friend_updates');return false;","id"=>"clear")); 
?>
</div>
