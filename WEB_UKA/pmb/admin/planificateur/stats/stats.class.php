<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: stats.class.php,v 1.1 2011-07-29 12:32:08 dgoron Exp $

global $class_path, $include_path;
require_once($include_path."/parser.inc.php");
require_once($class_path."/tache.class.php");
require_once ($class_path . "/consolidation.class.php");

class stats extends tache {
	var $id_tache;
	
	function stats($id_tache=''){
		global $base_path;
		
		parent::get_messages($base_path."/admin/planificateur/".get_class());
		$this->id_tache = $id_tache;

	}

	//formulaire spécifique au type de tâche
	function show_form ($param='') {
		global $base_path,$dbh, $charset, $msg;
				
		//paramètres pré-enregistré
		$liste_views = array();
		if ($param['list_view']) {
			foreach ($param['list_view'] as $id_view) {
				$liste_views[$id_view] = $id_view;
			}
		}
		$conso = ($param["conso"] ? $param["conso"] : "1");
		$date_deb = $param["date_deb"];
		$date_fin = $param["date_fin"];
		$date_ech = $param["date_ech"];
		
		$requete = "SELECT id_vue, date_consolidation, nom_vue, comment FROM statopac_vues";
		$res = mysql_query($requete, $dbh);
		$nb_rows = mysql_num_rows($res);
		//taille du selecteur
		if ($nb_rows < 3) $nb=3;
		else if ($nb_rows > 10) $nb=10;
		else $nb = $nb_rows;
		
		$select_view = "<select id='list_view' class='saisie-50em' name='list_view[]' size='".$nb."' multiple>";
		
		while($row = mysql_fetch_object($res)) {
			$select_view .="<option id='".$row->id_vue."' value='".$row->id_vue."' ".($liste_views[$row->id_vue] == $row->id_vue ? "selected" : "").">".htmlentities($row->nom_vue,ENT_QUOTES,$charset)."</option>";
		}
		
		$select_view .= "</select>";
		
		//liste des vues à consolider
		$form_task .= "
		<div class='row'>
			<div class='colonne3'>
				<label for='stats'>".$this->msg["planificateur_stats_listView"]."</label>
			</div>
			<div class='colonne_suite'>".
				$select_view
			."</div>
		</div>
		<div class='row'>&nbsp;</div>";

		/*appui sur la fin de la méthode do_form de la classe stat_view*/
		$form_task .= "<div class='row'>
			<div class='colonne3'>
				<label for='stats'>".$this->msg["planificateur_stats_options"]."</label>
			</div>
			<div class='colonne_suite'>
				<input type='radio' class='radio' id='id_lot' name='conso' value='1' ".($conso == "1" ? "checked" : "")."/> 
					<label for='id_lot'>$msg[stat_last_consolidation]</label> <br><br>
				<input type='radio' class='radio' id='id_interval' name='conso' value='2' ".($conso == "2" ? "checked" : "")."/> 
					<label for='id_interval'>$msg[stat_interval_consolidation] </label><br><br>
				<input type='radio' class='radio' id='id_debut' name='conso' value='3' ".($conso == "3" ? "checked" : "")."/> 
					<label for='id_debut'>$msg[stat_echeance_consolidation]</label><br>
			</div>
		</div>";
		$btn_date_deb = "<input type='hidden' name='date_deb' value='!!date_deb!!'/><input type='button' name='date_deb_lib' class='bouton_small' value='!!date_deb_lib!!'   
			onClick=\"openPopUp('./select.php?what=calendrier&caller=planificateur_form&date_caller=!!date_deb!!&param1=date_deb&param2=date_deb_lib&auto_submit=NO&date_anterieure=YES', 'date_deb', 250, 300, -2, -2, 'toolbar=no, dependent=yes, resizable=yes')\" />";
		$btn_date_fin = "<input type='hidden' name='date_fin' value='!!date_fin!!'/><input type='button' name='date_fin_lib' class='bouton_small'   value='!!date_fin_lib!!'
			onClick=\"openPopUp('./select.php?what=calendrier&caller=planificateur_form&date_caller=!!date_fin!!&param1=date_fin&param2=date_fin_lib&auto_submit=NO&date_anterieure=YES', 'date_fin', 250, 300, -2, -2, 'toolbar=no, dependent=yes, resizable=yes')\" />";
		$btn_date_echeance = "<input type='hidden' name='date_ech' value='!!date_ech!!'/><input type='button' name='date_ech_lib' class='bouton_small' value='!!date_ech_lib!!'  
			onClick=\"openPopUp('./select.php?what=calendrier&caller=planificateur_form&date_caller=!!date_ech!!&param1=date_ech&param2=date_ech_lib&auto_submit=NO&date_anterieure=YES', 'date_ech', 250, 300, -2, -2, 'toolbar=no, dependent=yes, resizable=yes')\" />";
			
		if (!$date_deb) // -- si nouvelle tâche = pas de params pré-enregistrés
			$date_deb = strftime("%Y-%m-%d", mktime(0, 0, 0, date('m'), date('d')-1, date('y'))); 
		$btn_date_deb=str_replace("!!date_deb!!",$date_deb,$btn_date_deb);
		$btn_date_deb=str_replace("!!date_deb_lib!!",formatdate($date_deb),$btn_date_deb);
		
		if(!$date_fin)
			$date_fin = today();			
		$btn_date_fin=str_replace("!!date_fin!!",$date_fin,$btn_date_fin);
		$btn_date_fin=str_replace("!!date_fin_lib!!",formatdate($date_fin),$btn_date_fin);
		
		if (!$date_ech)
			$date_ech = today();
		$btn_date_echeance=str_replace("!!date_ech!!",$date_ech,$btn_date_echeance);
		$btn_date_echeance=str_replace("!!date_ech_lib!!",formatdate($date_ech),$btn_date_echeance);
		
		$form_task=str_replace("!!date_deb_btn!!",$btn_date_deb,$form_task);
		$form_task=str_replace("!!date_fin_btn!!",$btn_date_fin,$form_task);
		$form_task=str_replace("!!echeance_btn!!",$btn_date_echeance,$form_task);
	 	
		return $form_task;
	}
	
	function task_execution($id_tache) {
		global $base_path, $dbh, $msg, $PMBusername;
		
		if (SESSrights & ADMINISTRATION_AUTH) {
			$parameters = $this->unserialize_task_params($id_tache);
			$conso = $parameters["conso"];
		
			if ($conso == "2") {
				$date_deb = $parameters["date_deb"];
				$date_fin = $parameters["date_fin"];
				$date_ech = "";
				$critere_title = $msg[stat_interval_consolidation];
				$critere_title=str_replace("!!date_deb_btn!!",formatdate($date_deb),$critere_title);
				$critere_title=str_replace("!!date_fin_btn!!",formatdate($date_fin),$critere_title);
			} else if ($conso == "3") {
				$date_deb = "";
				$date_fin = "";
				$date_ech = $parameters["date_ech"];
				$critere_title = $msg[stat_echeance_consolidation];
				$critere_title=str_replace("!!echeance_btn!!",formatdate($date_ech),$critere_title);
			} else {
				$date_deb = "";
				$date_fin = "";
				$date_ech = "";
				$critere_title = $msg[stat_last_consolidation];
			}
			if ($parameters["list_view"]) {
				foreach ($parameters["list_view"] as $list_id) {
					//on vérifie que la procédure existe toujours..
					$rqt = "select idproc, name from procs where idproc=".$list_id;
					$res = mysql_query($rqt, $dbh);
					if (mysql_num_rows($res) == "1") {
						$list_ck[] = $list_id; 					
						$list_name_ck[] = mysql_result($res,0,"name"); 
					}
				}

				$this->report[] = "<tr><th>".$this->msg["stats_conso"]." ( ".$critere_title." )</th></tr>";
				if (method_exists($this->proxy, "pmbesOPACStats_makeConsolidation")) {
					if ($list_ck && $list_name_ck) {
						$this->proxy->pmbesOPACStats_makeConsolidation($conso,$date_deb,$date_fin,$date_ech, $list_ck);
						foreach ($list_name_ck as $elem) {
							$this->report[] = "<tr><td>".$elem."</td></tr>";
						}
						//mise à jour de la progression
						$this->update_progression($id_tache, 100);
					} else {
						$this->report[] = "<tr><td>".$this->msg["stats_select_view_unknown"]."</td></tr>";
					}
				} else {
					$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"makeConsolidation","pmbesOPACStats",$PMBusername)."</td></tr>";
				}
			} else {
				$this->report[] = "<tr><td>".$this->msg["stats_no_view"]."</td></tr>";
				//mise à jour de la progression
				$this->update_progression($id_tache, 100);
			}
		} else {
			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
		}
	}

	/* Inutilisé...*/
	function traite_commande($cmd,$message) {	
		switch ($cmd) {
			case RESUME:
				break;
			case SUSPEND:
				break;
			case STOP:
				break;
			case RETRY:
				break;
			case ABORT:
				break;
		}	
	}
	
	function make_serialized_task_params() {
    	global $list_view, $conso, $date_deb, $date_fin, $date_ech,$task_id;
		
    	$t = parent::make_serialized_task_params($task_id);
		
		if ($list_view) {
			foreach ($list_view as $id_vue) {
				$t["list_view"][$id_vue]=$id_vue;			
			}
		}
		$t["conso"] = $conso;
		$t["date_deb"] = $date_deb;
		$t["date_fin"] = $date_fin;
		$t["date_ech"] = $date_ech;
		
    	$this->types_taches->params=serialize($t);

    	return serialize($t);
	}
	
	function unserialize_task_params($id_tache) {
    	$params = $this->get_task_params($id_tache);
		
		return $params;
    }
    
}