<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms.inc.php,v 1.3 2011-09-14 08:44:14 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once ("$include_path/cms/cms.inc.php");
require_once($class_path."/cms/cms_editorial.class.php");

switch($categ) {			
	case 'build':
		require_once("./cms/cms_build/cms_build.inc.php");		
	break;
	case 'section':
		require_once("./cms/cms_sections/cms_section.inc.php");		
	break;
	case 'editorial':
		$cms_layout = str_replace("!!menu_contextuel!!","",$cms_layout);
		require_once("./cms/cms_editorial/cms_editorial.inc.php");		
	break;
	case 'article':
		$cms_layout = str_replace("!!menu_contextuel!!","",$cms_layout);
		require_once("./cms/cms_articles/cms_articles.inc.php");		
	break;
	default:
		$cms_layout = str_replace("!!menu_contextuel!!","",$cms_layout);
		print $cms_layout;
	break;
}		

print $cms_layout_end;