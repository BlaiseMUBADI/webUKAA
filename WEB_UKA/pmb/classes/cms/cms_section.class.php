<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_section.class.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/cms/cms_editorial.class.php");

class cms_section extends cms_editorial {
	public $num_parent;		// id du parent
	function __construct($id=0){
		//on gère les propriétés communes dans la classe parente
		parent::__construct($id,"section");

		if($this->id == 0){
			$this->num_parent = 0;
		}
		$this->opt_elements =array(
			'contenu' => false,
		);
	}

	protected function fetch_data(){
		$rqt = "select section_title,section_resume,section_publication_state,section_start_date,section_end_date,section_num_parent from cms_sections where id_section ='".$this->id."'";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			$row = mysql_fetch_object($res);
			$this->title = $row->section_title;
			$this->resume = $row->section_resume;
			$this->publication_state = $row->section_publication_state;
			$this->start_date = $row->section_start_date;
			$this->end_date = $row->section_end_date;
			$this->num_parent = $row->section_num_parent;		
		}
		if(strpos($this->start_date,"0000-00-00")!== false){
			$this->start_date = "";
		}
		if(strpos($this->end_date,"0000-00-00")!== false){
			$this->end_date = "";
		}
		
		$this->get_descriptors();
	}
	
	public function save(){
		if($this->id){
			$save = "update ";
			$clause = "where id_section = '".$this->id."'";
		}else{
			$save = "insert into ";
			$clause = "";
		}
		$save.= "cms_sections set 
		section_title = '".addslashes($this->title)."', 
		section_resume = '".addslashes($this->resume)."', 
		section_publication_state ='".addslashes($this->publication_state)."', 
		section_start_date = '".addslashes($this->start_date)."', 
		section_end_date = '".addslashes($this->end_date)."', 
		section_num_parent = '".addslashes($this->num_parent)."' 
		$clause";
		mysql_query($save);
		if(!$this->id) $this->id = mysql_insert_id();
		
		//au tour des descripteurs...
		//on commence par tout retirer...
		$del = "delete from cms_sections_descriptors where num_section = '".$this->id."'";
		mysql_query($del);
		for($i=0 ; $i<count($this->descriptors) ; $i++){
			$rqt = "insert into cms_sections_descriptors set num_section = '".$this->id."', num_noeud = '".$this->descriptors[$i]."',section_descriptor_order='".$i."'";
			mysql_query($rqt);
		}
		
		//et maintenant le logo...
		$this->save_logo();
		
	}
	
	public function get_parent_selector(){
		$opts.=$this->_recurse_parent_select();
		return $opts;
	}
	
	protected function _recurse_parent_select($parent=0,$lvl=0){
		global $charset;
		global $msg;
		if($lvl==0){
			$opts = "
			<option value='0' >".htmlentities($msg['cms_editorial_form_parent_default_value'],ENT_QUOTES,$charset)."</option>";
		}else{
			$opts = "";
		}
		$rqt = "select id_section, section_title from cms_sections where section_num_parent = '".$parent."'";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			while($row = mysql_fetch_object($res)){
				if($this->id != $row->id_section){
					$opts.="
				<option value='".$row->id_section."'".($this->num_parent == $row->id_section ? " selected='selected'" : "").">".str_repeat("&nbsp;&nbsp;",$lvl).htmlentities($row->section_title,ENT_QUOTES,$charset)."</option>";
					$opts.=$this->_recurse_parent_select($row->id_section,$lvl+1);
				}
			}	
		}
		return $opts;	
	}	

	public function is_deletable(){
		global $msg;
		//on commence par regarder si la rubrique à des articles...
		$check_article = "select count(id_article) from cms_articles where num_section ='".$this->id."'";
		$res = mysql_query($check_article);
		if(mysql_num_rows($res)>0){
			$nb_articles = mysql_result($res,0,0);
			if($nb_articles>0){
				return $msg['cms_section_cant_delete_with_articles'];
			};
		}
		//on est encore la donc pas d'articles, on regarde les rubriques filles...
		$check_children = "select count(id_section) from cms_sections where section_num_parent ='".$this->id."'";
		$res = mysql_query($check_children);
		if(mysql_num_rows($res)){
			$nb_children = mysql_result($res,0,0);
			if($nb_children>0){
				return $msg['cms_section_has_children'];
			}
		}
		return true;
	}
}

//class cms_section extends cms_editorial {
//	public $num_parent;		//identifiant de la rubrique parente
//	

//

//	
//	public function get_form($name="cms_form_section",$id="cms_form_section",$attr="",$close=true){
//		global $base_path;
//		global $cms_section_form_tpl;
//		global $cms_editorial_first_desc,$cms_editorial_other_desc;
//		global $msg;
//		global $lang;
//			
//		$form = str_replace("!!cms_section_form_name!!",$name,$cms_section_form_tpl);
//		$form = str_replace("!!cms_section_form_id!!",$this->id,$form);
//		$form = str_replace("!!cms_section_form_attr!!",$attr,$form);
//		
//		$form = str_replace("!!cms_section_form_parent_options!!",$this->get_parent_select(),$form);
//		
//		$form = str_replace("!!cms_section_form_id!!",$this->id,$form);
//		
//		$form = str_replace("!!cms_section_form_title!!",$this->title,$form);
//		$form = str_replace("!!cms_section_form_resume!!",$this->resume,$form);
//		
//		//logo
//		$logo = new cms_logo($this->id,"section");
//		$form = str_replace("!!cms_section_form_logo!!",$logo->get_form(),$form);
//		
//		//categ
//		$categs = "";
//		if(count($this->descriptors)){
//			for ($i=0 ; $i<count($this->descriptors) ; $i++){
//				if($i==0) $categ=$cms_editorial_first_desc;
//				else $categ = $cms_editorial_other_desc;
//				//on y va
//				$categ = str_replace('!!icateg!!', $i, $categ);
//				$categ = str_replace('!!categ_id!!', $this->descriptors[$i], $categ);
//				$categorie = new categories($this->descriptors[$i],$lang);
//				$categ = str_replace('!!categ_libelle!!', $categorie->libelle_categorie, $categ);			
//				$categs.=$categ;
//			}
//			$categs = str_replace("!!max_categ!!",count($this->descriptors),$categs);
//		}else{
//			$categs=$cms_editorial_first_desc;
//			$categs = str_replace('!!icateg!!', 0, $categs) ;
//			$categs = str_replace('!!categ_id!!', "", $categs);
//			$categs = str_replace('!!categ_libelle!!', "", $categs);
//			$categs = str_replace('!!max_categ!!', 1, $categs);
//		}		
//		$form = str_replace("!!cms_categs!!",$categs,$form);
//
//		$day = date("Ymd");
//		$form = str_replace("!!day!!",$day,$form);
//		
//		$start_date = formatDate($this->start_date);
//		if(!$start_date) $start_date = $msg['no_date'];
//		$form = str_replace("!!cms_section_form_start_date_value!!",$this->start_date,$form);
//		$form = str_replace("!!cms_section_form_start_date!!",$start_date,$form);
//		
//		$end_date = formatDate($this->end_date);
//		if(!$end_date) $end_date = $msg['no_date'];
//		$form = str_replace("!!cms_section_form_end_date_value!!",$this->end_date,$form);
//		$form = str_replace("!!cms_section_form_end_date!!",$end_date,$form);
//
//		if($close){
//			$form = str_replace("!!cms_section_suite!!","",$form);
//		}
//		return $form; 
//	}
//	
//	public function get_from_form(){
//		global $cms_section_form_id;
//		global $cms_section_form_parent;
//		global $cms_section_form_title;
//		global $cms_section_form_resume;
//		global $max_categ;
//		global $cms_section_form_start_date_value;
//		global $cms_section_form_end_date_value;
//
//		for ($i=0 ; $i<$max_categ ; $i++){
//			$categ_id = 'f_categ_id'.$i;
//			global $$categ_id;
//			if($$categ_id > 0){
//				$this->descriptors[] = $$categ_id;
//			}
//		}
//		$this->id = $cms_section_form_id;
//		$this->num_parent = stripslashes($cms_section_form_parent);
//		$this->title = stripslashes($cms_section_form_title);
//		$this->resume = stripslashes($cms_section_form_resume);
//		$this->start_date = stripslashes($cms_section_form_start_date_value);
//		$this->end_date = stripslashes($cms_section_form_end_date_value);
//	}
//	public function get_ajax_form($name="cms_form_section",$id="cms_form_section"){
//		$form = $this->get_form($name,$id,"onsubmit='cms_ajax_submit();return false;'",false);
//		$suite ="
//		<script>
//			function cms_ajax_submit(){
//				var values = '';
//				for(var i=0 ; i<document.forms['$name'].elements.length ; i++){
//					var element = document.forms['$name'].elements[i];
//					if(element.name){
//						values+='&'+element.name+'='+element.value;
//					}
//				}
//				var post = new http_request();
//				post.request('./ajax.php?module=ajax&categ=cms&action=save_section',true,values,true,cms_section_saved);
//			}
//			
//			function cms_section_saved(response){
//				dijit.byId('editorial_tree_container').refresh();
//				dijit.byId('content_infos').refresh();
//			}
//		</script>";
//		$form = str_replace("!!cms_section_suite!!",$suite,$form);
//		return $form;		
//	}
//	
//	public function is_deletable(){
//		//on commence par regarder si la rubrique à des articles...
//		$check_article = "select count(id_article) from cms_articles where num_section ='".$this->id."'";
//		$res = mysql_query($check_article);
//		if(mysql_num_rows($res)>0){
//			$nb_articles = mysql_result($res,0,0);
//			if($nb_articles>0){
//				return false;
//			};
//		}
//		//on est encore la donc pas d'articles, on regarde les rubriques filles...
//		$check_children = "select count(id_section) from cms_sections where section_num_parent ='".$this->id."'";
//		$res = mysql_query($check_children);
//		if(mysql_num_rows($res)){
//			$nb_children = mysql_result($res,0,0);
//			if($nb_children>0){
//				return false;
//			}
//		}
//		return true;
//	}
//	
//	public function delete(){
//		return parent::delete("section");
//	}
//}