
<link rel="stylesheet" type="text/css" href="../bootstrap\dist\css\bootstrap.min.css" >      

  
<?php 
         include("./../Connexion_BDD/Connexion_1.php");  
?>        
 
<div class="container mt-4">


    <div class="row">
          <div class="col-md-12">
            <div class="card">
                  <div class="card-header">
                        <h4> Votre parcours académique
                        </h4>
                  </div>
                  <div class="card-body table-responsive-lg">
        <table class="table table-bordered table-striped ">
            <?php
                     $stmt = $con->prepare("SELECT promotion.Libelle_promotion, 
                     annee_academique.Annee_debut, 
                     annee_academique.Annee_fin, 
                     passer_par.Session1, 
                     passer_par.Mention1, 
                     passer_par.Session2, 
                     passer_par.Mention2,
                     passer_par.Decision_jury,
                     promotion.Abréviation 
                FROM passer_par, 
                     annee_academique, 
                     promotion 
                WHERE promotion.Code_Promotion=passer_par.Code_Promotion 
                AND passer_par.idAnnee_academique=annee_academique.idAnnee_Acad 
                AND passer_par.Etudiant_Matricule=:matricule
                ORDER BY annee_academique.Annee_debut,annee_academique.Annee_fin ASC");
            $stmt->bindParam(':matricule', $_SESSION['user']['Matricule']);
            $stmt->execute();    
            while($ligne1 = $stmt->fetch())
                  {
                      $_SESSION['Abreviation']['systeme']=$ligne1['Abréviation'] ;
                  }

                  if(strpos($_SESSION['Abreviation']['systeme'],"LMD")!==false){
                        echo "Nouveau";
                        $Systeme="LMD";
                        ?>
                        <thead>
                        <tr style="text-align: center;">
                            <th>Année Académique</th>
                            <th>Promotion</th>
                            <th>Moyenne S1</th>
                            <th>Mention</th>
                            <th>Moyenne S2</th>
                            <th>Mention</th>
                            <th>Décision Annuelle</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                  }
            else { $Systeme="PADEM";
            ?>
                    <thead>
                        <tr style="text-align: center;">
                            <th>Année Académique</th>
                            <th>Promotion</th>
                            <th>% S_1</th>
                            <th>Mention</th>
                            <th>% S_2</th>
                            <th>Mention</th>                          
                        </tr>
                    </thead>
                    <tbody>
                   <?php
                   }
// lancement de la requete
    
$stmt->execute();  
   
      while($ligne = $stmt->fetch())
      {
       

            ?> 
                               <tr style="text-align:center;">
                                    <td class="table-success"> <?php echo $ligne['Annee_debut']. "-". $ligne['Annee_fin'];?></td>
                                    <td class="table-primary"> <?php  echo $ligne['Libelle_promotion']; ?></td>                    
                                    <td class="table-danger"><?php echo $ligne['Session1']; ?></td>
                                    <td class="table-info"><?php echo $ligne['Mention1']; ?></td>
                                    <td class="table-danger"><?php echo $ligne['Session2']; ?></td>
                                    <td class="table-info"><?php echo $ligne['Mention2']; ?></td>
                                    <!--Affichage décision si LMD -->
                                    <?php if($_SESSION['Abreviation']['systeme']=="LMD") {?>
                                    <td class="table-danger"><?php echo $ligne['Decision_jury']; ?></td>
                                    <?php }?>
                              </tr>
                    <?php
          }

               

                     ?>
                  </tbody>
                </table>
                  </div>
            </div>
          </div>
    </div>

</div>


<!-- Option 1: Bootstrap Bundle with Popper -->

