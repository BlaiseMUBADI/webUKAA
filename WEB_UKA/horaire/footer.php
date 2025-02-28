
<section data-bs-version="5.1" class="footer7 cid-tVuvH1dJHp" once="footers" id="footer7-0">

    

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container">
        <div class="media-container-row align-center mbr-white">
            <div class="col-12">
                <p class="mbr-text mb-0 mbr-fonts-style display-7">
                    © <a href="Authentification.php" style="color:#fff;">Copyright </a> ===>
					<a href="deconnexion.php" style="color:#fff;">
                    <?php 


                        if(isset($_SESSION['Etat_connexion'])=="vrai")
                        {                            
                            if($_SESSION['Etat_connexion']=="vrai") echo $_SESSION['Nom_user'] ;
                            else echo "Connexion";
                        }
                        else echo "Connexion";
                    ?></a> | Cellule Informatique de l'UKA</p>
            </div>
        </div>
    </div>
</section>