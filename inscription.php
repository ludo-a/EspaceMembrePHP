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
    <title>Inscription</title>
</head>
<body>
	<?php include('menu.php');?>
    <h2>Inscription</h2>

<?php
	if(intval($_GET['errorpass']) === 1){
		echo "<p class='error'>ERREUR : Le mot de passe n'est pas conforme aux instructions.</p>";
	}
	if(intval($_GET['errorpass']) === 2){
		echo "<p class='error'>ERREUR : Les mots de passe ne sont pas identiques.</p>";
	}
	if(intval($_GET['errormail']) === 1 ){
		echo "<p class='error'>ERREUR : Cet email est déja associé à un compte.</p>";
	}
	if(isset($_GET['errorpseudo'])){
		echo "<p class='error'>ERREUR : Le pseudo n'est pas correct</p>";
	}
	if(isset($_GET['subscribe'])){
		echo "<p class='success'>OK : L'inscription a été réalisé avec succès</p>";
	}
?>

	<form method="POST" action="./src/inscription_post.php">
		<p class="infos">
			Le pseudo est limité à 24 caractères maximum et 2 caractères minimum.</br>
			Le mot de passe doit contenir entre 8 et 16 caractères dont une MAJUSCULE,</br>une minuscule, un chiffre et un caractère spécial.
		</p>
		<table>
           	<tr>
               	<td>Pseudo</td>
            	<td><input type="text" name="pseudo" maxlength="24" placeholder="Ex : SucréSalé" required></td>
			</tr>
            <tr>
				<td>Email</td>
				<td><input type="email" name="email" placeholder="Ex : example@google.com" required></td>
			</tr>
           	<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="pass" maxlength="16" placeholder="Ex : ********" required ></td>
			</tr>
           	<tr>
				<td>Retaper votre mot de passe</td>
				<td><input type="password" name="pass2" maxlength="16" required ></td>
			</tr>
		</table>
		<div id="button">
			<button type='submit'>S'INSCRIRE</button>
		</div>
	</form>
</body>
</html>