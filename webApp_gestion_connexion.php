<?php
	
	/* RECUEIL DU FORMULAIRE DE CONNEXION ET ENVOI DANS LA BASE DE DONNEES UTILISATEURS */
	
	if (isset($_POST['conn_name']) && isset($_POST['conn_password']))
	//Si tous les champs du formulaire sont remplis
	{
		
		//Recueil du nom d'utilisateur
		$name = $_POST['conn_name'];
		
		//Recueil du mot de passe de l'utilisateur
		$password = $_POST['conn_password'];
		
		//Accès à la base de données
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=utilisateurs', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e)
		{
			die("Erreur de connexion :" . $e->getMessage());
		}
		
		//On récupère les noms d'utilisateurs déjà contenus dans la base de données et on compare avec celui saisi
		$req = $bdd->prepare('SELECT user_name FROM users WHERE user_name = :name');
		$req->execute(array('name' => $name));
		
		//Le nom d'utilisateur existe déjà dans la base
		if ($req->rowCount() > 0)
		{
			//On récupère le mot de passe enregistré
			$hash = $bdd->prepare('SELECT user_password FROM users WHERE user_name = :name');
			$hash->execute(array('name' => $name));
			
			//On vérifie qu'un mot de passe a bien été trouvé
			if($hash -> rowCount() == 1){
				//On a bien trouvé un mot de passe, on le récupère
				$stored_password = $hash->fetch()[0];
			}else{
				//On n'a pas trouvé de mot de passe, on donne une valeur par défaut
				$stored_password = '0';
			}
			
			//On vérifie que le mot de passe saisi est correct
			if (password_verify($password, $stored_password)) {
				echo ("Le mot de passe est valide !");
				header("Location: webApp_page_utilisateur.html");
				
			} else {
				echo 'Le mot de passe est invalide.';
			}
			
		//Le nom d'utilisateur n'a pas été trouvé	
		}else{
			//On l'indique à l'utilisateur
			echo("Nom d'utilisateur inconnu.");
		}
		
	}

?>