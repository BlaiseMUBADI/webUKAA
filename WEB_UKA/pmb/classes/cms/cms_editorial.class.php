<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_editorial.class.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/cms/cms_root.class.php");
require_once($class_path."/cms/cms_logo.class.php");
require_once($class_path."/cms/cms_editorial_publications_states.class.php");

require_once($class_path."/categories.class.php");
require_once($include_path."/templates/cms/cms_editorial.tpl.php");

class cms_editorial extends cms_root {
	public $id;						// identifiant du contenu
	public $num_parent;				// id du parent
	public $title;					// le titre du contenu
	public $resume;					// résumé du contenu
	public $logo;					// objet gérant le logo
	public $publication_state;		// statut de publication	
	public $start_date;				// date de début de publication
	public $end_date;				// date de fin de publication
	public $descriptors = array();	// descripteurs
	protected $type;				// le type de l'objet
	protected $opt_elements;			// les éléments optionnels constituants l'objet
	
	public function __construct($id=2,$type="section"){
		$this->type = $type;
		if($id){
			$this->id = $id;
			$this->fetch_data();
			$this->logo = new cms_logo($this->id,$this->type);
		}else{
			$this->id = 0;
			$this->title = "";
			$this->resume = "";
			$this->logo = new cms_logo(0,$this->type);
			$this->publication_state = "";
			$this->start_date = "";
			$this->end_date = "";
			$this->num_parent = 0;
			$this->descriptors = array();
		}
	}
	
	protected function get_descriptors(){
		// les descripteurs...
		$rqt = "select num_noeud from cms_".$this->type."s_descriptors where num_".$this->type." = '".$this->id."' order by ".$this->type."_descriptor_order";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			while($row = mysql_fetch_object($res)){
				$categ = new categories($row->num_noeud, $lang);
				$this->descriptors[] = $categ->num_noeud;
			}
		}
	}
	
	public function delete(){
		$result = $this->is_deletable();
		if($result === true){
			$del = "delete from cms_".$this->type."s where id_".$this->type."='".$this->id."'";
			mysql_query($del);
			$del_desc = "delete from cms_".$this->type."_descriptors where num_".$this->type." = '".$this->id."'";
			mysql_query($del_desc);
			return true;
		}else{
			return $result;
		}
	}
		
	public function get_form($name="cms_form_editorial",$id="cms_form_editorial",$attr="",$close=true){
		//on récupère le template
		global $cms_editorial_form_tpl;
		global $cms_editorial_form_del_button_tpl;
		global $msg;
		global $lang;
		
		$fields_form="";
		$fields_form.=$this->get_parent_field();
		$fields_form.=$this->get_title_field();
		$fields_form.=$this->get_resume_field();
		$fields_form.=$this->get_contenu_field();
		$fields_form.=$this->get_logo_field();
		$fields_form.=$this->get_desc_field();
		$fields_form.=$this->get_publication_state_field();
		$fields_form.=$this->get_dates_field();
		
		
		$form = str_replace("!!fields!!",$fields_form,$cms_editorial_form_tpl);
		
		if($this->id){
			$del_button = $cms_editorial_form_del_button_tpl;
		}else{
			$del_button = "";
		}
		$form = str_replace("!!cms_editorial_form_suppr!!",$del_button,$form);
		
		$form = str_replace("!!type!!",$this->type,$form);
		$form = str_replace("!!cms_editorial_form_name!!",$name,$form);
		$form = str_replace("!!cms_editorial_form_id!!",$id,$form);
		$form = str_replace("!!cms_editorial_form_obj_id!!",$this->id,$form);
		
		if(!$this->id){
			$attr = "enctype='multipart/form-data' ".$attr;
		}
		$form = str_replace("!!cms_editorial_form_attr!!",$attr,$form);

		$form = str_replace("!!form_title!!",$msg['cms_'.($this->id ? "" : "new_").$this->type."_form_title"],$form);

		if($close){
			$form = str_replace("!!cms_editorial_suite!!","",$form);
		}		
		return $form;
	}
	
	public function get_ajax_form($name="cms_form_editable",$id="cms_form_editable"){
		global $msg;
		
		$form = $this->get_form($name,$id,"onsubmit='cms_ajax_submit();return false;'",false);
		$suite ="
		<script>
			function cms_ajax_submit(){
				var values = '';
				if(document.forms['$name'].cms_editorial_form_delete.value == 1){
					if(confirm(\"".$msg['cms_editorial_form_'.$this->type.'_delete_confirm']."\")){
						cms_".$this->type."_delete();
					}
				}else{
					for(var i=0 ; i<document.forms['$name'].elements.length ; i++){
						var element = document.forms['$name'].elements[i];
						if(element.name){
							values+='&'+element.name+'='+element.value;
						}
					}
					var post = new http_request();
					post.request('./ajax.php?module=ajax&categ=cms&action=save_".$this->type."',true,values,true,cms_".$this->type."_saved);
				}
			}
			
			function cms_".$this->type."_delete(){
				var post = new http_request();
				post.request('./ajax.php?module=ajax&categ=cms&action=delete_".$this->type."',true,'&id='+document.forms['$name'].cms_editorial_form_obj_id.value,true,cms_".$this->type."_deleted);
			}

			function cms_".$this->type."_deleted(response){
				var result = eval('('+response+')');
				if(result.status == 'ok'){
					dijit.byId('editorial_tree_container').refresh();
					dijit.byId('content_infos').destroyDescendants();			
				}else{
					alert(result.error_message);
				}
			}

			function cms_".$this->type."_saved(response){
				dijit.byId('editorial_tree_container').refresh();
				dijit.byId('content_infos').refresh();
			}
		</script>";
		$form = str_replace("!!cms_editorial_suite!!",$suite,$form);
		return $form;		
	}
	
	public function get_parent_selector(){
		//à surcharger...
	}
	
	protected function get_parent_field(){
		global $msg;
		global $cms_editorial_parent_field;
		return str_replace("!!cms_editorial_form_parent_options!!",$this->get_parent_selector(),$cms_editorial_parent_field);
	}
	
	protected function get_title_field(){
		global $cms_editorial_title_field;
		return str_replace("!!cms_editorial_form_title!!",$this->title,$cms_editorial_title_field);
	}
	
	protected function get_resume_field(){
		global $cms_editorial_resume_field;
		return str_replace("!!cms_editorial_form_resume!!",$this->resume,$cms_editorial_resume_field);
	}
	
	protected function get_contenu_field(){
		global $cms_editorial_contenu_field;
		if($this->opt_elements['contenu']==true){
			return str_replace("!!cms_editorial_form_contenu!!",$this->contenu,$cms_editorial_contenu_field);	
		}else{
			return "";		
		}
	}
	
	protected function get_logo_field(){
		return $this->logo->get_form();
	}
	
	protected function get_desc_field(){
		global $lang;
		global $cms_editorial_desc_field;
		global $cms_editorial_first_desc,$cms_editorial_other_desc;
		
		$categs = "";
		if(count($this->descriptors)){
			for ($i=0 ; $i<count($this->descriptors) ; $i++){
				if($i==0) $categ=$cms_editorial_first_desc;
				else $categ = $cms_editorial_other_desc;
				//on y va
				$categ = str_replace('!!icateg!!', $i, $categ);
				$categ = str_replace('!!categ_id!!', $this->descriptors[$i], $categ);
				$categorie = new categories($this->descriptors[$i],$lang);
				$categ = str_replace('!!categ_libelle!!', $categorie->libelle_categorie, $categ);			
				$categs.=$categ;
			}
			$categs = str_replace("!!max_categ!!",count($this->descriptors),$categs);
		}else{
			$categs=$cms_editorial_first_desc;
			$categs = str_replace('!!icateg!!', 0, $categs) ;
			$categs = str_replace('!!categ_id!!', "", $categs);
			$categs = str_replace('!!categ_libelle!!', "", $categs);
			$categs = str_replace('!!max_categ!!', 1, $categs);
		}		
		return str_replace("!!cms_categs!!",$categs,$cms_editorial_desc_field);
	}
	
	protected function get_publication_state_field(){
		global $cms_editorial_publication_state_field;
		$publications_states = new cms_editorial_publications_states();
		return str_replace("!!cms_editorial_form_publications_states_options!!",$publications_states->get_selector_options($this->publication_state),$cms_editorial_publication_state_field);
	}
	
	protected function get_dates_field(){
		global $cms_editorial_dates_field;
		global $msg;
		$day = date("Ymd");
		$form = str_replace("!!day!!",$day,$cms_editorial_dates_field);
		
		$start_date = formatDate($this->start_date);
		if(!$start_date) $start_date = $msg['no_date'];
		$form = str_replace("!!cms_editorial_form_start_date_value!!",$this->start_date,$form);
		$form = str_replace("!!cms_editorial_form_start_date!!",$start_date,$form);
		
		$end_date = formatDate($this->end_date);
		if(!$end_date) $end_date = $msg['no_date'];
		$form = str_replace("!!cms_editorial_form_end_date_value!!",$this->end_date,$form);
		$form = str_replace("!!cms_editorial_form_end_date!!",$end_date,$form);
		return $form;
	}
	
	public function get_from_form(){
		global $cms_editorial_form_obj_id;
		global $cms_editorial_form_parent;
		global $cms_editorial_form_title;
		global $cms_editorial_form_resume;
		global $cms_editorial_form_contenu;
		global $max_categ;
		global $cms_editorial_form_publication_state;
		global $cms_editorial_form_start_date_value;
		global $cms_editorial_form_end_date_value;

		for ($i=0 ; $i<$max_categ ; $i++){
			$categ_id = 'f_categ_id'.$i;
			global $$categ_id;
			if($$categ_id > 0){
				$this->descriptors[] = $$categ_id;
			}
		}
		$this->id = $cms_editorial_form_obj_id;
		$this->num_parent = stripslashes($cms_editorial_form_parent);
		$this->title = stripslashes($cms_editorial_form_title);
		$this->resume = stripslashes($cms_editorial_form_resume);
		$this->start_date = stripslashes($cms_editorial_form_start_date_value);
		$this->end_date = stripslashes($cms_editorial_form_end_date_value);
		print stripslashes($cms_editorial_form_publication_state);
		$this->publication_state = stripslashes($cms_editorial_form_publication_state);
		if($this->opt_elements['contenu']) {
			$this->contenu = stripslashes($cms_editorial_form_contenu);
		}
		$this->logo->id = $this->id;
	}

	protected function save_logo(){
		//on agit que si un fichier a été soumis...
		if(count($_FILES)){
			$this->logo->id = $this->id;
			$this->logo->save();	
		}
	}
}