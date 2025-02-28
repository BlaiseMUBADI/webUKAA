<?php 
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: facette_search.class.php,v 1.4.2.3 2012-01-19 15:36:33 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class facettes{
	public $tab_facettes_record;
	public $tab_facettes_opac;
	
	function facettes(){
		$tab_facettes_record = array();
		$tab_facettes_opac = array();
	}
	
	function facette_existing(){
		global $msg,$dbh,$charset;
		
		$req = "SELECT * FROM facettes";
		$req = mysql_query($req,$dbh) or die(mysql_error());
		while($rslt = mysql_fetch_object($req)){
			$tab_temp = array();
			$tab_temp = array(
					'id'=> $rslt->id_facette+0,
					'name'=>$rslt->facette_name,
					'id_critere'=>$rslt->facette_critere+0,
					'id_ss_critere'=>$rslt->facette_ss_critere+0,
					'nb_result'=>$rslt->facette_nb_result+0,
					'type_sort'=>$rslt->facette_type_sort+0,
					'order_sort'=>$rslt->facette_order_sort+0
					);
			if($rslt->facette_visible==1) $this->tab_facettes_record[]= $tab_temp;
		}
		return $this->tab_facettes_record;
	}
	
	function nb_results_by_facette($tab_id_notice){
		global $dbh;
		$size = sizeof($this->tab_facettes_record);
		$i = 0;
		$array_result = array();
		for($i;$i<$size;$i++){
			$limit = "";
			$order_sort = "";
			$type_sort = "";
			$end_req_sql="";
			if($this->tab_facettes_record[$i]['type_sort']==0) $type_sort = "nb_result";
			else $type_sort = "value";
			if($this->tab_facettes_record[$i]['order_sort']==0) $order_sort = "asc";
			else $order_sort = "desc";
			if($this->tab_facettes_record[$i]['nb_result']>0) $limit = "LIMIT"." ".$this->tab_facettes_record[$i]['nb_result'];
			$end_req_sql = "order by ".$type_sort." ".$order_sort." ".$limit;
			
			//AND (lang = '' OR lang = ".$lang.")
			$req = "SELECT value, count(distinct id_notice) as nb_result FROM notices_fields_global_index 
									WHERE id_notice IN (".$tab_id_notice.")
									AND code_champ = ".($this->tab_facettes_record[$i]['id_critere']+0)."
									AND code_ss_champ = ".($this->tab_facettes_record[$i]['id_ss_critere']+0)."
									GROUP BY value ".$end_req_sql;
			$res = @mysql_query($req,$dbh);
			$j=0;
			$array_tmp = array();
			$array_value = array();
			
			while($rslt = mysql_fetch_object($res)){
				$array_tmp[$j] =  $rslt->value." "."(".($rslt->nb_result+0).")";
				$array_value[$j] = $rslt->value;
				$j++;
			} 
			$array_result[] = array(
						'name'=>$this->tab_facettes_record[$i]['name'],
						'facette'=>$array_tmp,
						'code_champ'=>$this->tab_facettes_record[$i]['id_critere'],
						'code_ss_champ'=>$this->tab_facettes_record[$i]['id_ss_critere'],
						'value'=>$array_value
						);
		}
		
		$this->tab_facettes_opac = $array_result;
	}
	
	function create_table_facettes(){
		global $charset;
		global $mode;
		global $msg;
		
		$size = sizeof($this->tab_facettes_opac);
		$table_facette = "<script> function test(elmt){
										var idElmt=elmt.rowIndex;
										var tab = document.getElementById('facette_list');
										var tr_tab = tab.getElementsByTagName('th');
										alert(tr_tab[idElmt].rowIndex);
										if(idElmt > 0) idElmt = idElmt/2;
										idElmt = idElmt.toString();
										var list = document.getElementById(idElmt);
										if(list.style.display == 'none'){
											list.style.display = 'block';
										}else list.style.display = 'none';
			
									}; </script>";
		
		$table_facette .= "<table id='facette_list'>";
		$table_facette_clicked = "<table id='active_facette'>";// onclick='javascript:test(this);'
		$facette_list_view = 0;
		$n = 0;//iterateur de style $pair_impair
		for($i=0;$i<$size;$i++){
			$facette_view = 1;
			//test pour savoir si la facette a deja ete cliquee
			if($_SESSION['facette']){
				for($x=0;$x<count($_SESSION['facette']);$x++){
					if ($n % 2) $pair_impair = "odd"; else $pair_impair = "even";
					$td_javascript=" ";
		        	$tr_surbrillance = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
					if(($_SESSION['facette'][$x][1]==$this->tab_facettes_opac[$i]['code_champ'])&&($_SESSION['facette'][$x][2]==$this->tab_facettes_opac[$i]['code_ss_champ'])){
						if(($x==0)&&(count($_SESSION['facette'])==1)) $table_facette_clicked .= "<tr class=".$pair_impair." ".$tr_surbrillance."><td>".$this->tab_facettes_opac[$i]['name'].": ".stripslashes($_SESSION['facette'][$x][0])."</td><td><a href='./index.php?lvl=more_results&get_last_query=1&reinit_facette=1' style='text-decoration:none;'><img src='./images/cross.png'/></a></td></tr>";
						else $table_facette_clicked .= "<tr class=".$pair_impair." ".$tr_surbrillance."><td>".$this->tab_facettes_opac[$i]['name'].": ".stripslashes($_SESSION['facette'][$x][0])."</td><td><a href='./index.php?lvl=more_results&mode=extended&facette_test=1&param_delete_facette=".$x."' style='text-decoration:none;'><img src='./images/cross.png'/></a></td></tr>";
						$facette_view = 0;
						$n++;
					} 
				}
			}
			//si elle n'a pas ete cliquee
			if($facette_view && (sizeof($this->tab_facettes_opac[$i]['facette'])!=0)){
				$facette_list_view++;
				$table_facette .= "<tr><th onclick='javascript:test(this);'>".htmlentities($this->tab_facettes_opac[$i]['name'],ENT_QUOTES,$charset)."</th></tr>";
				$size2 = sizeof($this->tab_facettes_opac[$i]['facette']);
				for($j=0;$j<$size2;$j++){
					$new_value_search = $this->tab_facettes_opac[$i]['value'][$j];
					$id_last_query = $_SESSION['last_query']+0;
					$fields_search = "&facette_test=1&value=".rawurlencode($new_value_search)."&champ=".$this->tab_facettes_opac[$i]['code_champ']."&ss_champ=".$this->tab_facettes_opac[$i]['code_ss_champ']."";
					$table_facette .= "<tr><td><a href='./index.php?lvl=more_results&mode=extended".$fields_search."' style='text-decoration:none;'>".htmlentities($this->tab_facettes_opac[$i]['facette'][$j],ENT_QUOTES,$charset)."</a></td></tr>";
				}
			}
		}
		$table_facette_clicked .= "</table>";
		$table_facette .="</table>";
		
		if($_SESSION['facette'] && $facette_list_view>0) $table = "<h3>".$msg['facette_active']."</h3>".$table_facette_clicked."<br/><h3>".$msg['facette_list']."</h3>".$table_facette."";
		elseif(!$_SESSION['facette'] && $facette_list_view>0) $table = "<h3>".$msg['facette_list']."</h3>".$table_facette."";
		elseif($facette_list_view>0) $table = "<h3>".$msg['facette_active']."</h3>".$table_facette_clicked."<br/>";
		
		return $table;
	}
	
	public static function checked_facette_search($val,$champ,$ss_champ){
		global $search;
		global $op_0_s_1;
		global $field_0_s_1;
		global $param_delete_facette;
		
		//historique des recherches
		$search[]="s_1";
		$op_0_s_1 ="EQ";
		$field_0_s_1[] =  $_SESSION['last_query']+0; 
		
		//ajout des valeurs de la facette à la $SESSION
		if($param_delete_facette!=""){
			unset($_SESSION['facette'][$param_delete_facette]);
			$_SESSION['facette'] = array_values($_SESSION['facette']);
		}
		else $_SESSION['facette'][] = array($val,$champ,$ss_champ);
		//creation des globales => parametres de recherche
		if($_SESSION['facette']){
			for($i=0;$i<count($_SESSION['facette']);$i++){
				$search[]="s_3";
		    	$field="field_".($i+1)."_s_3";
    			$field_=array();
    			$field_[0]=$_SESSION['facette'][$i][0];
    			$field_[1]=$_SESSION['facette'][$i][1];
    			$field_[2]=$_SESSION['facette'][$i][2];
    			global $$field;
    			$$field=$field_;
		    	
		    	$op="op_".($i+1)."_s_3";
		    	$op_ = "EQ";
    			global $$op;
    			$$op=$op_;
    		    
    			$inter="inter_".($i+1)."_s_3";
    			$inter_ = "and";
    			global $$inter;
    			$$inter=$inter_;
			}	
		}
	} 
	
	public static function make_facette($id_notice_array){
		global $es;
		$face = new facettes();
		$face->facette_existing();
		$face->nb_results_by_facette($id_notice_array);
		return $face->create_table_facettes();
	}
}
