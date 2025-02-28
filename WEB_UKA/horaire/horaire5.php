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
		            include("../biblio/Connexion.php");
	            ?>  
	
	
	<style type="text/css">
	
	.corps
	{
	width: 100%; 
	height: auto;
	}
	

.liens{
	height: auto;
	border-bottom: 2px solid #a7a7a7;
	padding-bottom:1%;
}

.formul{
	margin-left:1%;
	height:auto;
}

.liens .bouton{
	width: 13%;
	margin: auto;
	background-color: #008b0f;
	text-align: center;
	display: inline-block;
	margin-top: 5px;
	padding: 6px;
	border-radius: 7px;
	font-size:1em;
}

.buton{
	width: 90%;
	margin: auto;
	background-color: #00a0e8;
	text-align: center;
	display: block;
	margin-bottom: 5px;
	padding: 6px;
	border-radius: 7px;
}
.buton a
{
color:#fff;
font-size:1.1em;
}

.liens .bouton:hover{
	background-color: #09aa00;
}
.liens .bouton a{
	color: white;
	text-decoration: none;
}
.liens .bouton a:hover{
	font-weight: bold;
}



.formul form{
	width: 90%; 
	height: auto;
	margin-top: 20px;
	margin: auto;
	padding: 5px;
	box-shadow: 1px 1px 15px #d9d9d9; 
	font-family: Tahoma; 
}
.formul form input[type="submit"]{
	width: 98%; 
	background-color: #00840d; 
	padding: 7px;
	color: white;
	border-radius: 10px;
}
.formul form input[type="submit"]:hover{
	font-weight: bold;
	background-color: #00b70e;
	cursor: pointer;
}

h2, th, td
{
text-align:center;
}
table
{
border-collapse:collapse;
border:2px solid blue;
margin:auto;
}
th, td
{
border:1px solid black;
}
</style>			


<div class="corps">
			<div class="liens">
				<div class="bouton"><a href="horaire.php?page=Médecine">Médecine</a></div>
				<div class="bouton"><a href="horaire.php?page=Informatique">Informatique</a></div>
				<div class="bouton"><a href="horaire.php?page=Droit">Droit</a></div>
				<div class="bouton"><a href="horaire.php?page=Economie">Economie</a></div>
				<div class="bouton"><a href="horaire.php?page=Architecture">Architecture</a></div>
				<div class="bouton"><a href="horaire.php?page=Communication">Communication</a></div>
				<div class="bouton"><a href="horaire.php?page=Communication">Polytechnique</a></div>
			</div>
		
			<div class="formul">
				<?php 
					switch (@$_GET['page']) 
					{
						case 'Médecine': include('Horaire_Info.php') ; break;
						case 'Informatique': include('Horaire_Info.php') ; break;
						case 'Droit': include('Horaire_Info.php') ; break;
						case 'Economie': include('Horaire_Info.php') ; break;
						case 'Communication': include('Horaire_Info.php') ; break;
						case 'Architecture': include('Horaire_Info.php') ; break;
						default: echo "<center> Selectionnez une Faculté </center>";
						break;
					}
				?>
			</div>
		</div>


					
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
                    © <a href="Authentification.php" style="color:#fff;">Copyright </a> | Cellule Informatique de l'UKA</p>
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