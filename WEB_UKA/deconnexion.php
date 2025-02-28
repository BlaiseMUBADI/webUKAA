
<?php
session_start();
  


    if(isset($_SESSION['Etat_connexion']))
    {    
        if($_SESSION['Etat_connexion']=="vrai")
        {
            $_SESSION = array();
            session_destroy();
            $_SESSION['Etat_connexion'] = "faux";

            header('location:Authentification.php');
            
        } 
        else
        {
            header('location:Authentification.php');
            
        } 
    }
    else 
    {
        header('location:Authentification.php');
        //echo "aucune session créée";
    }

?>