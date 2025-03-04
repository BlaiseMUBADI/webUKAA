<?php
// +-------------------------------------------------+
// � 2002-2010 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: visionneuse.php,v 1.8.2.1 2012-03-29 07:15:05 dbellamy Exp $
$base_path = ".";
$include_path ="$base_path/includes";
$class_path ="$base_path/classes";
$visionneuse_path="$base_path/visionneuse";

//y a plein de trucs � r�cup...
require_once($base_path."/includes/init.inc.php");
require_once($base_path.'/includes/opac_config.inc.php');
require_once($base_path.'/includes/opac_db_param.inc.php');
require_once($base_path.'/includes/opac_mysql_connect.inc.php');
$dbh = connection_mysql();
require_once($base_path."/includes/session.inc.php");
//vraiment plein...
require_once($base_path.'/includes/start.inc.php');
require_once($base_path.'/includes/divers.inc.php');
require_once($include_path.'/templates/common.tpl.php');
require_once($base_path."/includes/includes_rss.inc.php");
//c'est bon, on peut commencer...

require_once($include_path.'/misc.inc.php');

require_once($visionneuse_path."/classes/visionneuse.class.php");
if($lvl == "" || $lvl == "visionneuse"){
	$lvl = "visionneuse";
	$short_header= str_replace("!!liens_rss!!","",$short_header);
	print $short_header;
	print "<script type='text/javascript' src='$include_path/javascript/tablist.js'></script>";
}
if (isset($_POST["position"])){
	$position = $_POST["position"];
	if ($lvl == "visionneuse"){
		$explnum_id = 0;
		$start = false;
	}else{
		$start = true;
	}
}else{
	 $position = 0;
	 $start = true;
}

$params = array(
	"mode" => $mode,
	"user_query" => $user_query,
	"pert" => $pert,
	"join" => $join,
	"clause" => $clause,
	"clause_bull" => $clause_bull,
	"tri" => $tri,
	"table" => $table,
	"user_code" => $_SESSION["user_code"],
	"idautorite" => $idautorite,
	"id" => $id,
	"idperio" => $idperio,
	"search" => $search,
	"bulletin" => $bulletin,
	"explnum_id" => $explnum_id,
	"position" => $position,
	"start" => $start,
	"lvl" => $lvl,
	"explnum" => $explnum
);

$visionneuse = new visionneuse("pmb",$visionneuse_path,$lvl,$lang,$params);
if($lvl == "" || $lvl == "visionneuse"){
	print $short_footer;
}
?>