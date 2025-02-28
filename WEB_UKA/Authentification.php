<?php
session_start();
?>


<!DOCTYPE html>
<html  >
<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.8.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logouka.jpg" type="image/x-icon">
  <meta name="description" content="">
  
  
  <title>web.uka.ac.cd</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">

  <style type="text/css">
	.page{
		width: 50%; 
		height: 70%;
		margin: auto;
		margin-bottom:10%;
		margin-top: 5px;
		padding-top: 5%;
		padding-bottom: 2%;
		border: 1px solid white; 
	}
	.page .formulaire{
		width: 50%;
		border: 1px solid black;
		margin: 0 auto;
		border-radius: 10px; 
		padding: 10px; 
		font-size: 1.2em;
		font-family: 'Palatino Linotype';
		text-align: center;
	}
	.page .formulaire form{
		width: 100%;
	}
	.page .formulaire form input[type='text'], input[type='password'], input[type='submit']{
		padding: 7px;padding-left: 10px;
		font-weight: bold;
		width: 98%;
		font-size: 1em;
		font-family: 'Palatino Linotype';
	}
	.page .formulaire input[type='submit']{
		border-radius: 10px; 
		background-color: #2ac558; 
		border: 1px solid white;
	}
	.page .formulaire input[type='submit']:hover{
		background-color: white; 
		cursor: pointer;

	}
</style>
  
  
  
</head>
<body>
  
  <section data-bs-version="5.1" class="menu menu3 cid-sFAA5oUu2Y" once="menu" id="menu3-1">
    
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="container">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="index.php">
                        <img src="assets/images/logouka.jpg" alt="" style="height: 3rem;">
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
			
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
					<li class="nav-item"><a class="nav-link link text-primary display-7" href="biblio\page1.php"><span class="socicon socicon-buffer mbr-iconfont mbr-iconfont-btn"></span>Bibliothèque Virtuelle&nbsp;</a></li>
                    <li class="nav-item"><a class="nav-link link text-primary display-7" href="www.uka.ac.cd"><span class="mobi-mbri mobi-mbri-globe-2 mbr-iconfont mbr-iconfont-btn"></span>Site UKA</a></li>
					<li class="nav-item dropdown"><a class="nav-link link text-primary dropdown-toggle display-7" href="#" data-toggle="dropdown-submenu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><span class="mobi-mbri mobi-mbri-users mbr-iconfont mbr-iconfont-btn"></span>Etudiants</a>
						<div class="dropdown-menu" aria-labelledby="dropdown-721">
							<a class="text-primary dropdown-item display-7" href="Encours.php"><span class="mobi-mbri mobi-mbri-contact-form mbr-iconfont mbr-iconfont-btn"></span>Notes Obtenues</a>
							<a class="text-primary dropdown-item display-7" href="Encours.php"><span class="mobi-mbri mobi-mbri-cash mbr-iconfont mbr-iconfont-btn"></span>Frais Académiques</a>
							<a class="text-primary dropdown-item display-7" href="Encours.php"><span class="mobi-mbri mobi-mbri-contact-form mbr-iconfont mbr-iconfont-btn"></span>Communiqués</a>
						</div>
					</li>
                    <li class="nav-item"><a class="nav-link link text-primary display-7" href="Encours.php"><span class="mobi-mbri mobi-mbri-calendar mbr-iconfont mbr-iconfont-btn"></span>Les Horaires&nbsp;</a></li></ul>
                
                
            </div>
        </div>
    </nav>
</section>

<section data-bs-version="5.1" class="header1 cid-sFCAOqBTxa" id="header1-i">
	<div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(237, 245, 225);">
	</div>
	
	<div class="container">
        <div class="row">
            <div class="col-12 col-lg-11">
                <h1 class="mbr-section-title mbr-fonts-style mb-3 display-1"><p><strong> Campus WEB&nbsp;</strong></p></h1>
                
                <p class="mbr-text mbr-fonts-style display-7">
               
				

					<div class="page">
						<div class="formulaire">
						<?php 
							include("../Connexion_BDD/Con_biblio.php");
							
							if(isset($_SESSION['Etat_connexion']) && $_SESSION['Etat_connexion'] === "vrai")
							{
								header('location:admin2.php');
							}
							else
							{
								if (isset($_POST['btnIdentifier'])) 
								{
									
									$user = $_POST['username'];
									$mot = $_POST['motpasse'];
									
									//echo $_SESSION['Etat_connexion'];

									//$requete = mysql_query("select * from compte_webmaster where Login='$user'&& MotPass='$mot'"); 
									
									$reponse = $con->query("select count(id) as nb,Login from compte_webmaster where Login='$user'&& MotPass='$mot'");
									//$cpte = mysql_num_rows($requete);
									$ligne = $reponse->fetch();
									
									if ($ligne['nb']==1)
									{
										echo "Connecté";

										
										$_SESSION['Etat_connexion'] = "vrai";
										$_SESSION['Nom_user'] = $ligne['Login'];
										header('location:admin2.php');

									} else {
										$_SESSION['Etat_connexion'] = "faux";
										$_SESSION['Nom_user'] = "Rien";
										echo "<div style='color:red; font-size:20px; font-weight:bold; font-style:italic;'>Username ou mot de passe incorrect !</div>";
									}
								}
								else
								{
									$_SESSION['Etat_connexion'] = "faux";
									$_SESSION['Nom_user'] = "Rien";
								}
							}
							
						?>
					<form method="post" action="Authentification.php">
						<input type="text" name="username" placeholder="Utilisateur" required> <br>
						<br><input type="password" name="motpasse" placeholder="mot de passe" required> <br><br>
						<input type="submit" name="btnIdentifier" value="Se connecter">
					</form>
				</p>
			</div> 
		</div>
	</div>
</section>

 
<?php 
	include("footer.php");
?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>  
    <script src="assets/ytplayer/index.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  
    <script src="assets/embla/embla.min.js"></script>  <script src="assets/embla/script.js"></script>  
    <script src="assets/theme/js/script.js"></script>  
  
  
</body>
</html>