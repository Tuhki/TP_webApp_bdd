<?php

	/* 
	BUT 	: MODIFIER DES DONNEES EXISTANTES ET EN AJOUTER
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
			$numero 	= htmlspecialchars($_POST['idprod']);
			$libelle 	= htmlspecialchars($_POST['nomprod']);
			$prix 		= htmlspecialchars($_POST['prixprod']);

		//Si l'utilisateur a coché "ajouter", on rentre les données dans la base
		if(($_POST['choix_prod'])=="Ajout")
		{
			//On vérifie que les champs ne sont pas remplis par des caractères vides
			if((($_POST['nomprod']) != '') && (($_POST['prixprod']) != ''))
			{
				
				//On envoie les données dans la base
				$envoi =$bdd->prepare('INSERT INTO produits(Des,PUHT)VALUES(:desc,:price)');
				$envoi->execute(array	(
											'desc'	=>$libelle,
											'price'	=>$prix
										));
				
				//On referme la base
				$envoi->closeCursor();
				
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'Les informations du produit '.$libelle.' ont bien été ajoutées dans la base.<br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
			}
		
		//Si l'utilisateur a coché "modifier"
		}else if(($_POST['choix_prod'])=="Modification")
		{
			//On vérifie que le produit à modifier exite bien déjà
			$valide = $bdd->prepare('	
										SELECT 	*
										FROM 	produits 
										WHERE 	NumProduit = :numP
										AND		Des = :nomP
										AND		PUHT = :prixP
									');
									
			$valide->execute(array	(
										'numP'	=> $numero,
										'nomP' 	=> $libelle,
										'prixP'	=> $prix
									));
						
			$rows = $valide->rowCount();
						
			//On referme la base
			$valide->closeCursor();
			
			
			//Si on ne retrouve pas le produit, on indique l'erreur à l'utilisateur
			if ($rows == 0) 
			{
					echo 	'Les données renseignées ne correspondent à aucun produit connu. <br/>
							<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
			
			
			//Si on retrouve bien le produit, on peut le modifier
			}else{
				
				//On prend les nouvelles données, envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
				$n_libelle	= htmlspecialchars($_POST['new_nomprod']);
				$n_prix 	= htmlspecialchars($_POST['new_prixprod']);
			
			
				//On modifie le produit avec les nouvelles données
				$maj = $bdd->prepare('UPDATE produits SET Des = :newnom, PUHT = :newprix WHERE NumProduit = :id_prod');
					
				$modifs = $maj->execute	(array	(	
													'newnom'	=> $n_libelle,
													'newprix' 	=> $n_prix,
													'id_prod'	=> $numero
												));
											
				$maj->closeCursor();
			
				//Message de confirmation de la modification
				echo 	'Les informations du produit '.$n_libelle.' ont bien été modifiées.<br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
		
			}
		}
?>