<?php
// +-------------------------------------------------+
// © 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: ajax_main.inc.php,v 1.2 2011-09-28 14:26:22 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once($class_path."/cms/cms_editorial_tree.class.php");
require_once($class_path."/cms/cms_articles.class.php");
require_once($class_path."/cms/cms_section.class.php");
require_once($class_path."/cms/cms_article.class.php");
require_once($class_path."/cms/cms_logo.class.php");
require_once($class_path."/cms/cms_build.class.php");

switch($categ){
	case 'list_sections' :
	//	header('Content-type: application/json;charset=utf-8');
		$sections = new cms_editorial_tree();
		print $sections->get_json_list();
		break;
	case 'update_section' :
		header('Content-type: text/html;charset=iso-8859-1');
		$sections = new cms_editorial_tree();
		$result = $sections->update_children($new_children,$num_parent);
		print $result;
		break;
	case "get_tree" :
		header('Content-type: text/html;charset=iso-8859-1');
		print cms_editorial_tree::get_tree();
		break;
	case "get_infos" :
		header('Content-type: text/html;charset=iso-8859-1');
		switch($type){
			case "section" :
				$section = new cms_section($id);
				print $section->get_ajax_form("cms_section_edit","cms_section_edit");
				break;
			case "article" :
				$article = new cms_article($id);
				print $article->get_ajax_form("cms_article_edit","cms_article_edit");
				break;
			case "list_articles" :
				$articles = new cms_articles($id);
				print $articles->get_tab();
				break;
		}
		break;
	case "save_section" :
		//header('Content-type: text/html;charset=iso-8859-1');
		$section = new cms_section();
		$section->get_from_form();
		$section->save();
		break;
	case "save_article" :
		//header('Content-type: text/html;charset=iso-8859-1');
		$article = new cms_article();
		$article->get_from_form();
		$article->save();
		break;
	case "delete_section" :
		$section = new cms_section($id);
		$res = $section->delete();
		if($res!==true){
			$result =array(
				"status" => "ko",
				"error_message" => ($charset != "uft-8" ? utf8_encode($res) : $res)
			);
		}else{
			$result = array(
				'status' => "ok"
			);
		}
		print json_encode($result);
		break;
	case "delete_article" :
		$article = new cms_article($id);
		$res = $article->delete();
		if($res!==true){
			$result =array(
				"status" => "ko",
				"error_message" => ($charset != "uft-8" ? utf8_encode($res) : $res)
			);
		}else{
			$result = array(
				'status' => "ok"
			);
		}
		print json_encode($result);
		break;
	case "edit_logo" :
		$logo = new cms_logo($id,$quoi);
		print $logo->get_field();
		break;
	case 'update_article' :
		header('Content-type: text/html;charset=iso-8859-1');
		$articles = explode(",",$articles);
		foreach($articles as $id_article){
			$article = new cms_article($id_article);
			$article->update_parent_section($num_section);	
		}
		break;
	case "build" :
		switch($action){
			case "save":			
				$cms_build=new cms_build();
				$cms_build->save_opac(unserialize(stripslashes($cms_build_info)),unserialize(stripslashes($cms_data)));			
			break;
		}		
		break;
}