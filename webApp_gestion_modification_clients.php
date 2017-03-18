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
			$nom 		= htmlspecialchars($_POST['nomcli']);
			$prenom 	= htmlspecialchars($_POST['pnomcli']);
			$adresse 	= htmlspecialchars($_POST['adrcli']);
			$cp 		= htmlspecialchars($_POST['cpcli']);
			$ville 		= htmlspecialchars($_POST['villecli']);
			$pays 		= htmlspecialchars($_POST['payscli']);

		//Si l'utilisateur a coché "ajouter", on rentre les données dans la base
		if(($_POST['choix_cli'])=="Ajout")
		{
			//On vérifie que les champs ne sont pas remplis par des caractères vides
			if((($_POST['nomcli']) != '') && (($_POST['pnomcli']) != '')&& (($_POST['adrcli']) != ''))
			{
				
				//On envoie les données dans la base
				$envoi =$bdd->prepare('INSERT INTO client(NomClient,PrenomClient,AdresseClient,Cp,VilleClient,PaysClient)VALUES(:Nom,:Prenom,:Adr,:Cp,:Ville,:Pays)');
				$envoi->execute(array	(
											'Nom'	=>$nom,
											'Prenom'=>$prenom,
											'Adr'	=>$adresse,
											'Cp'	=>$cp,
											'Ville'	=>$ville,
											'Pays'	=>$pays
										));
				
				//On referme la base
				$envoi->closeCursor();
				
				//On signifie à l'utilisateur que tout s'est bien passé
				echo 	'Les données de '.$prenom.' '.$nom.' ont bien été ajoutées dans la base.<br/>
						<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
			}
		
		//Si l'utilisateur a coché "modifier"
		}else if(($_POST['choix_cli'])=="Modification")
		{
			
			//On prend les nouvelles données, envoyées par le formulaire et on vérifie que ce n'est pas du code dissimulé
				$n_nom 		= htmlspecialchars($_POST['new_nomcli']);
				$n_prenom 	= htmlspecialchars($_POST['new_pnomcli']);
				$n_adresse 	= htmlspecialchars($_POST['new_adrcli']);
				$n_cp 		= htmlspecialchars($_POST['new_cpcli']);
				$n_ville 	= htmlspecialchars($_POST['new_villecli']);
				$n_pays 	= htmlspecialchars($_POST['new_payscli']);
			
			//On récupère le numéro client, qui est unique et propre à chaque client
			$req = $bdd -> prepare	('	
										SELECT 	NumClient 
										FROM 	client 
										WHERE 	NomClient = :name
										AND 	PrenomClient = :fname
										AND		AdresseClient = :adr
										AND		Cp = :cdpo
										AND		VilleClient = :town
										AND		PaysClient = :land
									');
			
			$req->execute(array(
									'name'	=> $nom,
									'fname' => $prenom,
									'adr'	=> $adresse,
									'cdpo'	=> $cp,
									'town' 	=> $ville,
									'land'	=> $pays
									
								));
								
			$numero = $req->fetchAll();
			
			$req->closeCursor();
			
			//On utilise le numéro de client récupéré pour mettre à jour les données par rapport aux champs renseignés
			
			/* NOM */
			if(($n_nom != '') && ($n_nom != " "))
			{

				$maj = $bdd->prepare('UPDATE client SET NomClient = :newnom WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newnom'	=> $n_nom,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			/* PRENOM */
			if(($n_prenom != '') && ($n_prenom != " "))
			{

				$maj = $bdd->prepare('UPDATE client SET PrenomClient = :newpnom WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newpnom'	=> $n_prenom,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			/* ADRESSE */
			if(($n_adresse != '') && ($n_adresse != " "))
			{
				
				$maj = $bdd->prepare('UPDATE client SET AdresseClient = :newadr WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newadr'	=> $n_adresse,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			/* CODE POSTAL */
			if(($n_cp != '') && ($n_cp != " "))
			{

				$maj = $bdd->prepare('UPDATE client SET Cp = :newcp WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newcp'	=> $n_cp,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			/* VILLE */
			if(($n_ville != '') && ($n_ville != " "))
			{

				$maj = $bdd->prepare('UPDATE client SET VilleClient = :newtown WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newtown'	=> $n_ville,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			/* PAYS */
			if(($n_pays != '') && ($n_pays != " "))
			{

				$maj = $bdd->prepare('UPDATE client SET PaysClient = :newcountry WHERE NumClient = :numclient');
				
				$modifs = $maj->execute	(array	(	
													'newcountry'	=> $n_pays,
													'numclient' => $numero[0]['NumClient']
												));
										
				$maj->closeCursor();
			
			}
			
			echo 	'Les données de '.$prenom.' '.$nom.' ont bien été modifiées.<br/>
					<a href = "webApp_page_modification.html">Retourner à la page précédente.</a>';
			
		}else{
			echo 'Impossibilité de modifier la base de données.';
		}
	
?>