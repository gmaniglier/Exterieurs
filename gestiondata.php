<?php

require_once("../codebase/connector/form_connector.php");//includes related connector file
include("config/conf.php");

//create connector for dhtmlxForm using connection to mySQL server
$form = new FormConnector($res);
//$form->enable_log("log.txt");
//table name, id field name, fields to use to fill the form
//action à faire avant de reaffcher la table

$tab=array();
foreach(array_keys($_POST) as $key){
	array_push($tab, $_POST[$key]);
}

$Civ=$tab[0];
$Nom=mb_convert_case($tab[1], MB_CASE_UPPER, "UTF-8");
$Prenom=mb_convert_case($tab[2], MB_CASE_TITLE, "UTF-8");
$Societe=mb_convert_case($tab[3], MB_CASE_UPPER, "UTF-8");
$datedebut=$tab[4];
$datefin=$tab[5];

$sql="INSERT INTO outsiders (Civ, Nom, Prenom,  Societe, datedebut, datefin)
VALUES ('".$Civ."', '".$Nom."', '".$Prenom."', '".$Societe."', '".$datedebut."', '".$datefin."')";
$result = mysql_query($sql);

?>
