<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Codes d'accès au serveur central de la NASA</title>
    </head>
    <body>

<?php
    if (isset($_POST['mot_de_passe']) AND $_POST['mot_de_passe'] ==  "kangoo") // Si le mot de passe est bon
    {
    	header("Location: main.php" )// On affiche la page
?>
<?php
}
else // Sinon, on affiche un message d'erreur
{
	echo '<p>Mot de passe incorrect !</p>';
}
?>
    
        
    </body>
</html>