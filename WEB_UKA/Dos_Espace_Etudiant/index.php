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
        //include("connexion.php");
        include("../../Connexion_BDD/Connexion_1.php");
        
    ?>

<?php


$error_message='';


        
    if(empty($_POST['matricule'])) 
        {
        $error_message = '';
         }
 else
         {
        $matricule = htmlspecialchars($_POST['matricule']);
        $mail = htmlspecialchars($_POST['mail']);
        $motdepasse =  sha1($_POST['motdepasse']);
        $motdepasseConf = htmlspecialchars($_POST['motdepasseConf']);

        $reqmatri = $con ->prepare("SELECT * FROM etudiant WHERE Matricule=?");
        $reqmatri  -> execute(array($matricule));
        $existe = $reqmatri->rowCount();
        if ($_POST['motdepasse']!=$_POST['motdepasseConf']) 
        {
          $error_message="Mot de passe non identique";
        }
        else
        {

    if ($existe == 1) 
    {
        $reqmatri = $con ->prepare("SELECT * FROM compte_etudiant WHERE matricule=?");
        $reqmatri  -> execute(array($matricule));
        echo  " matricule ".$matricule;
        $existe = $reqmatri->rowCount();

        if ($existe == 0) 
        {
      
        $sql = "INSERT INTO compte_etudiant (matricule,Mail_etudiant,Mot_de_passe)VALUES ('$matricule','$mail','$motdepasse')" ;
        //echo " Reagarde "
        $con->exec($sql);
        isset($matricule);
        
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
      



            
        }
        else
        {
            $error_message="Un compte existe avec ce Matricule";
           
        }
    }
        else
        {
            $error_message="Matricule non attribué";
        }
    }
    }
?>
        <div class="wrapper login-1">
            <div class="container">
                <div class="col-left">
                    <div class="login-text">
                        <h2>Vous avez déjà un compte?</h2>
                        <p>Connectez vous ici</p>
                        <a class="btn" href="Se connecter.php">Connexion</a>
                    </div>
                </div>
                <div class="col-right">
                    <div class="login-form ">
                        <h2>Inscription</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <p>
                                <label>Matricule<span>*</span></label>
                                <input type="text" name="matricule" placeholder="Votre Matricule" value="<?php if(isset($matricule)){echo $matricule; } ?>">
                            </p>
                            <p>
                                <label>E-mail<span>*</span></label>
                                <input type="email" name="mail" placeholder="Votre Adresse Mail" required value="<?php if(isset($mail)){echo $mail; } ?>">
                            </p>
                            <p>
                                <label>Mot de passe<span>*</span></label>
                                <input type="password" name="motdepasse" placeholder="Mot de passe" required value="<?php if(isset($_POST['motdepasse'])){echo $_POST['motdepasse']; } ?>">
                            </p>
                            <p>
                                <label>Confirmer mot de passe<span>*</span></label>
                                <input type="password" name="motdepasseConf" placeholder="Confirmer" required value="<?php if(isset($motdepasseConf)){echo $motdepasseConf; } ?>">
                            </p>
                             
                            <p>
                                <input type="submit" name="Inscrire" value="S'Inscrire" />
                         
                            </p>
                            <p>
                                <a href="">Mot de passe oublié?</a>
                            </p>
                             </br>

                        </form>
                        <?php 
                            if (isset($error_message)) {

                                echo '<font color="#f89c0d" size="3%">'. $error_message."</form>";
                                
                            }
                         ?>
                    </div>
                    
                </div>
         
            </div>
           
        </div>
    </body>
</html>
