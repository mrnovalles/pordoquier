<?php 
$counter = $this->requestAction('comments/counter'); 
if($counter != 0)
	echo " (".$counter.")";
?>
