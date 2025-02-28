<style type="text/css">
	
h2, th, td
{
text-align:center;
}
table
{
border-collapse:collapse;
border:2px solid black;
margin:auto;
}
th, td
{
border:1px solid black;
}
</style>

<h2><a href="horaire/horaire_rediriger.php">Ajouter Horaire</a></h2>
<?php
include("Connexion.php");

//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une news ?
//-----------------------------------------------------
if (isset($_POST['Semaine']) AND isset($_POST['Faculte']))
{
$Semaine = addslashes($_POST['Semaine']);
$Faculte = addslashes($_POST['Faculte']);
$LAVMG1 = addslashes($_POST['LAVMG1']);
$LAPMG1 = addslashes($_POST['LAPMG1']);
$LAVMG2 = addslashes($_POST['LAVMG2']);
$LAPMG2 = addslashes($_POST['LAPMG2']);
$LAVMG3 = addslashes($_POST['LAVMG3']);
$LAPMG3 = addslashes($_POST['LAPMG3']);
$LAVML1 = addslashes($_POST['LAVML1']);
$LAPML1 = addslashes($_POST['LAPML1']);
$LAVML2 = addslashes($_POST['LAVML2']);
$LAPML2 = addslashes($_POST['LAPML2']);

$MAVMG1 = addslashes($_POST['MAVMG1']);
$MAPMG1 = addslashes($_POST['MAPMG1']);
$MAVMG2 = addslashes($_POST['MAVMG2']);
$MAPMG2 = addslashes($_POST['MAPMG2']);
$MAVMG3 = addslashes($_POST['MAVMG3']);
$MAPMG3 = addslashes($_POST['MAPMG3']);
$MAVML1 = addslashes($_POST['MAVML1']);
$MAPML1 = addslashes($_POST['MAPML1']);
$MAVML2 = addslashes($_POST['MAVML2']);
$MAPML2 = addslashes($_POST['MAPML2']);

$MeAVMG1 = addslashes($_POST['MeAVMG1']);
$MeAPMG1 = addslashes($_POST['MeAPMG1']);
$MeAVMG2 = addslashes($_POST['MeAVMG2']);
$MeAPMG2 = addslashes($_POST['MeAPMG2']);
$MeAVMG3 = addslashes($_POST['MeAVMG3']);
$MeAPMG3 = addslashes($_POST['MeAPMG3']);
$MeAVML1 = addslashes($_POST['MeAVML1']);
$MeAPML1 = addslashes($_POST['MeAPML1']);
$MeAVML2 = addslashes($_POST['MeAVML2']);
$MeAPML2 = addslashes($_POST['MeAPML2']);

$JAVMG1 = addslashes($_POST['JAVMG1']);
$JAPMG1 = addslashes($_POST['JAPMG1']);
$JAVMG2 = addslashes($_POST['JAVMG2']);
$JAPMG2 = addslashes($_POST['JAPMG2']);
$JAVMG3 = addslashes($_POST['JAVMG3']);
$JAPMG3 = addslashes($_POST['JAPMG3']);
$JAVML1 = addslashes($_POST['JAVML1']);
$JAPML1 = addslashes($_POST['JAPML1']);
$JAVML2 = addslashes($_POST['JAVML2']);
$JAPML2 = addslashes($_POST['JAPML2']);

$VAVMG1 = addslashes($_POST['VAVMG1']);
$VAPMG1 = addslashes($_POST['VAPMG1']);
$VAVMG2 = addslashes($_POST['VAVMG2']);
$VAPMG2 = addslashes($_POST['VAPMG2']);
$VAVMG3 = addslashes($_POST['VAVMG3']);
$VAPMG3 = addslashes($_POST['VAPMG3']);
$VAVML1 = addslashes($_POST['VAVML1']);
$VAPML1 = addslashes($_POST['VAPML1']);
$VAVML2 = addslashes($_POST['VAVML2']);
$VAPML2 = addslashes($_POST['VAPML2']);

$SAVMG1 = addslashes($_POST['SAVMG1']);
$SAPMG1 = addslashes($_POST['SAPMG1']);
$SAVMG2 = addslashes($_POST['SAVMG2']);
$SAPMG2 = addslashes($_POST['SAPMG2']);
$SAVMG3 = addslashes($_POST['SAVMG3']);
$SAPMG3 = addslashes($_POST['SAPMG3']);
$SAVML1 = addslashes($_POST['SAVML1']);
$SAPML1 = addslashes($_POST['SAPML1']);
$SAVML2 = addslashes($_POST['SAVML2']);
$SAPML2 = addslashes($_POST['SAPML2']);

// On vérifie si c'est une modification de news ou non.
if ($_POST['id_news'] == 0)
{
// Ce n'est pas une modification, on crée une nouvelle entrée dans la table.
 $bdd->query("INSERT INTO horaire 
    (
        Semaine, Faculte, LAVMG1, LAPMG1, LAVMG2, LAPMG2, LAVMG3, 
        LAPMG3, LAVML1, LAPML1, LAVML2, LAPML2, MAVMG1, MAPMG1, 
        MAVMG2, MAPMG2, MAVMG3, MAPMG3, MAVML1, MAPML1, MAVML2,
        MAPML2, MeAVMG1, MeAPMG1, MeAVMG2, MeAPMG2, MeAVMG3, MeAPMG3,
        MeAVML1, MeAPML1, MeAVML2, MeAPML2, JAVMG1, JAPMG1, JAVMG2, 
        JAPMG2, JAVMG3, JAPMG3, JAVML1, JAPML1, JAVML2, JAPML2, 
        VAVMG1, VAPMG1, VAVMG2, VAPMG2, VAVMG3, VAPMG3, VAVML1, 
        VAPML1, VAVML2, VAPML2, SAVMG1, SAPMG1,SAVMG2, SAPMG2, 
        SAVMG3, SAPMG3, SAVML1, SAPML1, SAVML2, SAPML2
    )

  VALUES(
    '" . $Semaine . "','" . $Faculte . "', '" . $LAVMG1 . "','" . $LAPMG1 . "','" . $LAVMG2 . "', '" . $LAPMG2 . "', '" . $LAVMG3 . "',
    '" . $LAPMG3 . "','" . $LAVML1 . "', '" . $LAPML1 . "','" . $LAVML2 . "', '" . $LAPML2 . "', '" . $MAVMG1 . "','" . $MAPMG1 . "',
    '" . $MAVMG2 . "','" . $MAPMG2 . "', '" . $MAVMG3 . "','" . $MAPMG3 . "','" . $MAVML1 . "', '" . $MAPML1 . "', '" . $MAVML2 . "',
    '" . $MAPML2 . "','" . $MeAVMG1 . "','" . $MeAPMG1 . "','" . $MeAVMG2 . "','" . $MeAPMG2 . "', '" . $MeAVMG3 . "','" . $MeAPMG3 . "',
    '" . $MeAVML1 . "','" . $MeAPML1 . "','" . $MeAVML2 . "','" . $MeAPML2 . "','" . $JAVMG1 . "','" . $JAPMG1 . "','" . $JAVMG2 . "', 
    '" . $JAPMG2 . "', '" . $JAVMG3 . "','" . $JAPMG3 . "','" . $JAVML1 . "', '" . $JAPML1 . "', '" . $JAVML2 . "', '" . $JAPML2 . "',
    '" . $VAVMG1 . "','" . $VAPMG1 . "','" . $VAVMG2 . "', '" . $VAPMG2 . "', '" . $VAVMG3 . "','" . $VAPMG3 . "','" . $VAVML1 . "',
    '" . $VAPML1 . "', '" . $VAVML2 . "', '" . $VAPML2 . "', '" . $SAVMG1 . "','" . $SAPMG1 . "','" . $SAVMG2 . "', '" . $SAPMG2 . "',
    '" . $SAVMG3 . "','" . $SAPMG3 . "','" . $SAVML1 . "', '" . $SAPML1 . "', '" . $SAVML2 . "', '" . $SAPML2 . "')");

header('location:http://localhost/Campus%20Web/admin2.php?page=horaire/horaire1.php');

}
else
{
// On protège la variable "id_news" pour éviter une faille SQL.
$_POST['id_news'] = addslashes($_POST['id_news']);
// C'est une modification, on met juste à jour les données de la table
 $bdd->query("UPDATE horaire SET Semaine='" . $Semaine . "', Faculte='" . $Faculte . "' 
, LAVMG1='" . $LAVMG1 . "', LAPMG1='" . $LAPMG1 . "', LAVMG2='" . $LAVMG2 . "', LAPMG2 ='" . $LAPMG2 . "', LAVMG3='" . $LAVMG3 . "', LAPMG3='" . $LAPMG3 . "', LAVML1='" . $LAVML1 . "', LAPML1='" . $LAPML1 . "', LAVML2='" . $LAVML2 . "', LAPML2='" . $LAPML2 . "'
, MAVMG1='" . $MAVMG1 . "', MAPMG1='" . $MAPMG1 . "', MAVMG2='" . $MAVMG2 . "', MAPMG2='" . $MAPMG2 . "', MAVMG3='" . $MAVMG3 . "', MAPMG3='" . $MAPMG3 . "', MAVML1='" . $MAVML1 . "', MAPML1='" . $MAPML1 . "', MAVML2='" . $MAVML2 . "', MAPML2='" . $MAPML2 . "'
, MeAVMG1='" . $MeAVMG1 . "', MeAPMG1='" . $MeAPMG1 . "', MeAVMG2='" . $MeAVMG2 . "', MeAPMG2='" . $MeAPMG2 . "', MeAVMG3='" . $MeAVMG3 . "', MeAPMG3='" . $MeAPMG3 . "', MeAVML1='" . $MeAVML1 . "', MeAPML1='" . $MeAPML1 . "', MeAVML2='" . $MeAVML2 . "', MeAPML2='" . $MeAPML2 . "'
, JAVMG1='" . $JAVMG1 . "', JAPMG1='" . $JAPMG1 . "', JAVMG2='" . $JAVMG2 . "', JAPMG2='" . $JAPMG2 . "', JAVMG3='" . $JAVMG3 . "', JAPMG3='" . $JAPMG3 . "', JAVML1='" . $JAVML1 . "', JAPML1='" . $JAPML1 . "', JAVML2='" . $JAVML2 . "', JAPML2='" . $JAPML2 . "'
, VAVMG1='" . $VAVMG1 . "', VAPMG1='" . $VAPMG1 . "', VAVMG2='" . $VAVMG2 . "', VAPMG2='" . $VAPMG2 . "', VAVMG3='" . $VAVMG3 . "', VAPMG3='" . $VAPMG3 . "', VAVML1='" . $VAVML1 . "', VAPML1='" . $VAPML1 . "', VAVML2='" . $VAVML2 . "', VAPML2='" . $VAPML2 . "'
, SAVMG1='" . $SAVMG1 . "', SAPMG1='" . $SAPMG1 . "', SAVMG2='" . $SAVMG2 . "', SAPMG2='" . $SAPMG2 . "', SAVMG3='" . $SAVMG3 . "', SAPMG3='" . $SAPMG3 . "', SAVML1='" . $SAVML1 . "', SAPML1='" . $SAPML1 . "', SAVML2='" . $SAVML2 . "', SAPML2='" . $SAPML2 . "'
WHERE Id_Horaire='" .$_POST['id_news']. "'");

header('location:http://localhost/Campus%20Web/admin2.php?page=horaire/horaire1.php');
}
}
//--------------------------------------------------------
// Vérification 2 : est-ce qu'on veut supprimer une news ?
//--------------------------------------------------------
if (isset($_GET['supprimer_news'])) // Si l'on demande de supprimer une news.
{
// Alors on supprime la news correspondante.
// On protège la variable « id_news » pour éviter une faille SQL.
$_GET['supprimer_news'] = addslashes($_GET['supprimer_news']);
 $bdd->query('DELETE FROM horaire WHERE Id_Horaire=\'' . $_GET['supprimer_news'] . '\'');
 header('location:http://localhost/Campus%20Web/admin2.php?page=horaire/horaire1.php');
}?>
<table><tr>
<th>Modifier</th>
<th>Supprimer</th>
<th>Semaine</th>
<th>Faculte</th>
</tr>
<?php
$retour = $bdd->query('SELECT * FROM horaire ORDER BY Id_Horaire DESC');
//while ($donnees = mysql_fetch_array($retour)) // On fait une boucle pour lister les news.
while ($donnees = $retour->fetch())
{
?>
<tr>
<td><?php echo '<a href="horaire/horaire_rediriger.php?modifier_news=' . $donnees['Id_Horaire'] . '">'; ?>Modifier</a></td>
<td><?php echo '<a href="horaire/horaire1.php?supprimer_news=' .$donnees['Id_Horaire'] . '">'; ?>Supprimer</a></td>
<td><?php echo stripslashes($donnees['Semaine']); ?></td>
<td><?php echo stripslashes($donnees['Faculte']); ?></td>
</tr>
<?php
} // Fin de la boucle qui liste les news.
?>
</table>	
