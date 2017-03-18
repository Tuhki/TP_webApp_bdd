<?php

	/* 
	BUT 	: SUPPRIMER UN CLIENT
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

		//Si l'utilisateur a rentré directement le numéro de client
		if(isset($_POST['numcli']) && (($_POST['numcli']) != ''))
		{
			//On prend les données envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
			$num 		= htmlspecialchars($_POST['numcli']);
			
			//On supprime les données de la base
			$supp =$bdd->prepare('DELETE FROM client WHERE NumClient = :ncli');
			$supp->execute(array('ncli'	=>$num));
				
			//On referme la base
			$supp->closeCursor();
				
			//On signifie à l'utilisateur que tout s'est bien passé
			echo 	'Les données du client ont bien été supprimées de la base.<br/>
					<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
		
		
		//Si l'utilisateur a rempli les autres champs
		}else if(isset($_POST['nomcli']) && (($_POST['nomcli']) != '')){
		
			//On prend les données envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
			$nom 		= htmlspecialchars($_POST['nomcli']);
			$prenom 	= htmlspecialchars($_POST['pnomcli']);
			$adresse 	= htmlspecialchars($_POST['adrcli']);
			$cp 		= htmlspecialchars($_POST['cpcli']);
			$ville 		= htmlspecialchars($_POST['villecli']);
			$pays 		= htmlspecialchars($_POST['payscli']);
			
			//On supprime les données de la base
			$supp =$bdd->prepare('	DELETE 	FROM client 
									WHERE 	NomClient = :ncli
									AND		PrenomClient = :pncli
									AND		AdresseClient = :adcli
									AND		Cp = :cpcli
									AND		VilleClient = :vcli
									AND		PaysClient = :pcli
								');
								
			$supp->execute(array(
									'ncli'	=>$nom,
									'pncli'	=>$prenom,
									'adcli' =>$adresse,
									'cpcli' =>$cp,
									'vcli' 	=>$ville,
									'pcli' 	=>$pays
								));
				
			//On referme la base
			$supp->closeCursor();
				
			//On signifie à l'utilisateur que tout s'est bien passé
			echo 	'Les données du client ont bien été supprimées de la base.<br/>
					<a href = "webApp_page_suppression.html">Retourner à la page précédente.</a>';
					
		}
?>