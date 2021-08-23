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
    <title>Connexion</title>
</head>
<body>
	<?php include('menu.php');?>
    <h2>Connexion:</h2>
	<?php
		if(intval($_GET['errormail']) === 2 ){
            echo "<p class='error'>ERREUR : Il n'y a pas de compte associé avec cet email.</p>";
		}
		if(intval($_GET['errorpass']) === 3 ){
            echo "<p class='error'>ERREUR : L'identifiant et l'email ne correspondent pas.</p>";
		}
        if(intval($_GET['errorpass']) === 1){
			echo "<p class='error'>ERREUR : Le mot de passe n'est pas conforme aux instructions.</p>";
		}
    ?>
	<form method="POST" action="connexion.php">
		<p class="infos">
			Le mot de passe doit contenir entre 8 et 16 caractères dont une MAJUSCULE,</br>une minuscule, un chiffre et un caractère spécial.
		</p>
		<table>
            <tr>
				<td>Email</td>
				<td><input type="email" name="email" placeholder="Ex : example@google.com" required></td>
			</tr>
           	<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="pass" maxlength="16" placeholder="Ex : ********" required ></td>
			</tr>  	
		</table>
		<p class="infos">
			Pour faire un essai avec un compte déja créé:</br>
			Email : tartuffe@lol.com</br>
			Mot de passe : killYou25?4#
		</p>
		<div id="button">
			<button type='submit'>SE CONNECTER</button>
		</div>
	</form>
</body>
</html>

<?php
if(!empty($_POST['email']) && !empty($_POST['pass'])){

	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$pass = htmlspecialchars($_POST['pass']);
	$error = 0;

	//controle du mot de passe avec REGEX
	if (preg_match("#^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$#", $pass))
	{
	    //VERIFICATION PRESENCE MAIL OU PSEUDO DANS BDD
		$req = $bdd->prepare('SELECT * FROM membres WHERE email = ?');
		$req->execute(array($email));

		while($admin = $req->fetch()){
            if($email === $admin['email'])
            {
                if(password_verify($pass, $admin['pass']))
                {
                    $_SESSION['connect'] = 1;
				    $_SESSION['userlogged'] = $admin['email'];
					$_SESSION['pseudo'] = $admin['pseudo'];
					$_SESSION['date'] = $admin['date_inscription'];

				    header('Location: membre_identifie.php?success=1');
				    exit();
                }
                else
                {
                    header('Location: connexion.php?errorpass=3');
					exit();
                }
            }
		}
		header('Location: connexion.php?errormail=2');
		exit();	
	}
	else
	{
		header('Location: connexion.php?errorpass=1');
        exit();
	}
}
?>