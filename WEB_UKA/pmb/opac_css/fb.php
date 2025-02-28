<?php
// +-------------------------------------------------+
// © 2002-2010 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: fb.php,v 1.4.2.3 2011-11-29 11:31:47 arenou Exp $
$base_path=".";
require_once($base_path."/includes/global_vars.inc.php");
require_once($base_path.'/includes/opac_config.inc.php');

print "
<html xmlns='http://www.w3.org/1999/xhtm'
      xmlns:og='http://ogp.me/ns#'
      xmlns:fb='http://www.facebook.com/2008/fbml'>
	<head>
		<meta name='title' content='".htmlentities(stripslashes($title),ENT_QUOTES,$charset)."' />
		<meta name='description' content='".htmlentities(stripslashes($desc),ENT_QUOTES,$charset)."' />
		<title>".htmlentities(stripslashes($title),ENT_QUOTES,$charset)."</title>
		
		<script type='text/javascript'>
			document.location='$url".($id ? "&id=$id" : "")."'
		</script>
	</head>
</html>";
?>
