<?php 
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: show_infopages.inc.php,v 1.4 2011-09-26 09:59:47 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($base_path.'/includes/etagere_func.inc.php');
// affichage des infopages demand�es 

function show_infopages($infopagesid="") {
	if (!$infopagesid) return "";
	$retaff="";
	$t_infopagesid=explode(",",$infopagesid);
	$t_infopageslues=array();
	$requete="select id_infopage, content_infopage, restrict_infopage from infopages where id_infopage in($infopagesid) and valid_infopage=1";
	$resultat=mysql_query($requete) or die(mysql_error().$requete);
	while ($res=mysql_fetch_object($resultat)) {
		//seulement si l'infopage est accessible...
		if(!$res->restrict_infopage || ($res->restrict_infopage && $_SESSION['id_empr_session']))
			$t_infopageslues[$res->id_infopage]=$res->content_infopage;
			
			$lu=$t_infopageslues[$res->id_infopage];
					// modif pour inclusion etagere dans infopages
			//  syntaxe : !!etagere_seeN,B,M,D,I!!
			//         N = id etagere
			//         B = nomBre maxi de notices � afficher, mettre 99999 pour illimiter
			//         M = 1,2,4 ou 8 mode d'affichage, comme dans le param�tre opac_etagere_notices_format  
			//         D = 0 ou 1 pour affichage d�pliable ou pas
			//         I = 0 ou  1 pour ins�rer le lien ... si nb notices > nb max notices
			$oldpos = 0 ; 
			while (($pos=strpos($lu, "!!etagere_see", $oldpos)) > 0) {
				// demande aff etagere trouv�e
				$pos_fin = strpos($lu, "!!", $pos+2);
				$info_etagere_str=substr($lu,$pos+13,$pos_fin-$pos-13);
				$info_etagere = array();
				$info_etagere = explode(",",$info_etagere_str);
	
				// $info_etagere[0] = id
				// $info_etagere[1] = nb max notices affich�es
				// $info_etagere[2] = mode d'affichage
				// $info_etagere[3] = d�pliable ou pas
				// $info_etagere[4] = lien ou pas quand plus de notices que NB max
				
				// param�tres :
				//	$idetagere : l'id de l'�tag�re
				//	$aff_notices_nb : nombres de notices affich�es : toutes = 0 
				//	$mode_aff_notice : mode d'affichage des notices, REDUIT (titre+auteur principal) ou ISBD ou PMB ou les deux : dans ce cas : (titre + auteur) en ent�te du truc, � faire dans notice_display.class.php
				//	$depliable : affichage des notices une par ligne avec le bouton de d�pliable
				//	$link_to_etagere : 0 ou 1
				//  $link : lien pour afficher le contenu de l'�tag�re "./index.php?lvl=etagere_see&id=!!id!!"
				$etagere = contenu_etagere($info_etagere[0], $info_etagere[1], $info_etagere[2], $info_etagere[3], $info_etagere[4], "./index.php?lvl=etagere_see&id=!!id!!");
				$lu = str_replace("!!etagere_see".$info_etagere_str."!!", $etagere, $lu);
				$oldpos = $pos+strlen($etagere);
			}
			$t_infopageslues[$res->id_infopage]=$lu;			
			
	}
	for ($i=0; $i<count($t_infopagesid); $i++)  {
		if ($t_infopageslues[$t_infopagesid[$i]]) $retaff.= $t_infopageslues[$t_infopagesid[$i]]; 
	}
	return $retaff;
}

