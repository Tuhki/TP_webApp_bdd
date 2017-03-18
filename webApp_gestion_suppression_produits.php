<?php

	/* 
	BUT 	: SUPPRIMER UN PRODUIT
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
			$numero 	= htmlspecialchars($_POST['numprod']);
			$prix 		= htmlspecialchars($_POST['prixprod']);

		
		//On vérifie que les champs ne sont pas remplis par des caractères vides
		if(($numero != '') && ($prix != ''))
		{
				
				//On supprime les données de la base
				$supp =$bdd->prepare('	
										DELETE 	FROM produits
										WHERE	NumProduit = :numP
										AND		PUHT = :price
									');
									
				$supp->execute(array(
										'numP'	=>$numero,
										'price'	=>$prix
									));
				
				//On referme la base
				$supp->closeCursor();
				
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'Le produit a bien été supprimé de la base.<br/>
						<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
		
		}else{
			echo 'Suppression impossible.</br>
				<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
		}
		
?>