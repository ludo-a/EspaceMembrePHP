<?php
session_start();
if(isset($_SESSION['connect']))
{
	header('location: membre_identifie.php');
	exit();
}
require('./src/connexion_bdd.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Accueil</title>
</head>
<body>
	<?php include('menu.php');?>
    <h2>Le Club</h2>
	<form id="formac" method="POST" action="./src/connexion_post.php">
		<table>
            <tr>
				<td><a class="boutonac" href="connexion.php">SE CONNECTER</a> </td>	
			</tr> 	
            <tr>
				<td><a class="boutonac" href="inscription.php">S'INSCRIRE</a> </td>	
			</tr>
        </table>
	</form>
</body>
</html>