<div id="comments_add"><?php
	echo $form->create(array('controller'=>'comments','action'=>'add'));
	echo $form->hidden('id_2user',array('value'=>$this->params['pass']['0']));
	echo $form->input('comment',array('type'=>'textbox','label'=>false,'class'=>'textArea','id'=>'comments_view_textarea','default'=>''));
	echo $form->end(__('Send',true));?>
</div>
