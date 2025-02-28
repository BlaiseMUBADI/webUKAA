

<?php 

if(!isset($_SESSION['user'])) {
    header('location: Se connecter.php');
    exit;
}
?>
<?php

    $sql = $con->prepare("SELECT * FROM compte_etudiant WHERE Matricule=?");
    $sql->execute((array($_SESSION['user']['Matricule'])));
    $resultat = $sql->fetchAll(PDO::FETCH_ASSOC);                           
                             

foreach ($resultat as $lign) 
    { 
        $mail = $lign['Mail_etudiant'];
        $matricule = $lign['Matricule'];       
    }     
 
   

?>

    <!--script src="process.js"></script-->


   <div class="container-fluid width 10% mt-5">

        <div class="row">
              <div class="col-md-16">
                <div class="card">
                  <div class="card-body" style="overflow: auto;">

                        
        <center>
              

              <?php   echo "Adresse E-Mail : ".$mail."<br>" ;
                      $stmt = $con->prepare("SELECT Photo,Type_image FROM photo WHERE Matricule = :Matr order by IdImage Desc limit 0,1 ");
                      $stmt->bindParam(':Matr', $_SESSION['user']['Matricule']);
                      $stmt->execute();
                      

                      if ( $_SESSION['user']['imageexiste']!=0) {

                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      $image = $row['Photo'];
                      $type_doc= $row['Type_image'];
                      echo '<br/>';
                    
                      echo '<img src="data:Image/$type_doc;base64,' . base64_encode($image) . '" alt="Image" style="width: 200px; height: 200px; border-radius: 40px;">';
                    }
                    else
                    {
                      echo'<img src="image/Profil.png"  style="width: 100px; height: 100px;"  >'; 

                    }
              ?>
              
                 <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
              
              <table style="overflow: auto";>
            
                <div class="input-group mb-3">
                  <tr><td colspan=2 class="text-center"><h3> Changer le mot de passe</h3></td></tr>
                  <tr>
                 
                   
                    <td colspan=2>
                    <input type="password" class="form-control" name="AncienPw" placeholder="Saisir ancien Mot de Passe" >
                    </td>
                  </tr>
                    <tr>
                      <td></td>
                      <td></td>
                    </tr>
                    
                </div>
                <div class="input-group mb-3">
                <tr>
                 
                  <td colspan=2>
                  <input type="password" class="form-control" name="motdepasse" placeholder="Nouveau Mot de Passe" >
                  </td>
                </tr>   
                <tr>
                      <td></td>
                      <td></td>
                    </tr>
                    
                </div>
                <div class="input-group mb-3">
                  <tr>
                    <td colspan=2>
                    <input type="password" class="form-control" name="motdepasseConf" placeholder="Confirmer Mot de Passe" >
                    </td>
                  </tr>
                  <tr>
                      <td></td>
                  </tr>
                  <tr>                   
                    <td colspan="2">
                    <center><input type="submit" class="form-control btn btn-success btn-sm" name="motsecre" value="Modifier le mot de passe"></center>  
                    </td>
                  </tr>
                  <tr><td>.</td></tr>
                </div>                    
                  <tr><td colspan=2 class="text-center"><h3> Changer la Photo de Profil</h3></td>
                </tr>
                  <tr>                                    
                     <td colspan=2>                                                   
                     <input type="file" name="Imageprofil" class="form-control"  onchange="previewImage(event)" accept="image/*">                                           
                      <center>
                        <img id="preview" src="#" alt="Image preview" style="display:none; height: 10rem; width: 10rem; border-radius: 8px; mt-2">
                       </center>
                            <script>
                        function previewImage(event)
                        {
                          console.log("dans la fonction");
                          var reader = new FileReader();
                          reader.onload = function () {
                            var preview = document.getElementById('preview');
                            preview.src = reader.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }
                    </script>

                     </td> 
                </tr>
                <tr><td>.</td></tr>
                  <tr>   
                    <td colspan=2>                   
                      <center><input type="submit" class="form-control btn btn-success btn-sm" name="Photoprof" value="Modifier la Photo"></center>  
                    </td>     
                  </tr> 
                  <div class="input-group mb-3">
                    <tr><td>.</td></tr>
                <tr><td colspan=2 class="text-center"><h3>Changer votre Adresse E-mail</h3></td></tr>
                  <tr>                         
                          <td colspan=2>
                              <input type="email" class="form-control" name="Mail" placeholder="Nouveau E-mail" >
                          </td>
                  </tr> 
                        <tr > 
                          <td colspan=2>
                           
                      <center><input type="submit" class="form-control btn btn-success btn-sm" name="Adressemail" value="Valider Nouveau E-Mail"></center>  

                          </td> 
                        </tr>

                      </table>     
                <form>
        
          </center>
                   
                      </div>
                </div>
              </div>
        </div>

   </div>

<?php
//Modification du mot de passe utiisateur
  if(isset($_POST['motsecre'])) 
    {

        $test = 1;
        if(empty($_POST['AncienPw'])) 
        {
          $test = 0;
          echo "<script langage= javascript>
          alert('Vous devez saisir l\'Ancien mot de passe');
          </script>";
          
        }
        elseif(!empty($_POST['AncienPw']))
        {
          if (sha1($_POST['AncienPw'])!=($_SESSION['motdepasse']['Mot_passe']))
          {
            echo "<script langage= javascript>
            alert('L\'Ancien mot de passe saisi est incorrect');
            </script>";
            //echo "Mot de passe".$_SESSION['Identite']['Mot_passe'];
          }
          else
          {
        if(empty($_POST['motdepasse'])) 
          {
            $test = 0;
            echo "<script langage= javascript>
            alert('Vous devez saisir le nouveau mot de passe');
            </script>";
          }

         else 
          {    
            if(sha1($_POST['motdepasseConf'])!= sha1($_POST['motdepasse'])) 
            { 
              echo "<script langage= javascript>
              alert('Leux deux mots de passe ne sont pas identiques');
              </script>";
            }
            else {
            $_SESSION['user']['Mot_de_passe'] = sha1($_POST['motdepasse']);          
            $sql = $con->prepare("UPDATE compte_etudiant SET Mot_de_passe=? WHERE Matricule=?");
            $sql->execute(array (sha1($_POST['motdepasse']),$_SESSION['user']['Matricule']));

            echo "<script langage= javascript>
            alert('Votre mot de passe a été mis à jour avec succès');
            </script>";
            echo '<script langage= javascript>
            window.location.href="redit.php?page=profil"
            </script> ';
            }
          }
        
        }
      }
    } 
 //Modification de la photo de profil
          
            if(isset($_POST['Photoprof'])) 
                {
                  
        if(isset($_FILES['Imageprofil']) && $_FILES['Imageprofil']['error'] == 0)
            {  
                  $stmt = $con->prepare("INSERT INTO photo (Matricule ,Nom_image,Type_image, Photo) VALUES (?, ?, ?, ?)");
                  $stmt->execute(array($_SESSION['user']['Matricule'],$_FILES["Imageprofil"]["name"],$_FILES["Imageprofil"]["type"],file_get_contents($_FILES["Imageprofil"]["tmp_name"]) ));
                  echo '<br/>';
                  echo "<script langage= javascript>
                        alert('Votre photo de profil a été modifiée avec succès');
                        </script> ";
              
                  echo '<script langage= javascript>
                        window.location.href="redit.php?page=profil"
                        </script> ';
              } 
        else
            {
                echo "Une erreur s'est produite lors du téléchargement du fichier.";
            }
                
        } 
    
        //Modification de l'adresse Mail
        if(isset($_POST['Adressemail'])) 
        {
    
            $test = 1;
    
            if(empty($_POST['Mail'])) 
              {
                $test = 0;
                echo "<script langage= javascript>
                alert('Vous devez saisir une adresse mail');
                </script>";
              }
    
            else 
              {               
                $sql = $con->prepare("UPDATE compte_etudiant SET Mail_etudiant=? WHERE Matricule=?");
                $sql->execute(array (($_POST['Mail']),$_SESSION['user']['Matricule']));
    
                echo "<script langage= javascript>
                alert('Votre Adresse mail a été mis à jour avec succès');
                </script>";
                echo '<script langage= javascript>
                window.location.href="redit.php?page=profil"
                </script> ';
              }
        } 
   
  ?>
