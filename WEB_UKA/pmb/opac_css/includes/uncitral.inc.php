<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: uncitral.inc.php,v 1.1.2.1 2012-01-17 17:38:38 dbellamy Exp $

function search_other_function_filters() {
	global $charset,$dbh;
	global $unc_country,$unc_applicable, $look_DOCNUM;
	global $opac_indexation_docnum_allfields;

	if(!is_array($unc_country)) $unc_country=array();
	if(!is_array($unc_applicable)) $unc_applicable=array();
	if(!isset($look_DOCNUM)) $look_DOCNUM='0';
	
	$unc_aff="<span id='unc_search'><table><tbody><tr>";
	
	//Pour la sélection par "country"
	$q="select num_thesaurus, libelle_thesaurus, num_noeud, libelle_categorie from categories join thesaurus on num_thesaurus=id_thesaurus where libelle_categorie not like '~%' and langue='en_UK' order by libelle_categorie";
	$r=mysql_query($q,$dbh);
	$unc_aff.="<td><label>Countries</label><br />";
	$unc_aff.="<select name='unc_country[]' multiple='multiple' >" ;
	if (mysql_num_rows($r)) {
		while (($row = mysql_fetch_object($r))) {
			$selected='';
			if (in_array($row->num_noeud, $unc_country)) {
				$selected="selected='selected' ";
			}
			$unc_aff.= "<option value='$row->num_noeud' $selected>".htmlentities($row->libelle_categorie,ENT_QUOTES,$charset)."</option>";
		}
	}
	$unc_aff.="</select></td>";
	
	
	//Pour la sélection par "applicable NYC provisions"
	$q="select notices_custom_list_value,notices_custom_list_lib from notices_custom_lists where notices_custom_champ='10' order by ordre";
	$r=mysql_query($q,$dbh);
	$unc_aff.="<td><label>Applicable NYC provisions</label><br />";
	$unc_aff.="<select name='unc_applicable[]' multiple='multiple' >" ;
	if (mysql_num_rows($r)) {
		while (($row = mysql_fetch_object($r))) {
			$selected='';
			if (in_array($row->notices_custom_list_value,$unc_applicable)) {
				$selected="selected='selected' ";
			}
			$unc_aff.= "<option value='$row->notices_custom_list_value' $selected>".htmlentities($row->notices_custom_list_lib,ENT_QUOTES,$charset)."</option>";
		}
	}
	$unc_aff.="</select></td>";
	
	
	//Pour la sélection "include attachements"
	$unc_aff.="<td><input type='checkbox' name='look_DOCNUM' id='look_DOCNUM' value='1' ";
	if ($opac_indexation_docnum_allfields) $unc_aff.="checked='checked' ";
	$unc_aff.="/><label for='look_DOCNUM'>&nbsp;Include attachments</label></td>";
		
	$unc_aff.="</tr></tbody></table></span>";
	
	return $unc_aff;
}


function search_other_function_clause() {
	
	
	//doit retourner une requete de selection d'identifiants de notices
	global $unc_country,$unc_applicable;

	if(!is_array($unc_country)) $unc_country=array();
	$country = implode(",",$unc_country);
	if(!is_array($unc_applicable)) $unc_applicable=array();
	$applicable = implode(",",$unc_applicable);
	
	$r='';
	$r1 = '';
	$r2='';
	
	if ($country) {
		$r1 = 'select distinct notcateg_notice as notice_id from notices_categories where num_noeud in ('.$country.')';	
	}
	
	if ($applicable) {
		$r2 = "select distinct notices_custom_origine as notice_id from notices_custom_values where notices_custom_champ='10' and notices_custom_integer in (".$applicable.")";
	}
	
	if ($r1 && !$r2) 	$r = $r1;
	if (!$r1 && $r2) 	$r = $r2;
	if ($r1 && $r2) 	$r = "select * from ($r1) as q1 where notice_id in ($r2) ";
	
	return $r;
}


function search_other_function_has_values() {
	global $unc_country,$unc_applicable;
	
	if ( (is_array($unc_country) && count($unc_country)) || (is_array($unc_applicable) && count($unc_applicable)) ) return true; else return false;
}


function search_other_function_get_values(){
	global $unc_country,$unc_applicable;
	
	return serialize(array($unc_country,$unc_applicable));
}


function search_other_function_rec_history($n) {
	global $unc_country,$unc_applicable;
	
	$_SESSION['unc_country'.$n]=$unc_country;
	$_SESSION['unc_applicable'.$n]=$unc_applicable;
}


function search_other_function_get_history($n) {
	global $unc_country,$unc_applicable;
	
	$unc_country=$_SESSION['unc_country'.$n];
	$unc_applicable=$_SESSION['unc_applicable'.$n];
}


function search_other_function_human_query($n) {
	
	global $dbh;
	
	$ret='';
	$unc_country=$_SESSION['unc_country'.$n];
	$unc_applicable=$_SESSION['unc_applicable'.$n];
	
	$app=array();
	if (count($unc_country)) {
		$q="select libelle_categorie from categories where num_noeud in (".implode(',',$unc_country).") and langue='en_UK' ";
		$r=mysql_query($q,$dbh);
		if (mysql_num_rows($r)) {
			while($row=mysql_fetch_object($r)) $app[] = $row->libelle_categorie;
		}
	}
	if (count($app)) $ret.="Country : ".implode(' ou ',$app);
	
	$app=array();
	if (count($unc_applicable)) {
 		$q="select notices_custom_list_lib from notices_custom_lists where notices_custom_champ='10' and notices_custom_list_value in (".implode(',',$unc_applicable).") ";
       	$r=mysql_query($q,$dbh);
       	if (mysql_num_rows($r)) {
			while($row=mysql_fetch_object($r)) $app[] = $row->notices_custom_list_lib;
		}
	}
	if($ret && $app) $ret.=", ";
	if (count($app)) $ret.="Applicable NYC provision : ".implode(' ou ',$app);
	
	return $ret;
}


function search_other_function_post_values() {
	global $unc_country,$unc_applicable;
	$retour='';
	if (is_array($unc_country) && count($unc_country)) {
		foreach($unc_country as $v) {
			$retour.= "<input type='hidden' name='unc_country[]' value='".$v."' />\n";
		}
	}
	if (is_array($unc_applicable) && count($unc_applicable)) {
		foreach($unc_applicable as $v) {
			$retour.= "<input type='hidden' name='unc_applicable[]' value='".$v."' />\n";
		}
	}
	return $retour;
}
