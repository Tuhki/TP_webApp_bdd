$(function(){
/* 
	BUT 	: GERER L'ANIMATION DES MENUS DEROULANTS
	ENTREE	: CLICS DE L'UTILISATEUR A LA SOURIS
	SORTIE	: AFFICHE OU CACHE LES LISTES DU MENU
*/

	
	
	//Cache le menu déroulant et les formulaires de recherche à l'ouverture de la page
	if($('.menu').is(":visible")){
			$('.li_form').hide();
			$('.choix_menu').hide();
		}
		
		
	//Déroule les choix du menu lorsque l'élément de menu dans lequel ils sont est cliqué
	$('#visualiser').click(function(){
		
			$('#choix_menu_visu').slideToggle();
			
	});
	
	
	//Déroule les choix du menu lorsque l'élément de menu dans lequel ils sont est cliqué
	$('#modifier').click(function(){
	
			$('#choix_menu_modif').slideToggle();

			
	});
		
		
	//Rend les formulaires visibles ou invisibles lorsque l'élément de liste dans lequel ils sont est cliqué
	$('#visu_li1').click(function(){
		
		$('#visu_li1_form').slideToggle();

	});
	
	
	$('#visu_li2').click(function(){
		
		$('#visu_li2_form').slideToggle();
	
	});
	
	
	$('#visu_li3').click(function(){
		
		$('#visu_li3_form').slideToggle();
	
	});
	
	
	$('#visu_li4').click(function(){
		
		$('#visu_li4_form').slideToggle();
	
	});
	

});