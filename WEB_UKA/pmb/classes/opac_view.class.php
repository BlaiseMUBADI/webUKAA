<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: opac_view.class.php,v 1.5 2011-10-06 15:16:31 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

// classes de gestion des vues Opac

// inclusions principales
require_once("$include_path/templates/opac_view.tpl.php");
require_once("$class_path/param_subst.class.php");
require_once($class_path."/opac_filters.class.php");
require_once("$class_path/search.class.php");


class opac_view {

	var $last_gen='';	//datetime derniere generation
	var $ttl='';		//duree de validite

// constructeur
function opac_view($id=0,$id_empr=0) {
	// si id, allez chercher les infos dans la base
	$this->search_class=new search(false);
	$this->id = $id;
	$this->id_empr = $id_empr;
	$this->fetch_data();
	return $this->id;
}

// r�cup�ration des infos en base
function fetch_data() {
	global $dbh;
	if($this->id){
		$myQuery = mysql_query("SELECT * FROM opac_views WHERE opac_view_id='".$this->id."' LIMIT 1", $dbh);
		$myreq= mysql_fetch_object($myQuery);
		$this->name=$myreq->opac_view_name;
		$this->requete=$myreq->opac_view_query;
		$this->human_query = $this->search_class->make_serialized_human_query($this->requete) ;
		$this->comment=$myreq->opac_view_comment;
		$this->visible=$myreq->opac_view_visible;
		$this->last_gen=$myreq->opac_view_last_gen;
		$this->ttl=$myreq->opac_view_ttl;

		$this->param_subst=new param_subst("opac", "opac_view",$this->id);
		$this->opac_filters=new opac_filters($this->id);
	}
	$this->view_list_empr[]	=array();
	$this->view_list_empr_default=0;
	if($this->id_empr){
		// vues selectionn�es pour empr
		$myQuery = mysql_query("SELECT * FROM opac_views_empr WHERE emprview_empr_num='".$this->id_empr."' ", $dbh);
		if(mysql_num_rows($myQuery)){
			while(($r=mysql_fetch_object($myQuery))) {
				if($r->emprview_default) $this->view_list_empr_default=$r->emprview_view_num;
				$this->view_list_empr[]=$r->emprview_view_num;
			}
		}
	}
	$this->get_list();
}

function get_list($name='', $value_selected=0) {
	global $dbh,$charset;
	$myQuery = mysql_query("SELECT * FROM opac_views order by opac_view_name ", $dbh);
	$this->opac_views_list=array();

	$selector = "<select name='$name' id='$name'>";
	if(mysql_num_rows($myQuery)){
		$i=0;
		while(($r=mysql_fetch_object($myQuery))) {
			$this->opac_views_list[$i]->id=$r->opac_view_id;
			$this->opac_views_list[$i]->name=$r->opac_view_name;
			$this->opac_views_list[$i]->visible=$r->opac_view_visible;
			$this->opac_views_list[$i]->query=$r->opac_view_query;
			$this->opac_views_list[$i]->comment=$r->opac_view_comment;
			$selector .= "<option value='".$r->opac_view_id."'";
			$r->opac_view_id == $value_selected ? $selector .= ' selected=\'selected\'>' : $selector .= '>';
	 		$selector .= htmlentities($r->opac_view_name,ENT_QUOTES, $charset).'</option>';
			$i++;
		}
	}
	$selector .= '</select>';
	$this->selector=$selector;
	return true;

}
// fonction de mise � jour ou de cr�ation
function update($value) {
	global $dbh,$msg;
	$fields="";
	foreach($value as $key => $val) {
		if($fields) $fields.=",";
		$fields.=" $key='$val' ";
	}

	if($this->id) {
		// modif
		$erreur=mysql_query("UPDATE opac_views SET $fields WHERE opac_view_id=".$this->id, $dbh);
		if(!$erreur) {
			error_message($msg["opac_view_form_edit"], $msg["opac_view_form_add_error"],1);
			exit;
		}
	} else {
		// create
		$erreur=mysql_query("INSERT INTO opac_views SET $fields ", $dbh);
		$this->id = mysql_insert_id($dbh);
		if(!$erreur) {
			error_message($msg["opac_view_form_edit"], $msg["opac_view_form_add_error"],1);
			exit;
		}
		// Cr�ation table associ�e
		$req_create="create table IF NOT EXISTS opac_view_notices_".$this->id." (
			opac_view_num_notice int(20) not null default 0,
			KEY `opac_view_num_notice` (`opac_view_num_notice`)
			)";
		mysql_query($req_create);
	}
	// rafraischissement des donn�es
	$this->fetch_data();
	return $this->id;
}

function update_form() {
	global $name,$requete,$comment,$opac_view_form_visible,$ttl;
	$value="";
	$value->opac_view_name=$name;
	$value->opac_view_query=$requete;
	$value->opac_view_comment=$comment;
	$value->opac_view_visible=$opac_view_form_visible;
	$value->opac_view_ttl = $ttl;
	$this->update($value);

	$this->opac_filters->save_all_form();
}

function gen() {
	global $dbh,$msg;
	for($i=0;$i<count($this->opac_views_list);$i++) {
		$req="TRUNCATE TABLE opac_view_notices_".$this->opac_views_list[$i]->id;
		mysql_query($req, $dbh);

		$this->search_class->unserialize_search($this->opac_views_list[$i]->query);
		$table=$this->search_class->make_search() ;

		$req="INSERT INTO opac_view_notices_".$this->opac_views_list[$i]->id." ( opac_view_num_notice) select notice_id from $table ";
		mysql_query($req, $dbh);
		mysql_query("drop table $table");

		$req="update opac_views set opac_view_last_gen=now()";
		mysql_query($req, $dbh);
	}
}

// fonction g�n�rant le form de saisie
function do_form() {
	global $msg,$tpl_opac_view_form, $tpl_opac_view_create_form, $charset,$newsearch;

	// titre formulaire
	if($this->id) {
		global $suite,$requete;
		if($suite== 'transform_equ') {
			$this->requete=stripslashes($requete);
			$this->human_query =$this->search_class->make_serialized_human_query($this->requete) ;
		}
		$libelle=$msg["opac_view_modifier"];
		$link_delete="<input type='button' class='bouton' value='".$msg[63]."' onClick=\"confirm_delete();\" />";
		$button_modif_requete = "onClick=\"document.modif_requete_form.submit();\" ";
		$form_modif_requete = $this->make_hidden_search_form();
		$tpl=$tpl_opac_view_form;
	} else {
		$tpl=$tpl_opac_view_create_form;
		$libelle=$msg["opac_view_add"];
		$link_delete="";
	}
	// Champ
	$opac_visible_selected= "!!opac_visible_selected_".$this->visible."!!";
	$tpl = str_replace($opac_visible_selected, "selected=selected", $tpl);
	$tpl = str_replace('!!name!!', htmlentities($this->name,ENT_QUOTES,$charset), $tpl);
	$tpl = str_replace('!!libelle!!',htmlentities($libelle,ENT_QUOTES,$charset) , $tpl);
	$tpl = str_replace('!!libelle!!',htmlentities($libelle,ENT_QUOTES,$charset) , $tpl);
	$tpl = str_replace('!!comment!!',htmlentities($this->comment,ENT_QUOTES,$charset) , $tpl);
	$tpl = str_replace('!!last_gen!!',(($this->last_gen!=NULL)?htmlentities(formatdate($this->last_gen,ENT_QUOTES,$charset)):'') , $tpl);
	$tpl = str_replace('!!ttl!!',htmlentities($this->ttl,ENT_QUOTES,$charset) , $tpl);

	// recherche multicrit�re
	$tpl = str_replace('!!opac_view_id!!', $this->id,  $tpl);
	$tpl = str_replace('!!form_modif_requete!!', $form_modif_requete,  $tpl);
	$tpl = str_replace('!!search_build!!', $button_modif_requete,  $tpl);
	$tpl = str_replace('!!requete_human!!', $this->human_query, $tpl);
	$tpl = str_replace('!!requete!!', $this->requete, $tpl);

	// param subst
	if($this->param_subst)$tpl = str_replace('!!parameters!!', $this->param_subst->get_form_list("./admin.php?categ=opac&sub=opac_view&section=list&opac_view_id=".$this->id."&action=param"), $tpl);
	else $tpl=str_replace('!!parameters!!',"", $tpl);

	// elements visibles: filtres
	if($this->opac_filters)$tpl = str_replace('!!filters!!', $this->opac_filters->show_all_form(), $tpl);
	else $tpl=str_replace('!!filters!!',"", $tpl);

	$action="./admin.php?categ=opac&sub=opac_view&section=list&opac_view_id=".$this->id."&action=save";
	$tpl = str_replace('!!action!!', $action, $tpl);
	$tpl = str_replace('!!delete!!', $link_delete, $tpl);
	$tpl = str_replace('!!annul!!', "onClick=\"document.location='./admin.php?categ=opac&sub=opac_view&section=list'\" ", $tpl);
	return $tpl;
}

function get_form_param() {
	return $this->param_subst->exec_param_form("./admin.php?categ=opac&sub=opac_view&section=list&opac_view_id=".$this->id."&action=param");
}

// fonction g�n�rant le form de saisie
function do_list() {
	global $tpl_opac_view_list_tableau,$tpl_opac_view_list_tableau_ligne;

	$liste="";
	// pour toute les vues
	for($i=0;$i<count($this->opac_views_list);$i++) {
		if ($i % 2) $pair_impair = "even"; else $pair_impair = "odd";
        $td_javascript="  onmousedown=\"document.location='./admin.php?categ=opac&sub=opac_view&section=list&action=form&opac_view_id=!!opac_view_id!!'\" ";
        $tr_surbrillance = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
        $line = str_replace('!!td_javascript!!',$td_javascript , $tpl_opac_view_list_tableau_ligne);
        $line = str_replace('!!tr_surbrillance!!',$tr_surbrillance , $line);
        $line = str_replace('!!pair_impair!!',$pair_impair , $line);

		$line =str_replace('!!opac_view_id!!', $this->opac_views_list[$i]->id, $line);
		$line = str_replace('!!name!!', $this->opac_views_list[$i]->name, $line);
		$line = str_replace('!!comment!!', $this->opac_views_list[$i]->comment, $line);
		$liste.=$line;
	}
	return str_replace('!!lignes_tableau!!',$liste , $tpl_opac_view_list_tableau);
}

function do_sel_list() {
	global $tpl_opac_view_list_sel_tableau,$tpl_opac_view_list_sel_tableau_ligne;
	global $pmb_opac_view_class;
	if($pmb_opac_view_class)$readonly="readonly='readonly' ";
	$liste="";
	// pour toute les vues
	$pair_impair = "odd";
	$readonly_visible="";
	for($i=0;$i<count($this->opac_views_list);$i++) {
		if($this->opac_views_list[$i]->visible==0) continue;
		if($this->opac_views_list[$i]->visible==1) {
			$checked = " checked='checked' ";
			$readonly_visible="readonly='readonly' ";
		} else{
			$checked="";
			$readonly_visible="";
		}
		if ($pair_impair== "odd") $pair_impair = "even"; else $pair_impair = "odd";
        $td_javascript="";
        $tr_surbrillance = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
        $line = str_replace('!!td_javascript!!',$td_javascript , $tpl_opac_view_list_sel_tableau_ligne);
        $line = str_replace('!!tr_surbrillance!!',$tr_surbrillance , $line);
        $line = str_replace('!!pair_impair!!',$pair_impair , $line);
        if(!$checked && in_array ($this->opac_views_list[$i]->id,$this->view_list_empr)) $checked = " checked='checked' ";
        if($this->view_list_empr_default == $this->opac_views_list[$i]->id) $checked_default=" checked='checked' "; else $checked_default="";
		$line = str_replace('!!opac_view_id!!', $this->opac_views_list[$i]->id, $line);
		if($readonly_visible || $readonly) $readonly_cmd="readonly='readonly' ";
		$line = str_replace('!!radio_checked!!',$checked_default.$readonly, $line);
		$line = str_replace('!!name!!', $this->opac_views_list[$i]->name, $line);
		$line = str_replace('!!comment!!', $this->opac_views_list[$i]->comment, $line);
		$line = str_replace('!!checkbox!!', $checked.$readonly_cmd, $line);
		$liste.=$line;
	}
	return str_replace('!!lignes_tableau!!',$liste , $tpl_opac_view_list_sel_tableau);
}

function update_sel_list() {
	global $dbh;
	global $form_empr_opac_view; // issu du formulaire
	global $form_empr_opac_view_default; // issu du formulaire

	if($this->id_empr) mysql_query("DELETE from opac_views_empr WHERE emprview_empr_num=".$this->id_empr, $dbh);

	if(is_array($form_empr_opac_view) && $this->id_empr){
		foreach($form_empr_opac_view as $view_num){
			$found=0;
			for($i=0;$i<count($this->opac_views_list);$i++) {
				if( $this->opac_views_list[$i]->id == $view_num){$found=1;break;}
			}
			if($found){
				if($view_num==$form_empr_opac_view_default)$default=1; else $default=0;
				$req="INSERT INTO opac_views_empr SET emprview_view_num=$view_num, emprview_empr_num=".$this->id_empr.", emprview_default=$default ";
				mysql_query($req, $dbh);
			}
		}
	}
}

function delete() {
	global $dbh;

	if($this->id) {
		// relation vues / empr
		mysql_query("DELETE from opac_views_empr WHERE emprview_view_num=".$this->id, $dbh);
		// table de la liste des notices de la vue
		$req="DROP TABLE opac_view_notices_".$this->id;
		mysql_query($req);
		// la vue
		mysql_query("DELETE from opac_views WHERE opac_view_id='".$this->id."' ", $dbh);
		$this->id=0;
	}
	$this->fetch_data();
}

function make_hidden_search_form() {
    global $search;
    global $charset;
    global $page;
    $url = "./catalog.php?categ=search&mode=6" ;
    // remplir $search
    $this->search_class->unserialize_search($this->requete);

    $r="<form name='modif_requete_form' action='$url' style='display:none' method='post'>";

    for ($i=0; $i<count($search); $i++) {
    	$inter="inter_".$i."_".$search[$i];
    	global $$inter;
    	$op="op_".$i."_".$search[$i];
    	global $$op;
    	$field_="field_".$i."_".$search[$i];
    	global $$field_;
    	$field=$$field_;
    	//R�cup�ration des variables auxiliaires
    	$fieldvar_="fieldvar_".$i."_".$search[$i];
    	global $$fieldvar_;
    	$fieldvar=$$fieldvar_;
    	if (!is_array($fieldvar)) $fieldvar=array();

    	$r.="<input type='hidden' name='search[]' value='".htmlentities($search[$i],ENT_QUOTES,$charset)."'/>";
    	$r.="<input type='hidden' name='".$inter."' value='".htmlentities($$inter,ENT_QUOTES,$charset)."'/>";
    	$r.="<input type='hidden' name='".$op."' value='".htmlentities($$op,ENT_QUOTES,$charset)."'/>";
    	for ($j=0; $j<count($field); $j++) {
    		$r.="<input type='hidden' name='".$field_."[]' value='".htmlentities($field[$j],ENT_QUOTES,$charset)."'/>";
    	}
    	reset($fieldvar);
    	while (list($var_name,$var_value)=each($fieldvar)) {
    		for ($j=0; $j<count($var_value); $j++) {
    			$r.="<input type='hidden' name='".$fieldvar_."[".$var_name."][]' value='".htmlentities($var_value[$j],ENT_QUOTES,$charset)."'/>";
    		}
    	}
    }
    // Champs � m�moriser
    $r.="<input type='hidden' name='opac_view_id' value='".$this->id."'/>";
    $r.="</form>";
    return $r;
    }

} // fin d�finition classe
