<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_article.class.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/cms/cms_editorial.class.php");



class cms_article extends cms_editorial {
	
	public function __construct($id=0){
		//on gère les propriétés communes dans la classe parente
		parent::__construct($id,"article");

		$this->opt_elements = array(
			'contenu' => true
		);
	}
	
	protected function fetch_data(){
		global $lang;
		
		if(!$this->id)
			return false;
		
		// les infos générales...	
		$rqt = "select * from cms_articles where id_article ='".$this->id."'";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			$row = mysql_fetch_object($res);
			$this->title = $row->article_title;
			$this->resume = $row->article_resume;
			$this->contenu = $row->article_contenu;
			$this->publication_state = $row->article_publication_state;
			$this->start_date = $row->article_start_date;
			$this->end_date = $row->article_end_date;
			$this->num_parent = $row->num_section;		
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
			$clause = "where id_article = '".$this->id."'";
		}else{
			$save = "insert into ";
			$clause = "";
		}
		$save.= "cms_articles set 
		article_title = '".addslashes($this->title)."', 
		article_resume = '".addslashes($this->resume)."', 
		article_contenu = '".addslashes($this->contenu)."',
		article_publication_state ='".addslashes($this->publication_state)."', 
		article_start_date = '".addslashes($this->start_date)."', 
		article_end_date = '".addslashes($this->end_date)."', 
		num_section = '".addslashes($this->num_parent)."' 
		$clause";
		mysql_query($save);
		if(!$this->id) $this->id = mysql_insert_id();
		//au tour des descripteurs...
		//on commence par tout retirer...
		$del = "delete from cms_articles_descriptors where num_article = '".$this->id."'";
		mysql_query($del);
		for($i=0 ; $i<count($this->descriptors) ; $i++){
			$rqt = "insert into cms_articles_descriptors set num_article = '".$this->id."', num_noeud = '".$this->descriptors[$i]."',article_descriptor_order='".$i."'";
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
		$opts = "";
		$rqt = "select id_section, section_title from cms_sections where section_num_parent = '".$parent."'";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			while($row = mysql_fetch_object($res)){
				$opts.="
				<option value='".$row->id_section."'".($this->num_parent == $row->id_section ? " selected='selected'" : "").">".str_repeat("&nbsp;&nbsp;",$lvl).htmlentities($row->section_title,ENT_QUOTES,$charset)."</option>";
				$opts.=$this->_recurse_parent_select($row->id_section,$lvl+1);
			}	
		}
		return $opts;	
	}
	
	public function update_parent_section($num_section){
		$this->num_section = $num_section;
		$update = "update cms_articles set num_section ='".$num_section."' where id_article = '".$this->id."'";
		mysql_query($update);
	}
	
	protected function is_deletable(){
		return true;
	}
}