
jQuery(function($) {
	var equine_text = ' cette annonce';
	var equine_text_s_all = ' les annonces';
	var equipeer_submit_button_text = $("#original_publish").val();
	var equine_voir_link = $("#sample-permalink a").attr('href');
	var equine_all_link = "./edit.php?post_type=equine";
	
	$( "#wpbody-content" ).prepend( '<div id="equipeer-controls"><input form="post" name="save" type="submit" class="button button-primary button-large" id="equipeer-publish" value="'+equipeer_submit_button_text+equine_text+'"><a target="_blank" href="'+equine_voir_link+'" class="button button-primary button-large" id="equipeer-preview">Prévisualiser'+equine_text+'</a><a target="_blank" href="'+equine_voir_link+'" class="button button-primary button-large" id="equipeer-link">Voir'+equine_text+'</a><a onclick="return equine_confirm_exit()" href="'+equine_all_link+'" class="button button-primary button-large" id="equipeer-link">Toutes '+equine_text_s_all+'</a></div><style>#wpbody { margin-top: 57px; } #adminmenuwrap { margin-top: -118px; }</style>' );
	
});

function equine_confirm_exit() {
	var r = confirm( "Vous souhaitez quitter la page ?" );
	if (r === false) return false;
}