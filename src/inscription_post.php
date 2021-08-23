<?php
session_start();
require('connexion_bdd.php');

if(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['pseudo'])){

	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$pass = htmlspecialchars($_POST['pass']);
	$pass2 = htmlspecialchars($_POST['pass2']);
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$error = 0;

	//controle du pseudo
	if (!preg_match("#^[a-zA-Z][a-zA-Z[0-9]{1,23}$#", $pseudo))
	{
		header('Location: ../inscription.php?errorpseudo=1');
	}
	else if (preg_match("#^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$#", $pass)) //controle du mot de passe
	{
		if($pass != $pass2) //verif correspondance des 2 mots de passe
		{
			header('Location: ../inscription.php?errorpass=2');
		}
		else
		{
			//VERIFICATION SI PRESENCE MAIL DANS LA BDD
			$req = $bdd->prepare('SELECT * FROM membres WHERE email = ?');
			$req->execute(array($email));

			while($admin = $req->fetch()){

				if($email === $admin['email'])
				{
					$error = 1;
					header('Location: ../inscription.php?errormail=1');
					exit();
				}
			}
			if($error == 0){
				//le password et le pseudo sont correct donc on va les traiter
				$passHash = password_hash($pass, PASSWORD_DEFAULT);
				$data = array(
					':pseudo' =>$pseudo,
					':pass' =>$passHash,
					':email' =>$email
				);
				$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription)
				VALUES (:pseudo, :pass, :email, NOW())');
    			$req->execute($data);

				$req = $bdd->prepare('SELECT * FROM membres WHERE email = ?');
				$req->execute(array($email));
				
				while($admin = $req->fetch()){
					if($email === $admin['email'])
					{
						$_SESSION['connect'] = 1;
						$_SESSION['userlogged'] = $admin['email'];
						$_SESSION['pseudo'] = $admin['pseudo'];
						$_SESSION['date'] = $admin['date_inscription'];
		
							header('Location: ../membre_identifie.php?success=1');
							exit();
					}	
				}
			}
		}
	}
	else
	{
		header('Location: ../inscription.php?errorpass=1');
	}
}
?>