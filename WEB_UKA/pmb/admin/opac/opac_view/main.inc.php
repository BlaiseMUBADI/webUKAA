<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: main.inc.php,v 1.1 2011-04-20 06:27:21 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// page de switch recherche notice

// inclusions principales

switch($section) {
	case "list":
		// affichage de la liste des recherches en opac
		$admin_layout = str_replace('!!menu_sous_rub!!', $msg["opac_view_admin_menu"], $admin_layout);
		print $admin_layout;		
		include("./admin/opac/opac_view/list.inc.php");
	break;	
	default :
		// affichage de la liste des recherches en opac
		$admin_layout = str_replace('!!menu_sous_rub!!', $msg["opac_view_admin_menu"], $admin_layout);
		print $admin_layout;	
		include("./admin/opac/opac_view/list.inc.php");
	break;
}


