<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms.tpl.php,v 1.3 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], "tpl.php")) die("no access");

$cms_build_menu_tpl = "
	<h1>".$msg["cms_menu_build_block"]." <span>> !!menu_sous_rub!!</span></h1>
	<div class='hmenu'>
		<span".ongletSelect("categ=build&sub=block").">
			<a title='".$msg["search_persopac_list_title"]."' href='./cms.php?categ=build&sub=block&action='>
				".$msg["cms_menu_build_page_layout"]."
			</a>
		</span>
	
	</div>
";



$cms_editorial_menu_tpl = "
	<h1>".$msg["cms_menu_editorial"]." <span>!!menu_sous_rub!!</span></h1>
	<div class='hmenu'>
	</div>
";
$cms_section_menu_tpl = "
	<h1>".$msg["cms_menu_editorial_section"]." <span>!!menu_sous_rub!!</span></h1>
	<div class='hmenu'>
	</div>
";

$cms_article_menu_tpl = "
	<h1>".$msg["cms_menu_editorial_article"]." <span>!!menu_sous_rub!!</span></h1>
	<div class='hmenu'>
	</div>
";