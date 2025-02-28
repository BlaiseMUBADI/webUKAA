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
	
	.corps
	{
	width: 100%; 
	height: auto;
	}
	

.liens{
	width: 25%;
	height: auto;
	float:left;
	border-right: 2px solid #a7a7a7;
}

.formul{
	width: 73%;
	float:left;
	margin-left:1%;
	height:700px;
	overflow:auto;
}

.liens .bouton{
	width: 90%;
	margin: auto;
	background-color: #008b0f;
	text-align: center;
	display: block;
	margin-top: 5px;
	padding: 6px;
	border-radius: 7px;
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
border:2px solid black;
margin:auto;
}
th, td
{
border:1px solid black;
}
</style>
  
  
</head>
<body>
	<?php 
		include("../Connexion_BDD/Con_biblio.php");
	?> 
	<?php 
        include("Entete_index.php");
        ?>
<section data-bs-version="5.1" class="header1 cid-sFCAOqBTxa" id="header1-i">
	<div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(237, 245, 225);">
	</div>
	<div class="container">
        <div class="row">
            <div class="col-12 col-lg-11">
				<p class="mbr-text mbr-fonts-style display-7"> </p>
				<div class="corps">
					<hr>
					<div class="liens">
						<div class="bouton"><a href="admin2.php?page=encodage">Ajouter Nouveau Livre</a></div>
						<div class="bouton"><a href="admin2.php?page=Modifier">Modifier/Supprimer un Livre</a></div>
						<div class="bouton"><a href="admin2.php?page=annonce">Publier un Communiqué</a></div>
						<div class="bouton"><a href="admin2.php?page=Horaire">Publier les Horaires de cours</a></div>
				
					</div>
					<div class="formul">
						<?php 

							if(@$_GET['page'])
							{
								$page=$_GET['page'];
								echo $page;
							}
							if(@$_GET['faculte'])
							{
								
								$variable=$_GET['faculte']; // cette variable nous permet de faire une requette dans la section incluse de modifier1
								echo " faculté ".$variable;
							}
							if(@$_GET['id_livre'])
							{
								$id_livre=$_GET['id_livre'];
							}

							switch (@$_GET['page']) 
							{
								
								case 'annonce': include('annonce.php') ; break;
								case 'annonce_rediger': include('annonce_rediger.php') ; break;
								case 'encodage': include('Bibliotheque/encodage.php') ; break;
								case 'Modifier': include('Bibliotheque/modifier2.php') ; break;
								case 'Horaire': include('Horaire/horaire1.php') ; break;
								case 'modifier2':include('Bibliotheque/modifier1.php') ; break;
								
								case 'mod': include('Bibliotheque/mod1.php'); break;						
								case 'sup': include('Bibliotheque/sup.php') ; break;
								
								default:include('Bibliotheque/encodage.php') ; break;
								break;
							}
							
						?>
					</div>
				</div>
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