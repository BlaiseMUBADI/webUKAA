<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: ajax_main.inc.php,v 1.4 2011-10-26 09:31:34 fgautier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

//En fonction de $categ, il inclut les fichiers correspondants

switch($categ):
	case 'acces':
		include('./admin/acces/ajax/acces.inc.php');
		break;
	case 'req':
		include('./admin/proc/ajax/req.inc.php');
		break;
	case 'sync':
		include('./admin/connecteurs/in/dosync.php');
		break;
	case 'opac':
		include('./admin/opac/ajax_main.inc.php');
	break;
	default:
		break;		
endswitch;	
