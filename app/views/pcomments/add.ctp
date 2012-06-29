<div id="pcomments_add">
<?php 
echo $form->create('Pcomment',array('controller'=>'comment','action'=>'add'));
echo $form ->input('comment', array('type'=>'text', 'rows'=>4,'label'=>false,'class'=>'textarea'));
echo $form ->hidden('place_id', array('value'=>$this->params['pass']['0']));
echo $form ->hidden('user_id',array('value'=> $session->read('uid')));
echo $form ->hidden('author',array('value'=>$session->read('Auth.User.username')));
echo $form->end('Send');
?>
</div>
