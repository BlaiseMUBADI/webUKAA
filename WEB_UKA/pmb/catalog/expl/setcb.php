<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: setcb.php,v 1.11 2009-05-16 11:11:53 dbellamy Exp $
// popup de saisie d'un code barre

// YPR 22/11/2004 : on lui passe en param�tre le DOM du champ � modifier en retour $returnDOM

require_once ("../../includes/error_report.inc.php") ;
require_once ("../../includes/global_vars.inc.php") ;
require_once ("../../includes/config.inc.php");

$include_path      = "../../".$include_path; 
$class_path        = "../../".$class_path;
$javascript_path   = "../../".$javascript_path;
$styles_path       = "../../".$styles_path;

require("$include_path/db_param.inc.php");
require("$include_path/mysql_connect.inc.php");
// connection MySQL
$dbh = connection_mysql();

include("$include_path/error_handler.inc.php");
include("$include_path/sessions.inc.php");
include("$include_path/misc.inc.php");
include("$class_path/XMLlist.class.php");

if(!checkUser('PhpMyBibli')) {
	// localisation (fichier XML) (valeur par d�faut)
	$messages = new XMLlist("$include_path/messages/$lang.xml", 0);
 	$messages->analyser();
	$msg = $messages->table;
	print '<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"../../styles/$stylesheet; ?>\"></head><body>';
	require_once("$include_path/user_error.inc.php");
	error_message($msg[11], $msg[12], 1);
	print '</body></html>';
	exit;
	}


if(SESSlang) {
	$lang=SESSlang;
	$helpdir = $lang;
	}



// localisation (fichier XML)

$messages = new XMLlist("$include_path/messages/$lang.xml", 0);
$messages->analyser();
$msg = $messages->table;

require("$include_path/templates/common.tpl.php");

header ("Content-Type: text/html; charset=".$charset);

// $d = $_GET['returnDOM'];
if (! isset($form))  $form  = 'expl';
if (! isset($field)) $field = 'f_ex_cb';
$returnDOM = "window.opener.document.forms['".$form."'].elements['".$field."'].value";

print "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='$msg[1002]' charset='".$charset."'>
	<meta http-equiv='Pragma' content='no-cache'>
		<meta http-equiv='Cache-Control' content='no-cache'>";
print link_styles($stylesheet) ;
print "	<title>setcb</title>
	</head>
	<body>";
?>
<script type="text/javascript">
function updateParent() {
	<?php echo $returnDOM; ?> = document.forms['setcb'].elements['cb'].value;
	window.close();
}
</script>
<div align='center'>
	<form class='form-$current_module' name='setcb' onSubmit='updateParent();'>
		<small><?php echo $msg[4056]; ?></small><br />
		<input type='text' name='cb' value=''>
		<p>
			<input type='button' class='bouton' name='bouton' value='<?php echo $msg[76]; ?>' onClick='window.close();'>
			<input type='submit' class='bouton' name='save' value='<?php echo $msg[77]; ?>' />
		</p>
	</form>
<script type="text/javascript">
self.focus();
		document.forms['setcb'].elements['cb'].focus();
</script>
</div>
</body>
</html>
