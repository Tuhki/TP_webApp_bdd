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
		if(isset($_POST['allcli']))
		{
			
			//Si c'est le cas, on affiche toutes les données de la table concernée
			$reponse = $bdd->query('SELECT * FROM client ');
			$rows = $reponse->rowCount();
						
			//On vérifie que la table contient des données
			if ($rows == 0) 
			{
				//Si non, on indique à l'utilisateur
				echo 'Pas de clients répondant aux critères <br/>';
			
			}else
			{
				//Si oui, on affiche les données rangées dans un tableau, dont on définit le style
				echo '<div style="padding-top:10px;">
				
						<table style="width:470pt; color:darkblue; background-color:#f1f1c1; border:1px black solid;">
						
							<tr style="text-align:left;">
								<th>Numéro de client </th>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Adresse</th>
								<th>Ville</th>
								<th>Pays</th>
							</tr>';
				
				while ($donnees = $reponse->fetch())
				{	
											
					echo 	'<tr>
								<td>'.$donnees['NumClient'].'</td>
								<td>'.$donnees['NomClient'].'</td>
								<td>'.$donnees['PrenomClient'].'</td>
								<td>'.$donnees['AdresseClient'].'</td>
								<td>'.$donnees['VilleClient'].'</td>
								<td>'.$donnees['PaysClient'].'</td>
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
				if ((isset($_POST['numcli'])) AND ($_POST['numcli']!=""))
				{
					$whereseek='NumClient = '.$_POST['numcli'];
				}
				
				//On récupère les saisies du deuxième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['nomcli'])) AND ($_POST['nomcli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='NomClient like\'%'.$_POST['nomcli'].'%\'';
					} else {
						$whereseek.=' AND NomClient like \'%'.$_POST['nomcli'].'%\'';
					}
				}
				
				//On récupère les saisies du troisième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['pnomcli'])) AND ($_POST['pnomcli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='PrenomClient like \'%'.$_POST['pnomcli'].'%\'';
					}else{
						$whereseek.=' AND PrenomClient like \'%'.$_POST['pnomcli'].'%\'';
					}
				}
				
				//On récupère les saisies du quatrième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['adrcli'])) AND ($_POST['adrcli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='AdresseClient like \'%'.$_POST['adrcli'].'%\'';
					}else{
						$whereseek.=' AND AdresseClient like \'%'.$_POST['adrcli'].'%\'';
					}
				}
				
				//On récupère les saisies du cinquième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['villecli'])) AND ($_POST['villecli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='VilleClient like \'%'.$_POST['villecli'].'%\'';
					}else{
						$whereseek.=' AND VilleClient like \'%'.$_POST['villecli'].'%\'';
					}
				}
				
				//On récupère les saisies du sixième champ du formulaire, s'il y en a, 
					//et ajoute aux autres saisies du formulaire s'il y d'autres champs étaient remplis
				if ((isset($_POST['payscli'])) AND ($_POST['payscli']!=""))
				{
					if ($whereseek=='')
					{
						$whereseek='PaysClient like \'%'.$_POST['payscli'].'%\'';
					}else{
						$whereseek.=' AND PaysClient like \'%'.$_POST['payscli'].'%\'';
					}
				}
				
				//On récupère les données possédant des infos similaires à la recherche de l'utilisateur
				$reponse = $bdd->query('SELECT * FROM client WHERE ('.$whereseek.') ');
				$rows = $reponse->rowCount();
											
				if ($rows == 0) 
				{
					echo 'Pas de produit répondant aux critères <br/>';
					
				}else{
					
					//Si oui, on affiche les données rangées dans un tableau, dont on définit le style
					echo '<div style="padding-top:10px;">
				
						<table style="width:50%; color:darkblue; background-color:#f1f1c1; border:1px black solid;">
						
							<tr style="text-align:left;">
								<th>Numéro de client </th>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Adresse</th>
								<th>Ville</th>
								<th>Pays</th>
							</tr>';
					
					while ($donnees = $reponse->fetch())
					{	
												
						echo 	'<tr>
									<td>'.$donnees['NumClient'].'</td>
									<td>'.$donnees['NomClient'].'</td>
									<td>'.$donnees['PrenomClient'].'</td>
									<td>'.$donnees['AdresseClient'].'</td>
									<td>'.$donnees['VilleClient'].'</td>
									<td>'.$donnees['PaysClient'].'</td>
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
				echo('Pas de clients répondant aux critères.');
			}
		}
		
?>