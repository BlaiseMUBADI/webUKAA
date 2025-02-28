

        
    <div class="container-xxl py-5 mt-3">
        <div class="container">                
            <div class="row g-5 align-items-center">
                <div class="col-lg-50" >
                     <h6 class="section-title text-start text-primary text-uppercase">Details de vos paiements</h6>
                     <h1 class="mb-4">Bienvenu sur la plate forme numérique de <span class="text-primary text-uppercase">l'U.KA.</span></h1>
                     <p class="mb-4">Numérisons notre quotidien ensemble</p>
                        
                </div>
            </div>
            <hr><center><h4 style="font-size:2em; font-weight:bold;">Frais à payer</h4>  </center> <hr>   
        
            <div class="row g-3 pb-4">
                <i class="fa fa-hotel fa-2x text-primary mb-2"></i>

                <?php
                    $stmt2 = $con->prepare(" SELECT frais.Libelle_Frais as Lib 
                                FROM promotion, frais, annee_academique  
                                WHERE frais.idAnnee_Acad=:idAnnee 
                                AND frais.Code_Promotion=:codepromo
                                GROUP BY frais.Libelle_Frais");

                    
                    $stmt2->bindParam(':idAnnee', $_SESSION['AnneeEtude']['idAnnee_academique']);
                    $stmt2->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                    $stmt2->execute();
                    $LibelleFrais="";
                    while($ligne = $stmt2->fetch())
                    {     
                       $LibelleFrais=$ligne['Lib'];                      

                        $stmt1 = $con->prepare(" SELECT frais.Montant, frais.Tranche, frais.idFrais FROM 
                                frais WHERE frais.idAnnee_Acad=:anne AND frais.Code_Promotion=:codepromo AND frais.Libelle_Frais=:libelle");   
                        $stmt1->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt1->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);                     
                        $stmt1->bindParam(':libelle', $LibelleFrais);                     
                        $stmt1->execute();
                        $fa ="";
                        $TrancheFA="";
                        $idfraisFA="";
                        while($ligne = $stmt1->fetch())
                        {
                            $fa=$ligne['Montant'];
                            $TrancheFA=$ligne['Tranche'];
                            $idfraisFA=$ligne['idFrais'];

                ?>          
                <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="border rounded border-primary p-1">
                        <div class="border rounded border-primary text-center p-4">
 
                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(Empty($fa))echo "0 ";else echo $fa." "; ?>$</h2>
                            <a href="">   <p class="mb-0"><?php echo $LibelleFrais; ?></p></a>
                                       
                        </div>
                    </div>
                </div>
                <?php  
                        if(!empty($TrancheFA))
                        {
                ?>      
                <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="border rounded border-primary p-1">
                        <div class="border rounded border-primary text-center p-4">
                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(Empty($TrancheFA))echo "0 ";else echo $TrancheFA." "; ?>$</h2>
                            <a href=""><p class="mb-0"><?php echo "Première Tranche ".$LibelleFrais; ?></p></a>
                                       
                        </div>
                    </div>
                </div>     
                <?php 
                        }
                    }
                }
                   
                ?>
            </div>
        
             <hr><center><h4 style="font-size:2em; font-weight:bold;">Frais dejà payés</h4>  </center> <hr>   
        
             <div class="row g-3 pb-4">
                <i class="fa fa-hotel fa-2x text-primary mb-2"></i>

                <?php
                   $stmt2 = $con->prepare(" SELECT payer_frais.Motif_paie as motif 
                   FROM payer_frais, frais  
                   WHERE payer_frais.idFrais=frais.idFrais 
                   AND frais.idAnnee_Acad=:idAnnee 
                   AND frais.Code_Promotion=:codepromo 
                   AND Matricule=:matricule GROUP BY payer_frais.Motif_paie");

                   $stmt2->bindParam(':matricule', $_SESSION['user']['Matricule']);
                   $stmt2->bindParam(':idAnnee', $_SESSION['AnneeEtude']['idAnnee_academique']);
                   $stmt2->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                   $stmt2->execute();
                   $motifpaie="";
                   while($ligne = $stmt2->fetch())
                   {
                           $motifpaie=$ligne['motif'];                      
                
                           $stmt = $con->prepare(" SELECT SUM(Montant_paie)as som
                           FROM 
                               payer_frais, frais 
                           WHERE 
                               payer_frais.idFrais=frais.idFrais 
                           AND frais.idAnnee_Acad=:idAnnee 
                           AND frais.Code_Promotion=:codepromo 
                           AND Matricule=:matricule 
                           AND payer_frais.Motif_paie=:motif" );                 
                           
                           $stmt->bindParam(':matricule', $_SESSION['user']['Matricule']);
                           $stmt->bindParam(':motif', $motifpaie);
                           $stmt->bindParam(':idAnnee', $_SESSION['AnneeEtude']['idAnnee_academique']);
                           $stmt->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                           $stmt->execute();
                           $fapaye="";
                           while($ligne = $stmt->fetch())
                               {
                                   $fapaye=$ligne['som'];

                ?>          
                <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="border rounded border-primary p-1">
                        <div class="border rounded border-primary text-center p-4">

                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($fapaye))echo "0 ";else echo $fapaye." ";  ?>$</h2>
                            <a href="">   <p class="mb-0"><?php echo $motifpaie; ?></p></a>
                                    
                        </div>
                    </div>
                </div>
               
                <?php 
                        
                    }
                }
                
                ?>
            </div>





            

            </div>

            
        </div>






        <div class="row g-3 pb-4">
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    
               <a class="btn btn-primary py-3 px-5 mt-3 border border-secondary" href=""></a>        
            </div>
        </div> 
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </div>
    </div>
                       
    
