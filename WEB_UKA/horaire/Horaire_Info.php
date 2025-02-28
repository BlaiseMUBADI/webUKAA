
<?php

//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une news ?
//-----------------------------------------------------
//if (isset($_POST['Faculte'])) 
{
$Faculte = ($_GET['page']);
//$Faculte="Informatique"; 
$reponse = $bdd->query ('SELECT * FROM horaire WHERE Faculte=\'' . $Faculte . '\' order by Id_Horaire Desc limit 0,1' );
while ($ligne = $reponse->fetch())
//while($ligne=mysql_fetch_array ($reponse))
{
echo "<center>";
echo 'Semaine du : '. '<span style="font-size:16px;">' . '<strong>'. '<span class="gt-baf-word-clickable">'; echo $ligne['Semaine']; echo '</span>'.'</strong>'.'</span>'.'<br>';
echo 'Faculté : '. '<span style="font-size:1em; color:#fff; background-color:green; padding:0.5%; border-radius:10px;">' . '<strong>'. '<span class="gt-baf-word-clickable">'; echo $ligne['Faculte']; echo '</span>'.'</strong>'.'</span>'.'<br>';
echo "</center>";
?>
<br>

<table border=1 width=100% size=50 >
 <tr align="center"> 
   <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td> <b>Licence 1 (LMD)</b></td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
   <td rowspan=2> Lundi  </td>
	<td width=14% >  08h30'-12h10' </td>
	<td> <?php echo $ligne['LAVMG1']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>  <?php echo $ligne['LAPMG1']; ?> </td>
 </tr>


 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MAVMG1']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MAPMG1']; ?> </td>
 </tr>

 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2>  Mercredi </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MeAVMG1']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MeAPMG1']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['JAVMG1']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
    <td>   <?php echo $ligne['JAPMG1']; ?> </td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Vendredi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['VAVMG1']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['VAPMG1']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['SAVMG1']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['SAPMG1']; ?> </td>
 </tr>
</table>


<br><br>

<table border=1 width=100% size=50 >
 <tr align="center"> 
   <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td> <b>Licence 2 (LMD)</b></td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
   <td rowspan=2> Lundi  </td>
	<td width=14% >  08h30'-12h10' </td>
	<td> <?php echo $ligne['LAVMG2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>  <?php echo $ligne['LAPMG2']; ?> </td>
 </tr>


 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MAVMG2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MAPMG2']; ?> </td>
 </tr>

 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2>  Mercredi </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MeAVMG2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MeAPMG2']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['JAVMG2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
    <td>   <?php echo $ligne['JAPMG2']; ?> </td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Vendredi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['VAVMG2']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['VAPMG2']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['SAVMG2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['SAPMG2']; ?> </td>
 </tr>
</table>


<br><br>

<table border=1 width=100% size=50 >
 <tr align="center"> 
   <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td> <b>Licence 3 (LMD)</b></td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
   <td rowspan=2> Lundi  </td>
	<td width=14% >  08h30'-12h10' </td>
	<td> <?php echo $ligne['LAVMG3']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>  <?php echo $ligne['LAPMG3']; ?> </td>
 </tr>


 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MAVMG3']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MAPMG3']; ?> </td>
 </tr>

 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2>  Mercredi </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MeAVMG3']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MeAPMG3']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['JAVMG3']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
    <td>   <?php echo $ligne['JAPMG3']; ?> </td>
 </tr>


 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Vendredi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['VAVMG3']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['VAPMG3']; ?> </td>
 </tr>

 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['SAVMG3']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['SAPMG3']; ?> </td>
 </tr>
</table>


<br><br>
<table border=1 width=100% size=50 >
 <tr align="center"> 
    <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td><b> L1 </b></td>
	
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Lundi  </td>
	<td width=14% >  0830'-12h10' </td>
	<td> <?php echo $ligne['LAVML1']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>  <?php echo $ligne['LAPML1']; ?> </td>

 </tr>
 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MAVML1']; ?> </td>

 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MAPML1']; ?> </td>
	
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2>  Mercredi </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['MeAVML1']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MeAPML1']; ?> </td>

 </tr>
 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['JAVML1']; ?> </td>

 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['JAPML1']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Vendredi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['VAVML1']; ?> </td>

 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['VAPML1']; ?> </td>

 </tr>
 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['SAVML1']; ?> </td>

 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['SAPML1']; ?> </td>

 </tr>
</table>


<br><br>
<table border=1 width=100% size=50 >
 <tr align="center"> 
    <td width=10%> <b>Jour/Date</b> </td>
	<td> <b>Heure </b> </td>
	<td> <b>L2 </b></td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Lundi  </td>
	<td width=14% >  0830'-12h10' </td>

	<td> <?php echo $ligne['LAVML2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>  <?php echo $ligne['LAPML2']; ?> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Mardi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['MAVML2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>

	<td>   <?php echo $ligne['MAPML2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2>  Mercredi </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['MeAVML2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['MeAPML2']; ?> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Jeudi  </td>
	<td>  0830'-12h10' </td>
	<td>   <?php echo $ligne['JAVML2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['JAPML2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
    <td rowspan=2> Vendredi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['VAVML2']; ?> </td>
 </tr>
 <tr align="center" style="background-color:#ced4e5;"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['VAPML2']; ?> </td>
 </tr>
 <tr align="center"> 
    <td rowspan=2> Samedi  </td>
	<td>  08h30'-12h10' </td>
	<td>   <?php echo $ligne['SAVML2']; ?> </td>
 </tr>
 <tr align="center"> 
	<td>  13h30'-17h10' </td>
	<td>   <?php echo $ligne['SAPML2']; ?> </td>
 </tr>
</table>


<?php
}
}
?>