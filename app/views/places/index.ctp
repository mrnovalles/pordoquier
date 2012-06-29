<!-- ////////////////////////////////////////// MAP //////////////////////////////////////// -->
<div id='map'><?php
    $avg_lat = -32.8917;
    $avg_lon = -68.8328;
    $country = $ipToCountry->getCountry();
        if($country['coordinates']){
            $coord = split(",",$country['coordinates']);
            echo $country['city']." - ".$country['country'];
            $avg_lat = $coord[1];
            $avg_lon = $coord[0];
        }
    $default = array('type'=>'0','zoom'=> 6,'lat'=>$avg_lat,'long'=>$avg_lon);  ?>
	<?php echo $googleMap->map($default);?>
</div>
<!-- /////////////////////////////////////// SIDEBAR /////////////////////////////////////// -->
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
			<div id="category_list"><?php echo $this->element('category_list');?></div>
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
<div style="margin-left:45px; margin-top:20px;"><?php echo $this->element('tagcloud');?></div>
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
