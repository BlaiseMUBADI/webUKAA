<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: liste_relances.inc.php,v 1.4 2011-08-16 12:17:31 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// popup d'impression PDF pour liste des relances de receptions
// reçoit : tab_no_mail

require_once("$class_path/entites.class.php");
require_once("$class_path/receptions_relances.class.php");

$tab_fou = unserialize(rawurldecode($tab_no_mail));

if (count($tab_fou) && $id_bibli){
	
	switch($acquisition_pdfrel_pdfrtf) {
		case '1' :
			$lettre = new lettreRelance_RTF();
			break;
		default :
			$lettre = new lettreRelance_PDF();
			break;
	}
	foreach($tab_fou as $id_fou=>$tab_act) {
		
		$bib = new entites($id_bibli);
		$bib_coord = mysql_fetch_object($bib->get_coordonnees($id_bibli,1));
		
		$fou = new entites($id_fou);
		$fou_coord = mysql_fetch_object($fou->get_coordonnees($id_fou,1));
		$lettre->doLettre(&$bib, &$bib_coord,&$fou, &$fou_coord, &$tab_act);
	}
	$lettre->getLettre();
	
}