<?php

	/* 
	BUT 	: SUPPRIMER LES DETAILS D'UNE FACTURE
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
			$facture 	= htmlspecialchars($_POST['numfacture']);
			$produit 	= htmlspecialchars($_POST['numprod']);
			$quantite 	= htmlspecialchars($_POST['quantite']);

		//On vérifie que le numéro de facture renseigné correspond bien à une facture existante
		$valide = $bdd->prepare('	
									SELECT 	* 
									FROM 	facture 
									WHERE 	NumFacture = ?
								');
		$valide->execute(array($facture));
					
		$rows = $valide->rowCount();
					
		//On referme la base
		$valide->closeCursor();
			
		if ($rows == 0) 
		{
				echo 	'Le numéro de facture renseigné n\'existe pas<br/>
						<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
				
		}else{
				
			//On vérifie que le numéro de produit renseigné correspond bien à un produit existant
			$valide = $bdd->prepare('	
										SELECT 	* 
										FROM 	produits 
										WHERE 	NumProduit = ?
									');
			$valide->execute(array($produit));
			
			$rows = $valide->rowCount();
				
			//On referme la base
			$valide->closeCursor();
					
			if ($rows == 0) 
			{
				echo 	'Le numéro de produit renseigné n\'existe pas.<br/>
						<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
			
			}else{	
							
				//On supprime les données de la base
				$supp =$bdd->prepare	('	
											DELETE	FROM 	d_facture 
											WHERE 	NumFacture = :nfact
											AND		NumProduit = :nprod
											AND		Qte = :quantite
										');
				$supp->execute(array	(
											'nfact'		=>$facture,
											'nprod'		=>$produit,
											'quantite'	=>$quantite
										));
							
				//On referme la base
				$supp->closeCursor();
						
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'Les données ont bien été supprimées dans la base.<br/>
						<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
							
			}
			
		}

?>