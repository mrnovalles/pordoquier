<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout ?></title>
<?php echo $html->meta('favicon.ico', '/favicon.ico', array('type' =>'icon')); ?> 
<?php 
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');
echo $javascript->link('shadowbox/shadowbox.js');
echo $html->css("shadowbox.css");	
?>
<script type="text/javascript">
Shadowbox.init({overlayColor:'#FFFFFF'});
</script>
</head>
<?php 
echo $html->css("cake_generic.css");
echo $html->css("menu.css");
?>
<body>
<?php
   if ($session->check('Message.flash')): $session->flash(); endif; // this line displays our flash messages
?>
<div id="wrapper">
	<div id="header">
		<div id="headerLogo"></div>
		<div id="headerSlice"></div>
		<div id="headerRight"></div>
	</div>
    <div id="navigation" class="shadow">
	   <ul id="navmenu-h">
        <li><?php echo $html->link('Places', array('controller'=>'places','action'=>'index'));?></li>
        <li><?php if($session->check('uid')) echo $html->link('Categories', array('controller'=>'categories','action'=>'index'));?></li>		
        <li><?php if($session->check('uid')) echo $html->link('Users', array('controller'=>'users','action'=>'index'));?></li>		
		<li>
		<?php if(!$session->check('uid')) echo $ajax->link('Login','#',array('complete'=>'Effect.toggle("element_login", "blind", {duration: 0.4}); return false;'));
			  else echo $html->link('Logout', "/users/logout/");?></b></li>
		</ul>
    </div>
    <?php echo $this->element('user_login');?>		
	<div id="content"><?php echo $content_for_layout;?></div>    
    <!--<div id="footer"></div>    -->
	
</div>
</body>
</html>