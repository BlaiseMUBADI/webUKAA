<?php
// +-------------------------------------------------+
//  2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: addon.inc.php,v 1.1.2.16 2012-03-28 12:04:47 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

function traite_rqt($requete="", $message="") {

	global $dbh;
	$retour="";
	$res = mysql_query($requete, $dbh) ; 
	$erreur_no = mysql_errno();
	if (!$erreur_no) {
		$retour = "Successful";
	} else {
		switch ($erreur_no) {
			case "1060":
				$retour = "Field already exists, no problem.";
				break;
			case "1061":
				$retour = "Key already exists, no problem.";
				break;
			case "1091":
				$retour = "Object already deleted, no problem.";
				break;
			default:
				$retour = "<font color=\"#FF0000\">Error may be fatal : <i>".mysql_error()."<i></font>";
				break;
			}
	}		
	return "<tr><td><font size='1'>".$message."</font></td><td><font size='1'>".$retour."</font></td></tr>";
}
echo "<table>";

/******************** AJOUTER ICI LES MODIFICATIONS *******************************/

// création $pmb_bdd_subversion
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'pmb' and sstype_param='bdd_subversion' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param) 
		VALUES (0, 'pmb', 'bdd_subversion', '0', 'Sous-version de la base de données')";
	echo traite_rqt($rqt,"insert pmb_bdd_subversion=0 into parametres");
}


//DB
//modification du paramètre empr_sms_activation
$rqt = "select valeur_param from parametres where type_param= 'empr' and sstype_param='sms_activation' ";
$res = mysql_query($rqt);
if (mysql_num_rows($res)) {
	$old_value = mysql_result($res,0,0);
	if ($old_value==1) {
		$new_value='1,1,1,1';
		$rqt = "update parametres set valeur_param='".$new_value."', comment_param='Activation de l\'envoi de sms. : relance 1,relance 2,relance 3,resa\n\n 0: Inactif\n 1: Actif' where type_param= 'empr' and sstype_param='sms_activation' ";
		echo traite_rqt($rqt,"update sms_activation");
	} elseif ($old_value==0) {
		$new_value='0,0,0,0';	
		$rqt = "update parametres set valeur_param='".$new_value."', comment_param='Activation de l\'envoi de sms. : relance 1,relance 2,relance 3,resa\n\n 0: Inactif\n 1: Actif' where type_param= 'empr' and sstype_param='sms_activation' ";
		echo traite_rqt($rqt,"update empr_sms_activation");
	}
}

//DG
// comptabilisation de l'amende : à partir de la date de retour, à partir du délai de grâce
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'pmb' and sstype_param='amende_comptabilisation' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param,section_param)
		VALUES (0, 'pmb', 'amende_comptabilisation', '0','Date à laquelle le début de l\'amende sera comptabilisée \r\n 0 : à partir de la date de retour \r\n 1 : à partir du délai de grâce','')";
	echo traite_rqt($rqt,"insert pmb_amende_comptabilisation=0 into parametres");
}

// prêt en retard : compter le jour de la date de retour ou la date de relance comme un retard ?
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'pmb' and sstype_param='pret_calcul_retard_date_debut_incluse' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param,section_param)
		VALUES (0, 'pmb', 'pret_calcul_retard_date_debut_incluse', '0','Compter le jour de retour ou de relance comme un jour de retard pour le calcul de l\'amende ? \r\n 0 : Non \r\n  1 : Oui','')";
	echo traite_rqt($rqt,"insert pmb_pret_calcul_retard_date_debut_incluse=0 into parametres");
}

//modification taille du champ comment_gestion de la table bannettes
$rqt = "ALTER TABLE bannettes MODIFY comment_gestion text NOT NULL ";
echo traite_rqt($rqt,"ALTER TABLE bannettes MODIFY comment_gestion");

//modification taille du champ comment_public de la table bannettes
$rqt = "ALTER TABLE bannettes MODIFY comment_public text NOT NULL ";
echo traite_rqt($rqt,"ALTER TABLE bannettes MODIFY comment_public");
		
// localisation des prévisions
if (mysql_num_rows(mysql_query("SELECT 1 FROM parametres WHERE type_param= 'pmb' and sstype_param='location_resa_planning' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, gestion, comment_param)
			VALUES (0, 'pmb', 'location_resa_planning', '0', '0', 'Utiliser la gestion de la prévision localisée?\n 0: Non\n 1: Oui') ";
	echo traite_rqt($rqt,"INSERT location_resa_planning INTO parametres") ;
}

//Localisation par défaut sur la visualisation des états des collections
$rqt = "ALTER TABLE users ADD deflt_collstate_location int(6) UNSIGNED DEFAULT 0 after deflt_docs_location";
echo traite_rqt($rqt,"ALTER TABLE users ADD deflt_collstate_location after deflt_docs_location");

//maj valeurs possibles pour empr_filter_rows
$rqt = "update parametres set comment_param='Colonnes disponibles pour filtrer la liste des emprunteurs : \n v: ville\n l: localisation\n c: catégorie\n s: statut\n g: groupe\n y: année de naissance\n cp: code postal\n cs : code statistique\n ab : type d\'abonnement\n #n : id des champs personnalisés' where type_param= 'empr' and sstype_param='filter_rows' ";
echo traite_rqt($rqt,"update empr_filter_rows into parametres");

//maj valeurs possibles pour empr_show_rows
$rqt = "update parametres set comment_param='Colonnes affichées en liste de lecteurs, saisir les colonnes séparées par des virgules. Les colonnes disponibles pour l\'affichage de la liste des emprunteurs sont : \n n: nom+prénom \n a: adresse \n b: code-barre \n c: catégories \n g: groupes \n l: localisation \n s: statut \n cp: code postal \n v: ville \n y: année de naissance \n ab: type d\'abonnement \n #n : id des champs personnalisés \n 1: icône panier' where type_param= 'empr' and sstype_param='show_rows' ";
echo traite_rqt($rqt,"update empr_show_rows into parametres");

//maj valeurs possibles pour empr_sort_rows
$rqt = "update parametres set comment_param='Colonnes qui seront disponibles pour le tri des emprunteurs. Les colonnes possibles sont : \n n: nom+prénom \n c: catégories \n g: groupes \n l: localisation \n s: statut \n cp: code postal \n v: ville \n y: année de naissance \n ab: type d\'abonnement \n #n : id des champs personnalisés' where type_param= 'empr' and sstype_param='sort_rows' ";
echo traite_rqt($rqt,"update empr_sort_rows into parametres");

//maj commentaire sms_msg_retard
$rqt = "update parametres set comment_param='Texte du sms envoyé lors d\'un retard' where type_param= 'empr' and sstype_param='sms_msg_retard' ";
echo traite_rqt($rqt,"update empr_sms_msg_retard into parametres");

//maj commentaire afficher_numero_lecteur_lettres
$rqt = "update parametres set comment_param='Afficher le numéro et le mail du lecteur sous l\'adresse dans les différentes lettres' where type_param= 'pmb' and sstype_param='afficher_numero_lecteur_lettres' ";
echo traite_rqt($rqt,"update pmb_afficher_numero_lecteur_lettres into parametres");

//Modification du commentaire du paramètre opac_notice_reduit_format
$rqt = "update parametres set comment_param = 'Format d\'affichage des réduits de notices :\n 0 = titre+auteur principal\n 1 = titre+auteur principal+date édition\n 2 = titre+auteur principal+date édition + ISBN\n 3 = titre seul\n P 1,2,3 = tit+aut+champs persos id 1 2 3\n E 1,2,3 = tit+aut+édit+champs persos id 1 2 3\n T = tit1+tit4' where type_param='opac' and sstype_param='notice_reduit_format'";
echo traite_rqt($rqt,"update parametre opac_notice_reduit_format");

//Ajout d'un parametre permettant de préciser si l'on informe par email de l'évolution des demandes 
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'demandes' and sstype_param='email_demandes' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param, section_param, gestion) 
			VALUES (0, 'demandes', 'email_demandes', '1', 
			'Information par email de l\'évolution des demandes.\n 0 : Non\n 1 : Oui',
			'',0) ";
	echo traite_rqt($rqt, "insert demandes_email_demandes into parameters");
}

//AR - Ajout d'une colonne sur la table connectors_sources pour définir les types d'enrichissements autorisés dans une source
$rqt = "alter table connectors_sources add type_enrichment_allowed text not null";
echo traite_rqt($rqt,"alter table connectors_sources add type_enrichment_allowed");


//DB -correction origine notices
$rqt = "update notices set origine_catalogage='1' where origine_catalogage='0' ";
echo traite_rqt($rqt,"alter table notices correct origine_catalogage");

// ER - index notices.statut
$rqt = "ALTER TABLE notices DROP INDEX i_not_statut " ;
echo traite_rqt($rqt,"ALTER TABLE notices DROP INDEX i_not_statut ") ;
$rqt = "ALTER TABLE notices ADD INDEX i_not_statut (statut)" ;
echo traite_rqt($rqt,"ALTER TABLE notices ADD INDEX i_not_statut (statut)") ;

// ER : pour le gars au pull rouge
$rqt = "ALTER TABLE exemplaires MODIFY expl_cote varchar(255) ";
echo traite_rqt($rqt,"ALTER TABLE exemplaires MODIFY expl_cote varchar(255) ");
$rqt = "ALTER TABLE exemplaires MODIFY expl_cb varchar(255) ";
echo traite_rqt($rqt,"ALTER TABLE exemplaires MODIFY expl_cb varchar(255) ");

// JP : ajout tri en opac pour champs persos de notice
$rqt = "ALTER TABLE collstate_custom ADD opac_sort INT NOT NULL DEFAULT 0";
echo traite_rqt($rqt,"ALTER TABLE collstate_custom ADD opac_sort INT NOT NULL DEFAULT 0");
$rqt = "ALTER TABLE empr_custom ADD opac_sort INT NOT NULL DEFAULT 0";
echo traite_rqt($rqt,"ALTER TABLE empr_custom ADD opac_sort INT NOT NULL DEFAULT 0");
$rqt = "ALTER TABLE expl_custom ADD opac_sort INT NOT NULL DEFAULT 0";
echo traite_rqt($rqt,"ALTER TABLE expl_custom ADD opac_sort INT NOT NULL DEFAULT 0");
$rqt = "ALTER TABLE gestfic0_custom ADD opac_sort INT NOT NULL DEFAULT 0";
echo traite_rqt($rqt,"ALTER TABLE gestfic0_custom ADD opac_sort INT NOT NULL DEFAULT 0");
$rqt = "ALTER TABLE notices_custom ADD opac_sort INT NOT NULL DEFAULT 1";
echo traite_rqt($rqt,"ALTER TABLE notices_custom ADD opac_sort INT NOT NULL DEFAULT 1");

//JP : Ajout d'un paramètre permettant de choisir une navigation abécédaire ou non en navigation dans les périodiques en OPAC
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'opac' and sstype_param='perio_a2z_abc_search' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param, section_param, gestion) 
			VALUES (0, 'opac', 'perio_a2z_abc_search', '0', 
			'Recherche abécédaire dans le navigateur de périodiques en OPAC.\n0 : Non.\n1 : Oui.',
			'c_recherche',0) ";
	echo traite_rqt($rqt, "insert opac_perio_a2z_abc_search 0 into parameters");
}

//JP : Ajout d'un paramètre permettant de choisir le nombre maximum de notices par onglet en navigation dans les périodiques en OPAC 
if (mysql_num_rows(mysql_query("select 1 from parametres where type_param= 'opac' and sstype_param='perio_a2z_max_per_onglet' "))==0){
	$rqt = "INSERT INTO parametres (id_param, type_param, sstype_param, valeur_param, comment_param, section_param, gestion) 
			VALUES (0, 'opac', 'perio_a2z_max_per_onglet', '10', 
			'Recherche dans le navigateur de périodiques en OPAC : nombre maximum de notices par onglet.',
			'c_recherche',0) ";
	echo traite_rqt($rqt, "insert opac_perio_a2z_max_per_onglet 10 into parameters");
}

//DG - Modification du commentaire du paramètre opac_notice_reduit_format pour ajout format titre uniquement
$rqt = "update parametres set comment_param = 'Format d\'affichage des réduits de notices :\n 0 = titre+auteur principal\n 1 = titre+auteur principal+date édition\n 2 = titre+auteur principal+date édition + ISBN\n 3 = titre seul\n P 1,2,3 = tit+aut+champs persos id 1 2 3\n E 1,2,3 = tit+aut+édit+champs persos id 1 2 3\n T = tit1+tit4\n 4 = titre+titre parallèle+auteur principal' where type_param='opac' and sstype_param='notice_reduit_format'";
echo traite_rqt($rqt,"update parametre opac_notice_reduit_format");

//DG - Ordre des langues pour les notices
$rqt = "ALTER TABLE notices_langues ADD ordre_langue smallint(2) UNSIGNED NOT NULL DEFAULT 0";
echo traite_rqt($rqt,"ALTER TABLE notices_langues ADD ordre_langue") ;
		
/******************** JUSQU'ICI **************************************************/
/* PENSER à faire +1 au paramètre $pmb_subversion_database_as_it_shouldbe dans includes/config.inc.php */
/* COMMITER les deux fichiers addon.inc.php ET config.inc.php en même temps */

echo traite_rqt("update parametres set valeur_param='".$pmb_subversion_database_as_it_shouldbe."' where type_param='pmb' and sstype_param='bdd_subversion'","Update to $pmb_subversion_database_as_it_shouldbe database subversion.");
echo "<table>";