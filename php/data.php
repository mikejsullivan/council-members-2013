<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

//require_once('../../../../nyw_includes/public_connect.php');
require_once('../../public_connect.php');


$whichInd = mysqlclean($_GET, "i", 64, $connection); //grab the issue from the URL which is stored in i


$Indquery = "SELECT * FROM council_member_indicator WHERE ind_id = ".$whichInd;
$Indresult = mysql_query($Indquery);

while ($Indrow = mysql_fetch_assoc($Indresult)) {
  $myInd = $Indrow['ind_shortname'];
}

//echo $myInd;


$the_data = array(); //store everything on one array


$query = "SELECT n.name, t.value, m.TEXT FROM city_council_2013_main m, council_member_".$myInd." t, council_member_names n WHERE m.INDICATOR_ID = ".$whichInd." AND m.VALUE_ID = t.id AND m.NAME_ID = n.name_id ORDER BY t.id ASC";

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
  	array_push($the_data, array('name'=> $row['name'], 'value'=> $row['value'], 'text'=> $row['TEXT']));
}
	

mysql_close($connection);


$call = json_encode($the_data); //JSON format

echo $call; //spit out the JSON


function mysqlclean($array, $index, $maxlength, $connection)
{
  if (isset($array["{$index}"]))
  {
     $input = substr($array["{$index}"], 0, $maxlength);
     $input = mysql_real_escape_string($input, $connection);
     return ($input);
  }
  return NULL;
}


?>