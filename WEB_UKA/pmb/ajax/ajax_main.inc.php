<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: ajax_main.inc.php,v 1.8.2.1 2012-02-15 15:14:30 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

//En fonction de $categ, il inclut les fichiers correspondants

switch($categ):
	case 'misc':
		include('./ajax/misc/misc.inc.php');
	break;
	case 'alert':
		include('./ajax/misc/alert.inc.php');
	break;
	case 'menuhide':
		include('./ajax/misc/menuhide.inc.php');
	break;
	case 'tri':
		include('./ajax/misc/tri.inc.php');
	break;
	case 'chklnk':
		include('./ajax/misc/chklnk.inc.php');
	break;
	case 'isbn':
		include('./ajax/misc/isbn.inc.php');
	break;
	case 'planificateur':
		include('./ajax/misc/planificateur.inc.php');
	break;
	case 'expand':
		include('./ajax/misc/expand_ajax.inc.php');
	break;
	case 'expand_block':
		include('./ajax/misc/expand_block_ajax.inc.php');
	break;
	default:
	break;
endswitch;