<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: mysql.class.php,v 1.1 2011-07-29 12:32:10 dgoron Exp $

global $class_path, $include_path;
require_once($include_path."/parser.inc.php");
require_once($class_path."/tache.class.php");

class mysql extends tache {
	var $id_tache;						//identifiant de la tâche
	
	function mysql($id_tache=''){
		global $base_path;
		
		parent::get_messages($base_path."/admin/planificateur/".get_class());
		$this->id_tache = $id_tache;
				
	}
	
	//formulaire spécifique au type de tâche
	function show_form ($param='') {		
		//paramètres pré-enregistré
		$tab_maintenance = array();
		if ($param['mySQL']) {
			foreach ($param['mySQL'] as $elem) {
				$tab_maintenance[$elem] = $elem;
			}
		}

		$form_task .= "
		<div class='row'>
			<div class='colonne3'>
				<label for='bannette'>".$this->msg["planificateur_mysql_maintenance"]."</label>
			</div>
			<div class='colonne_suite'>
				<input type='checkbox' name='mySQL[]' value='CHECK' ".($tab_maintenance['CHECK'] == 'CHECK' ? 'checked' : '')."/>".$this->msg["planificateur_mysql_checkTable"]."
				<br />
				<input type='checkbox' name='mySQL[]' value='ANALYZE' ".($tab_maintenance['ANALYZE'] == 'ANALYZE' ? 'checked' : '')."/>".$this->msg["planificateur_mysql_analyzeTable"]."
				<br />
				<input type='checkbox' name='mySQL[]' value='REPAIR' ".($tab_maintenance['REPAIR'] == 'REPAIR' ? 'checked' : '')."/>".$this->msg["planificateur_mysql_repairTable"]."
				<br />
				<input type='checkbox' name='mySQL[]' value='OPTIMIZE' ".($tab_maintenance['OPTIMIZE'] == 'OPTIMIZE' ? 'checked' : '')."/>".$this->msg["planificateur_mysql_optimizeTable"]."		
			</div>
		</div>";
					
		return $form_task;
	}
	
	function task_execution($id_tache) {
		global $dbh, $charset, $msg, $PMBusername;
		
		if (SESSrights & ADMINISTRATION_AUTH) {
			$parameters = $this->unserialize_task_params($id_tache);
		
			$this->report[] = "<tr><th colspan=4>".$this->msg["mysql_operation"]."</th></tr>";
			if (method_exists($this->proxy, "pmbesMySQL_mysqlTable")) {
				if ($parameters["mySQL"]) {
					$percent = 0;
					$p_value = (int) 100/count($parameters["mySQL"]);
					foreach($parameters["mySQL"] as $action) {
						$this->listen_commande($id_tache,array(&$this, 'traite_commande')); //fonction a rappeller (traite commande)
			
						if($this->statut == WAITING) {
							$this->send_command($id_tache,RUNNING);
						}
					
						if($this->statut == RUNNING) {
							$this->report[] = "<tr ><th colspan=4>".$action."</th></tr>";
							$result = $this->proxy->pmbesMySQL_mysqlTable($action);
							foreach ($result as $i=>$table) {
								$htmlOutput = "<tr class='odd'>";
								foreach ($table as $col) {
									$htmlOutput .= "<td >".$col."</td>";
								}
								$htmlOutput .= "</tr>";
								$this->report[] = htmlentities($htmlOutput, ENT_QUOTES, $charset);
							}
			
							$percent += $p_value;
							$this->update_progression($id_tache, $percent);	
						}
					}
				} else {
					$this->report[] = "<tr><td>".$this->msg["mysql_action_unknown"]."</td></tr>";
					$this->update_progression($id_tache, 100);
				}
			} else {
				$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"mysqlTable","pmbesMySQL",$PMBusername)."</td></tr>";
			}
		} else {
			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
		}
	}
	
	function traite_commande($cmd,$message) {		
		switch ($cmd) {
			case RESUME:
				$this->send_command($this->id_tache,WAITING);
				break;
			case SUSPEND:
				$this->suspend_mysql();
				break;
			case STOP:
				$this->finalize($this->id_tache);
				die();
				break;
			case FAIL:
				$this->finalize($this->id_tache);
				die();
				break;
//			case RETRY:
//				break;
		}
	}
    
	function make_serialized_task_params() {
    	global $mySQL;

		$t = parent::make_serialized_task_params($task_id);
		
		if ($mySQL) {
			foreach ($mySQL as $elem) {
				$t["mySQL"][$elem]=stripslashes($elem);			
			}
		}
		
    	$this->types_taches->params=serialize($t);

    	return serialize($t);
	}
	
	function unserialize_task_params($id_tache) {
    	$params = $this->get_task_params($id_tache);
		
		return $params;
    }

	function suspend_mysql() {
		while ($this->statut == SUSPENDED) {
			sleep(20);
			$this->listen_commande($this->id_tache, array(&$this,"traite_commande"));
		}
	}
}