<?php $this->layout = "index"; 
$avg_lat = -32.8917;
$avg_lon = -68.8328;
$country = $ipToCountry->getCountry();
if($country['coordinates']){
	$coord = split(",",$country['coordinates']);
	//echo $country['city']." - ".$country['country'];
	$avg_lat = $coord[1];
	$avg_lon = $coord[0];
}
$default = array('type'=>'0','zoom'=> 1,'lat'=>$avg_lat,'long'=>$avg_lon);  ?>

<div id="content_index">
	<div id='intro_index'>
		<h3>Pordoquier </h3>
		<p><?php __('is a collection of places submitted by users to users') ?></p>
		<p><?php __('This info is showed on maps') ?></p>
	</div>	
	<div id="intro_map">
		<?php echo $googleMap->smallMap($default);
		$places = $this->requestAction(array('controller'=>'places','action'=>'last'));
		?>
	</div>
	<div id="last10">
		<h3><?php __('Last 5 places'); ?> </h3>
		<ul style="background:#76CBF2; opacity:0.9;">
		<?php foreach($places as $place):
		echo $googleMap->addMiniMarker($place);
		echo "<li>";
		echo $html->image('categories/small/'.$place['Category']['photo'],array('width'=>'15px','div'=>false)); 
		echo'<a href="#" onclick="'.$googleMap->ShowInfoWindow($place).'">'.$place['Place']['name'].'</a><span>('.$time->relativeTime($place['Place']['created']).')</span></li>';
		endforeach;
		?>
		</ul>
	</div>
	<div id="badge"><?php echo $html->link(__('Enter now!',true),'/places/index');?></div>
</div>
<div id="footer_index">
</div>
<div id="footerCiudades_index">
<div id="footer_logo">
			<?php echo $html->image('footer/logo_small.png'); ?><br />
			Copyright Pordoquier <?php echo date('Y')?>			
			</div>
			<div id="footer_cc">
			<?php echo __("The content displayed on this page of places, <br> maps and categories, is licensed under <br>",true).$html->link($html->image('footer/cc.png'),'http://creativecommons.org/licenses/by-nc-sa/2.5/deed.es_AR', null, null, false);
			?>
			 </div>
</div>
