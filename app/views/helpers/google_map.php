<?php
/*
 * CakeMap -- a google maps integrated application built on CakePHP framework.
 * Copyright (c) 2005 Garrett J. Woodworth : gwoo@rd11.com
 * rd11,inc : http://rd11.com
 *
 * @author      gwoo <gwoo@rd11.com>
 * @version     0.10.1311_pre_beta
 * @license     OPPL
 *
 * Modified by 	Mahmoud Lababidi <lababidi@bearsontherun.com>
 * Date			Dec 16, 2006
 * 
 * Modified by 	Mariano Valles & Pablo Herrera 
 * Date			Mar 2009
 *
 */
class GoogleMapHelper extends Helper {
    var $helpers = array('Html');
	var $errors = array();

	function map($default, $places = NULL){
		$out = "<div id=\"map\"></div>";
		$out .= "
		<script type=\"text/javascript\">
		//<![CDATA[
		if (GBrowserIsCompatible()){	
			var map = new GMap2(document.getElementById(\"map\"));			
			map.setMapType(map.getMapTypes()[".$default['type']."]);
			map.setUIToDefault();
			point = new GLatLng(".$default['lat'].", ".$default['long'].")
			map.setCenter(point, ".$default['zoom'].");
			geocoder = new GClientGeocoder();
		}
		</script>";
		return $out;
	}
	function smallMap($default, $places = NULL){
		$out = "<div id=\"smallMap\"></div>";
		$out .= "
		<script type=\"text/javascript\">
		//<![CDATA[
		if (GBrowserIsCompatible()){	
			var map = new GMap2(document.getElementById(\"smallMap\"));			
			map.setMapType(map.getMapTypes()[".$default['type']."]);
			map.setUIToDefault();
			point = new GLatLng(".$default['lat'].", ".$default['long'].")
			map.setCenter(point, ".$default['zoom'].");
			geocoder = new GClientGeocoder();
		}
		</script>";
		return $out;
	}
	function addPlace($address) {
		$out = "
			<script type=\"text/javascript\">
				if (geocoder) {
				geocoder.getLatLng('".$address."',
				function(point) {
                                if (!point) {
                                    alert('".$address."' + \" not found\");
                                } else {
					map.setCenter(point, 13);
					var marker = new GMarker(point,{draggable:true});
					map.addOverlay(marker);
					marker.openInfoWindowHtml('".__('Drag this marker around to set a new position',true)."');

					".$this->getIconCode("default")."
					
					var point = marker.getPoint();
					var latitude = document.getElementById('PlaceLatitude');
					latitude.setAttribute('value',point.lat());
					var longitude = document.getElementById('PlaceLongitude');
					longitude.setAttribute('value',point.lng());
					
					GEvent.addListener(marker, \"dragend\", function() {
						var point = marker.getPoint();
						var latitude = document.getElementById('PlaceLatitude');
						latitude.setAttribute('value',point.lat());
						var longitude = document.getElementById('PlaceLongitude');
						longitude.setAttribute('value',point.lng());
						marker.openInfoWindowHtml('".$address."');
					});
					
					addr = document.getElementById('PlaceAddress');
					addr.setAttribute('value','".$address."');
				
					subutton = document.getElementById('submit');
					subutton.setAttribute('value','".__('Clear results',true)."');
                                }
                       });
	         }
		//]]>
		</script>"; 
		return $out;
    }
		

 	function getIconCode($image){
 			if($image == 'default'){
				$image== 'default.png';
			}
			$out ='
				icon = new GIcon();
				icon.image = \'/pordoquier/img/categories/small/'.$image.'\';    
				icon.shadow = \'/pordoquier/img/categories/shadows/'.$image.'\';'; 
			$out .= "
				icon.iconSize = new GSize(32, 32);
				icon.shadowSize = new GSize(32, 32);
				icon.iconAnchor = new GPoint(6, 20);
				icon.infoWindowAnchor = new GPoint(5, 1);";
			return $out;
	}

	function addMarkers($data){
		$out = "
			<script type=\"text/javascript\">
			//<![CDATA[
			if (GBrowserIsCompatible()) 
			{
			";
			if(is_array($data)){
				foreach($data as $m){              
					$out .= $this->addMarker($m,"false",true);	    
				}
			}
			$out .=	"}
			//]]>
			</script>";
		return $out;
	}

    
	function addMarkersFromCat(&$data, $r=null)
	{
		$out = "
			<script type=\"text/javascript\">
			//<![CDATA[
			if (GBrowserIsCompatible()) 
			{
			";
            foreach($data as $category){
                    $out .=$this->getIconCode($category['Category']['photo']);
                    foreach ($category['Place'] as $point){
                            $i=$point['id'];    					
                            $out .="
			    	var point".$i." = new GLatLng(".$point['latitude'].",".$point['longitude'].");
					marker".$i." = new GMarker(point".$i.",icon);
			    	map.addOverlay(marker".$i.");
					
					GEvent.addListener(marker".$i.", \"click\", 
			    	function() {
					map.setCenter(point".$i.", 14);
			    		marker".$i.".openInfoWindowHtml('<a href=/pordoquier/places/view/".$point['id'].">".$point['name']."</a> -".$point['address']."<br>".$point['description']."<br>".__('Category',true).": ".$category['Category']['name']."<br>Rating: ".$point['rating']."')
			    	});";
                        }
				    }
			 $out .=	"} 
				//]]>
			</script>";
	return $out;
	}
    
	function addMarker($data,$drag,$from=null){
			if(!empty($data['Category'])){        
				$outt =$this->getIconCode($data['Category']['photo']);
			}else{
				$outt = $this->getIconCode("default");
			}
			$outt .="
					point = new GLatLng(".$data['Place']['latitude'].", ".$data['Place']['longitude'].")
					map.setCenter(point, 5);
					var marker = new GMarker(point,{icon:icon, draggable:".$drag."})
					map.addOverlay(marker);";
			//Aca tendria que ir el listener para poder ir a esa funcion cdo se haga click sobre el icono		
			$outt .= 'GEvent.addListener(marker, "click",function() {'.$this->showInfoWindow($data).'});';

			if($from){
				$out = $outt;
			}else{
				$out = "
				<script type=\"text/javascript\">
				//<![CDATA[
				".$outt."
						GEvent.addListener(marker, \"dragend\", function() {
							var latlng = marker.getPoint();	
							var latitude = document.getElementById('PlaceLatitude');
							latitude.setAttribute('value',latlng.lat());
							var longitude = document.getElementById('PlaceLongitude');
							longitude.setAttribute('value',latlng.lng());
							marker.openInfoWindowHtml('".$data['Place']['name']."','".$data['Place']['address']."');
                    	})
				//]]>
				</script>";
			}
			return $out;
	}
	function addMiniMarker($data){
			if(!empty($data['Category'])){        
				$outt =$this->getIconCode($data['Category']['photo']);
			}else{
				$outt = $this->getIconCode("default");
			}
			$outt .="
					point = new GLatLng(".$data['Place']['latitude'].", ".$data['Place']['longitude'].")
					var marker = new GMarker(point,{icon:icon})
					map.addOverlay(marker);";
			$outt .= 'GEvent.addListener(marker, "click",function() {'.$this->showInfoWindow($data).'});';
			$out = "
				<script type=\"text/javascript\">
				//<![CDATA[
				".$outt."
				//]]>
				</script>";
	return $out;
	}
	
	function addClick($var, $script=null){
		$out = "
			<script type=\"text/javascript\">
			//<![CDATA[
			if (GBrowserIsCompatible()) 
			{
			" 
			.$script
			.'GEvent.addListener(map, "click", '.$var.', true);'
			."} 
				//]]>
			</script>";
		return $out;
	}	
    

    function addDragMarkerOnClick($innerHtml = null){
		$mapClick = '
                    /*counter = 0;
                    var mapClick = function (overlay, point) {
                    var point = new GPoint(point.x,point.y);
                    var marker = new GMarker(point,{draggable:true});
                    var point = marker.getPoint();                     
                    
                    if(counter==0){
                        map.addOverlay(marker);

                        var lat = document.getElementById(\'PlaceLatitude\')                
                        lat.setAttribute(\'value\',point.lat())
                        var lng = document.getElementById(\'PlaceLongitude\')                
                        lng.setAttribute(\'value\',point.lng())

                        GEvent.addListener(marker, "dragstart", function() {
                            map.closeInfoWindow();
                        });
                        
                        GEvent.addListener(marker, "dragend", function() {
                            var point = marker.getPoint(); 

                            var lat = document.getElementById(\'PlaceLatitude\')                
                            lat.setAttribute(\'value\',point.lat())
                            var lng = document.getElementById(\'PlaceLongitude\')                
                            lng.setAttribute(\'value\',point.lng())
                            marker.openInfoWindowHtml("Just bouncing along...");
                        });
                        }
                        counter = 1;
        }*/
		';
		return $this->addClick('mapClick', $mapClick);
	}	
	
    function addMarkerOnClick($innerHtml = null){
		$mapClick = '
			var mapClick = function (overlay, point) {
				var point = new GPoint(point.x,point.y);
                var marker = new GMarker(point,icon);
				map.addOverlay(marker)
				GEvent.addListener(marker, "click", 
				function() {
					marker.openInfoWindowHtml('.$innerHtml.');
				});
			}
		';
		return $this->addClick('mapClick', $mapClick);
	}

	function showInfoWindow($data){
		$out = "
			var point = new GLatLng(".$data['Place']['latitude'].", ".$data['Place']['longitude'].")
			map.setCenter(point, 15);
			var marker = new GMarker(point,icon);
			map.openInfoWindowHtml(point,'<a href=/pordoquier/places/view/".$data['Place']['id'].">".$data['Place']['name']."</a> - ".$data['Place']['address']."<br>".__('Category',true).": ".$data['Category']['name']."<br>Rating: ".$data['Place']['rating']."<br>". __('Submitted by',true).": ".$data['User']['username']."<br>";	
			foreach($data['Tag'] as $tag):
				$out .= "<a href=/pordoquier/tags/view/".$tag['id'].">".$tag['tag']."</a>, ";
			endforeach;
			if(!empty($data['Photo'])){
				if(strlen($data['Photo']['0']['photo'])>0){
					for($i=0;$i<2;$i++){
						$pic = $data['Photo'][$i];
						$out .= "<a href=/pordoquier/places/view/".$data['Place']['id']."><img src=/pordoquier/img/places/small/".$pic['photo']." border=0 /></a>";
					}
				}
			}
		$out .= "');";	
		return $out;
	}
	
	function clearMarkers(){
		$out =" 
			<script type=\"text/javascript\">
			//<![CDATA[
			map.clearOverlays();
			//]]>
			</script>";
		return $out;
	}
	function removeMarker($categories){
    		$out = "
			<script type=\"text/javascript\">
			//<![CDATA[
			";
             $i=0;
             foreach($categories[0]['Place'] as $place){
                        $i=$place['id'];
                        $out.="map.removeOverlay(marker$i);
                        ";
             }    					
                $out .= "//]]>
			</script>";
        return $out;
        
    }
	
}
?>
