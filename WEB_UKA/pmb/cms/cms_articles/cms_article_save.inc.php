<?php
// +-------------------------------------------------+
// © 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_article_save.inc.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($class_path."/cms/cms_article.class.php");

$article = new cms_article();
$article->get_from_form();
$article->save();
print "<a href='./cms.php?categ=editorial&sub=list'>".$msg['cms_editorial_go_list']."</a>";