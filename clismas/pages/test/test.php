<?php			
//display error 
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
$age['pkb'] = '66';
print_r($age);

$jason_data = array();
$jason_data[0] = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
$jason_data[1] = array("Peter2"=>"35", "Ben2"=>"37", "Joe2"=>"43");
$jason_data[1]['tory'] = '99';
print_r($jason_data);
?>
