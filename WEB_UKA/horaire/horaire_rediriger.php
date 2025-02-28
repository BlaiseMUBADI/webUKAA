<!DOCTYPE html>
<html  >
<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.8.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="../assets/images/logouka.jpg" type="image/x-icon">
  <meta name="description" content="">
  
  
  <title>web.uka.ac.cd</title>
  <link rel="stylesheet" href="../assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="../assets/dropdown/css/style.css">
  <link rel="stylesheet" href="../assets/socicon/css/styles.css">
  <link rel="stylesheet" href="../assets/theme/css/style.css">
  <link rel="preload" as="style" href="../assets/mobirise/css/mbr-additional.css">
  <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">

  
  
  
</head>
<body>
  
  <section data-bs-version="5.1" class="menu menu3 cid-sFAA5oUu2Y" once="menu" id="menu3-1">
    
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="container">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="index.php">
                        <img src="../assets/images/logouka.jpg" alt="" style="height: 3rem;">
                    </a>
                </span>
                <span class="navbar-caption-wrap"><a class="navbar-caption text-primary display-5" href="index.php">UKA</a></span>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
			
           <?php  include ("../MenuPrincipal.php");?>
        </div>
    </nav>
</section>

<section data-bs-version="5.1" class="header1 cid-sFCAOqBTxa" id="header1-i">

    

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(237, 245, 225);"></div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-15">
                <h1 class="mbr-section-title mbr-fonts-style mb-3 display-2"><p><strong> Horaires des Cours&nbsp;</strong></p></h2>
				<h1 class="mbr-section-title mbr-fonts-style mb-3 display-4"><p><strong> Choisir ta faculté&nbsp;</strong></p></h2>
                
                <p class="mbr-text mbr-fonts-style display-7">
				
				<?php 
		            include("Connexion.php");
	          

if (isset($_GET['modifier_news'])) // Si on demande de modifier une news.
{
// On protège la variable « modifier_news » pour éviter une faille SQL.
//$_GET['modifier_news'] = mysql_real_escape_string(htmlspecialchars($_GET['modifier_news']));
// On récupère les informations de la news correspondante.
$retour = $bdd->query('SELECT * FROM horaire WHERE Id_Horaire=\'' . $_GET['modifier_news'] . '\'');
$donnees = $retour->fetch();
// On place le titre et le contenu dans des variables simples.
$Semaine = stripslashes($donnees['Semaine']);
$Faculte = stripslashes($donnees['Faculte']);
$LAVMG1 = stripslashes($donnees['LAVMG1']);
$LAPMG1 = stripslashes($donnees['LAPMG1']);
$LAVMG2 = stripslashes($donnees['LAVMG2']);
$LAPMG2 = stripslashes($donnees['LAPMG2']);
$LAVMG3 = stripslashes($donnees['LAVMG3']);
$LAPMG3 = stripslashes($donnees['LAPMG3']);
$LAVML1 = stripslashes($donnees['LAVML1']);
$LAPML1 = stripslashes($donnees['LAPML1']);
$LAVML2 = stripslashes($donnees['LAVML2']);
$LAPML2 = stripslashes($donnees['LAPML2']);
//$LAVMD3 = stripslashes($donnees['LAVMD3']);
//$LAPMD3 = stripslashes($donnees['LAPMD3']);

$MAVMG1 = stripslashes($donnees['MAVMG1']);
$MAPMG1 = stripslashes($donnees['MAPMG1']);
$MAVMG2 = stripslashes($donnees['MAVMG2']);
$MAPMG2 = stripslashes($donnees['MAPMG2']);
$MAVMG3 = stripslashes($donnees['MAVMG3']);
$MAPMG3 = stripslashes($donnees['MAPMG3']);
$MAVML1 = stripslashes($donnees['MAVML1']);
$MAPML1 = stripslashes($donnees['MAPML1']);
$MAVML2 = stripslashes($donnees['MAVML2']);
$MAPML2 = stripslashes($donnees['MAPML2']);
//$MAVMD3 = stripslashes($donnees['MAVMD3']);
//$MAPMD3 = stripslashes($donnees['MAPMD3']);

$MeAVMG1 = stripslashes($donnees['MeAVMG1']);
$MeAPMG1 = stripslashes($donnees['MeAPMG1']);
$MeAVMG2 = stripslashes($donnees['MeAVMG2']);
$MeAPMG2 = stripslashes($donnees['MeAPMG2']);
$MeAVMG3 = stripslashes($donnees['MeAVMG3']);
$MeAPMG3 = stripslashes($donnees['MeAPMG3']);
$MeAVML1 = stripslashes($donnees['MeAVML1']);
$MeAPML1 = stripslashes($donnees['MeAPML1']);
$MeAVML2 = stripslashes($donnees['MeAVML2']);
$MeAPML2 = stripslashes($donnees['MeAPML2']);
//$MeAVMD3 = stripslashes($donnees['MeAVMD3']);
//$MeAPMD3 = stripslashes($donnees['MeAPMD3']);

$JAVMG1 = stripslashes($donnees['JAVMG1']);
$JAPMG1 = stripslashes($donnees['JAPMG1']);
$JAVMG2 = stripslashes($donnees['JAVMG2']);
$JAPMG2 = stripslashes($donnees['JAPMG2']);
$JAVMG3 = stripslashes($donnees['JAVMG3']);
$JAPMG3 = stripslashes($donnees['JAPMG3']);
$JAVML1 = stripslashes($donnees['JAVML1']);
$JAPML1 = stripslashes($donnees['JAPML1']);
$JAVML2 = stripslashes($donnees['JAVML2']);
$JAPML2 = stripslashes($donnees['JAPML2']);
//$JAVMD3 = stripslashes($donnees['JAVMD3']);
//$JAPMD3 = stripslashes($donnees['JAPMD3']);

$VAVMG1 = stripslashes($donnees['VAVMG1']);
$VAPMG1 = stripslashes($donnees['VAPMG1']);
$VAVMG2 = stripslashes($donnees['VAVMG2']);
$VAPMG2 = stripslashes($donnees['VAPMG2']);
$VAVMG3 = stripslashes($donnees['VAVMG3']);
$VAPMG3 = stripslashes($donnees['VAPMG3']);
$VAVML1 = stripslashes($donnees['VAVML1']);
$VAPML1 = stripslashes($donnees['VAPML1']);
$VAVML2 = stripslashes($donnees['VAVML2']);
$VAPML2 = stripslashes($donnees['VAPML2']);
//$VAVMD3 = stripslashes($donnees['VAVMD3']);
//$VAPMD3 = stripslashes($donnees['VAPMD3']);

$SAVMG1 = stripslashes($donnees['SAVMG1']);
$SAPMG1 = stripslashes($donnees['SAPMG1']);
$SAVMG2 = stripslashes($donnees['SAVMG2']);
$SAPMG2 = stripslashes($donnees['SAPMG2']);
$SAVMG3 = stripslashes($donnees['SAVMG3']);
$SAPMG3 = stripslashes($donnees['SAPMG3']);
$SAVML1 = stripslashes($donnees['SAVML1']);
$SAPML1 = stripslashes($donnees['SAPML1']);
$SAVML2 = stripslashes($donnees['SAVML2']);
$SAPML2 = stripslashes($donnees['SAPML2']);
//$SAVMD3 = stripslashes($donnees['SAVMD3']);
//$SAPMD3 = stripslashes($donnees['SAPMD3']);
$id_news = $donnees['Id_Horaire']; // Cette variable va servir pour se souvenir que c'est une modification.
}
else // C'est qu'on rédige une nouvelle news.
{
// Les variables $titre et $contenu sont vides, puisque c'est une nouvelle news.
$Titre_Actualite = stripslashes('');
$Semaine = stripslashes('');
$Faculte = stripslashes('');
$LAVMG1 = stripslashes('');
$LAPMG1 = stripslashes('');
$LAVMG2 = stripslashes('');
$LAPMG2 = stripslashes('');
$LAVMG3 = stripslashes('');
$LAPMG3 = stripslashes('');
$LAVML1 = stripslashes('');
$LAPML1 = stripslashes('');
$LAVML2 = stripslashes('');
$LAPML2 = stripslashes('');
$LAVMD3 = stripslashes('');
$LAPMD3 = stripslashes('');

$MAVMG1 = stripslashes('');
$MAPMG1 = stripslashes('');
$MAVMG2 = stripslashes('');
$MAPMG2 = stripslashes('');
$MAVMG3 = stripslashes('');
$MAPMG3 = stripslashes('');
$MAVML1 = stripslashes('');
$MAPML1 = stripslashes('');
$MAVML2 = stripslashes('');
$MAPML2 = stripslashes('');
$MAVMD3 = stripslashes('');
$MAPMD3 = stripslashes('');

$MeAVMG1 = stripslashes('');
$MeAPMG1 = stripslashes('');
$MeAVMG2 = stripslashes('');
$MeAPMG2 = stripslashes('');
$MeAVMG3 = stripslashes('');
$MeAPMG3 = stripslashes('');
$MeAVML1 = stripslashes('');
$MeAPML1 = stripslashes('');
$MeAVML2 = stripslashes('');
$MeAPML2 = stripslashes('');
$MeAVMD3 = stripslashes('');
$MeAPMD3 = stripslashes('');

$JAVMG1 = stripslashes('');
$JAPMG1 = stripslashes('');
$JAVMG2 = stripslashes('');
$JAPMG2 = stripslashes('');
$JAVMG3 = stripslashes('');
$JAPMG3 = stripslashes('');
$JAVML1 = stripslashes('');
$JAPML1 = stripslashes('');
$JAVML2 = stripslashes('');
$JAPML2 = stripslashes('');
$JAVMD3 = stripslashes('');
$JAPMD3 = stripslashes('');

$VAVMG1 = stripslashes('');
$VAPMG1 = stripslashes('');
$VAVMG2 = stripslashes('');
$VAPMG2 = stripslashes('');
$VAVMG3 = stripslashes('');
$VAPMG3 = stripslashes('');
$VAVML1 = stripslashes('');
$VAPML1 = stripslashes('');
$VAVML2 = stripslashes('');
$VAPML2 = stripslashes('');
$VAVMD3 = stripslashes('');
$VAPMD3 = stripslashes('');

$SAVMG1 = stripslashes('');
$SAPMG1 = stripslashes('');
$SAVMG2 = stripslashes('');
$SAPMG2 = stripslashes('');
$SAVMG3 = stripslashes('');
$SAPMG3 = stripslashes('');
$SAVML1 = stripslashes('');
$SAPML1 = stripslashes('');
$SAVML2 = stripslashes('');
$SAPML2 = stripslashes('');
$SAVMD3 = stripslashes('');
$SAPMD3 = stripslashes('');

$id_news = 0; // La variable vaut 0, donc on se souviendra que ce n'est pas une modification.
}
?>	

	  
<form action="horaire1.php" method="post">
<center>
Choisir la Faculté : 
<SELECT NAME="Faculte">
<option value="Informatique" selected>Informatique </option>
<option value="Médecine">Médecine </option>
<option value="Droit">Droit </option>
<option value="Economie">Sciences Economique et Adm des Aff. </option>
<option value="Architecture">Architecture et Construction </option>
</SELECT>
Semaine du :<input type="text" size="50" name="Semaine" maxlength="50" value="<?php echo $Semaine; ?>">
</center>
<table border=1 width=100% >
 <tr align="center"> 
    <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td> <b>L1 LMD </b></td>
	<td> <b>L2 LMD</b> </td>
	<td> <b>L3 LMD </b></td>
	<td><b> L1 Anc. Syst. </b></td>
	<td> <b>L2 Anc. Syst.</b></td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Lundi  </td>
	<td width=14% >  08h30'-12h10' </td>
	<td>   <input type="text" size="20" name="LAVMG1" maxlength="45" value="<?php echo $LAVMG1; ?> "></td>
	<td>   <input type="text" size="20" name="LAVMG2" maxlength="45" value="<?php echo $LAVMG2; ?>"></td>
	<td>   <input type="text" size="20" name="LAVMG3" maxlength="45" value="<?php echo $LAVMG3; ?> "></td>
	<td>   <input type="text" size="20" name="LAVML1" maxlength="45" value="<?php echo $LAVML1; ?> "></td>
	<td>   <input type="text" size="20" name="LAVML2" maxlength="45" value="<?php echo $LAVML2; ?> "></td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <input type="text" size="20" name="LAPMG1" maxlength="45" value="<?php echo $LAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="LAPMG2" maxlength="45" value="<?php echo $LAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="LAPMG3" maxlength="45" value="<?php echo $LAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="LAPML1" maxlength="45" value="<?php echo $LAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="LAPML2" maxlength="45" value="<?php echo $LAPML2; ?> "> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <input type="text" size="20" name="MAVMG1" maxlength="45" value="<?php echo $MAVMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="MAVMG2" maxlength="45" value="<?php echo $MAVMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="MAVMG3" maxlength="45" value="<?php echo $MAVMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="MAVML1" maxlength="45" value="<?php echo $MAVML1; ?> "> </td>
	<td>   <input type="text" size="20" name="MAVML2" maxlength="45" value="<?php echo $MAVML2; ?> "> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <input type="text" size="20" name="MAPMG1" maxlength="45" value="<?php echo $MAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="MAPMG2" maxlength="45" value="<?php echo $MAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="MAPMG3" maxlength="45" value="<?php echo $MAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="MAPML1" maxlength="45" value="<?php echo $MAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="MAPML2" maxlength="45" value="<?php echo $MAPML2; ?> "> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2>  Mercredi </td>
	<td>  0830'-12h10' </td>
	<td>   <input type="text" size="20" name="MeAVMG1" maxlength="45" value="<?php echo $MeAVMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAVMG2" maxlength="45" value="<?php echo $MeAVMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAVMG3" maxlength="45" value="<?php echo $MeAVMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAVML1" maxlength="45" value="<?php echo $MeAVML1; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAVML2" maxlength="45" value="<?php echo $MeAVML2; ?> "> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <input type="text" size="20" name="MeAPMG1" maxlength="45" value="<?php echo $MeAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAPMG2" maxlength="45" value="<?php echo $MeAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAPMG3" maxlength="45" value="<?php echo $MeAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAPML1" maxlength="45" value="<?php echo $MeAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="MeAPML2" maxlength="45" value="<?php echo $MeAPML2; ?> "> </td>
</tr>
 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <input type="text" size="20" name="JAVMG1" maxlength="45" value="<?php echo $JAVMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="JAVMG2" maxlength="45" value="<?php echo $JAVMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="JAVMG3" maxlength="45" value="<?php echo $JAVMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="JAVML1" maxlength="45" value="<?php echo $JAVML1; ?> "> </td>
	<td>   <input type="text" size="20" name="JAVML2" maxlength="45" value="<?php echo $JAVML2; ?> "> </td>
</tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
    <td>   <input type="text" size="20" name="JAPMG1" maxlength="45" value="<?php echo $JAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="JAPMG2" maxlength="45" value="<?php echo $JAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="JAPMG3" maxlength="45" value="<?php echo $JAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="JAPML1" maxlength="45" value="<?php echo $JAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="JAPML2" maxlength="45" value="<?php echo $JAPML2; ?> "> </td>
</tr>
 <tr align="center"> 
    <td rowspan=2> Vendredi  </td>
	<td>  0830'-12h10' </td>
	<td>   <input type="text" size="20" name="VAVMG1" maxlength="45" value="<?php echo $VAVMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="VAVMG2" maxlength="45" value="<?php echo $VAVMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="VAVMG3" maxlength="45" value="<?php echo $VAVMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="VAVML1" maxlength="45" value="<?php echo $VAVML1; ?> "> </td>
	<td>   <input type="text" size="20" name="VAVML2" maxlength="45" value="<?php echo $VAVML2; ?> "> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <input type="text" size="20" name="VAPMG1" maxlength="45" value="<?php echo $VAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="VAPMG2" maxlength="45" value="<?php echo $VAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="VAPMG3" maxlength="45" value="<?php echo $VAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="VAPML1" maxlength="45" value="<?php echo $VAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="VAPML2" maxlength="45" value="<?php echo $VAPML2; ?> "> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  0830'-12h10' </td>
	<td>   <input type="text" size="20" name="SAVMG1" maxlength="45" value="<?php echo $SAVMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="SAVMG2" maxlength="45" value="<?php echo $SAVMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="SAVMG3" maxlength="45" value="<?php echo $SAVMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="SAVML1" maxlength="45" value="<?php echo $SAVML1; ?> "> </td>
	<td>   <input type="text" size="20" name="SAVML2" maxlength="45" value="<?php echo $SAVML2; ?> "> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <input type="text" size="20" name="SAPMG1" maxlength="45" value="<?php echo $SAPMG1; ?> "> </td>
	<td>   <input type="text" size="20" name="SAPMG2" maxlength="45" value="<?php echo $SAPMG2; ?> "> </td>
	<td>   <input type="text" size="20" name="SAPMG3" maxlength="45" value="<?php echo $SAPMG3; ?> "> </td>
	<td>   <input type="text" size="20" name="SAPML1" maxlength="45" value="<?php echo $SAPML1; ?> "> </td>
	<td>   <input type="text" size="20" name="SAPML2" maxlength="45" value="<?php echo $SAPML2; ?> "> </td>
 </tr>
</table>
<input type="hidden" name="id_news" value="<?php echo $id_news; ?>" />
<INPUT TYPE="submit" VALUE="Envoyer">
</form> 


					
                </p>
                
            </div>
        </div>
    </div>
</section>

 

<section data-bs-version="5.1" class="footer7 cid-tVuvH1dJHp" once="footers" id="footer7-0">

    

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container">
        <div class="media-container-row align-center mbr-white">
            <div class="col-12">
                <p class="mbr-text mb-0 mbr-fonts-style display-7">
                    © <a href="../Authentification.php" style="color:#fff;">Copyright </a> | Cellule Informatique de l'UKA</p>
            </div>
        </div>
    </div>
</section>

    
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>  
    <script src="assets/ytplayer/index.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  
    <script src="assets/embla/embla.min.js"></script>  <script src="assets/embla/script.js"></script>  
    <script src="assets/theme/js/script.js"></script>  
  
  
</body>
</html>