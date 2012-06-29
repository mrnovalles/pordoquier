<script>
document.observe('dom:loaded', function(){
	if($('PlaceLatitude').value.length > 0){
		new Effect.Appear('addplace2');
		//$('addplace2').show();
		$('PlaceAddr').writeAttribute('readonly','readonly')
	}

})
var max = 1;
function newpic(){
	if(max < 4){
		var div = document.getElementById("picDiv");
		var img = document.createElement("input");
		img.setAttribute("type","file");
		img.setAttribute("name","data[Place][pic]["+max+"]");

		var less = document.createElement("a");
		less.innerHTML=" X";
		less.setAttribute("name","data[Place][pic]["+max+"]");
		less.setAttribute("onclick","javascript:removepic("+max+")");

		div.appendChild(img);
		div.appendChild(less);
		max = max + 1;
	}
}
function removepic(id){
	var tags = document.getElementsByName("data[Place][pic]["+id+"]");
	for(var i=0,mx=tags.length;i<mx;i++){
		tags[i].style.display="none";
	}
	max = max - 1;
}
</script>
<div id="map" align="center">
<?php
$avg_lat = -32.8917;
$avg_lon = -68.8328;
$default = array('type'=>'0','zoom'=> 4,'lat'=>$avg_lat,'long'=>$avg_lon);
echo $googleMap->map($default);
?>
</div>
<div id="sidebar">
<?php echo  $form->create(array('action'=>'add')); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="roundedTopLeft">&nbsp;</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td class="roundedTopRight">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td bgcolor="#DDDDDD">
			<table id="addplace1" width="100%" border="0">
				<th><p align="left"><h3><?php __('First, search for a place'); ?></h3><?php __('Type in Address,City or Country (eg: Lamadrid 63, Mendoza, Argentina)');?></p></th>
				<tr><td><?php echo  $form->input('addr',array('type'=>'text','name'=>'addr','label'=>__('Address',true),'div'=>false,'size'=>'30%')); ?>
						<input type="hidden" name="action" value="submit" />
						<?php echo  $form->end(array('label' => __('Search',true), 'id' => 'submit','div'=>false)); ?></td></tr>
			</table>
			<?php echo  $form->create(array('controller'=>'places','action'=>'add','type'=>'file')); ?>
			<table width="100%" border="0" id="addplace2" style="display:none;">
				<th colspan="2"><p align="left"><h3><?php __('Then, Add your place') ?></h3></p></th>
				<tr>
				<td><? echo $form->label(__('name',true)); ?> </td>
				<td><?php echo  $form->input('name',array(
				'label'=>false,
				'error'=>array('ruleMaxLength'=> __('30 chars max', true),
					'ruleNotEmpty'=>__('error-notEmpty-allowed',true))));         
				?>				</td>
				</tr>
				<tr>
				<td><?php __('Address') ?></td>
				<td><?php echo  $form->input('address',array('label'=>false,
				'error'=> array('ruleMinLength'=> __('error-min-length-1', true)))); 
				?></td>
				</tr>
				<tr>
				<td valign="middle"><?php __('Description')?></td>
				<td><?php echo  $form->input('description',array('label'=>false,
				'error'=> __('error-only-alphabets-and-numbers-allowed', true))); 
				?></td>
				</tr>
				<tr>
				<td><?php __('Latitude') ?></td>
				<td><?php echo  $form->input('latitude',array('readonly'=>'true','label'=>false,'error'=> __('error-not-empty-search-first',true))); ?></td>
				</tr>
				<tr>
				<td><?php __('Longitude')?></td>
				<td><?php echo  $form->input('longitude',array('readonly'=>'true','label'=>false,'error'=> __('error-not-empty-search-first',true))); ?></td>
				</tr>
				<tr>
				<td><?php __('Category')?></td>
				<td><?php echo  $form->input('Place.category_id',array('type'=>'select','options'=>$categories,'label'=>'Categories','label'=>false)); ?></td>
				</tr>
				<tr>
				<td>Tags</td>
				<td><?php echo  $form->input('tags',array('label'=>false,'onmouseover'=>'Element.show("tag_info")','onmouseout'=>'Element.hide("tag_info")','onfocus'=>'Element.show("tag_info");this.setAttribute("onmouseout","")','onblur'=>'Element.hide("tag_info");this.setAttribute("onmouseout","Element.hide(\"tag_info\")");','error'=>__('error-30-chars-max',true))); ?><span id="tag_info" style="display:none; width:150px; height:10px; background-color:#FFC; position:absolute; border:#CCC 1px solid; padding:5px;">Tags <?php __('Separated by , (comma)')?></span></td>
				</tr>
				<tr>
				<td><?php __('Place Image') ?></td>
				<td><?php  echo $form->input('Place.pic.0', array('type'=>'file','label'=>false,'error'=>__('error-bad-format',true))); ?></td>
				</tr>
				<tr>
				<td width="10px"><a href="#" onclick="javascript:newpic(); return false"><?php __('Add another image') ?></a></td>
				<td><div id="picDiv"></div></td>
				</tr>
				<?php echo $form->hidden('Place.user_id',array('value'=>$session->read('uid')));?>
				<tr>
				<td colspan="2" align="center"><?php echo  $form->end(__('Add',true)); ?></td>
				</tr>  
			</table>		</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD" colspan="3"><div style="margin-left:110px;" <?=$html->image("places/mario.png");?></div></td>
	</tr>
	<tr>
		<td class="roundedBottomLeft">&nbsp;</td>
		<td bgcolor="#DDDDDD">&nbsp;</td>
		<td class="roundedBottomRight">&nbsp;</td>
	</tr>
</table>
<?php
if($this->params['form'] != NULL)
echo $googleMap->addPlace($this->params['form']['addr']);?>
</div>