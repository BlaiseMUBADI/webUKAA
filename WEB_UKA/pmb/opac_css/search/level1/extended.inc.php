<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: extended.inc.php,v 1.21.2.2 2011-12-16 13:51:39 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");
require_once($class_path."/searcher.class.php");

$nb_result_extended=0;
$flag=false;
//Vérification des champs vides
//Y-a-t-il des champs ?
if (count($search)==0) {
	$search_error_message=$msg["extended_use_at_least_one"];
	$flag=true;
} else {
    //Vérification des champs vides
    for ($i=0; $i<count($search); $i++) {
    	$op="op_".$i."_".$search[$i];
    	global $$op;
    	$field_="field_".$i."_".$search[$i];
    	global $$field_;
    	$field=$$field_;
    	$s=explode("_",$search[$i]);
    	if ($s[0]=="f") {
    		$champ=$es->fixedfields[$s[1]]["TITLE"];
    	} elseif ($s[0]=="s") { 
    		$champ=$es->specialfields[$s[1]]["TITLE"];	
    	} else {
    		$champ=$es->pp->t_fields[$s[1]]["TITRE"];
    	}
    	if (((string)$field[0]=="") && (!$es->op_empty[$$op])) {
    		$search_error_message=sprintf($msg["extended_empty_field"],$champ);
    		$flag=true;
 			break;
    	}
    }
}
if (!$flag) {
	$searcher_extended = new searcher_extended();
	$searcher_extended->get_result();
	$nb_result_extended =  $searcher_extended->get_nb_results();

	//	Enregistrement des stats
	if($pmb_logs_activate){
		global $nb_results_tab;
		$nb_results_tab['extended'] = $nb_result_extended;
	}
	
	if($opac_allow_affiliate_search){
		$search_result_affiliate_extented =  str_replace("!!mode!!","extended",$search_extented_result_affiliate_lvl1);
		$search_result_affiliate_extented =  str_replace("!!search_type!!","notices",$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!label!!",$es->make_human_query(),$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!nb_result!!",$nb_result_extended,$search_result_affiliate_extented);
		if($nb_result_extended){
			$link = "<a href='#' onclick=\"document.search_form.action = './index.php?lvl=more_results&mode=extended&tab=catalog'; document.search_form.submit();return false;\">".$msg['suite']."&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a>";
		}else $link = "";
		$search_result_affiliate_extented =  str_replace("!!link!!",$link,$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!style!!","",$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!user_query!!",$es->serialize_search(),$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!form_name!!","search_form",$search_result_affiliate_extented);
		$search_result_affiliate_extented =  str_replace("!!form!!","",$search_result_affiliate_extented);
		print $search_result_affiliate_extented;
	}else{	
		if ($nb_result_extended) {
			print pmb_bidi("<strong>".$es->make_human_query()."</strong> ".$nb_result_extended." $msg[results] ");
			print "<a href=\"#\" onclick=\"document.search_form.action='./index.php?lvl=more_results&mode=extended'; document.search_form.submit(); return false;\">$msg[suite]&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a><br /><br />";
		}
	}	
	
}



//if (!$flag) {
//	$table=$es->make_search();
//	
//	//droits d'acces emprunteur/notice
//	$acces_j='';
//	if ($gestion_acces_active==1 && $gestion_acces_empr_notice==1) {
//		require_once("$class_path/acces.class.php");
//		$ac= new acces();
//		$dom_2= $ac->setDomain(2);
//		$acces_j = $dom_2->getJoin($_SESSION['id_empr_session'],4,'notice_id');
//	}
//		
//	if($acces_j) {
//		$statut_j='';
//		$statut_r='';
//	} else {
//		$statut_j=',notice_statut';
//		$statut_r="and statut=id_notice_statut and ((notice_visible_opac=1 and notice_visible_opac_abon=0)".($_SESSION["user_code"]?" or (notice_visible_opac_abon=1 and notice_visible_opac=1)":"").")";
//	}
//	if($_SESSION["opac_view"]){
//		$opac_view_restrict=" $table.notice_id in (select opac_view_num_notice from  opac_view_notices_".$_SESSION["opac_view"].") ";
//		$statut_r.=" and ".$opac_view_restrict;
//	}	
//		
//	//$requete="select count(1) from $table, notices, notice_statut where $table.notice_id=notices.notice_id and (statut=id_notice_statut and ((notice_visible_opac=1 and notice_visible_opac_abon=0)".($_SESSION["user_code"]?" or (notice_visible_opac_abon=1 and notice_visible_opac=1)":"")."))";
//	$requete="select count(1) from $table, notices $acces_j $statut_j where $table.notice_id=notices.notice_id $statut_r ";
//	$resultat=mysql_query($requete);
//	
//	$nb_result_extended=@mysql_result($resultat,0,0);
//	
//	//Enregistrement des stats
//	if($pmb_logs_activate){
//		global $nb_results_tab;
//		$nb_results_tab['extended'] = $nb_result_extended;
//	}
//	
//	
//	if($opac_allow_affiliate_search){
//		$search_result_affiliate_extented =  str_replace("!!mode!!","extended",$search_extented_result_affiliate_lvl1);
//		$search_result_affiliate_extented =  str_replace("!!search_type!!","notices",$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!label!!",$es->make_human_query(),$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!nb_result!!",$nb_result_extended,$search_result_affiliate_extented);
//		if($nb_result_extended){
//			$link = "<a href='#' onclick=\"document.search_form.action = './index.php?lvl=more_results&mode=extended&tab=catalog'; document.search_form.submit();return false;\">".$msg['suite']."&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a>";
//		}else $link = "";
//		$search_result_affiliate_extented =  str_replace("!!link!!",$link,$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!style!!","",$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!user_query!!",$es->serialize_search(),$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!form_name!!","search_form",$search_result_affiliate_extented);
//		$search_result_affiliate_extented =  str_replace("!!form!!","",$search_result_affiliate_extented);
//		print $search_result_affiliate_extented;
//	}else{	
//		if ($nb_result_extended) {
//			print pmb_bidi("<strong>".$es->make_human_query()."</strong> ".$nb_result_extended." $msg[results] ");
//			print "<a href=\"javascript:document.search_form.action='./index.php?lvl=more_results&mode=extended'; document.search_form.submit()\">$msg[suite]&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a><br /><br />";
//		}
//	}
//}
?>