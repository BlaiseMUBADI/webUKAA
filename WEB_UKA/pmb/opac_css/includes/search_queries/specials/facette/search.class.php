<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: search.class.php,v 1.2.2.1 2012-02-17 13:32:14 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($include_path."/rec_history.inc.php");

//Classe de gestion de la recherche spécial "facette"

class facette_search {
	var $id;
	var $n_ligne;
	var $params;
	var $search;

	//Constructeur
    function facette_search($id,$n_ligne,$params,&$search) {
    	$this->id=$id;
    	$this->n_ligne=$n_ligne;
    	$this->params=$params;
    	$this->search=&$search;
    }
    
	function get_op() {
    	$operators = array();
    	if ($_SESSION["nb_queries"]!=0) {
    		$operators["EQ"]="=";
    	}
    	return $operators;
    }
    
    function make_search(){
    	$valeur = "field_".$this->n_ligne."_s_".$this->id;
    	global $$valeur;
    	$filter_array = $$valeur;
    	$filter_value = $filter_array[0];
    	$filter_field = $filter_array[1];
    	$filter_subfield = $filter_array[2];
    	
    	$table_name = "table_facette_temp".$this->n_ligne;
  		$req_table_tempo = "CREATE TEMPORARY TABLE ".$table_name." (notice_id int, index i_notice_id(notice_id)) 
  												SELECT distinct id_notice as notice_id FROM notices_fields_global_index 
  														WHERE code_champ = ".($filter_field+0)." 
  														AND code_ss_champ = ".($filter_subfield+0)." 
  														AND value ='".$filter_value."'";
    	$req = mysql_query($req_table_tempo) or die (mysql_error());
    	if(!$req) print mysql_error();
  		 	
    	return $table_name;
    }
    
    function make_human_query(){
    	global $include_path,$msg;
		global $dbh, $champ_base,$charset;
		$literral_words = array();
		
		if(!count($champ_base)) {
			$file = $include_path."/indexation/notices/champs_base_subst.xml";
			if(!file_exists($file)){
				$file = $include_path."/indexation/notices/champs_base.xml";
			}
			$fp=fopen($file,"r");
	    	if ($fp) {
				$xml=fread($fp,filesize($file));
			}
			fclose($fp);
			$champ_base=_parser_text_no_function_($xml,"INDEXATION");
		}
    	
    	$field="field_".$this->n_ligne."_s_3";
    	global $$field;
    	$field = $$field;
    	$filter_field = $field[1];
    	$filter_subfield = $field[2];
    	$filter_value = $field[0];
    	
    	if($filter_field!=100){
	    	for($i=0;$i<count($champ_base['FIELD']);$i++){
	    		if($champ_base['FIELD'][$i]['ID']==$filter_field){
					break;
				} 
	    	}
	    	$literral_words[] = $msg[$champ_base['FIELD'][$i]['NAME']]."  : '".stripslashes($filter_value)."'";
    	}else{
    		$req= mysql_query("select titre from notices_custom where idchamp = '".($filter_subfield+0)."' limit 1");
			$rslt=mysql_fetch_object($req);
			$literral_words[] = $rslt->titre."  : '".stripslashes($filter_value)."'";
    	} 
    	return $literral_words;
    }
    
}
?>