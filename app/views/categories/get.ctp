<?php
if($show == 1){ 
    echo $googleMap->addMarkersFromCat($cats); 
    }
else {
    echo $googleMap->removeMarker($cats); 
    
}
?>
