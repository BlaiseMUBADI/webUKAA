<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: pmbesMySQL.class.php,v 1.1 2011-07-29 12:32:13 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/external_services.class.php");

class pmbesMySQL extends external_services_api_class {
	var $error=false;		//Y-a-t-il eu une erreur
	var $error_message="";	//Message correspondant à l'erreur
	
	function restore_general_config() {
		
	}
	
	function form_general_config() {
		return false;
	}
	
	function save_general_config() {
		
	}
	
	/*
	 * @param CHECK ANALYZE REPAIR OPTIMIZE
	 */
	function mysqlTable($action) {
		global $pmb_set_time_limit, $dbh;
		
		if (SESSrights & ADMINISTRATION_AUTH) {
			$result=array();
			
			if($action) {	
				@set_time_limit($pmb_set_time_limit);
				$db = DATA_BASE;
				$tables = mysql_list_tables($db);
				$num_tables = @mysql_num_rows($tables);
			
				$i = 0;
				while($i < $num_tables) {
					$table[$i] = mysql_tablename($tables, $i);
					$i++;
				}
	
				while(list($cle, $valeur) = each($table)) {
					$requete = $action." TABLE ".$valeur." ";
					$res = @mysql_query($requete, $dbh);
					$nbr_lignes = @mysql_num_rows($res);
					$nbr_champs = @mysql_num_fields($res);
	
					if($nbr_lignes) {
						if(!$cle) {
							for($i=0; $i < $nbr_champs; $i++) {
//								$result[] = mysql_field_name($res, $i);
							}
						}
			
						for($i=0; $i < $nbr_lignes; $i++) {
							$row = mysql_fetch_row($res);
							$tab = array();
							foreach($row as $dummykey=>$col) {
								if(!$col) $col="&nbsp;";
									$tab[$dummykey] = $col;	
							}
							$result[] = $tab;
						}
					}	
				}
			}	
			return $result;
		} else {
			return array();
		}
	}
}




?>