<div id="friends_info">
		<h2><?php echo $view[0]['User']['name']." ".$view[0]['User']['lastname'];?></h2>
			<p><b><?php __('Birthdate:')?></b> <?php echo $view[0]['User']['birthdate'];?></p>
			<p><b><?php __('Country:')?></b> <?php echo $view[0]['User']['country'];?></p>
			<p><b><?php __('Email:')?></b> <?php echo $view[0]['User']['email'];?></p>
			<p><?=$html->image('users/big/'.$view[0]['User']['photo'])?></p>
</div>
<div id="friends_places">
<h2><?php __('Places') ?></h2><?php
foreach ($places as $data):
	echo "<p>";
	foreach($data['Photo'] as $pic){
	echo $html->link($html->image('places/small/'.$pic['photo']),"../img/places/big/".$pic['photo'],array('escape'=>false,'rel'=>'shadowbox[place]'));
};
	echo "<br/>";
	echo $html->link($data['Place']['name'],'/places/view/' . $data['Place']['id']);
	echo " - ".$data['Place']['address']." - ".$data['Category']['name']."<br><i>".$data['Place']['description']."</i>";
    $r = $data['Place']['rating'];
		while($r > 0){
			if($r > 0 && $r < 1){
				if($r > 0.25 && $r < 0.75)
					echo $html->image('halfstar.png');
				else if($r >= 0.7)
					echo $html->image('star.png');
			}else{
				echo $html->image('star.png');
			}
			$r = $r-1; 
		}
	echo "</p>";
	endforeach;	?>	
</div>