

  <section class="home-section" style="height: auto;">
        <?php
          require_once 'D_Generale/Profil_Sec_Administratif.php';
        ?>

      <div class="home-content me-3 ms-3 "id=""style="height:auto;"  >
        <div class="sales-boxes m-0 p-0 " >
          <div class="recent-sales box " style="width:100%; margin:0px;">
            
            <div class=" wrapper login-2 " id="Calendrier">
                <div class="containe">
                    <div class="col-left">
                        <div class="login-form">
                            <h2>Evenements</h2>
                            <form>
                            Titre:
                                <p>
                                
                                <select id="typeConge" name="" class="form-control " style="width:100%;font-family:Palatino Linotype;">
                                    <option value="" selected>-</option>
                                    <?php 
                                            //Requette de sélection de catégorie agent
                                            $req="select * from type_conge order by IdTypeConge Asc";
                                            $data= $con-> query($req);
                                            while ($ligne=$data->fetch())
                                            {
                                            ?>
                                            <option value="<?php echo $ligne['IdTypeConge']?>"><?php echo $ligne['Libelle'];?></option>
                                            <?php 
                                            }
                                            ?>     
                                    </select>
                                
                                </p>
                                Date-début :
                                <p>
                                
                                <input type="Date" id="date-debut" placeholder=" " required>
                                
                                </p>
                                Date-fin :
                                <p>
                                
                                <input type="Date" id="date-fin" placeholder=" " required>
                                
                                </p>
                                
                                <p>
                                    <input class="btn" type="submit" value="Enregistrer" />
                                </p>
                            
                            </form>
                        </div>
                    </div>
                       
                    <div class='col-right'>               
                        <div id='calendrier'></div>              
                    </div>
                </div>           
            </div>
        </div>
    </div>
</div>
  </section>
    
       



