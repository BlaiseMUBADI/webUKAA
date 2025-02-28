<?php
        include("../../Connexion_BDD/Connexion_1.php");
        $matricule=$_GET['Mat'];
        $idanne=$_GET['IdAnne'];
        $motif=$_GET['Motif'];

        $stmt = $con->prepare("SELECT payer_frais.Date_paie, payer_frais.Montant_paie, payer_frais.Motif_paie, 
                lieu_paiement.Libelle_lieu
            FROM payer_frais, lieu_paiement, frais
            WHERE
                lieu_paiement.idLieu_paiement=payer_frais.idLieu_paiement 
            AND payer_frais.idFrais=frais.idFrais
            AND frais.idAnnee_Acad=:annee
            AND payer_frais.Matricule=:matricule
            And payer_frais.Motif_paie=:motif
            ORDER BY payer_frais.Date_paie DESC");
        $stmt->bindParam(':annee', $idanne);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':motif', $motif);
        $stmt->execute();

        $Situationpaie=array();
        while($ligne = $stmt->fetch())
        {
            $Situationpaie[]=$ligne;
    
        }                             
            echo json_encode($Situationpaie);

        ?>