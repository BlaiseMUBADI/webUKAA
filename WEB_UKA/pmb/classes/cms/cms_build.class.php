<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_build.class.php,v 1.2 2011-09-28 14:26:23 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once ("$include_path/cms/cms.inc.php");
require_once ("$include_path/templates/cms/cms_build.tpl.php");  

class cms_build{
	
	var $data = "";
	var $dom;
	//Constructeur	 
	function cms_build(){
		global $include_path;
		$this->dom = new DomDocument;

		$this->dom->load("$include_path/cms/cms_build/cms_build_id.xml") ;
		$cms_objects=$this->dom->getElementsByTagName('cms_object');
		$this->contener_list=array();
		$this->cadre_list=array();
		$this->objet_list=array();
		foreach ($cms_objects as $cms_object){    		
    		if($cms_object->getAttribute('container')=='yes'&& $cms_object->getAttribute('receptable')=='yes'){
    			$this->contener_list[]=$cms_object->getAttribute('id');    			
    		}elseif($cms_object->getAttribute('draggable')=='yes' && $cms_object->getAttribute('receptable')=='yes'){
    			// un cadre
    			$this->cadre_list[]=$cms_object->getAttribute('id');    			
    		}elseif($cms_object->getAttribute('draggable')=='yes'){ 
    			// un objet déplacable dans un cadre ou le contener
    			$this->objet_list[]=$cms_object->getAttribute('id');
    		}	    		
		}
	}
	
	function get_form_block(){
		global $cms_build_block_tpl;
		
		$tpl=$cms_build_block_tpl;
		$javascript="";
		if(count($this->contener_list))$javascript.="var cms_contener_list=new Array('".implode("','",$this->contener_list)."');";
		if(count($this->cadre_list))$javascript.="var cms_cadre_list=new Array('".implode("','",$this->cadre_list)."');";
		if(count($this->objet_list))$javascript.="var cms_objet_list=new Array('".implode("','",$this->objet_list)."');";
		$tpl=str_replace("!!cms_objet_list_declaration!!",$javascript,$tpl);
		
		return $tpl;
	}
		
	function save_opac($build_info,$data){		
		$data_merge= array();		
		//merge des css et du placement	
		foreach($data['cms_nodes'] as $node_name => $placement){			
			$data_merge[$node_name]['parent']=$placement['parent'];			
			$data_merge[$node_name]['child_after']=$placement['child_after'];		
		}		
		foreach($data['cms_css'] as $node_name => $placement){			
			$data_merge[$node_name]['style']=$placement['style'];			
		}		
		foreach($data_merge as $node_name => $placement){
			if($node_name){				
				$rqt = "delete from cms_build where build_obj='$node_name' ";			
				mysql_query($rqt);				
				$rqt_insert = "INSERT INTO cms_build SET 
					build_obj='$node_name', 
					build_parent='".$placement['parent']."' , 
					build_child_after='".$placement['child_after']."', 
					build_css='".$placement['style']."' ";	
				mysql_query($rqt_insert);
			}	
		}		
	}
}