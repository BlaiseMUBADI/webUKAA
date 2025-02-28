<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: category.inc.php,v 1.40.2.3 2012-01-24 13:57:56 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// premier niveau de recherche OPAC sur catégorie

if($_SESSION["opac_view"]){
	$opac_view_restrict=" notice_id in (select opac_view_num_notice from  opac_view_notices_".$_SESSION["opac_view"].") ";
}
// on regarde comment la saisie utilisateur se présente

if ($opac_search_other_function) require_once($include_path."/".$opac_search_other_function);
require_once($class_path."/thesaurus.class.php");

$first_clause.= "categories.libelle_categorie not like '~%' ";

$q = 'drop table if exists catdef ';
$r = mysql_query($q, $dbh);
$q = 'create temporary table catdef ( ';
$q.= "num_thesaurus int(3) unsigned not null default '0', ";
$q.= "num_noeud int(9) unsigned not null default '0', ";
$q.= 'libelle_categorie text not null , ';
$q.= 'index_categorie text not null , ';
$q.= 'key (num_noeud) ';
$q.= ") ENGINE=MyISAM ";
$r = mysql_query($q, $dbh);

$list_thes = array();
if ($opac_thesaurus) { 
//mode multithesaurus
	$list_thes = thesaurus::getThesaurusList();
} else {
//mode monothesaurus
	$thes = new thesaurus($opac_thesaurus_defaut);
	$list_thes[$opac_thesaurus_defaut]=$thes->libelle_thesaurus;
}

foreach ($list_thes as $id_thesaurus=>$libelle_thesaurus) {
	$thes = new thesaurus($id_thesaurus);
	$q = 'insert into catdef ';
	$q.= 'select noeuds.num_thesaurus, ';
	$q.= 'categories.num_noeud, categories.libelle_categorie, categories.index_categorie ';
	$q.= 'from noeuds, categories ';
	$q.= "where categories.langue = '".$thes->langue_defaut."' ";
	$q.= 'and '.$first_clause.' ';
	$q.= "and noeuds.num_thesaurus = '".$id_thesaurus."' ";
	$q.= 'and noeuds.id_noeud = categories.num_noeud ';
	$r = mysql_query($q, $dbh);
}

$q = 'drop table if exists catlg ';
$r = mysql_query($q, $dbh);
$q = 'create temporary table catlg ENGINE=MyISAM as ';
$q.= 'select categories.num_noeud, categories.libelle_categorie, categories.index_categorie ';
$q.= 'from noeuds, categories ';
$q.= "where categories.langue = '".$lang."' ";
$q.= 'and '.$first_clause.' ';
$q.= "and noeuds.id_noeud = categories.num_noeud ";
$r = mysql_query($q, $dbh);
$q = 'alter table catlg add key (num_noeud) ';
$r = mysql_query($q, $dbh);

$aq=new analyse_query(stripslashes($user_query));
$members_catdef = $aq->get_query_members('catdef','catdef.libelle_categorie','catdef.index_categorie','catdef.num_noeud');
$members_catlg = $aq->get_query_members('catlg','catlg.libelle_categorie','catlg.index_categorie','catlg.num_noeud');

$q = 'drop table if exists catjoin ';
$r = mysql_query($q, $dbh);
$q = 'create temporary table catjoin ENGINE=MyISAM as select ';
$q.= 'catdef.num_thesaurus, catdef.num_noeud ';
$q.= 'from catdef ';
$q.= 'left join catlg on catdef.num_noeud = catlg.num_noeud ';
$q.= 'where ';
$q.= '( '.$members_catlg['where'].' '; 
$q.= "or ( catlg.num_noeud is null and ".$members_catdef['where']." ) ) ";
$r = mysql_query($q, $dbh);

$clause = '';
$add_notice = '';

if ($opac_search_other_function) $add_notice=search_other_function_clause();

if ($typdoc || $add_notice) $clause.= ', notices, notices_categories where (notices_categories.num_noeud=catjoin.num_noeud and notices_categories.notcateg_notice=notices.notice_id)';

if ($typdoc) $clause.=" and typdoc='".$typdoc."' ";

if ($add_notice) $clause.= ' and notice_id in ('.$add_notice.')'; 

$q = 'select count(distinct catjoin.num_noeud) from catjoin '.$clause;

$r=mysql_query($q);
$nb_result_categories = mysql_result($r, 0 , 0);

//Enregistrement des stats
if($pmb_logs_activate){
	global $nb_results_tab;
	$nb_results_tab['categories'] = $nb_result_categories;
}

$form = "<form name=\"search_categorie\" action=\"./index.php?lvl=more_results\" method=\"post\">";
$form .= "<input type=\"hidden\" name=\"user_query\" value=\"".htmlentities(stripslashes($user_query),ENT_QUOTES,$charset)."\">\n";
if (function_exists("search_other_function_post_values")){ $form .=search_other_function_post_values(); }
$form .= "<input type=\"hidden\" name=\"mode\" value=\"categorie\">\n";
$form .= "<input type=\"hidden\" id=\"count\" name=\"count\" value=\"".$nb_result_categories."\">\n";
$form .= "<input type=\"hidden\" name=\"clause\" value=\"".htmlentities($clause,ENT_QUOTES,$charset)."\">\n";
$form .= "<input type=\"hidden\" id=\"id_thes\" name=\"id_thes\" value=\"-1\"></form>\n";
$form .= "
			<script type='text/javascript' >\n

				function submitSearch_CategorieForm(id, nb)
				{
					document.getElementById('id_thes').value = id;
					document.getElementById('count').value = nb;
					document.forms['search_categorie'].submit();  
				}
			</script>\n";

if($opac_allow_affiliate_search){
	$search_result_affiliate_all =  str_replace("!!mode!!","category",$search_result_affiliate_lvl1);
	$search_result_affiliate_all =  str_replace("!!search_type!!","authorities",$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!label!!",$msg['categories'],$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!nb_result!!",$nb_result_categories,$search_result_affiliate_all);
	if($nb_result_categories){
		$link = "<a href='#' onclick=\"document.search_categorie.action = './index.php?lvl=more_results&tab=catalog'; document.search_categorie.submit();return false;\">".$msg['suite']."&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a>";
	}else $link = "";
	$search_result_affiliate_all =  str_replace("!!link!!",$link,$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!style!!","",$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!user_query!!",$user_query,$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!form_name!!","search_categorie",$search_result_affiliate_all);
	$search_result_affiliate_all =  str_replace("!!form!!",$form,$search_result_affiliate_all);
	print $search_result_affiliate_all;
}else{
	if($nb_result_categories) {
		// tout bon, y'a du résultat, on lance le pataquès d'affichage
		print "<div style=search_result id=\"categorie\" name=\"categorie\">";
		print "<strong>$msg[categories]</strong> ".$nb_result_categories." $msg[results] ";
		print "<a href=\"javascript:document.forms['search_categorie'].submit()\">$msg[suite]&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a>";
	
		if ($opac_thesaurus) {	//mode multithesaurus dans l'opac
			$nb_thes=0;
			foreach ($list_thes as $id_thesaurus=>$libelle_thesaurus) {
				$q = 'select count(distinct catjoin.num_noeud) from catjoin '.$clause;
				$q.= "and catjoin.num_thesaurus = '".$id_thesaurus."' ";
				$clause_link=$clause." and catjoin.num_thesaurus = '".$id_thesaurus."' ";
				$r = mysql_query($q, $dbh);
				$nb = mysql_result($r, 0, 0);
				if ($nb) {
					$nb_thes++;
					if($nb_thes==1)print '<blockquote>';
					print htmlentities($msg['thes_libelle'],ENT_QUOTES, $charset).' '.htmlentities($libelle_thesaurus,ENT_QUOTES, $charset).'&nbsp;'.$nb.' '.htmlentities($msg[results],ENT_QUOTES, $charset);
					print "<a href=\"#\" onclick=\"document.forms.search_categorie.count.value='".$nb."';document.forms.search_categorie.clause.value='".htmlentities(addslashes($clause_link),ENT_QUOTES,$charset)."';submitSearch_CategorieForm('".$id_thesaurus."','".$nb."'); return false;\">$msg[suite]&nbsp;<img src='./images/search.gif' border='0' align='absmiddle'/></a>";
					print '<br />';
				}
			}
			if($nb_thes)print ' </blockquote>';	
		}
		// Le lien validant le formulaire est inséré dans le code avant le formulaire, cela évite les blancs à l'écran
		$form = "<div style=search_result>".$form."</div>\n";
		print $form;
		print "</div>";
	}
}