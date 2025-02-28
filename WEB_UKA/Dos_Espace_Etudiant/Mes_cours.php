
<link rel="stylesheet" type="text/css" href="../bootstrap\dist\css\bootstrap.min.css" >      

  
<?php 
         include("../../Connexion_BDD/Connexion_1.php");  
?>        
 
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                            <h4> Voici vos côtes
                            </h4>
                    </div>
                    <div class="card-body table-responsive-lg">
                        <div class="card-header">
                            
                            <?php
                                $id_semestre="";
                                $semestre="";                                
                                $paier=false;


                                
                                $sql = "SELECT 
                                            IFNULL(
                                                (SELECT frais.Montant 
                                                FROM frais 
                                                WHERE frais.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique) 
                                                AND frais.Code_Promotion = :code_prom 
                                                AND frais.Libelle_Frais = 'Frais Académiques') - ROUND(SUM(payer_frais.Montant_paie), 2),
                                                (SELECT frais.Montant 
                                                FROM frais 
                                                WHERE frais.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique)
                                                AND frais.Code_Promotion = :code_prom 
                                                AND frais.Libelle_Frais = 'Frais Académiques')
                                            ) AS reste_FA, 
                                            (SELECT frais.Tranche 
                                            FROM frais 
                                            WHERE frais.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique)
                                            AND frais.Code_Promotion = :code_prom 
                                            AND frais.Libelle_Frais = 'Frais Académiques') as Tranche
                                        FROM 
                                            annee_academique, frais, payer_frais, etudiant
                                        WHERE 
                                            annee_academique.idAnnee_Acad = frais.idAnnee_Acad
                                            AND frais.idFrais = payer_frais.idFrais
                                            AND payer_frais.Matricule = etudiant.Matricule
                                            AND annee_academique.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique)
                                            AND etudiant.Matricule = :mat_etudiant
                                            AND payer_frais.Motif_paie = 'Frais Académiques'";

                                $stmt = $con->prepare($sql);
                                $stmt->bindParam(':mat_etudiant', $_SESSION['user']['Matricule']);
                                $stmt->bindParam(':code_prom', $_SESSION['AnneeEtude']['Code_Promotion'], PDO::PARAM_STR);
                                $stmt->execute();

                                 while ($ligne = $stmt->fetch()) 
                                {
                                    if($ligne['reste_FA']<=$ligne['Tranche']) $paier=true;
                                    else $paier=false;
                                }
                                
                                $req = "SELECT semestre.Id_Semestre, semestre.libelle_semestre 
                                            FROM element_constitutifs_aligne 
                                            JOIN semestre ON element_constitutifs_aligne.Id_Semestre = semestre.Id_Semestre
                                            WHERE element_constitutifs_aligne.Code_Promotion = :code_prom 
                                            GROUP BY semestre.Id_Semestre
                                            ORDER BY semestre.Id_Semestre ASC LIMIT 1";
                                $stmt = $con->prepare($req);
                                $stmt->bindParam(':code_prom', $_SESSION['AnneeEtude']['Code_Promotion'], PDO::PARAM_STR);
                                $stmt->execute();

                                while ($ligne = $stmt->fetch()) 
                                {
                                    $id_semestre=$ligne['Id_Semestre'];
                                    $semestre=$ligne['libelle_semestre'];
                                }
                            ?>
                            <h4 class="border text-center"><?php echo $semestre; ?></h4>
                                    
                        </div>
                        <table class="table table-bordered table-striped ">
                            <?php
                                $sql="SELECT 
                                            e.Cote,
                                            ec.Intutile_ec AS Nom_Element_Constitutif,
                                            ec.Credit,
                                            CONCAT('Prof.',' ',a.Nom_agent, ' ', a.Post_agent, ' ', a.Prenom) AS Enseignant
                                        FROM 
                                            element_constitutifs_aligne eca
                                        JOIN 
                                            element_constitutifs ec ON eca.id_ec = ec.id_ec
                                        JOIN 
                                            agent a ON eca.Mat_agent = a.Mat_agent
                                        JOIN 
                                            annee_academique aa ON eca.idAnnee_Acad = aa.idAnnee_Acad
                                        LEFT JOIN 
                                            evaluer e ON eca.id_ec_aligne = e.id_ec_aligne AND e.Matricule = :mat_etudiant
                                        WHERE 
                                            aa.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique)
                                            AND eca.Id_Semestre=:idsemestre";
                                $stmt = $con->prepare($sql);
                                $stmt->bindParam(':mat_etudiant', $_SESSION['user']['Matricule']);
                                $stmt->bindParam(':idsemestre', $id_semestre);
                                $stmt->execute(); 
                                $Systeme="LMD";
                            ?>
                            <thead>
                                <tr style="text-align: center;">
                                    <th>N° </th>
                                    <th>Cours Semestre </th>
                                    <th>Cédit</th>
                                    <th>Côtes</th>
                                    <th>Titulaire</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt->execute();
                                    $i=1;
                                    while($ligne = $stmt->fetch())
                                    {
                                ?> 
                                <tr>
                                        <td class="table-success text-center"> <?php echo $i; ?></td>
                                        <td class="table-success text-end"> <?php echo $ligne['Nom_Element_Constitutif'];?></td>
                                        <td class="table-primary text-center"> <?php  echo $ligne['Credit']; ?></td>                    
                                        <td class="table-danger text-center"><?php if($paier) echo $ligne['Cote']; else echo " tu n'es pas en ordre"; ?></td>
                                        <td class="table-info text-start"><?php echo $ligne['Enseignant']; ?></td>
                                        
                                </tr>
                                <?php
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive-lg">
                        <div class="card-header">
                            
                            <?php
                                                            
                                $req = "SELECT semestre.Id_Semestre, semestre.libelle_semestre 
                                            FROM element_constitutifs_aligne 
                                            JOIN semestre ON element_constitutifs_aligne.Id_Semestre = semestre.Id_Semestre
                                            WHERE element_constitutifs_aligne.Code_Promotion = :code_prom 
                                            GROUP BY semestre.Id_Semestre
                                            ORDER BY semestre.Id_Semestre DESC LIMIT 1";
                                $stmt = $con->prepare($req);
                                $stmt->bindParam(':code_prom', $_SESSION['AnneeEtude']['Code_Promotion'], PDO::PARAM_STR);
                                $stmt->execute();

                                while ($ligne = $stmt->fetch()) 
                                {
                                    $id_semestre=$ligne['Id_Semestre'];
                                    $semestre=$ligne['libelle_semestre'];
                                }                            ?>
                            <h4 class="border text-center"><?php echo $semestre; ?></h4>
                                    
                        </div>
                        <table class="table table-bordered table-striped ">
                            <?php
                                $sql="SELECT 
                                            e.Cote,
                                            ec.Intutile_ec AS Nom_Element_Constitutif,
                                            ec.Credit,
                                            CONCAT('Prof.',' ',a.Nom_agent, ' ', a.Post_agent, ' ', a.Prenom) AS Enseignant
                                        FROM 
                                            element_constitutifs_aligne eca
                                        JOIN 
                                            element_constitutifs ec ON eca.id_ec = ec.id_ec
                                        JOIN 
                                            agent a ON eca.Mat_agent = a.Mat_agent
                                        JOIN 
                                            annee_academique aa ON eca.idAnnee_Acad = aa.idAnnee_Acad
                                        LEFT JOIN 
                                            evaluer e ON eca.id_ec_aligne = e.id_ec_aligne AND e.Matricule = :mat_etudiant
                                        WHERE 
                                            aa.idAnnee_Acad = (SELECT MAX(idAnnee_Acad) FROM annee_academique)
                                            AND eca.Id_Semestre=:idsemestre";
                                $stmt = $con->prepare($sql);
                                $stmt->bindParam(':mat_etudiant', $_SESSION['user']['Matricule']);
                                $stmt->bindParam(':idsemestre', $id_semestre);
                                $stmt->execute(); 
                                $Systeme="LMD";
                            ?>
                            <thead>
                                <tr style="text-align: center;">
                                    <th>N° </th>
                                    <th>Cours Semestre </th>
                                    <th>Cédit</th>
                                    <th>Côtes</th>
                                    <th>Titulaire</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt->execute();
                                    $i=1;
                                    while($ligne = $stmt->fetch())
                                    {
                                ?> 
                                <tr>
                                        <td class="table-success text-center"> <?php echo $i; ?></td>
                                        <td class="table-success text-end"> <?php echo $ligne['Nom_Element_Constitutif'];?></td>
                                        <td class="table-primary text-center"> <?php  echo $ligne['Credit']; ?></td>                    
                                        <td class="table-danger text-center"><?php if($paier) echo $ligne['Cote']; else echo " tu n'es pas en ordre"; ?></td>
                                        <td class="table-info text-start"><?php echo $ligne['Enseignant']; ?></td>
                                        
                                </tr>
                                <?php
                                        $i++;
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

