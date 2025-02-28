<!--<div class="container mt-4">
  <div class="row">
    <div class="col-md-8">
      <div class="card">-->

        <table class="mt-4">
          <form action="" method="POST">
            <tr>
                <td colspan=2><span class="input-group-text">Completez les informations</span></td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Nom</span>
              </td>
              <td>
                <input type="text" class="form-control" name="nom"  placeholder="Nom Etudiant"  value="<?php if(!isset($_SESSION['Identite'])){echo "Nom Etudiant";}else{echo $_SESSION['Identite']['NomEtudiant']; } ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Postnom</span>
              </td>
              <td>
                <input type="text" class="form-control" name="postnom" placeholder="Postnom" value="<?php if(!isset($_SESSION['Identite'])){echo "Postnom";}else{echo $_SESSION['Identite']['Pnom']; } ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Prénom</span>
              </td>
              <td>
                <input type="text" class="form-control" name="prenom" placeholder="Prénom" value="<?php if(!isset($_SESSION['Identite'])){echo "Prénom";}else{echo $_SESSION['Identite']['prenom']; } ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Sexe</span>
              </td>
              <td>
                <select type="text" class="form-control" name="sexe">
                  <option value="<?php echo $_SESSION['Identite']['Sexe'];?>" selected><?php if(!isset($_SESSION['Identite'])){echo "Sexe";}else{echo $_SESSION['Identite']['Sexe']; } ?></option>
                  <option value="M">M</option>
                  <option value="F">F</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Lieu de Naiss</span>
              </td>
              <td>
                <input type="text" class="form-control" name="LieuNaiss"  placeholder="Lieu de Naissance" value="<?php echo $_SESSION['Identite']['LieuNaissance']; ?>">
              </td>
            </tr> 
            <tr>
              <td>
                <span class="input-group-text">Date</span>
              </td>
              <td>
                <input type="date" class="form-control" name="DateNaiss"  value="<?php $date=date('Y-m-d'); if(!isset($_SESSION['Identite']['DateNaissance'])){echo $date;}else{ echo  date('Y-m-d', strtotime($_SESSION['Identite']['DateNaissance']));} ?>">
              </td>
            </tr>   
                
              
              <!--- Selection autres informations existantes dans la base de données-->
              <?php

              $sqlidentite = $con->prepare("SELECT * FROM autreinfo_etudiant WHERE Matricule=?");
              $sqlidentite->execute((array($_SESSION['user']['Matricule'])));
              $identite = $sqlidentite->fetchAll(PDO::FETCH_ASSOC);                           
              foreach ($identite as $lign) 
              {     
                  $_SESSION['Etudiant']=$lign;    
              }   
              ?>


            <tr>
              <td>
                <span class="input-group-text">Religion</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Religion" placeholder="Religion" value="<?php echo $_SESSION['Etudiant']['Religion']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Nationalité</span>
              </td>
              <td>
                <input type="text" class="form-control"name="Nationalite" placeholder="Nationalité" value="<?php echo $_SESSION['Etudiant']['Nationalite']; ?>">
              </td>
            </tr>  
            <tr>
              <td>
                <span class="input-group-text">Etat Civil</span>
              </td>
              <td>
                <select type="text" class="form-control" name="EtatCivil" >
                  <option value="Marié">Marié</option>
                  <option value="Célibataire">Célibataire</option>
                  <option value="<?php echo $_SESSION['Etudiant']['EtatCiv'];?>"selected><?php if(!isset($_SESSION['Etudiant'])){echo "Etat civil";}else{echo $_SESSION['Etudiant']['EtatCiv']; } ?></option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Nom du Père</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Nompere" placeholder="Nom du Père" value="<?php echo $_SESSION['Etudiant']['NomPere']; ?>">
              </td>
            </tr> 
            <tr>
              <td>
                <span class="input-group-text">Profession Père</span>
              </td>
              <td>
              <input type="text" class="form-control"name="ProfPere" value="<?php echo $_SESSION['Etudiant']['ProfPere']; ?>">
              </td>
            </tr>  
            <tr>
              <td>
                <span class="input-group-text">Nom de la Mère</span>
              </td>
              <td>
                <input type="text" class="form-control"name="NomMere" value="<?php echo $_SESSION['Etudiant']['NomMere']; ?>">
              </td>
            </tr>    
            <tr>
              <td>
                <span class="input-group-text">Profession Mère</span>
              </td>
              <td>
              <input type="text" class="form-control"name="ProfMere" value="<?php echo $_SESSION['Etudiant']['ProfMere']; ?>">
              </td>
            </tr> 
            
            <tr>
              <td>
              <span class="input-group-text">Adresse Physique</span>
              </td>
              <td>
              <input type="text" class="form-control"name="Adresse" value="<?php echo $_SESSION['Etudiant']['AdresseActuelle'];?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Paroisse</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Paroisse" value="<?php echo $_SESSION['Etudiant']['Paroisse']; ?>">
              </td>
            </tr>     
            <tr>
              <td>
                <span class="input-group-text">Diocèse</span>
              </td>
              <td>
                <input type="text" class="form-control"name="Diocese" value="<?php echo $_SESSION['Etudiant']['Diocese']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Tél Voda</span>
              </td>
              <td>
                <input type="text" class="form-control"name="TelVoda" value="<?php echo $_SESSION['Etudiant']['TelVoda']; ?>">
              </td>
            </tr> 
            <tr>
              <td>
                <span class="input-group-text">Tél Orange</span>
              </td>
              <td>
                <input type="text" class="form-control"name="TelOrange" value="<?php echo $_SESSION['Etudiant']['TelOrange']; ?>">
              </td>
            </tr>     
            <tr>
              <td>
                <span class="input-group-text">Tél Aitel</span>
              </td>
              <td>
                <input type="tel" class="form-control" name="TelAirtel" value="<?php echo $_SESSION['Etudiant']['TelAirtel']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Année 6ème Primaire</span>
              </td>
              <td>
                <input type="text" class="form-control" name="AnneeP"
                  <?php
                  if(!isset($_SESSION['Etudiant']['Annscol']))
                  {
                    ?>
                    placeholder="Ex: 2015-2016"
                    <?php
                  }
                  else
                  {
                    ?>
                  value="<?php echo $_SESSION['Etudiant']['Annscol']; ?>"
                    <?php
                  }
                  ?>>
              </td>
            </tr>   
            
            <tr>
              <td>
              <span class="input-group-text">Nom Etablissement</span>
              </td>
              <td>
                <input type="text" class="form-control"name="EtabP" value="<?php echo $_SESSION['Etudiant']['NomEtablis']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">% Certificat</span>
              </td>
              <td>
                <input type="tel" class="form-control"name="Pourc6P" 
                <?php
                if(!isset($_SESSION['Etudiant']['PourceCertificat']))
                {
                  ?>
                  placeholder="Exemple 70"
                  <?php
                }
                else
                {
                  ?>
                value="<?php echo $_SESSION['Etudiant']['PourceCertificat']; ?>"
                  <?php
                }
                ?>>
              </td>
            </tr>    
            <tr>
              <td>
                <span class="input-group-text">% Diplôme</span>
              </td>
              <td>
                <input type="text" class="form-control"name="PourcDiplome"
                <?php
                if(!isset($_SESSION['Etudiant']['PourceDiplome']))
                {
                  ?>
                  placeholder="Exemple 60"
                  <?php
                }
                else
                {
                  ?>
                value="<?php echo $_SESSION['Etudiant']['PourceDiplome']; ?>"
                  <?php
                }
                ?>  maxlength="2">
              </td>
            </tr>   
            <tr>
              <td>
                <span class="input-group-text">N° Diplôme</span>
              </td>
              <td>
                <input type="text" class="form-control"name="NumDiplome" value="<?php echo $_SESSION['Etudiant']['NumDiplom']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Section</span>
              </td>
              <td>
                <input type="tel" class="form-control"name="Section" value="<?php echo $_SESSION['Etudiant']['SetionEtude']; ?>">
              </td>
            </tr>   
            <tr>
              <td>
              <span class="input-group-text">Option</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Option" value="<?php echo $_SESSION['Etudiant']['OptionEtude']; ?>">
              </td>
            </tr>    
            <tr>
              <td>
                <span class="input-group-text">Lieu délivrance</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Lieu" value="<?php echo $_SESSION['Etudiant']['Lieudelivrance']; ?>">
              </td>
            </tr>
            <tr>
              <td>
                <span class="input-group-text">Date de délivrance</span>
              </td>
              <td>
                <input type="date" class="form-control" name="Datedel" value="<?php $date = date('Y-m-d'); if(!isset($_SESSION['Etudiant']['Datedelivrance'])){echo $date;}else{  echo  date('Y-m-d', strtotime($_SESSION['Etudiant']['Datedelivrance']));} ?>" >
              </td>
            </tr>   
            <tr>
              <td>
                <span class="input-group-text">Nom Etablissement</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Ecole" value="<?php echo $_SESSION['Etudiant']['Ecole']; ?>">
              </td>
            </tr>    
            <tr>
              <td>
                <span class="input-group-text">Prov. d'Obt.</span>
              </td>
              <td>
                <select type="text" class="form-control" name="Prov">
                  <option value="<?php echo $_SESSION['Etudiant']['Province']; ?>" selected><?php echo $_SESSION['Etudiant']['Province']; ?> </option>
                  <option value="Kasai central">Kasai central</option>
                  <option value="Kinshasa">Kinshasa</option>
                </select>
              </td>
            </tr> 
            <tr>
              <td>
                <span class="input-group-text">Province d'Org.</span>
              </td>
              <td>
                <select type="text" class="form-control" name="ProvO">
                  <option value="<?php echo $_SESSION['Etudiant']['ProvinceOrigine']; ?>" selected><?php echo $_SESSION['Etudiant']['ProvinceOrigine']; ?> </option>
                  <option value="Kasai central">Kasai central</option>
                  <option value="Kinshasa">Kinshasa</option>
                  <option value="Haut Katanga">Haut Katanga</option>
                </select>
              </td>
            </tr>    
            <tr>
              <td>
                <span class="input-group-text">Territoire</span>
              </td>
              <td>
                <input type="text" class="form-control" name="Territoire" value="<?php echo $_SESSION['Etudiant']['Territoire']; ?>">
              </td>
            </tr>
            <tr>
              <td>
              <span class="input-group-text">Tél Responsable</span>
              </td>
              <td>
                <input type="text" class="form-control" name="TelResp" value="<?php echo $_SESSION['Etudiant']['TelResponsable']; ?>">
              </td>
            </tr>
            <tr>
              <td colspan=2><input type="submit" class="form-control btn btn-success btn-sm" name="Send" value="Enregistrer"></td>
            </tr>
                
          </form>
        </table>

 <!--     </div>
    </div>
  </div>
</div> -->
        <?php
        if (isset($_POST['Send']))
        { 
            $sql = "UPDATE etudiant SET Nom = :Nom, Postnom=:postnom, 
            Prenom=:prenom, Sexe=:sexe, LieuNaissance=:lieu, DateNaissance=:datnais WHERE Matricule = :matricule";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':Nom', $_POST['nom']);
            $stmt->bindParam(':postnom', $_POST['postnom']);
            $stmt->bindParam(':prenom', $_POST['prenom']);
            $stmt->bindParam(':sexe', $_POST['sexe']);
            $stmt->bindParam(':lieu', $_POST['LieuNaiss']);
            $stmt->bindParam(':datnais', $_POST['DateNaiss'], PDO::PARAM_STR);
            $stmt->bindParam(':matricule', $_SESSION['user']['Matricule']);
            
        //Mofication Autres information etudiant
            $req = "UPDATE autreinfo_etudiant SET 
              Religion=:religion, 
              Nationalite=:nationalite, 
              EtatCiv=:etatCiv, 
              NomPere=:NomPere, 
              ProfPere=:ProfPere, 
              NomMere=:NomMere, 
              ProfMere=:ProfMere, 
              AdresseActuelle=:Adresse, 
              Paroisse=:Paroisse,
              Diocese=:Diocese, 
              TelVoda=:TelVoda, 
              TelOrange=:TelOrange, 
              TelAirtel=:TelAirtel,           
              Annscol=:Annsco, 
              NomEtablis=:NomEtabli,
              PourceCertificat=:PourceCertificat,
              PourceDiplome=:PourceDiplome,
              NumDiplom=:NumDiplom, 
              SetionEtude=:SetionEtude,
              OptionEtude=:OptionEtude, 
              Lieudelivrance=:Lieudelivrance,

              Datedelivrance=:Datedelivrance,
              Ecole=:Ecole,
              Province=:Province,
              ProvinceOrigine=:ProvinceOrigine,
              Territoire=:Territoire,
              TelResponsable=:TelResponsable


              WHERE Matricule =:matricule";

            $stmt1 = $con->prepare($req);
            $stmt1->bindParam(':religion', $_POST['Religion']);
            $stmt1->bindParam(':nationalite', $_POST['Nationalite']);
            $stmt1->bindParam(':etatCiv', $_POST['EtatCivil']);
            $stmt1->bindParam(':NomPere', $_POST['Nompere']);
            $stmt1->bindParam(':ProfPere', $_POST['ProfPere']);
            $stmt1->bindParam(':NomMere', $_POST['NomMere']);
            $stmt1->bindParam(':ProfMere', $_POST['ProfMere']);
            $stmt1->bindParam(':Adresse', $_POST['Adresse']);
            $stmt1->bindParam(':Paroisse', $_POST['Paroisse']);
            $stmt1->bindParam(':Diocese', $_POST['Diocese']);
            $stmt1->bindParam(':TelVoda', $_POST['TelVoda']);
            $stmt1->bindParam(':TelOrange', $_POST['TelOrange']);
            $stmt1->bindParam(':TelAirtel', $_POST['TelAirtel']);
            $stmt1->bindParam(':Annsco', $_POST['AnneeP']);
            $stmt1->bindParam(':NomEtabli', $_POST['EtabP']);
            $stmt1->bindParam(':PourceCertificat', $_POST['Pourc6P'],PDO::PARAM_INT);
            $stmt1->bindParam(':PourceDiplome', $_POST['PourcDiplome'], PDO::PARAM_INT);
            $stmt1->bindParam(':NumDiplom', $_POST['NumDiplome']);
            $stmt1->bindParam(':SetionEtude', $_POST['Section']);
            $stmt1->bindParam(':OptionEtude', $_POST['Option']);
            $stmt1->bindParam(':Lieudelivrance', $_POST['Lieu']);
            
            $stmt1->bindParam(':Datedelivrance', $_POST['Datedel'], PDO::PARAM_STR);
            $stmt1->bindParam(':Ecole', $_POST['Ecole']);
            $stmt1->bindParam(':Province', $_POST['Prov']);
            $stmt1->bindParam(':ProvinceOrigine', $_POST['ProvO']);
            $stmt1->bindParam(':Territoire', $_POST['Territoire']);
            $stmt1->bindParam(':TelResponsable', $_POST['TelResp']);
            
            $stmt1->bindParam(':matricule', $_SESSION['user']['Matricule']);
            $stmt1->execute();
          if ($stmt->execute()) 
                {
                  echo "<script langage= javascript>
                  alert('Modificaion effectuée avec succès');

                  </script> ";
                  echo '<script langage= javascript>
                  window.location.href="redit.php?page=Autre"
                  </script> ';
                 //echo '<script langage= javascript>
                   // window.location.href="redit.php?page=Autre"
                  //</script> ';
                  //header('Location:redit.php');
                 // echo "date:" .$_SESSION['Identite']['datenais'];
                }
          else {
                  echo "<script langage= javascript>
                  alert('Non effectué');
                  </script>";
              }
        }
        ?>
