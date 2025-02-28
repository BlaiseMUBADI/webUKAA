<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_editorial_publications_states.class.php,v 1.1 2011-09-14 08:44:12 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class cms_editorial_publications_states {
	public $publications_states;	//tableau des statuts de publication
	
	public function __construct(){
		$this->publications_states = array();
	}

	protected function fetch_data(){
		$rqt = "select * from cms_editorial_publications_states";
		$res = mysql_query($rqt);
		if(mysql_num_rows($res)){
			while($row = mysql_fetch_object($res)){
				$this->publications_states[] =array(
					'id' => $row->id_editorial_publication_state,
					'label' => $row->editorial_publication_state_label,
					'opac_show' => $row->editorial_publication_opac_show,
					'auth_opac_show' => $row->editorial_publication_auth_opac_show
				);
			}
		}
	}

	public function get_publications_states(){
		if(!$this->publications_states) {
			$this->fetch_data();
		}
		return $this->publications_states;
	}

	public function get_selector_options($selected=0){
		global $charset;
		$options = "";
		$this->get_publications_states();
		for($i=0 ; $i<count($this->publications_states) ; $i++){
			$options.= "
			<option value='".$this->publications_states[$i]['id']."'".($this->publications_states[$i]['id']==$selected ? "selected='selected'" : "").">".htmlentities($this->publications_states[$i]['label'],ENT_QUOTES,$charset)."</option>";	
		}
		return $options;
	}
}