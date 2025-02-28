<?php
// +-------------------------------------------------+
// © 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_section_save.inc.php,v 1.1 2011-09-14 08:44:13 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($class_path."/cms/cms_section.class.php");

$section = new cms_section();
$section->get_from_form();
$section->save();

print "<a href='./cms.php?categ=editorial&sub=list'>".$msg['cms_editorial_go_list']."</a>";
