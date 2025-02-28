<?php
 if (@$_GET['page']) 
 { 
      if ($_GET['page']=="profil") 
      {
        header('location:Principal.php?page=Modifier');   
      }
      
      elseif($_GET['page']=="Autre")
      {
          header('location:Principal.php?page=Autre');
        
      }
 }
      
?>