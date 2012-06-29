<?php
$friends_list= $this->requestAction('friends/setFriends');
if($friends_list != NULL){
    $value = __('Visit ',true).$place['Place']['name'].' <a href="places/view/'.$place['Place']['id'].'>'.__('Click here',true).'</a>'; 
    echo $form->create('Comment',array('controller'=>'comments','action'=>'add','div'=>false));
    echo $form->hidden('comment',array('value'=>$value,'div'=>false));
    echo $form->input('id_2user',array('type'=>'select','div'=>false,'label'=>false,'options'=>$friends_list));
    echo $form->end(__('Recommend',true));
}    
?>
