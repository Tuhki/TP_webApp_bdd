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
			$facture 	= htmlspecialchars($_POST['numfacture']);
			$produit 	= htmlspecialchars($_POST['numprod']);
			$quantite 	= htmlspecialchars($_POST['qprod']);

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
				echo 	'Le numéro de facture renseigné n\'existe pas, veuillez commencer par créer la facture correspondante. <br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
				
		}else{
		
			//Si l'utilisateur a coché "ajouter", on rentre les données dans la base
			if(($_POST['choix_comm'])=="Ajout")
			{
				//On vérifie que tous les champs sont renseignés
				if(($_POST['numprod']) != '')
				{
					
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
							echo 	'Le numéro de produit renseigné n\'existe pas, veuillez commencer par rentrer le produit 
									correspondant dans la base. <br/>';
				
						}else{	
							
							//On envoie les données dans la base
							$envoi =$bdd->prepare('INSERT INTO d_facture (NumFacture,NumProduit,Qte) VALUES(:nfact,:nprod,:quantite)');
							$envoi->execute(array	(
														'nfact'		=>$facture,
														'nprod'		=>$produit,
														'quantite'	=>$quantite
													));
							
							//On referme la base
							$envoi->closeCursor();
							
							//On signifie à l'utilisateur que tout s'est bien passé
							echo 	'Les données ont bien été ajoutées dans la base.<br/>
									<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
							
						}

					
				}
		
			//Si l'utilisateur a coché "modifier"
			}else if(($_POST['choix_comm'])=="Modification")
			{
				
				//On prend les nouvelles données, envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
					$n_quantite = htmlspecialchars($_POST['new_qprod']);
		
				//On modifie le détail de la facture
				if(($n_quantite != '') && ($n_quantite != " "))
				{

					$maj = $bdd->prepare('	UPDATE 	d_facture 
											SET 	Qte = :newqte 
											WHERE 	NumFacture = :numfact
											AND		NumProduit = :numprod
										');
					
					$modifs = $maj->execute	(array	(	
														'newqte'	=> $n_quantite,
														'numfact' 	=> $facture,
														'numprod'	=> $produit
													));
											
					$maj->closeCursor();
				
				}
				
				//On signifie à l'utilisateur que tout s'est déroulé correctement
				echo 	'Les données ont bien été modifiées.<br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
			
			}
		}
	
?>