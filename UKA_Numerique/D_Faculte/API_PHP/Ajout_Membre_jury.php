<?php
session_start();
include("../../../Connexion_BDD/Connexion_1.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_filiere = $_SESSION['id_fac'];

$data = json_decode(file_get_contents('php://input'), true);

$Mat_agent = $data['Mat_agent'];
$Code_promotion = $data['Code_promotion'];
$Login = $data['Login'];
$Password = password_hash($data['Password'], PASSWORD_DEFAULT); // Récuperation du mot de passe et hacher
$Fonction = $data['Fonction'];
$Etat = $data['Etat'];

//$con->beginTransaction();

try {
    // Appeler la procédure stockée pour ajouter un membre du jury
    $sql_ajout = "CALL Nouvel_membre_jury(:Mat_agent, :Code_promotion, :Login, :Password, :categorie, :Etat,:id_filiere)";
    $stmt = $con->prepare($sql_ajout);
    $stmt->bindParam(':Mat_agent', $Mat_agent);
    $stmt->bindParam(':Code_promotion', $Code_promotion);
    $stmt->bindParam(':Login', $Login);
    $stmt->bindParam(':Password', $Password);
    $stmt->bindParam(':categorie', $Fonction);
    $stmt->bindParam(':Etat', $Etat);
    $stmt->bindParam(':id_filiere', $id_filiere);

    if ($stmt->execute()) {
        //$con->commit();
        echo json_encode(["status" => "success", "message" => "Membre du jury ajouté avec succès !"]);
    } else {
        throw new Exception("Échec de l'ajout.");
    }
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    //$con->rollback();
    echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout du membre du jury : " . $e->getMessage()]);
} catch (Exception $e) {
    //$con->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>