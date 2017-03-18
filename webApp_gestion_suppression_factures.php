<?php

	/* 
	BUT 	: SUPPRIMER UNE FACTURE
	ENTREE	: CHOIX UTILISATEUR
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
			$client 		= htmlspecialchars($_POST['numcli']);
			$num_facture	= htmlspecialchars($_POST['numfacture']);
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
			echo 	'Le numéro de client renseigné n\'existe pas.<br/>
					<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
				
		}else{

			//On vérifie que tous les champs sont renseignés correctement
			if(($num_facture != '') && ($date_facture != ''))
			{
				
				//On supprime les données dans la base
				$supp =$bdd->prepare	('	
											DELETE 	FROM facture 
											WHERE 	DateFacture = :fdate
											AND		NumClient = :ncli
											AND		NumFacture = :fnum
										');
										
				$supp->execute(array	(
											'fdate'	=>$date_facture,
											'ncli'	=>$client,
											'fnum'	=>$num_facture
										));
							
				//On referme la base
				$supp->closeCursor();
						
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'La facture a bien été supprimée.<br/>
						<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
				
					
			}

			
		}
	
?>