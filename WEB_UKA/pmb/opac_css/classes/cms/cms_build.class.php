<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_build.class.php,v 1.1 2011-09-29 08:16:15 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");


class cms_build{	
	var $dom;
	//Constructeur	 
	function cms_build(){

	}	
	
	function transform_html($html){
		$this->dom = new DomDocument;
		
		if(!$this->dom->loadHTML($html)) return $html ;
		
		$rqt = "select * from cms_build  order by id_build ";			
		$res = mysql_query($rqt);
		while($transform = mysql_fetch_object($res)){
			$this->change_object($transform->build_obj,$transform->build_parent,$transform->build_child_after,$transform->build_css);			
		}
		return($this->dom->saveHTML());	
	}
	
	function change_object($node_name,$build_parent,$build_child_after,$build_css){
		
		if($id=$this->dom->getElementById($node_name)){
			//l'objet est bien présent dans la page
			if($build_css){
				$id->setAttribute("style",$build_css);
			}			
			if($build_parent){				
				if(($parent=$this->dom->getElementById($build_parent))){				
						$id=$id->parentNode->removeChild($id);							
						$parent->appendChild($id);	

				}	
			}		
		}
	}	


// class end
}