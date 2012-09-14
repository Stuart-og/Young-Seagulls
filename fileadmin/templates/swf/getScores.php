 <?php
   require_once("includes/config.php");
   require_once("includes/database.php");
   require_once("includes/XmlParser.php");
?>
 <?php
 
  $xml = new XmlParser();
  
  $xml->XmlWriter();
  
  $xml->push('scores');
  
		$sql = "SELECT * FROM players ORDER BY score DESC , first_name ASC LIMIT 13 ";
		$resultSet = $database->query($sql);

		$numResults = mysql_num_rows($resultSet);
$data = array ();


		for($i=1;$i<=$numResults;$i++) {
		
			$foundUser = $database->fetch_array($resultSet);
		   $data = array ('name'=>$foundUser['first_name'],'score'=>$foundUser['score']);
		   $xml->emptyelement('user',$data);
		   
		}


 $xml->pop();
  
$xmlFinal=$xml->getXml();
  
 print $xmlFinal; 

  

  ?>