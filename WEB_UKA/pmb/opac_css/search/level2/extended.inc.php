<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: extended.inc.php,v 1.58.2.3 2012-02-28 14:06:52 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// second niveau de recherche OPAC sur titre
// inclusion classe pour affichage notices (level 1)
require_once($base_path.'/includes/templates/notice.tpl.php');
require_once($base_path.'/classes/notice.class.php');
require_once($class_path."/search.class.php");
require_once($class_path."/searcher.class.php");
require_once($base_path.'/classes/facette_search.class.php');

$es=new search();

$sr_form='';

if($opac_allow_affiliate_search){
	$sr_form.= $search_result_extended_affiliate_lvl2_head;
} else {
	$sr_form.= "	<div id=\"resultatrech\"><h3>".$msg['resultat_recherche']."</h3>\n
		<div id=\"resultatrech_container\">
		<div id=\"resultatrech_see\">";
}

//le contenu du catalogue est calculé dans 2 cas  :
// 1- la recherche affiliée n'est pas activée, c'est donc le seul résultat affichable
// 2- la recherche affiliée est active et on demande l'onglet catalog...
if(!$opac_allow_affiliate_search || ($opac_allow_affiliate_search && $tab == "catalog")){
	//gestion du tri
	if (isset($_GET["sort"])) {	
		$_SESSION["last_sortnotices"]=$_GET["sort"];
	}
	if ($count>$opac_nb_max_tri) {
		$_SESSION["last_sortnotices"]="";
	}
	
	global $facette_test;
	if($facette_test==1){
		global $search;
		global $value;
		global $champ;
		global $ss_champ;
		facettes::checked_facette_search($value,$champ,$ss_champ);
	}
	
	$searcher = new searcher_extended();
	if($opac_visionneuse_allow){
		$nbexplnum_to_photo = $searcher->get_nb_explnums();	
	}
	$count = $searcher->get_nb_results();
	//Enregistrement des stats
	if($pmb_logs_activate){
		global $nb_results_tab;
		$nb_results_tab['extended'] = $count;
	}
	
	if($count){
		if(isset($_SESSION["last_sortnotices"]) && $_SESSION["last_sortnotices"]!==""){
			$notices = $searcher->get_sorted_result($_SESSION["last_sortnotices"],$debut,$opac_search_results_per_page);	
		}else{
			$notices = $searcher->get_sorted_result("default",$debut,$opac_search_results_per_page);	
		}
	}
	$sr_form.= pmb_bidi("<h3>$count $msg[titles_found] ".$es->make_human_query()."</h3>");
	
	// pour la DSI
	if ($opac_allow_bannette_priv && $allow_dsi_priv && ($_SESSION['abon_cree_bannette_priv']==1 || $opac_allow_bannette_priv==2)) {
		$sr_form.= "<input type='button' class='bouton' name='dsi_priv' value=\"$msg[dsi_bt_bannette_priv]\" onClick=\"document.form_values.action='./empr.php?lvl=bannette_creer'; document.form_values.submit();\">&nbsp;";
	}
	
	if(!$opac_allow_affiliate_search) {
		$sr_form.= "</div>";
	}
	$sr_form.= "<div id=\"resultatrech_liste\">";
	
	if ($opac_notices_depliable) {
		$sr_form.= 	$begin_result_liste;
	}
	
	//gestion du tri
	if ($count<=$opac_nb_max_tri) {
		$pos=strpos($_SERVER['REQUEST_URI'],"?");
		$pos1=strpos($_SERVER['REQUEST_URI'],"get");
		if ($pos1==0) $pos1=strlen($_SERVER['REQUEST_URI']);
		else $pos1=$pos1-3;
		$para=urlencode(substr($_SERVER['REQUEST_URI'],$pos+1,$pos1-$pos+1));
		$affich_tris_result_liste=str_replace("!!page_en_cours!!",$para,$affich_tris_result_liste); 
		$sr_form.= $affich_tris_result_liste;
		
		if ($_SESSION["last_sortnotices"]!="") {
			$sort=new sort('notices','session');
			$sr_form.= " ".$msg['tri_par']." ".$sort->descriptionTriParId($_SESSION["last_sortnotices"])."&nbsp;";
		}
	} else {
		$sr_form.= "&nbsp;";
	}
	//fin gestion du tri
	
	$sr_form.= $add_cart_link;
	
	if($opac_visionneuse_allow && $nbexplnum_to_photo){
		$search_to_post = $es->serialize_search();
		$sr_form.= "&nbsp;&nbsp;&nbsp;".$link_to_visionneuse;

		$sr_form.= "
	<script type='text/javascript'>
		function sendToVisionneuse(explnum_id){
			if (typeof(explnum_id)!= 'undefined') {
				var explnum =document.createElement('input');
				explnum.setAttribute('type','hidden');
				explnum.setAttribute('name','explnum_id');
				explnum.setAttribute('value',explnum_id);
				document.form_values.appendChild(explnum);
			}
			var mode = document.createElement('input');
			mode.setAttribute('type','hidden');
			mode.setAttribute('name','mode');
			mode.setAttribute('value','extended');
			var input = document.createElement('input');
			input.setAttribute('id','search');
			input.setAttribute('name','search');
			input.setAttribute('value','".htmlspecialchars($search_to_post,ENT_QUOTES,$charset)."');
			document.form_values.appendChild(input);
			document.form_values.appendChild(mode);
		
	
			document.form_values.action='visionneuse.php';
			document.form_values.target='visionneuse';
			document.form_values.submit();
		}
	</script>";
		
	}

	//affinage
	//enregistrement de l'endroit actuel dans la session
	if ($_SESSION["last_query"]) {	$n=$_SESSION["last_query"]; } else { $n=$_SESSION["nb_queries"]; }
	
	if(count($_SESSION['facette'])==0){
		$_SESSION["notice_view".$n]["search_mod"]="extended";
		$_SESSION["notice_view".$n]["search_page"]=$page;
	}
	
	
	//affichage
	$sr_form.= "&nbsp;&nbsp;<a href='$base_path/index.php?search_type_asked=extended_search&get_query=$n'>".$msg["affiner_recherche"]."</a>";
	
	//fin affinage
	
	//Etendre
	if ($opac_allow_external_search) {
		$sr_form.= 	"&nbsp;&nbsp;<a href='$base_path/index.php?search_type_asked=external_search&mode_aff=aff_simple_search&external_type=multi'>".$msg["connecteurs_external_search_sources"]."</a>";
	}
	//fin etendre
	
	if ($opac_show_suggest) {
		$bt_sugg = "&nbsp;&nbsp;&nbsp;<a href=# ";
		if ($opac_resa_popup) $bt_sugg .= " onClick=\"w=window.open('./do_resa.php?lvl=make_sugg&oresa=popup','doresa','scrollbars=yes,width=600,height=600,menubar=0,resizable=yes'); w.focus(); return false;\"";
		else $bt_sugg .= "onClick=\"document.location='./do_resa.php?lvl=make_sugg&oresa=popup' \" ";			
		$bt_sugg.= " >".$msg[empr_bt_make_sugg]."</a>";
		$sr_form.= $bt_sugg;
	}
	$sr_form.= "<blockquote>";
	$sr_form.= aff_notice(-1);
	$nb=0;
	$recherche_ajax_mode=0;
	;
	for ($i =0 ; $i<count($notices);$i++){
		if($i>4)$recherche_ajax_mode=1;
		$sr_form.= pmb_bidi(aff_notice($notices[$i], 0, 1, 0, "", "", 0, 0, $recherche_ajax_mode));
	}
	$sr_form.= aff_notice(-2);
	
	$sr_form.= "</blockquote></div></div>";
	
	// constitution des liens
	$nbepages = ceil($count/$opac_search_results_per_page);
	$sr_form.= "<div class='row'>&nbsp;</div>";
	
	if(!$opac_allow_affiliate_search){
		$url_page = "javascript:document.form_values.page.value=!!page!!; document.form_values.submit()";
		$action = "javascript:document.form_values.page.value=document.form.page.value; document.form_values.submit()";
	}else{
		$url_page = "javascript:document.form_values.page.value=!!page!!; document.form_values.catalog_page.value=document.form_values.page.value; document.form_values.action = \"./index.php?lvl=more_results&mode=extended&tab=catalog\"; document.form_values.submit()";
		$action = "javascript:document.form_values.page.value=document.form.page.value; document.form_values.catalog_page.value=document.form_values.page.value; document.form_values.action = \"./index.php?lvl=more_results&mode=extended&tab=catalog\"; document.form_values.submit()";
	}	
	$sr_form.="<hr />\n<center>".printnavbar($page, $nbepages, $url_page,$action)."</center>";
	
	if(!$opac_allow_affiliate_search) {
		$sr_form.= "	</div>";
	}
	$sr_form = str_replace('<!-- search_result_extended_affiliate_lvl2_head_link -->',$search_result_extended_affiliate_lvl2_head_wo_link,$sr_form);
	
} else {
	
	if($tab == "affiliate"){
		//l'onglet source affiliées est actif, il faut son contenu...
		$query = $es->serialize_search();
		$as=new affiliate_search_extended($query);
		$as->getResults();
		$sr_form.= $as->results;
	}
	$sr_form.= "
	</div>
	<div class='row'>&nbsp;</div>";
	
	//Enregistrement des stats
	if($pmb_logs_activate){
		global $nb_results_tab;
		$nb_results_tab['extended_affiliate'] = $as->getTotalNbResults();
	}	
	$es->unserialize_search($query);
	
}
print $sr_form;


		