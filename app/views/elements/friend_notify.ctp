<?php 
echo $ajax->link(
                __('Updates',true),array('controller'=>'friends','action'=>'notify'),
                                array('update'=>'friend_updates',
                                      'loading'=>"Element.show('loading2')",
                                      'complete'=>"Element.show('friend_updates');Element.hide('loading2')"));
?>
<span id='loading2' style='display:none;'><?php echo $html->image('spinner2.gif'); ?></span>
<span id='friend_updates'></span>

