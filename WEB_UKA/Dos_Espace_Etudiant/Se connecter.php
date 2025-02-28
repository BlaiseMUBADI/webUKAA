<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Inscription</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Login Form Template" name="keywords">
        <meta content="Login Form Template" name="description">

        <!-- Favicon -->
        <link href="img/toto.ico" rel="icon">

        <!-- Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php 
   session_start();
   include("../../Connexion_BDD/Connexion_1.php");     
   //include("connexion.php");
        
    ?>

<?php


$msgerreur='';  

  if(isset($_POST['Inscrire'])) 
  {
        $matricule = htmlspecialchars($_POST['matricule']);
        $motdepasse =  ($_POST['motdepasse']);

        $sql = $con->prepare("SELECT * FROM compte_etudiant WHERE matricule=?");
        $sql->execute(array($matricule));
        $totale = $sql->rowCount();    
        $resultat = $sql->fetchAll(PDO::FETCH_ASSOC); 
        foreach($resultat as $ligne) 
        {
            $ligne_motdepasse = $ligne['Mot_de_passe'];
        }   
        if($totale==0) 
        {
            $msgerreur .= 'Matricule invalide<br>';
        } 
        else 
        {              
            if( $ligne_motdepasse != sha1($motdepasse) ) {
                $msgerreur .= 'Mot de passe invalide<br>';
            } 
            else 
            {       
              $_SESSION['user'] = $ligne;
              header('location:Principal.php?page=Situation');
             
            }
        }
     } 

?>
        <div class="wrapper login-1">
            <div class="container">
                <div class="col-left">
                    <div class="login-text">
                        <h2>Vous n'avez pas un compte?</h2>
                        <p>Cliquer ici bas</p>
                         <a class="btn" href="index.php">Créer un compte</a>
                    </div>
                </div>
                <div class="col-right">
                    <div class="login-form">
                        <h2>Connexion</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                           <?php 
                            if (isset($msgerreur)) {

                                echo '<font color="#f89c0d" size="3%" font-weight:bold;>'. $msgerreur."</font>";
                                
                            }
                         ?> <br>
                            <p>
                                <label>Matricule<span>*</span></label>
                                <input type="text" name="matricule" placeholder="Votre Matricule" value="<?php if(isset($matricule)){echo $matricule; } ?>">
                            </p>
                     
                            <p>
                                <label>Mot de passe<span>*</span></label>
                                <input type="password" name="motdepasse" placeholder="Mot de passe" required value="<?php if(isset($_POST['motdepasse'])){echo $_POST['motdepasse']; } ?>">
                            </p>
              
                             
                            <p>
                                <input type="submit" name="Inscrire" value="Se connecter"/>
                         
                            </p>
                            <p>
                                <a href="">Mot de passe oublié?</a>
                            </p>
                             </br>

                </form>
                      
                
                    </div>
                </div>
            </div>
           
        </div>
    </body>
</html>
