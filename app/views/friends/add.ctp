<div id="friend_add">
    <form id="formSearch" name="formSearch" accept-charset="UNKNOWN" enctype="application/x-www-form-urlencoded" method="get">
	<input id="query" maxlength="256" name="query" size="10" type="text" />
    <div id="loading"><?php echo $html->image("spinner.gif") ?></div><?php

		$options = array(
			'update' => 'view',
			'url'    => '/friends/search/',
			'frequency' => 1);
		
		print $ajax->observeField('query', $options);?>
    </form> 
<div id="view"></div>
</div>