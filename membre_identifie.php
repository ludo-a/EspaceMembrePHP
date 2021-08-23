<?php
session_start();
if(isset($_SESSION['connect'])){	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Espace Membre</title>
</head>
<body>
    <?php include('menu.php');?>
    <h2>Espace Membre</h2>
    <?php

    $pseudosession = $_SESSION['pseudo'];
    $mailsession = $_SESSION['userlogged'];
    $datesession = $_SESSION['date'];

    ?>
    <form id="formMember" method="POST" action="./src/connexion_post.php">
        <p class="infos">PROFIL UTILISATEUR</p>
		<table>
            
            <tr>
               	<td>Pseudo : <?php echo $pseudosession;?></td>
			</tr>
            <tr>
               	<td>Email : <?php echo $mailsession;?></td>
			</tr>
            <tr>
               	<td>Date d'inscription : <?php echo $datesession;?></td>
			</tr>
            <tr class="btn">
				<td><a class="boutonMember" href="./src/deconnexion.php">DECONNEXION</a></td>	
			</tr> 	
        </table>
	</form>
</body>
</html>

<?php
}
?>