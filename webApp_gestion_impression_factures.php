<?php
	
	/*
		BUT 	: PERMETTRE A L'UTILISATEUR D'AFFICHER UNE FACTURE ET L'IMPRIMER
		ENTREE 	: NUMERO DE CLIENT, DE FACTURE ET DATE DE FACTURE SAISIES PAR L'UTILISATEUR
		SORTIE	: FACTURE CONTENANT TOUTES LES INFORMATIONS DE COMMANDE ET FACTURATION
	*/
	
	//On inclut la page de recherche de facture
	include 'webApp_page_impression_facture.html';
	

	//Connexion à la base de donnée
		Try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=facture_prof','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		
		
	//Récupération du formulaire et recherche dans la base
	
		Try 
		{
			//Variable prenant les saisies utilisateur du formulaire
			
				$whereseek="";
					
					
			//On récupère les saisies du premier champ du formulaire, s'il y en a
			
				if ((isset($_POST['idfacture'])) AND ($_POST['idfacture']!=""))
				{
					$whereseek='NumFacture = '.$_POST['idfacture'];
				}
				
			//On récupère les saisies du deuxième champ du formulaire, s'il y en a, 
			//et ajoute aux autres saisies du formulaire si d'autres champs étaient remplis
			
				if ((isset($_POST['datefacture'])) AND ($_POST['datefacture']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='DateFacture = '.$_POST['datefacture'];
					} else {
						$whereseek.=' AND DateFacture like \'%'.$_POST['datefacture'].'%\'';
					}
				}
				
			//On récupère les saisies du troisième champ du formulaire, s'il y en a, 
			//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
			
				if ((isset($_POST['idcli'])) AND ($_POST['idcli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='NumClient = '.$_POST['idcli'];
					}else{
						$whereseek.=' AND NumClient = '.$_POST['idcli'];
					}
				}
				
			//On récupère les données de la base possédant des infos similaires à la recherche de l'utilisateur	
			//On commence par récupérer les coordonnées du client
				
				$req = $bdd->prepare('SELECT * FROM client WHERE NumClient = ?');
				$req->execute(array($_POST['idcli']));

				while ($donnees = $req->fetch())
				{
					
					echo 	
							'<div id="coordonnees">
								<ul style="list-style-type: none;">
									<li>'.$donnees['NomClient'].' '.$donnees['PrenomClient'].'</li> 
									<li>'.$donnees['AdresseClient'].'</li>
									<li>'.$donnees['Cp'].' '.$donnees['VilleClient'].'</li>
									<li>'.$donnees['PaysClient'].'</li>
								</ul>
							</div>
							';
				
				}

				
			//On récupère tous les détails de la facture et des produits				
				
				$reponse = $bdd->prepare('	SELECT 	Facture.NumFacture, DateFacture, Qte, d_facture.NumProduit, Des, PUHT  
											FROM 	facture, d_facture, produits
											WHERE  	Facture.NumFacture = ?
											AND		d_facture.NumFacture = Facture.NumFacture
											AND		produits.NumProduit = d_facture.NumProduit');
				
				$reponse->execute(array($_POST['idfacture']));
				
				$rows = $reponse->rowCount();
				
				//S'il n'y a pas de données on indique un message d'erreur
				if ($rows == 0) 
				{
					echo 'Pas de facture répondant aux critères <br/>';
				
				//S'il y a des données, on les affiche dans un tableau précédé du n° et la date de facture 
				}else{
					echo '<div style="padding-top:10px;">
					
							<ul style="list-style-type: none;">
								<li>Numéro de facture : '.$_POST['idfacture'].'</li>
								<li>Date de facturation : '.$_POST['datefacture'].'</li>
							</ul>
							
							<table style = "width:450pt; color:darkblue; background-color:#f1f1c1; border:1px black solid;">
							
								<tr style="text-align:left;">
									<th>Numéro de produit</th>
									<th>Libellé</th>
									<th>Quantité commandée</th>
									<th>Prix unitaire HT</th>
								</tr>';
				
				while ($donnees = $reponse->fetch())
				{	
					
					echo 	'<tr>
								<td>'.$donnees['NumProduit'].'</td>
								<td>'.$donnees['Des'].'</td>
								<td>'.$donnees['Qte'].'</td>
								<td>'.$donnees['PUHT'].'</td>
							</tr>';														
					}

				}
				
				//On calcule et affiche le montant total de la facture
				$total = $bdd->prepare('SELECT SUM(Qte*PUHT)
										FROM `d_facture`, `produits` 
										WHERE d_facture.NumProduit = produits.NumProduit 
										AND NumFacture = ?');
				$total->execute(array($_POST['idfacture']));

				while	($donnees = $total->fetch()){
					
					echo 	'	<tr>
									<td colspan = "2"></td>
									<td style = "color : black; border-top : 1px dashed black;" >Montant total Hors-Taxe : </td>
									<td style = "border-top : 1px dashed black;" >'.$donnees[0].'</td>
								</tr>
							</table>
						</div>';
							
				}
				
	
				//On referme la base de données							
				$reponse->closeCursor();
				
			}
			
			//Si aucun des cas précédents n'a donné de résultat
			catch (Exception $e)
			{
				echo('Aucune facture ne répond aux critères.');
			}

		//Message pour indiquer à l'utilisateur comment imprimer sa facture	
		echo 	'<p>
					Quand vous êtes prêts, faites un clic droit avec la souris puis sélectionnez "Imprimer..."</br>
					N\'oubliez pas de décocher la case "En-tête et pied-de-page" si vous souhaitez ne pas voir
					apparaître l\'adresse url sur votre feuille imprimée.
				</p>';
				
?>