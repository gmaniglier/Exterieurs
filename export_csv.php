<?php
// connexion � la base des donn�es :
include("config/conf.php");

$namefile = "file.csv";
// ouverture du flux texte
$fp = fopen('file.csv', 'w');

// selection de la table � exporter
$result = mysql_query('select * from v_export');
$enclosure='';
// �criture de chaque ligne en format csv
while( $row = mysql_fetch_row( $result ) )
{
	fputcsv($fp, $row,";", "*");
}

// on ferme
fclose($fp);
$lecsv = "file.csv";
//Remplacement des '*' en ''
$replace = str_replace("*", "", file_get_contents($lecsv) );
file_put_contents($lecsv, $replace);

?>
