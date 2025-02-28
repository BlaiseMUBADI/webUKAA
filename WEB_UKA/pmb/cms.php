<?php
// +-------------------------------------------------+
// © 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms.php,v 1.5 2011-09-28 14:40:47 arenou Exp $


// définition du minimum nécessaire 
$base_path=".";                            
$base_auth = "CMS_AUTH";  
$base_title = "\$msg[cms_onglet_title]";  

require_once ("$base_path/includes/init.inc.php");  
require_once($include_path."/templates/cms.tpl.php");

print " <script type='text/javascript' src='javascript/ajax.js'></script>";
print "<div id='att' style='z-Index:1000'></div>";
print $menu_bar;
print $extra;
print $extra_info;



if($use_shortcuts) {
	include("$include_path/shortcuts/circ.sht");
}
echo window_title($database_window_title.$msg['cms_onglet_title'].$msg[1003].$msg[1001]);

switch($categ){
	case "build" :
		$cms_layout = str_replace("!!menu_contextuel!!",$cms_build_menu_tpl,$cms_layout);
	break;
	case "editorial" :
		$cms_layout = str_replace("!!menu_contextuel!!",$cms_editorial_menu_tpl,$cms_layout);	
	break;
	case "section" :
		$cms_layout = str_replace("!!menu_contextuel!!",$cms_section_menu_tpl,$cms_layout);	
	break;
	case "article" :
		$cms_layout = str_replace("!!menu_contextuel!!",$cms_article_menu_tpl,$cms_layout);	
	break;
}
require_once("./cms/cms.inc.php");	

// pied de page
print $footer;

// deconnection MYSql
mysql_close($dbh);