<?php
session_start();

//connexion à la BDD auto
require_once "config/conf.php";
  
//récupération PROPRE des variables
$username= !empty($_POST['username']) ? htmlspecialchars($_POST['username']) : NULL;
$password = !empty($_POST['password']) ? htmlspecialchars($_POST['password']) : NULL ;

//traitement du submit
if($username && $password){
  $requete="SELECT * 
            FROM administrateur 
            WHERE username = '$username'
              AND password = '$password';";
  try{
    $query = mysql_query($requete);
    if(mysql_num_rows($query)==1){

    	$_SESSION['auth']='true';
      header("Location: main.php"); 
      exit(); //toujours mettre un Exit apres une redirection ...   
    }   
  }catch(Exception $e){
    die('Erreur '.$e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   <title>
    Connexion
   </title>
  </head>
 <body>     
  <img src="heading.png">          
  <div class="right_col" role="main" >
    <form method="POST" action="">   
      <fieldset>
        <div style="margin:20%";>
          <table >
           <tr>
            <td>
             Login: 
            </td>
            <td>  
             <input type="text" name="username" required>
            </td>
          </tr>
          <tr>
           <td>
            Password: 
           </td>
           <td>
            <input type="password" name="password" required>
           </td>
          </tr>
          <tr>
           <td>
            <button type="submit" Value="Connection">Connection</button>
           </td>
          </tr>
         </table>
        </div>    
      </fieldset>
    </form>
  </div>
 </body>
</html>