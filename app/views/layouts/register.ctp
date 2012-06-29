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
echo $html->css("reset.css");
echo $html->css("register.css");
echo $html->css("menu.css");
?>
<body>
<?php
   if ($session->check('Message.flash')): $session->flash(); endif; // this line displays our flash messages
?>
<div id="wrapper_index">
	<div id="header">
		<div id="headerLogo"><?php echo $html->link($html->image('header/header_logo.png'),'/',null,null,false)?></div>
		<div id="headerSlice">
			<div style="float:right; margin-top:30px;"></div>
			<div style="clear:both;"></div>
			<div style="float:right;">
			</div>			
		</form>				
		</div>
		<div id="headerRight"></div>
	</div>
    <div id="navigation_index" class="shadow">
	  <ul id="navmenu-h">
        <li><?php echo $html->link(__('Places',true), array('controller'=>'places','action'=>'index'));?>
          <ul>
            <li><?php if($session->check('uid')) echo $html->link(__('My Places',true), array('controller'=>'places','action'=>'list_places'));?></li>
            <li><?php if($session->check('uid')) echo $html->link(__('Add Places',true), array('controller'=>'places','action'=>'add'));?></li>
          </ul>
        </li>
        <li><?php if($session->check('uid')) echo $html->link(__('Friends',true), array('controller'=>'friends','action'=>'index'));?>
        </li>
        <li><?php if($session->check('uid')) echo $html->link(__('Inbox',true), array('controller'=>'comments','action'=>'index'));?></li>
        <li><?php if($session->check('uid')) echo $html->link(__('Profile',true), array('controller'=>'users','action'=>'view'));?></li>		
        <li><a href="#"><?php __('Language') ?></a>
          <ul>
            <li style="background-color:#FFF; z-index:999;"><?php echo $html->link($html->image('lang.png',array('usemap'=>'#Map2','alt'=>'')),'#', false, false,false);?>
			<map name="Map2" id="Map2">
				<area shape="poly" coords="1,4,21,4,24,13,3,18" href="../lang/spa" title='<?php __("Spanish"); ?>' />
				<area shape="poly" coords="79,18,79,5,99,6,99,19" href="../lang/eng" title='<?php __("English"); ?>'/>
			</map>
			</li>
          </ul>
		</li>
		<li>
		<?php if(!$session->check('uid')) echo $ajax->link('Login','#',array('complete'=>'Effect.toggle("element_login", "blind", {duration: 0.4}); return false;'));
			  else echo $html->link('Logout', "/users/logout/");?></b></li>
		<li><?php if(!$session->check('uid')) echo $html->link(__('Register',true), array('controller'=>'users','action'=>'add')); ?></li>
		</ul>
        <div id="rss"><?php echo $html->link($html->image('rss.png'),'/places/index.rss', false, false,false);?></div>
    </div>
    <?php echo $this->element('user_login');?>		
	<div id="content"><?php echo $content_for_layout;?></div>    
    <div id="footer_register">
        <?php echo $html->image("register/mario_register.png",array('class'=>'mario_register')) ?>
    </div>	
</div>
</body>
</html>
