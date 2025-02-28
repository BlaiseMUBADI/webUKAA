<?php
// +-------------------------------------------------+
// © 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_article_edit.inc.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($class_path."/cms/cms_article.class.php");

if($id != "new"){
	$article = new cms_article($id);
}else{
	$article = new cms_article();
}

print $article->get_form("cms_article_edit","cms_article_edit", $base_path."/cms.php?categ=articles&sub=save");