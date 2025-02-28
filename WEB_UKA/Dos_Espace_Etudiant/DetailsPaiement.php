
   <div class="container mt-4">


        <div class="row">
              <div class="col-md-12">
                <div class="card">
                      <div class="card-header">
                            <h4> Details des vos entrées
                                  <a href="CreerCompteAgent.php?page=CreerCompte" class="btn btn-primary float-end">Nouveau Compte</a>
                            </h4>
                      </div>
                      <div class="card-body">

                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Numéro</th>
                                <th>Date opération</th>
                                <th>Motif</th>
                                <th>Montant</th>
                                <th>Observation</th> 
                            </tr>
                        </thead>
                        <tbody>
                  <?php

                        $stmt = $con->prepare("SELECT payer_frais.Date_paie, payer_frais.Montant_paie, payer_frais.Motif_paie, 
                                          lieu_paiement.Libelle_lieu
                                    FROM payer_frais, lieu_paiement
                                    WHERE
                                          payer_frais.Matricule=:matricule
                                    AND	lieu_paiement.idLieu_paiement=payer_frais.idLieu_paiement ORDER BY payer_frais.Date_paie DESC");
                              $stmt->bindParam(':matricule', $_SESSION['user']['Matricule']);
                              $stmt->execute();
                        
                              while($ligne = $stmt->fetch())
                              {
                  ?> 
                                   <tr>
                                        <td><?php echo //$ligne['Etat']; ?></td>
                                        <td> <?php echo $ligne['Date_paie']; ?></td>
                                        <td> <?php echo $ligne['Montant_paie']; ?></td>
                                        <td><?php echo $ligne['Motif_paie']; ?></td>
                                        <td><?php echo $ligne['Libelle_kieu']; ?></td>                                      
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

