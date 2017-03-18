<?php

	/* 
	BUT 	: AJOUTER DES DONNEES
	ENTREE	: SAISIES UTILISATEUR
	SORTIE	: BDD MISE A JOUR
	*/
		
		
	//Connexion à la base de données
		Try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=facture_prof','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
			
		//On prend les données envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
			$client 		= htmlspecialchars($_POST['idcli']);
			$date_facture 	= htmlspecialchars($_POST['datefacture']);

		//On vérifie que le numéro de client renseigné correspond bien à une facture existante
		$valide = $bdd->prepare('	
									SELECT 	* 
									FROM 	client 
									WHERE 	NumClient = ?
								');
		$valide->execute(array($client));
					
		$rows = $valide->rowCount();
					
		//On referme la base
		$valide->closeCursor();
			
		if ($rows == 0) 
		{
			echo 	'Le numéro de client renseigné n\'existe pas, veuillez commencer par créer le fichier client correspondant.<br/>
					<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
				
		}else{

			//On vérifie que tous les champs sont renseignés correctement
			if((($_POST['idcli']) != '') && ($_POST['datefacture']) != '')
			{
				
				//On envoie les données dans la base
				$envoi =$bdd->prepare('INSERT INTO facture (DateFacture,NumClient) VALUES(:ndate,:ncli)');
				$envoi->execute(array	(
											'ndate'		=>$date_facture,
											'ncli'		=>$client
										));
							
				//On referme la base
				$envoi->closeCursor();
						
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'La facture a bien été créée.<br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
				
					
			}

			
		}
	
?>