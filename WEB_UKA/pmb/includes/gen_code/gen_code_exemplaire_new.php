<?php

function init_gen_code_exemplaire($notice_id,$bull_id)
{
	global $dbh;
	$prefixe="GEN";
	//$requete="select max(expl_cb)as cb from exemplaires WHERE expl_cb like 'GEN%'";
	$requete="select MAX(SUBSTRING(expl_cb,(LENGTH('".$prefixe."')*1+1))*1) AS cb  from exemplaires WHERE expl_cb REGEXP '^".$prefixe."[0-9]*$'";
	$query = mysql_query($requete, $dbh);
	if(mysql_num_rows($query)) {	
    	if(($cb = mysql_fetch_object($query))){
    		if($cb->cb){
    			$code_exemplaire= $prefixe.$cb->cb;
    		}else{
    			$code_exemplaire = $prefixe."0";
    		}
    	}else{
    		$code_exemplaire = $prefixe."0";
    	}
	}else{
		$code_exemplaire = $prefixe."0";
	}
	return $code_exemplaire;
}

function gen_code_exemplaire($notice_id,$bull_id,$code_exemplaire)
{
	if(preg_match("/(\D*)([0-9]*)/",$code_exemplaire,$matches)){
		$matches[2]++;
		$code_exemplaire=$matches[1].$matches[2];
	}else{
		$code_exemplaire++;
	}
	return $code_exemplaire;
}