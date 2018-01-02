<?php
//"connector.php" file
require_once("../codebase/connector/grid_connector.php");//includes related connector file
include("config/conf.php");

$conn = new GridConnector($mysql,"MySQL");                    // connector initialization

//on peuple company.json
$result=mysql_query("select distinct Societe from outsiders order by Societe;");
$j=1;
$filename="outs/company.json";
$data="{\n options: [\n";
file_put_contents($filename, $data);
while($j<mysql_num_rows($result)){
	$row = mysql_fetch_array($result);
	$company = $row['Societe'];
	$data = "{value: \"" . $company ."\", text: \"". $company."\"},\n";
	file_put_contents($filename, $data, FILE_APPEND);
	$j=$j+1;
	}
$row = mysql_fetch_array($result);
$company = $row['Societe'];
$data = "{value: \"" . $company ."\", text: \"". $company."\"}\n]}";
file_put_contents($filename, $data, FILE_APPEND);

//on peuple stat.json
$result=mysql_query("select nbvalid, nboutdated from v_stats;");
$filename="outs/stat.json";
$data="{[\n";
file_put_contents($filename, $data);
$row = mysql_fetch_array($result);
$valid = $row['nbvalid'];
$outdated = $row['nboutdated'];
$data = "[\n{ badges: \"" . $valid ."\" , color: \"#66ff33\" },\n { badges: \"" . $outdated ."\", color: \"#ff6666\" }\n]";
file_put_contents($filename, $data);


function custom_sort($sorted_by){
	if (!sizeof($sorted_by->rules))
		$sorted_by->add("group","DESC");
}
function formatting($row){
	if ($row->get_value("datefin")<date('Y-m-d'))
		$row->set_value("datefin","<font color=#FF0066>".$row->get_value("datefin")."</font>");
}
function validate($data){
}

$conn->event->attach("beforeProcessing","validate");
//$conn->event->attach("beforeSort","custom_sort");
$conn->event->attach("beforeRender","formatting");

//$conn->render_table("outsiders", "Id_unique", "Civ, Nom, Prenom, Societe, datedebut, datefin" );     // data configuration
$conn->render_sql("select Civ, Nom, Prenom, Id_unique, Societe, datedebut, datefin from outsiders order by datefin asc", "Id_unique", "Civ, Nom, Prenom, Societe, datedebut, datefin" );     // data configuration



?>

