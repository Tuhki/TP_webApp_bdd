<?php
	
	/*
		BUT 	: RECUEIL DU FORMULAIRE D'INSCRIPTION ET ENVOI DANS LA BASE DE DONNEES UTILISATEURS 
		ENTREE 	: IDENTIFIANT ET MOT DE PASSE DU NOUVEL UTILISATEUR
		SORTIE	: ACCES AU MENU PRINCIPAL SI IDENTIFIANT PAS DEJA PRIS
	*/
	
	if (isset($_POST['insc_name']) && isset($_POST['insc_password']))
	//Si tous les champs du formulaire sont remplis
	{
		
		//Recueil du nom d'utilisateur
		$name = $_POST['insc_name'];
		
		//Hashage du mot de passe pour le stocker de façon sécurisée dans la base
		$password = password_hash($_POST['insc_password'], PASSWORD_DEFAULT);
		
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
		
		if ($req->rowCount() > 0)
		{
			//Le nom d'utilisateur existe déjà dans la base
			echo("Le nom d'utilisateur est déjà pris.");
			include("webApp_page_inscription.html");
			
		}else{
			
			//Si le nom n'existe pas, on le crée dans la base
			$req = $bdd->prepare('INSERT INTO users(user_name,user_password) VALUES(:name, :password)');
			$req->execute(array('name' => $name, 'password' => $password));
			
			//On redirige vers le menu principal
			header('Location: webApp_page_utilisateur.html');
		}
		
	}

?>