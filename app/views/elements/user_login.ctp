<div id="element_login" style="display:none"><?php
	if  ($session->check('Message.auth')) $session->flash('auth');
	echo $form->create('User', array('action' => 'login'));?>
	<div id="form_login" style="margin-left:350px;">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr align="right">
			<td><?= "Username".$form->input('username',array('label'=>false,'div'=>false));?></td>
			<td><?= "Password".$form->input('password',array('label'=>false,'div'=>false));?></td>
			<td><?= $form->checkbox('remember_me',array('div'=>false));?></td>
			<td><?= $form->label(__('remember_me',true));?></td>
			<td><?= $form->end('Login');?></td>
			<td><?= "<div align=\"right\">".$ajax->link(__("close",true),'',array('complete'=>'Effect.toggle("element_login", "blind", {duration: 0.4}); return false;'),NULL,NULL)."</div>"; ?></td>
		</tr>
	</table>
	</div>
</div>
