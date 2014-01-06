<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

//require_once('../../../../nyw_includes/public_connect.php');
require_once('../../public_connect.php');


$whichInd = mysqlclean($_GET, "i", 64, $connection); //grab the issue from the URL which is stored in i


$the_data = array(); //store everything on one array


//the issue id and name. We need the issue_id before starting second query
$query = "SELECT * FROM council_member_names";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
echo $row["name"]."<br/>";

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