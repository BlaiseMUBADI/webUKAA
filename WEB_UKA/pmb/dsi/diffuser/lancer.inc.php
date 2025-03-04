<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: lancer.inc.php,v 1.15 2010-07-06 09:20:16 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

print "<h1>".$msg[dsi_dif_auto_titre]."</h1>" ;

// en visualisation, possibilit� de supprimer des notices � la demande
if ($suite=="suppr_notice") {
	$bannette = new bannette($id_bannette) ;
	$bannette->suppr_notice($num_notice);
	// on r�affiche la bannette de laquelle on a supprim� une notice
	$liste_bannette[] = $id_bannette ;
	$suite = "visualiser";
}

// r�cup�rer les bannettes coch�es
if (!$liste_bannette) $liste_bannette = array() ;
for ($iba=0 ; $iba < sizeof($liste_bannette) ; $iba++) {
	$bannette = new bannette($liste_bannette[$iba]) ;
	switch($suite) {
    	case "vider" :
			$action_diff_aff .= $msg['dsi_dif_vidage'].": ".$bannette->nom_bannette."<br />" ; 
			$bannette->vider();
			break ;
		case "remplir" :
			$action_diff_aff .= $msg['dsi_dif_remplissage'].": ".$bannette->nom_bannette ; 
			$action_diff_aff .= $bannette->remplir();
			$bannette->purger();
			break ;
		case "diffuser" :
			$action_diff_aff .= "<strong>".$msg['dsi_dif_diffusion'].": ".$bannette->nom_bannette."</strong><br />" ; 
			$action_diff_aff .= $bannette->diffuser();
			break ;
		case "visualiser" :
			$action_diff_aff .= "<h3>".$msg['dsi_dif_ban_contenu'].": ".$bannette->nom_bannette."</h3>" ; 
			$action_diff_aff .= $bannette->aff_contenu_bannette("./dsi.php?categ=diffuser&sub=auto", 0);
			break ;
		case "full_auto" :
			$action_diff_aff .= $msg['dsi_dif_vidage'].": ".$bannette->nom_bannette."<br />" ; 
			if(!$bannette->limite_type)$action_diff_aff .= $bannette->vider();
			$action_diff_aff .= $msg['dsi_dif_remplissage'].": ".$bannette->nom_bannette ; 
			$action_diff_aff .= $bannette->remplir();
			$bannette->purger();
			$action_diff_aff .= "<strong>".$msg['dsi_dif_diffusion'].": ".$bannette->nom_bannette."</strong><br />" ; 
			$action_diff_aff .= $bannette->diffuser();
			break ;
		case "exporter" :
			$action_diff_aff .= "<script>window.open('./print_dsi.php?id_bannette=$bannette->id_bannette', 'Impression de DSI : $bannette->id_bannette ', 'toolbar=no, dependent=yes, width=500, height=400, resizable=yes')</script>" ; 
			break ;
	}
}

switch($suite) {
    case "search":
	case "vider" :
	case "remplir" :
	case "diffuser" :
	case "full_auto" :
	case "exporter" :
		if ($action_diff_aff) print "<h1>".$msg['dsi_dif_action_effectuee']." : </h1>".$action_diff_aff ;
		print pmb_bidi(dif_list_bannettes_full_auto("./dsi.php?categ=diffuser&sub=lancer")) ;
		break ;
	case "visualiser" :
		if ($action_diff_aff) print $action_diff_aff;
		break ;
    default:
		echo window_title($database_window_title.$msg[dsi_dif_auto]);
		print pmb_bidi(dif_list_bannettes_full_auto("./dsi.php?categ=diffuser&sub=lancer")) ;
        break;
}

