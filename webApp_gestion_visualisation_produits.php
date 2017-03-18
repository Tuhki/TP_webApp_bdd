<?php
	
	//On inclut la page avec le menu, pour qu'elle ne disparaisse pas à l'affichage des données
	include 'webApp_page_utilisateur.html';

	
	/* RECUEIL DU FORMULAIRE DE RECHERCHES ET AFFICHAGE DES RESULTATS*/

		//Connexion à la base de donnée
		Try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=facture_prof','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
							
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		
		//On vérifie si la case "afficher tout" est cochée
		if(isset($_POST['allprod']))
		{
			
			//Si c'est le cas, on affiche toutes les données de la table concernée
			
			$reponse = $bdd->query('SELECT * FROM produits ');
			$rows = $reponse->rowCount();
						
			//On vérifie que la table contient des données
			if ($rows == 0) 
			{
				//Si non, on indique à l'utilisateur
				echo 'Pas de produit répondant aux critères <br/>';
			
			}else
			{
				//Si oui, on affiche les données rangées dans un tableau, dont on définit le style
				echo '<div style="padding-top:10px;">
				
						<table style="width:50%; color:darkblue; background-color:#f1f1c1; border:1px black solid;">
						
							<tr style="text-align:left;">
								<th>Numéro du produit </th>
								<th>Description</th>
								<th>Prix unitaire hors taxe</th>
							</tr>';
				
				while ($donnees = $reponse->fetch())
				{	
											
					echo 	'<tr>
								<td>'.$donnees['NumProduit'].'</td>
								<td>'.$donnees['Des'].'</td>
								<td>'.$donnees['PUHT'].'</td>
							</tr>';														
				}
												
				echo '	</table>
					</div>';	
					
			}
		
		//Si la case n'est pas cochée, on effectue des requêtes sql avec les données entrées dans le formulaire de recherche
		}else{
	
			Try 
			{
				//Variable prenant les saisies utilisateur du formulaire
				$whereseek="";
				
				
				//On récupère les saisies du premier champ du formulaire, s'il y en a
				if ((isset($_POST['idprod'])) AND ($_POST['idprod']!=""))
				{
					$whereseek='NumProduit = '.$_POST["idprod"];
				}
				
				//On récupère les saisies du deuxième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['nomprod'])) AND ($_POST['nomprod']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='Des like\'%'.$_POST['nomprod'].'%\'';
					} else {
						$whereseek.=' AND Des like %\''.$_POST['nomprod'].'%\'';
					}
				}
				
				//On récupère les saisies du troisième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['prixprod'])) AND ($_POST['prixprod']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='PUHT like %\''.$_POST["prixprod"].'%\'';
					}else{
						$whereseek.=' AND PUHT like %\''.$_POST["prixprod"].'%\'';
					}
				}
				
				//On récupère les données possédant des infos similaires à la recherche de l'utilisateur
				$reponse = $bdd->query('SELECT * FROM produits WHERE ('.$whereseek.') ');
				$rows = $reponse->rowCount();
											
				if ($rows == 0) 
				{
					echo 'Pas de produit répondant aux critères <br/>';
					
				}else{
					echo '<div style="padding-top:10px;">
				
						<table style="width:50%; color:darkblue; background-color:#f1f1c1; border:1px black solid;">
						
							<tr style="text-align:left;">
								<th>Numéro du produit </th>
								<th>Description</th>
								<th>Prix unitaire hors taxe</th>
							</tr>';
					
					while ($donnees = $reponse->fetch())
					{	
												
						echo 	'<tr>
									<td>'.$donnees['NumProduit'].'</td>
									<td>'.$donnees['Des'].'</td>
									<td>'.$donnees['PUHT'].'</td>
								</tr>';														
					}
													
					echo '	</table>
						</div>';	
																    
				}

				//On referme la base de données							
				$reponse->closeCursor();
			}
			
			//Si aucun des cas précédents n'a donné de résultat
			catch (Exception $e)
			{
				echo('Pas de produits répondant aux critères.');
			}
		}
		
?>