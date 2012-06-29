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
<script>
	function remove(){
		document.getElementById("place_search").style.display="none";
	}
</script>
</head>
<?php 
echo $html->css("reset.css");
echo $html->css("styles.css");
echo $html->css("menu.css");
?>
<body>
<div id="place_search" style="width:400px; height:200px; overflow:scroll; overflow-y:scroll; display:none; position:absolute; top:10%; right:12%; background-color:#FFF; padding-left:10px; padding-right:10px; z-index:999; color:#333; cursor:pointer;" onclick="remove()"></div>	
<?php
   if ($session->check('Message.flash')): $session->flash(); endif; // this line displays our flash messages
?>
<div id="wrapper">
	<div id="header">
	<div id="headerLogo"><?php echo $html->link($html->image('header/header_logo.png'),'/',null,null,false)?></div>
		<div id="headerSlice">
			<div style="float:right; margin-top:30px;"></div>
			<div style="clear:both;"></div>
			<div style="float:right;"></div>			
		</form>				
		</div>
		<div id="headerRight"></div>
	</div>
    <div id="navigation" class="shadow">
	   <ul id="navmenu-h">
        <li><?php echo $html->link(__('Places',true), array('controller'=>'places','action'=>'index'));?>
          <ul>
            <li><?php if($session->check('uid')) echo $html->link(__('My Places',true), array('controller'=>'places','action'=>'list_places'));?></li>
            <li><?php if($session->check('uid')) echo $html->link(__('Add Places',true), array('controller'=>'places','action'=>'add'));?></li>
          </ul>
        </li>
        <li><?php if($session->check('uid')) echo $html->link(__('Friends',true), array('controller'=>'friends','action'=>'index'));?>
        </li>
        <li><?php if($session->check('uid')){ 
					echo $html->link(__('Inbox',true).$this->element('message_count'), array('controller'=>'comments','action'=>'index')); 
					}?></li>
        <li><?php if($session->check('uid')) echo $html->link(__('Profile',true), array('controller'=>'users','action'=>'view'));?></li>		
        <li><a href="#"><?php __('Language') ?></a>
          <ul>
            <li style="background-color:#FFF; z-index:999;"><?php echo $html->link($html->image('lang.png',array('usemap'=>'#Map2','alt'=>'')),'#', false, false,false);?>
			<map name="Map2" id="Map2">
				<area shape="poly" coords="1,4,21,4,24,13,3,18" href="/pordoquier/lang/spa" title='<?php __("Spanish"); ?>' />
				<area shape="poly" coords="79,18,79,5,99,6,99,19" href="/pordoquier/lang/eng" title='<?php __("English"); ?>'/>
			</map>
			</li>
          </ul>
		</li>
		<li>
		<?php if(!$session->check('uid')) echo $ajax->link('Login','#',array('complete'=>'Effect.toggle("element_login", "blind", {duration: 0.4}); return false;'));
			  else echo $html->link('Logout', "/users/logout/");?></b></li>
		</ul>
        <div id="rss"><?php echo $html->link($html->image('rss.png'),'/places/index.rss', false, false,false);?></div>
    </div>
    <?php echo $this->element('user_login');?>		
	<div id="content"><?php echo $content_for_layout;?></div>    
	<div id="footer"><?php
			if($session->check('uid')){
				echo __("Welcome",true)." ".$html->link($session->read('Auth.User.name')." ".$session->read('Auth.User.lastname'),"/users/view")." | ";
				echo "<span id='updates'>".$this->element('friend_notify')."</span>"; //Updates
				echo "&nbsp;| ";
				echo "<span id='requests'>".$this->element('friend_request')."</span>"; //Friends
			}?>
			<div id="footer_logo">
			<?php echo $html->image('logo_map.png',array('align'=>'right')); ?><br /><br />
			<p align="right">Copyright Pordoquier <?php echo date('Y')?></p>
			</div>
	</div>
	
</div>
<div id="ciudades"></div>
<div id="footerCiudades">
			<div id="footer_cc"><?php
echo "<p align='right'>".$html->link($html->image('footer/cc.png'),'http://creativecommons.org/licenses/by-nc-sa/2.5/deed.es_AR', array("onmouseover"=>"Element.show('cc')",'onmouseout'=>'Element.hide("cc")'), null, false)."</p>";?>
			<span style="float:right; display:none; margin-right:-5%; width:150px; height:30px; background-color:#FFC; border:#CCC 1px solid; padding:5px;" id="cc"><?php echo __("The content displayed on this page of places, maps and categories, is licensed under <br>",true);?></span><?php
			?>
			 </div><?php
			echo $html->image("cake.power.gif");?>
</div>
<script type="text/javascript">
  var uservoiceJsHost = ("https:" == document.location.protocol) ? "https://uservoice.com" : "http://cdn.uservoice.com";
  document.write(unescape("%3Cscript src='" + uservoiceJsHost + "/javascripts/widgets/tab.js' type='text/javascript'%3E%3C/script%3E"))
</script>
<script type="text/javascript">
UserVoice.Tab.show({ 
  /* required */
  key: 'pordoquier',
  host: 'pordoquier.uservoice.com', 
  forum: '29745', 
  /* optional */
  alignment: 'left',
  background_color:'#F7931E', 
  text_color: 'white',
  hover_color: '#76CBF2',
<?php if(Configure::read('Config.language') == 'spa')
echo  "lang: 'es'";
else
echo "lang: 'en'";
?>
})
</script>

</body>
</html>
