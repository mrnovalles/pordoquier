<div style="width:319px;"><?php echo $html->image('tags/tags_top.png') ?></div>
<div id="tagBackground" style="width:319px;">
<?php
    $tags = $this->requestAction('tags/count');
    $tags2=array();
    foreach($tags as $tag){    
        $tags2 = array_merge($tags2, array($tag['Tag']['tag'] => $tag[0]['count']));     
    }
    
    $max_size = 15; $max_weight = 900; //max font size and max font weight
    $min_size = 7; $min_weight = 100; //min font size and min font weight

    $max_qty = max(array_values($tags2)); //the maximum data
    $min_qty = min(array_values($tags2)); //the minimum data
    $spread = $max_qty - $min_qty;
    
	if (0 == $spread) { 
        $spread = 1;
    }
    $step = ($max_size - $min_size)/($spread);
    $bold = ($max_weight - $min_weight)/($spread);
?>
<div style="padding-left:20px; padding-right:20px; width:290px;"><?php
shuffle($tags);
foreach ($tags as $tag){
	$value = $tag['0']['count'];
    $size = round($min_size + (($value - $min_qty) * $step),0);
    $weight = round($min_weight + (($value - $min_qty) * $bold),0);
	$rnd = rand(-10,10);
	if($rnd > 7){
		if($rnd == 8) {$color = "#76CBF2"; $borde="dashed";}
		if($rnd == 9) {$color = "#F7931E"; $borde="dotted";}
		if($rnd == 10){$color = "#CDD06E"; $borde="double";}
		$calco = "background-color:".$color."; border:2px ".$borde." #FFFFFF; padding:3px;";
	}else{
		$calco = "";
	}
	?>
    <a id="tagcloud" href="/pordoquier/tags/view/<?php echo $tag['Tag']['id'].'/'.$tag['Tag']['tag'];?>" style="font-weight:<?php echo $weight; ?>; font-size:<?php echo $size ?>pt; font-weight:bold; line-height:30px; text-decoration:none; color:#FFF; <?=$calco?> title=<?php echo $value.' '.$tag['Tag']['tag']?>;"><?php echo $tag['Tag']['tag']; ?></a>
    <?php
}?>
</div>
</div>
<div style="width:319px;"><?php echo $html->image('tags/tags_bottom.png') ?></div>