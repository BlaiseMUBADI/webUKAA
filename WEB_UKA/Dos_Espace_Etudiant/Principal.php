<?php session_start();?>

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

 
  
  
</head>
<body>
<?php
    include("../../Connexion_BDD/Connexion_1.php");
    //include("connexion.php");
      ?>
              
            </div>
  <section data-bs-version="5.1" class="menu menu3 cid-sFAA5oUu2Y" once="menu" id="menu3-1">
    
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="container">
            <div class="navbar-brand">
                <span class="navbar-logo ">
        <?php
               if(!isset($_SESSION['user'])) {
                header('location: Se connecter.php');
                exit;
            }
          
                $sql = $con->prepare("SELECT * FROM compte_etudiant WHERE Matricule=?");
                $sql->execute((array($_SESSION['user']['Matricule'])));
                $resultat = $sql->fetchAll(PDO::FETCH_ASSOC);                           
                foreach ($resultat as $ligne) 
                { 
                    //Selection du mot de passe pour comparaison à la modification
                $_SESSION['motdepasse']['Mot_passe']=$ligne['Mot_de_passe'];
                $Matr = $ligne['Matricule'];
                $sqlidentite = $con->prepare("SELECT UPPER(Nom) as NomEtudiant,
                                CONCAT(UPPER(SUBSTRING(Postnom,1, 1)),
                                LOWER(SUBSTRING(Postnom, 2))) AS Pnom,
                                CONCAT(UPPER(SUBSTRING(Prenom,1, 1)),
                                LOWER(SUBSTRING(Prenom, 2))) AS prenom, 
                                Sexe,
                                LieuNaissance, DateNaissance
                                FROM etudiant WHERE Matricule=?");
                
                $sqlidentite->execute((array($_SESSION['user']['Matricule'])));
                $identite = $sqlidentite->fetchAll(PDO::FETCH_ASSOC);                           

                foreach ($identite as $lign) 
                    { 
                        
                        $nom = $lign['NomEtudiant']; $postnom = $lign['Pnom']; $prenom = $lign['prenom'];   
                        $_SESSION['Identite']=$lign;    
                    } 
                    //Selection id année, code promo et année etude 
                   
                    $sqlidentite = $con->prepare("SELECT passer_par.Code_Promotion, passer_par.idAnnee_academique,promotion.Libelle_promotion, 
                    annee_academique.Annee_debut, annee_academique.Annee_fin 
                    FROM passer_par, annee_academique, promotion 
                    WHERE 
                        passer_par.Etudiant_Matricule=? 
                    AND 
                        passer_par.idAnnee_academique=annee_academique.idAnnee_Acad 
                    AND
                        passer_par.Code_Promotion=promotion.Code_Promotion
                    ORDER BY 
                        annee_academique.Annee_debut DESC LIMIT 0,1");

                    $sqlidentite->execute((array($_SESSION['user']['Matricule'])));
                    $identite = $sqlidentite->fetchAll(PDO::FETCH_ASSOC);                           
    
                    foreach ($identite as $rows) 
                        {                                                     
                            $_SESSION['AnneeEtude']=$rows;    
                        } 
                        //selection libellé frais et montant

                         

                }
            try {
                    $reqmatri = $con ->prepare("SELECT * FROM photo WHERE Matricule=?");
                      $reqmatri  -> execute(array($_SESSION['user']['Matricule']));
                      $existe = $reqmatri->rowCount();
                      $_SESSION['user']['imageexiste']=$existe;
                      if ($existe != 0) 
                      {
              
               
                 $stmt = $con->prepare("SELECT Photo,Type_image FROM photo WHERE Matricule = :Matr order by IdImage Desc limit 0,1" );
                      $stmt->bindParam(':Matr', $_SESSION['user']['Matricule']);
                      $stmt->execute();
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      $image = $row['Photo'];
                      $type_doc= $row['Type_image'];
                      echo '<br/>';
                      echo '<img src="data:image/$type_doc;base64,' . base64_encode($image) . '" alt="Image" style=" height: 6rem; border-radius: 40px;" >'; 
                      
                    }
                    else
                    {
                      echo'<img src="image/Profil.png"  style=" height: 4rem; border-radius: 40px;" >'; 
                    } 
                  } 
                  catch (Exception $e) 
                  {
                      //echo'<img src="image/alumni4.png"  style=" height: 4rem; border-radius: 40px;" >'; 
                      //echo "Ajouter une photo";
                } 
              

                       ?> 
                  
                  
                  <!--<img src="assets/images/logouka.jpg" alt="" style="height: 3rem;">-->
                   
                </span>
                
                <span class="navbar-caption-wrap fw-bold" style="color:#110973 ; font-family:Candara;">
                    <?php 
                    //Affichage du profil utilisateur
                    echo $Matr. '<br>'; 
                    echo $nom." ".$postnom." ".$prenom.'<br>';
                    echo "Année Acad: ".$_SESSION['AnneeEtude']['Annee_debut']."-".$_SESSION['AnneeEtude']['Annee_fin'].'<br>';
                    echo "En ".$_SESSION['AnneeEtude']['Libelle_promotion'];
                    ?></span>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
		<?php	
           
        include("Menu.php");?>
			
			
			
			
        </div>
    </nav>
</section>

<section data-bs-version="5.1" class="header1 cid-sFCAOqBTxa" id="header1-i">

    

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(237, 245, 225);"></div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-11">
                <?php
                 if (@$_GET['page']) 
                 { 
                      if ($_GET['page']=="Modifier") 
                      {
                      
                     include("ModifierProfil.php");
                    
                      }
                      elseif ($_GET['page']=="Situation")
                      {
                        
                        include("Situation.php");
                        
                      }
                      elseif ($_GET['page']=="Autre")
                      {
                        include("AutresInfo.php");
                        
                      }
                      elseif ($_GET['page']=="Cursus")
                      {
                        include("Cursus.php");
                        
                      }
                      elseif ($_GET['page']=="Mes_cotes")
                      {
                        include("Mes_cours.php");
                        
                      }
                 }
                      
                ?>
               
                
           
                
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

    
    <script type="text/javascript" src="js/AfficherSituation.js"></script>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>  
    <script src="assets/ytplayer/index.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  
    <script src="assets/embla/embla.min.js"></script>  <script src="assets/embla/script.js"></script>  
    <script src="assets/theme/js/script.js"></script>  
  
  
</body>
</html>