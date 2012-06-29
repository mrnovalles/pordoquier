<div id='map' align="center"><?php
        $avg_lat = $place['Place']['latitude'];
        $avg_lon = $place['Place']['longitude'];
        $default = array('type'=>'0','zoom'=> 14,'lat'=>$avg_lat,'long'=>$avg_lon);
        echo $googleMap->map($default);
        echo $googleMap->addMarker($place,"false");?>
</div>
<div id="sidebar">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="roundedTopLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedTopRightWhite">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">
		<h3><?php __('Info about this place'); ?></h3>
		<table class="viewPlace" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td colspan="2" align="center"><?php
			foreach($place['Photo'] as $pic){
			echo $html->link($html->image('places/small/'.$pic['photo']),"../img/places/big/".$pic['photo'],array('escape'=>false,'rel'=>'shadowbox[place]'));
			};?>
				</td>
			</tr>
			<tr>
				<td width="25%" valign="middle"><b><?php __('Name:')?></b></td>
				<td width="75%" valign="middle"><?php echo $place['Place']['name']?></td>
			</tr>
			<tr>
				<td valign="middle"><b><?php __('Address:') ?></b></td>
				<td valign="middle"><?php echo $place['Place']['address']?></td>
			</tr>
			<tr>
				<td valign="middle"><b><?php __('Description:') ?></b></td>
				<td valign="middle"><?php echo $place['Place']['description']?></td>
			</tr>

			<tr>
				<td valign="middle"><b><?php __('Latitude:') ?></b></td>
				<td valign="middle"><?php echo $place['Place']['latitude']?></td>
			</tr>
			<tr>
				<td valign="middle"><b><?php __('Longitude:') ?></b></td>
				<td valign="middle"><?php echo $place['Place']['longitude']?></td>
			</tr>		
			<tr>
				<td valign="middle"><b><?php __('Category:') ?></b></td>
				<td valign="middle"><?php echo $place['Category']['name']; echo $html->image('categories/small/'.$place['Category']['photo'],array("width"=>"16px"))?></td>
			</tr>	
			<tr>
				<td valign="middle"><b><?php __('Rating: ') .$place['Place']['rating'];?></b></td>
				<td valign="middle"><?php
		            $r = $place['Place']['rating'];
		            while($r > 0){
        		        if($r > 0 && $r < 1){
                		    if($r > 0.25 && $r < 0.75)
                        		echo $html->image('halfstar.png');
		                    else if($r >= 0.7)
        		                echo $html->image('star.png');
                		}else{
		                    echo $html->image('star.png');
        		        }
                	$r = $r-1; 
            		}

			        if($session->check('uid') && $session->read('uid') != $place['Place']['user_id']){
			            echo $ajax->link(__('Add Rating',true),array('controller'=>'ratings','action'=>'add',$this->params['pass'][0]),array('update'=>'add_rating'));				
					}?>			
				</td>
			</tr>														
		</table>
         <div id='result'></div>
         <div id='add_rating'></div><?php 
 		echo "<br><br>";
		echo "<h3>".__('Share: ',true)."</h3>".$bookmark->getBookmarks($this->pageTitle);
		echo "<br><br>";
          	if($session->check('uid')){
		echo "<h3>" .__('Recomend to a friend:'). "</h3>";
		echo $this->element('place_recommend',array('place'=>$place));
		echo "<br><br>";
		}
		  ?>

    <div id='comments' style="background-color:#FFF">
		<h3><?php __('Comments') ?></h3><?php
		if($session->check('uid')){
			echo $ajax->link(__('Add Comment',true),
                             array('controller'=>'pcomments',
                                   'action'=>'add',$this->params['pass'][0]),
                            array('update'=>'add_comment'));
          }
		 echo "<div id='add_comment'></div>";?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="roundedTopLeft">&nbsp;</td>
			<td bgcolor="#DDDDDD">&nbsp;</td>
			<td class="roundedTopRight">&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD">&nbsp;</td>
			<td bgcolor="#DDDDDD"><?php
			if($place['Pcomment']){
				foreach($place['Pcomment'] as $pcomment ):
				echo "<div class='pcomment' id='pcomment".$pcomment['id']."'>";
				echo "<div class=\"comment\">".$pcomment['comment']."</div>";
				$author = String::insert(__('Written by :author on :date',true),array('author' => $pcomment['author'],'date'=> $pcomment['created']));
				echo "<div class=\"autor\"><i>".$author."</i>";
				if($session->read('uid')== $place['Place']['user_id']){
				echo $ajax->link(__('Delete',true),array('controller'=>'pcomments','action'=>'delete',$pcomment['id']),array('complete'=>'Element.hide(\'pcomment'.$pcomment['id'].'\')'));
				}
				echo "</div></div>";
				endforeach ;
			}else{
				__('No comments');;
			}?>
			</td>
				<td bgcolor="#DDDDDD">&nbsp;</td>
			</tr>
			<tr>
				<td class="roundedBottomLeft">&nbsp;</td>
				<td bgcolor="#DDDDDD">&nbsp;</td>
				<td class="roundedBottomRight">&nbsp;</td>
			</tr>
		</table>
    </div>    
		</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
	<tr>
		<td class="roundedBottomLeftWhite">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td class="roundedBottomRightWhite">&nbsp;</td>
	</tr>
</table>
</div>
