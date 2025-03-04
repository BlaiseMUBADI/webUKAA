<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: ajax_main.inc.php,v 1.4.8.1 2011-12-23 09:38:45 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

//En fonction de $categ, il inclut les fichiers correspondants

switch($categ):
	case 'pret_ajax':
		include("./circ/pret_ajax/main.inc.php");
		break;
	case 'transferts':
		include("./circ/transferts/ajax/main.inc.php");
		break;			
	case 'print_pret':
		include("./circ/print_pret/main.inc.php");
		break;
	case 'resa_planning':
		include("./circ/resa_planning/resa_planning_ajax.inc.php");
		break;	
	default:
		ajax_http_send_error('400',$msg["ajax_commande_inconnue"]);
		break;		
endswitch;	
