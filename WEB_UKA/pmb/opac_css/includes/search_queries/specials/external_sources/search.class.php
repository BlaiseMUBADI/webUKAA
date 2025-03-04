<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: search.class.php,v 1.19 2010-08-27 07:48:10 mbertin Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $class_path,$include_path,$base_path;
require_once($class_path."/connecteurs.class.php");

//Classe de gestion de la recherche sp�cial "combine"

class external_sources {
	var $id;
	var $n_ligne;		//Num�ro de ligne du crit�re dans la multi-crit�re
	var $params;		//
	var $search;		//Classe d'origine de la recherche

	//Constructeur
    function external_sources($id,$n_ligne,$params,&$search) {
    	$this->id=$id;
    	$this->n_ligne=$n_ligne;
    	$this->params=$params;
    	$this->search=&$search;
    }
    
    //fonction de r�cup�ration des op�rateurs disponibles pour ce champ sp�cial (renvoie un tableau d'op�rateurs)
    function get_op() {
    	$operators = array();
    	$operators["EQ"]="=";
    	return $operators;
    }
    
    function get_input_box() {
    	global $msg,$charset;
    	
    	//R�cup�ration de la valeur de saisie
    	$valeur_="field_".$this->n_ligne."_s_".$this->id;
    	global $$valeur_;
    	$valeur=$$valeur_;
    	
    	if ((!$valeur)&&($_SESSION["checked_sources"])) $valeur=$_SESSION["checked_sources"];
    	if (!is_array($valeur)) $valeur=array();
    	
    	//Recherche des sources
    	$requete="SELECT connectors_categ_sources.num_categ, connectors_sources.source_id, connectors_categ.connectors_categ_name as categ_name, connectors_sources.name, connectors_sources.comment, connectors_sources.repository, connectors_sources.opac_allowed, source_sync.cancel FROM connectors_sources LEFT JOIN connectors_categ_sources ON (connectors_categ_sources.num_source = connectors_sources.source_id) LEFT JOIN connectors_categ ON (connectors_categ.connectors_categ_id = connectors_categ_sources.num_categ) LEFT JOIN source_sync ON (connectors_sources.source_id = source_sync.source_id AND connectors_sources.repository=2) WHERE connectors_sources.opac_allowed=1 ORDER BY connectors_categ_sources.num_categ DESC, connectors_sources.name";
    	$resultat=mysql_query($requete);
    	$r="<select name='field_".$this->n_ligne."_s_".$this->id."[]' multiple='yes'>";
    	$current_categ=0;
    	$count = 0;
    	while ($source=mysql_fetch_object($resultat)) {
    		if ($current_categ !== $source->num_categ) {
    			$current_categ = $source->num_categ;
    			$source->categ_name = $source->categ_name ? $source->categ_name : $msg["source_no_category"];
    			$r .= "<optgroup label='".$source->categ_name."'>";
    			$count++;
    		}
    		$r.="<option id='op_".$source->source_id."_".$count."' value='".$source->source_id."'".(array_search($source->source_id,$valeur)!==false?" selected":"").">".htmlentities($source->name.($source->comment?" : ".$source->comment:""),ENT_QUOTES,$charset)."</option>\n";
    	}
    	$r.="</select>";
    	return $r;
    }
    
   
    //fonction de conversion de la saisie en quelque chose de compatible avec l'environnement
    function transform_input() {
    }
    
    //fonction de cr�ation de la requ�te (retourne une table temporaire)
    function make_search() {	
    	global $search;
    	global $selected_sources;

    	//On modifie l'op�rateur suivant !!
    	$inter_next="inter_".($this->n_ligne+1)."_".$search[$this->n_ligne+1];
    	global $$inter_next;
    	if ($$inter_next) $$inter_next="or";

    	//R�cup�ration de la valeur de saisie
    	$valeur_="field_".$this->n_ligne."_s_".$this->id;
    	global $$valeur_;
    	$valeur=$$valeur_;
    	global $charset, $class_path,$include_path,$base_path;
    	
    	//Override le timeout du serveur mysql, pour �tre s�r que le socket dure assez longtemps pour aller jusqu'aux ajouts des r�sultats dans la base. 
		$sql = "set wait_timeout = 300";
		mysql_query($sql);
    	
    	$conn=new connecteurs();
    	
    	for ($i=0; $i<count($valeur); $i++) {
    		//Recherche de la source
    		$source=$conn->get_class_name($valeur[$i]);
    		require_once($base_path."/admin/connecteurs/in/$source/$source.class.php");
    		eval("\$src=new $source(\"".$base_path."/admin/connecteurs/in/".$source."\");");
    		$params=$src->get_source_params($valeur[$i]);
    		if ($params["REPOSITORY"]==2) {
    			$source_id=$valeur[$i];
    			$unimarc_query=$this->search->make_unimarc_query();
    			$search_id=md5(serialize($unimarc_query));

				//Suppression des vieilles notices
				//V�rification du ttl
				$ttl=$params["TTL"];
				$requete="delete from entrepot_source_$source_id where unix_timestamp(now())-unix_timestamp(date_import)>".$ttl.';';
				mysql_query($requete);

    			$requete="select count(1) from entrepot_source_$source_id where search_id='".addslashes($search_id)."'";
				$resultat=mysql_query($requete);
				$search_exists=mysql_result($resultat,0,0);
				
				$requete="select count(1) from entrepot_source_$source_id where search_id='".addslashes($search_id)."' and unix_timestamp(now())-unix_timestamp(date_import)>".$ttl;
				$resultat=mysql_query($requete);
				if ((mysql_result($resultat,0,0))||((!mysql_result($resultat,0,0))&&(!$search_exists))) {
					if (mysql_result($resultat,0,0)) {
						//Suppression des notices
						$requete="delete from entrepot_source_$source_id where search_id='".addslashes($search_id)."'";
						mysql_query($requete);
					}
					//Recherche si on a le droit
					$flag_search=true;
					$requete="select (unix_timestamp(now())-unix_timestamp(date_sync)) as sec from source_sync where source_id=$source_id";
					$res_sync=mysql_query($requete);
					if (mysql_num_rows($res_sync)) {
						$rsync=mysql_fetch_object($res_sync);
						if ($rsync->sec>300) {
							mysql_query("delete from source_sync where source_id=".$source_id);
						} else $flag_search=false;
					}
					if ($flag_search) {
						$flag_error=false;
						for ($j=0; $j<$params["RETRY"]; $j++) {
    						$src->search($valeur[$i],$unimarc_query,$search_id);
    						if (!$src->error) break; else $flag_error=true;
						}
						//Il y a eu trois essais infructueux, on d�sactive pendant 5 min !!
						if ($flag_error) {
							mysql_query("insert into source_sync (source_id,date_sync,cancel) values($source_id,now(),2)");
						}
					}
    			}
    		}
       	}
       	//Sources
       	$tvaleur=array();
       	for ($i=0; $i<count($valeur); $i++) {
       			$tvaleur[]=$valeur[$i];
       	}
       	$selected_sources=implode(",",$tvaleur);
       	
    	$t_table="t_sources_".$this->n_ligne;
    	$requete="create temporary table ".$t_table." (notice_id integer unsigned not null)";
    	mysql_query($requete);
		return $t_table; 
    }
    
    //fonction de traduction litt�rale de la requ�te effectu�e (renvoie un tableau des termes saisis)
    function make_human_query() {
    	global $msg;
    	global $include_path;
    	
    	$litteral=array();
    	
    	//R�cup�ration de la valeur de saisie 
    	$valeur_="field_".$this->n_ligne."_s_".$this->id;
    	global $$valeur_;
    	$valeur=$$valeur_;
    	
    	$requete="select name from connectors_sources where source_id in (".implode(",",$valeur).") and opac_allowed=1";
    	$resultat=mysql_query($requete);
    	while ($r=mysql_fetch_object($resultat)) {
    		$litteral[]=$r->name;
    	}	
		return $litteral;    
    }
     
    function make_unimarc_query() {
    	return array();
    }
    
	//fonction de v�rification du champ saisi ou s�lectionn�
    function is_empty($valeur) {
    	if (count($valeur)) return false; else return true;
    }
}
?>