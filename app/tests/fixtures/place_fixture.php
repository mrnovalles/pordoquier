<?php
class PlaceFixture extends CakeTestFixture{
    var $name= 'Place';
    var $import=array('model'=>'Place');
    var $records=array(
                array('id'=>1,'name'=>'Testplace 1','description'=>'Test description for place 1','latitude'=>-32,'longitude'=>-68,'zoom'=>'10','tags'=>'test_tag1, test_tag2, test_tag3','rating'=>3.8,'user_id'=>1,'category_id'=>1),        
                array('id'=>2,'name'=>'Testplace 2','description'=>'Test description for place 2','latitude'=>-32,'longitude'=>-68,'zoom'=>'10','tags'=>'test_tag1, test_tag2, test_tag3','rating'=>4.0,'user_id'=>2,'category_id'=>2),
                array('id'=>3,'name'=>'Testplace 3','description'=>'Test description for place 3','latitude'=>-32,'longitude'=>-68,'zoom'=>'10','tags'=>'test_tag1, test_tag2, test_tag3','rating'=>5.0,'user_id'=>3,'category_id'=>3),
        );

}
?>
