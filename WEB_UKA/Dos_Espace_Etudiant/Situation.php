      
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
                    $stmt2 = $con->prepare(" SELECT frais.Libelle_Frais as Lib, frais.Devise as devise
                                FROM promotion, frais, annee_academique  
                                WHERE frais.idAnnee_Acad=:idAnnee 
                                AND frais.Code_Promotion=:codepromo
                                GROUP BY frais.Libelle_Frais, frais.Devise");

                    
                    $stmt2->bindParam(':idAnnee', $_SESSION['AnneeEtude']['idAnnee_academique']);
                    $stmt2->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                    $stmt2->execute();
                    $LibelleFrais="";
                    $devise="";
                    while($ligne = $stmt2->fetch())
                    {     
                       $LibelleFrais=$ligne['Lib']; 
                       $devise=$ligne['devise'];                     

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
 
                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(Empty($fa))echo "0 ";else echo $fa." ". $devise;  ?></h2>
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
                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(Empty($TrancheFA))echo "0 ";else echo $TrancheFA." ". $devise; ?></h2>
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
                   $stmt2 = $con->prepare(" SELECT payer_frais.Motif_paie as motif, frais.Devise as dev
                   FROM payer_frais, frais  
                   WHERE payer_frais.idFrais=frais.idFrais 
                   AND frais.idAnnee_Acad=:idAnnee 
                   AND frais.Code_Promotion=:codepromo 
                   AND Matricule=:matricule GROUP BY payer_frais.Motif_paie, frais.Devise");

                   $stmt2->bindParam(':matricule', $_SESSION['user']['Matricule']);
                   $stmt2->bindParam(':idAnnee', $_SESSION['AnneeEtude']['idAnnee_academique']);
                   $stmt2->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                   $stmt2->execute();
                   $motifpaie="";
                   $devise="";

                   while($ligne = $stmt2->fetch())
                   {
                           $motifpaie=$ligne['motif'];                      
                            $devise=$ligne['dev'];
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
                           $i=0;
                           while($ligne = $stmt->fetch())
                               {
                                   $fapaye=$ligne['som'];

                ?>          
                <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="border rounded border-primary p-1" >
                        <div class="border rounded border-primary text-center p-4">

                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($fapaye))echo "0 ";else echo $fapaye." ".$devise;  ?></h2>
                            <span class="cursor-pointer" id="FraisPayé">   <p class="mb-0"><?php echo $motifpaie; ?></p></span>
                                    
                        </div>
                    </div>
                </div>
               
                <?php 
                    
                    }
                }
                
                ?>
                <input type="text" hidden value="<?php echo $_SESSION['AnneeEtude']['idAnnee_academique']?>" id="IdAnnee">
                <input type="text" hidden value="<?php echo $_SESSION['user']['Matricule']?>" id="Matricule">
            </div>
            

<!-- TABLEAU SITUATION-->

            <div class="row ">
                            <div class="col-md-12" >
                                <div class="card ">
                                    <div class="card-header ">
                                        <h4> Details des vos entrées
                                            <!--<a href="CreerCompteAgent.php?page=CreerCompte" class="btn btn-primary float-end">Nouveau Compte</a>-->
                                        </h4>
                                    </div>
                                    <div class="card-body table-responsive-lg visible" id="DivTab">
                                        <table class="table table-bordered table-striped table-responsive" style="width:auto;"id="TabSituation">
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
                                                
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                        </div>

<!-- FIN-->








            <hr><center><h4 style="font-size:2em; font-weight:bold;">Reste à Payer</h4>  </center> <hr>   
        
            <div class="row g-3 pb-4">
                <i class="fa fa-hotel fa-2x text-primary mb-2"></i>

                <?php
                //SELECTION DU MONTANT FIXE POUR LES FRAIS ACADEMIQUES

                        $stmt0 = $con->prepare("SELECT DISTINCT frais.Montant
                        FROM frais
                        WHERE frais.idAnnee_Acad=:anne 
                        AND frais.Code_Promotion=:codepromo
                        and frais.Libelle_Frais='Frais Académiques'");
                        $stmt0->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                        $stmt0->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt0->execute();
                        $FAdef=0;                      
                        while($ligne = $stmt0->fetch())
                        {
                            $FAdef=$ligne['Montant'];
                        }
                        $stm = $con->prepare("SELECT sum(payer_frais.Montant_paie) as reste_FA 
                                 FROM annee_academique,frais,payer_frais,etudiant 
                                 WHERE annee_academique.idAnnee_Acad=frais.idAnnee_Acad 
                                 and frais.idFrais=payer_frais.idFrais 
                                 and payer_frais.Matricule=etudiant.Matricule 
                                 and annee_academique.idAnnee_Acad=:anne 
                                 and etudiant.Matricule=:matricule
                                 and payer_frais.Motif_paie='Frais Académiques'");
                            
                        $stm->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stm->bindParam(':matricule', $_SESSION['user']['Matricule']);                   
                                        
                        $stm->execute();
                        $fa ="";
                        $TrancheFA="";
                        $idfraisFA="";
                        while($ligne = $stm->fetch())
                        {                           
                            $ResteFA=$ligne['reste_FA'];
                        }
                ?>          
                <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="border rounded border-primary p-1"id="BtnLien">
                        <div class="border rounded border-primary text-center p-4">
 
                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($ResteFA))echo $FAdef." ";else echo $FAdef-$ResteFA." ".$devise; ?></h2>
                            <span >   <p class="mb-0">Frais Académiques</p></span>
                                       
                        </div>
                    </div>
                </div>
                <?php
                 //SELECTION DU MONTANT FIXE POUR LES FRAIS D'ENROLEMENT

                    $stmt2 = $con->prepare("SELECT DISTINCT frais.Montant
                            FROM frais
                            WHERE frais.idAnnee_Acad=:anne 
                            AND frais.Code_Promotion=:codepromo
                            and frais.Libelle_Frais='Enrôlement à la Session'");
                    $stmt2->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                    $stmt2->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                    $stmt2->execute();
                    $EnrolMi=0;  
                    
                    while($ligne = $stmt2->fetch())
                    {
                        $EnrolMi=$ligne['Montant'];                   
                    }        
                    //Reste à payer si motif existe
                    $stmt1 = $con->prepare("SELECT sum(payer_frais.Montant_paie) as reste_FA 
                            FROM annee_academique,frais,payer_frais,etudiant 
                            WHERE annee_academique.idAnnee_Acad=frais.idAnnee_Acad 
                            and frais.idFrais=payer_frais.idFrais 
                            and payer_frais.Matricule=etudiant.Matricule 
                            and annee_academique.idAnnee_Acad=:anne 
                            and etudiant.Matricule=:matricule
                            and payer_frais.Motif_paie='Enrôlement à la Mi-Session' ");
                        
                    $stmt1->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                    $stmt1->bindParam(':matricule', $_SESSION['user']['Matricule']);                   
                                    
                    $stmt1->execute();
                    $ResteEnrolMis="";
                    while($ligne = $stmt1->fetch())
                    {                           
                        $ResteEnrolMis=$ligne['reste_FA'];
                    }
                ?>          
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="border rounded border-primary p-1">
                            <div class="border rounded border-primary text-center p-4">

                        <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($ResteEnrolMis))echo $EnrolMi." ";else echo $EnrolMi-$ResteEnrolMis." ".$devise; ?></h2>
                        <span>   <p class="mb-0">Enrôlement à la Mi-Session</p></span>
                                
                            </div>
                        </div>
                    </div>

                    <?php
                         //SELECTION DU MONTANT FIXE POUR LES FRAIS ACADEMIQUES

                        $stmt3 = $con->prepare("SELECT DISTINCT frais.Montant
                                FROM frais
                                WHERE frais.idAnnee_Acad=:anne 
                                AND frais.Code_Promotion=:codepromo
                                and frais.Libelle_Frais='Enrôlement à la Session'");
                        $stmt3->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                        $stmt3->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt3->execute();
                        $EnrolGdeSess=0;
                        while($ligne = $stmt3->fetch())
                        {
                            $EnrolGdeSess=$ligne['Montant'];
                        }                        
                        
            //Reste à payer si motif existe Pour la grande session

                        $stmt4 = $con->prepare(" SELECT sum(payer_frais.Montant_paie) as reste_FA 
                                FROM annee_academique,frais,payer_frais,etudiant 
                                WHERE annee_academique.idAnnee_Acad=frais.idAnnee_Acad 
                                and frais.idFrais=payer_frais.idFrais 
                                and payer_frais.Matricule=etudiant.Matricule 
                                and annee_academique.idAnnee_Acad=:anne 
                                and etudiant.Matricule=:matricule
                                and payer_frais.Motif_paie='Enrôlement à la Grande-Session'");
                            
                        $stmt4->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt4->bindParam(':matricule', $_SESSION['user']['Matricule']);                   
                                        
                        $stmt4->execute();
                        $ResteGdeSes="";
                        while($ligne = $stmt4->fetch())
                        {                           
                            $ResteGdeSes=$ligne['reste_FA'];
                        }
                    ?>          
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded border-primary p-1">
                                <div class="border rounded border-primary text-center p-4">

                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($ResteGdeSes))echo $EnrolGdeSess." ";else echo $EnrolGdeSess-$ResteGdeSes." ".$devise; ?></h2>
                            <span>   <p class="mb-0">Enrôlement à la Grande-Session</p></span>
                                    
                                </div>
                            </div>
                        </div>  
            
                        <?php
                         //SELECTION DU MONTANT FIXE POUR LES FRAIS ACADEMIQUES

                        $stmt3 = $con->prepare("SELECT DISTINCT frais.Montant
                                FROM frais
                                WHERE frais.idAnnee_Acad=:anne 
                                AND frais.Code_Promotion=:codepromo
                                and frais.Libelle_Frais='Enrôlement à la Session'");
                        $stmt3->bindParam(':codepromo', $_SESSION['AnneeEtude']['Code_Promotion']);
                        $stmt3->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt3->execute();
                        $Enrol2Sess=0;
                        while($ligne = $stmt3->fetch())
                        {
                            $Enrol2Sess=$ligne['Montant'];
                        }                        
                        
            //Reste à payer si motif existe Pour la grande session

                        $stmt4 = $con->prepare(" SELECT sum(payer_frais.Montant_paie) as reste_FA 
                                FROM annee_academique,frais,payer_frais,etudiant 
                                WHERE annee_academique.idAnnee_Acad=frais.idAnnee_Acad 
                                and frais.idFrais=payer_frais.idFrais 
                                and payer_frais.Matricule=etudiant.Matricule 
                                and annee_academique.idAnnee_Acad=:anne 
                                and etudiant.Matricule=:matricule
                                and payer_frais.Motif_paie='Enrôlement à la Deuxième-Session'");
                            
                        $stmt4->bindParam(':anne', $_SESSION['AnneeEtude']['idAnnee_academique']);
                        $stmt4->bindParam(':matricule', $_SESSION['user']['Matricule']);                   
                                        
                        $stmt4->execute();
                        $Reste2Ses="";
                        while($ligne = $stmt4->fetch())
                        {                           
                            $ResteSes2=$ligne['reste_FA'];
                        }
                    ?>          
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded border-primary p-1">
                                <div class="border rounded border-primary text-center p-4">

                            <h2 class="mb-1 fw-bold" style="Color:rgb(113, 7, 7);"data-toggle="counter-up"><?php if(empty($ResteSes2))echo $Enrol2Sess ." " ;else echo $Enrol2Sess-$ResteSes2." ".$devise; ?></h2>
                            <span>   <p class="mb-0">Enrôlement à la Deuxième-Session</p></span>
                                    
                                </div>
                            </div>
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
                       
    
