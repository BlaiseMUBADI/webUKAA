<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: pmbesTasks.class.php,v 1.2 2011-11-04 13:42:10 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/external_services.class.php");
require_once($class_path.'/tache.class.php');
require_once($class_path.'/tache_calendar.class.php');

class pmbesTasks extends external_services_api_class {
	var $error=false;		//Y-a-t-il eu une erreur
	var $error_message="";	//Message correspondant à l'erreur
	
	function restore_general_config() {
		
	}
	
	function form_general_config() {
		return false;
	}
	
	function save_general_config() {
		
	}
		
	function timeoutTasks() {
		global $dbh;

		$requete = "select id_tache, num_planificateur, param, start_at FROM taches t, planificateur p 
			WHERE t.num_planificateur=p.id_planificateur 
			And t.id_process <> 0";

		$resultat=mysql_query($requete, $dbh);
		while ($row = mysql_fetch_object($resultat)) {
			$params=unserialize($row->param);
			foreach ($params as $index=>$param) {
				if (($index == "timeout") && ($param != "")) {
					// 6 = FAIL - Sera mis à l'échec à l'écoute de la tâche
					$requete_check_timeout = "update taches set commande=6 
						where DATE_ADD('".$row->start_at."', INTERVAL ".($param)." MINUTE) <= CURRENT_TIMESTAMP 
						and id_tache=".$row->id_tache;
					
					mysql_query($requete_check_timeout, $dbh);
				}
			}
		}
	}
	
	function getOS() {
		if (ereg("Win", $_SERVER['SERVER_SOFTWARE']))
		  $os = "Windows";
		elseif ((ereg("Mac", $_SERVER['SERVER_SOFTWARE'])) || (ereg("PPC", $_SERVER['SERVER_SOFTWARE'])))
		  $os = "Mac";
		elseif (ereg("Linux", $_SERVER['SERVER_SOFTWARE']))
		  $os = "Linux";
		elseif (ereg("FreeBSD", $_SERVER['SERVER_SOFTWARE']))
		  $os = "FreeBSD";
		elseif (ereg("SunOS", $_SERVER['SERVER_SOFTWARE']))
		  $os = "SunOS";
		elseif (ereg("IRIX", $_SERVER['SERVER_SOFTWARE']))
		  $os = "IRIX";
		elseif (ereg("BeOS", $_SERVER['SERVER_SOFTWARE']))
		  $os = "BeOS";
		elseif (ereg("OS/2", $_SERVER['SERVER_SOFTWARE']))
		  $os = "OS/2";
		elseif (ereg("AIX", $_SERVER['SERVER_SOFTWARE']))
		  $os = "AIX";
		else
		  $os = "Autre";
		  
		return $os;
	}
	
	/*Vérifie les processus actifs*/
	function checkTasks() {
		global $dbh;
		global $msg;

		//Récupération de l'OS pour la vérification des processus
		$os = $this->getOS();
		
		$sql = "SELECT t.id_tache, t.num_planificateur, t.id_process, p.num_type_tache 
			FROM taches t, planificateur p 
			WHERE t.num_planificateur=p.id_planificateur 
			And t.id_process <> 0";
		$res = mysql_query($sql,$dbh);
		while ($row = mysql_fetch_assoc($res)) {
			if ($os == "Linux") {
				$command = 'ps -p '.$row['id_process'];
			} else if ($os == "Windows") {
				//TASKLIST /V | FIND "192"
				$command = 'tasklist /FI PID = '.$row['id_process'];
			} else if ($os == "Mac") {
				$command = 'ps -p '.$row['id_process'];
			} else {
				$command = 'ps -p '.$row['id_process'];
			}
        	exec($command,$output);
        	if (!isset($output[1])) {
        		// 5 = STOPPED
        		$sql_stop_task = "update taches set status=5, end_at=CURRENT_TIMESTAMP, id_process=0, commande=0 where id_tache=".$row["id_tache"];
        		$res = mysql_query($sql_stop_task);
        	}
		}
	}
		
	/*Vérifie si une ou plusieurs tâches doivent être exécutées et lance celles-ci*/
	function runTasks($connectors_out_source_id) {
		global $dbh;
		global $base_path;
		global $pmb_path_php;
		
		//Récupération de l'OS sur lequel est exécuté la tâche
		$os = $this->getOS();

		//Y-a t-il une ou plusieurs tâches à exécuter...
		$sql = "SELECT id_planificateur, p.num_type_tache, p.libelle_tache, p.num_user, t.id_tache FROM planificateur p, taches t
			WHERE t.num_planificateur = p.id_planificateur
			And t.start_at='0000-00-00 00:00:00'
			And t.status=1
			And (p.calc_next_date_deb < '".date('Y-m-d')."'
			Or p.calc_next_date_deb = '".date('Y-m-d')."' 
			And p.calc_next_heure_deb <= '".date('H:i')."')
			";
		$res = mysql_query($sql,$dbh);
		while ($row = mysql_fetch_assoc($res)) {
			if ($os == "Linux") {		
				exec("nohup $pmb_path_php  $base_path/admin/planificateur/run_task.php ".$row["id_tache"]." ".$row["num_type_tache"]." ".$row["id_planificateur"]." ".$row["num_user"]." ".$connectors_out_source_id." > /dev/null 2>&1 & echo $!", $output);
			} else if ($os == "Windows") {
				// à completer...
//				$exec_cmd="PsExec -d \"".$base_path."\admin\planificateur\run_task.php\" ".$row["id_tache"]." ".$row["num_type_tache"]." ".$row["id_planificateur"]." ".$row["num_user"]." ".$connectors_out_source_id;
				$exec_cmd="PsExec -d \"".$base_path."\admin\planificateur\run_task.php\" ".$row["id_tache"]." ".$row["num_type_tache"]." ".$row["id_planificateur"]." ".$row["num_user"]." ".$connectors_out_source_id;
				exec($exec_cmd,$output);
			} else if ($os == "Mac") {
				exec("nohup $pmb_path_php  $base_path/admin/planificateur/run_task.php ".$row["id_tache"]." ".$row["num_type_tache"]." ".$row["id_planificateur"]." ".$row["num_user"]." ".$connectors_out_source_id." > /dev/null 2>&1 & echo $!", $output);
			} else {
				exec("nohup $pmb_path_php  $base_path/admin/planificateur/run_task.php ".$row["id_tache"]." ".$row["num_type_tache"]." ".$row["id_planificateur"]." ".$row["num_user"]." ".$connectors_out_source_id." > /dev/null 2>&1 & echo $!", $output);
			}
			$id_process = (int)$output[0];
			
			$update_process = "update taches set id_process='".$id_process."' where id_tache='".$row["id_tache"]."'";		
			mysql_query($update_process,$dbh);
		}
	}
	
	/*Retourne la liste des tâches réalisées et planifiées
	 */
	function listTasksPlanned() {
		global $dbh;
		global $msg;
		$result = array();
		
		$sql = "Select t.id_tache, p.libelle_tache, p.desc_tache,";
		$sql .= "t.start_at, t.end_at, t.indicat_progress, t.status";
		$sql .= "FROM taches t, planificateur p where t.num_planificateur=p.id_planificateur"; 
			
		$res = mysql_query($sql, $dbh);
		if ($res) {
			while($row = mysql_fetch_assoc($res)) {
				$result[] = array (
						"id_tache" => $row["id_tache"],
						"libelle_tache" => utf8_normalize($row["libelle_tache"]),
						"desc_tache" => utf8_normalize($row["desc_tache"]),
						"start_at" => $row["start_at"],
						"end_at" => $row["end_at"],
						"indicat_progress" => $row["indicat_progress"],
						"status" => $row["status"],
				);
			}
		}
		return $result;
	}
	
	/*Retourne les types de tâches*/
	function listTypesTasks() {
		global $dbh;
		global $msg;
		$result = array();
	
		$filename="../admin/planificateur/catalog.xml";
		$xml=file_get_contents($filename);
		$param=_parser_text_no_function_($xml,"CATALOG");
		
		foreach ($param["ACTION"] as $anitem) {
			$t=array();
			$t["ID"] = $anitem["ID"];
			$t["NAME"] = $anitem["NAME"];
			$t["COMMENT"] = $anitem["COMMENT"];
			$types_taches[$t["ID"]] = $t;
		}				
		return $types_taches;
	}
	
	/*Retourne les informations concernant une tâche planifiée
	 */
	function getInfoTaskPlanned($planificateur_id, $active="") {
		global $dbh;
		global $msg;
		$result = array();

		$planificateur_id += 0;
		if (!$planificateur_id)
			throw new Exception("Missing parameter: planificateur_id");

		if ($active !="") {
			$critere = " and statut=".$active;
		} else {
			$critere ="";
		}
		
		$sql = "SELECT * FROM planificateur WHERE id_planificateur = ".$planificateur_id;
		$sql = $sql.$critere;
		$res = mysql_query($sql,$dbh);
		if (!$res)
			throw new Exception("Not found: planificateur_id = ".$planificateur_id);
		
		while ($row = mysql_fetch_assoc($res)) {
			$result[] = array(
				"id_planificateur" => $row["id_planificateur"],
				"num_type_tache" => $row["num_type_tache"],
				"libelle_tache" => utf8_normalize($row["libelle_tache"]),
				"desc_tache" => utf8_normalize($row["desc_tache"]),
				"num_user" => $row["num_user"],
				"statut" => $row["statut"],
				"calc_next_date_deb" => utf8_normalize($row["calc_next_date_deb"]),
				"calc_next_heure_deb" => utf8_normalize($row["calc_next_heure_deb"]),
			);
		}		
		return $result;
	}
	
	/**
	 * 
	 * Change le statut d'une planification
	 * @param $id_planificateur 
	 * @param $activation (0=false, 1=true)
	 */
	function changeStatut($id_planificateur,$activation='') {
		global $dbh;
		
		if (!$id_planificateur)
			throw new Exception("Missing parameter: id_planificateur");
			
		$sql = "select statut from planificateur where id_planificateur=".$id_planificateur;
		$res = mysql_query($sql, $dbh);
		
		if (mysql_num_rows($res) == "1") {
			$statut_sql = mysql_result($res, 0,"statut");
			if ((($statut_sql == "0") && ($activation == "1")) ||
				(($statut_sql == "1") && ($activation == "0"))) {
				$sql_update = "update planificateur set statut=".$activation." where id_planificateur=".$id_planificateur;
				mysql_query($sql_update, $dbh);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

?>