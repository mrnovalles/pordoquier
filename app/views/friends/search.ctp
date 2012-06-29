
<?php
if(!empty($search)){?>
	<?php
	foreach ($search as $data):?>
	<div style="margin-top:30px;">
		<div style="float:left; margin:4px;"><?php echo $html->image("users/small/".$data['User']['photo']);?></div>
		<div><?php
			echo $data['User']['name']." ".$data['User']['lastname']."<br>";
			echo $data['User']['country']." - ".$data['User']['birthdate']."<br>";
			echo $html->link(__('Add',true),'/friends/add/'.$data['User']['id'])?>
		</div>
	</div><?php
	endforeach;
}else{
	__('No results');
}?>
