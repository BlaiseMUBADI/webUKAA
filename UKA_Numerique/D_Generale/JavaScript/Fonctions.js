
/*********************************************************************************
 * ********* ICI ON CREE LE MENU CONTEXTUEL SUR LES MENU A GAUCHE ****************
 * *******************************************************************************
 */

// Ce menu concerne la caisse ou la gestion de la perception
const Li_Pereception=document.getElementById("Li_Perception");
const Li_Budget=document.getElementById("Li_Budget");
const Li_Administration=document.getElementById("Li_Administration");
const Li_Comptable=document.getElementById("Li_Comptable");


// ce menu concerne l'Administration
const Li_Gestion_USER=document.getElementById("Li_Gestion_user");


// ce menu concerne la gestion de la faculté 
const Li_Gestion_UEs=document.getElementById("Li_Gestion_UEs")
const Li_Gestion_Encodage=document.getElementById("Li_Gestion_Encodage")
const Li_Gestion_Enseignants=document.getElementById("Li_Gestion_Enseignants")


const tab_transact_sur_entre_par_manip_operation=document.getElementById("table_transact");

// ICI On attache avec les menus contextuels crées qui conserne la perception
const boite_perception = document.getElementById("Menu_contextuel_Perception");
const boite_budget= document.getElementById("Menu_contextuel_Budget");
const boite_administration= document.getElementById("Menu_contextuel_Adminstration");
const boite_comptable= document.getElementById("Menu_contextuel_Comptable");


// Ici on attache les menues contextuels créers qui concerne l'administration
const boite_gestion_user = document.getElementById("Menu_contextuel_Gestion_user");

// Ici on attache les menus contextuels créers qui concerne la gestion des UEs
const boite_gestion_UEs=document.getElementById("Menu_contextuel_Gestion_UE")
const boite_gestion_cote=document.getElementById("Menu_contextuel_Gestion_cote")

// Ici on attache les menus contextuels créers qui concerne la gestion des Enseignants
const boite_gestion_Enseignants=document.getElementById("Menu_contextuel_Gestion_Enseignants")




//const menu_contextuel_sur_tab_manip_operation= document.getElementById("Menu_contextuel_operation");

if(Li_Pereception!=null)
{
    //
    Li_Pereception.addEventListener("contextmenu", function(event) {
        event.preventDefault();
        boite_perception.style.top = Li_Pereception.pageY+"px";
        boite_perception.style.left = "55px";
        boite_perception.classList.add("show");
      });

}

if(Li_Budget!=null)
{
    //
    Li_Budget.addEventListener("contextmenu", function(event) {
        event.preventDefault();

        // ici on efface toute autres boite de dialog
        boite_budget.style.top = Li_Budget.pageY+"px";
        boite_budget.style.left = "55px";
        boite_budget.classList.add("show");
      });

}


if(Li_Comptable!=null)
{
  console.log(" je suis dans comptable");
    //
    Li_Comptable.addEventListener("contextmenu", function(event) {
        event.preventDefault();

        // ici on efface toute autres boite de dialog
        boite_comptable.style.top = boite_comptable.pageY+"px";
        boite_comptable.style.left = "55px";
        boite_comptable.classList.add("show");
      });

}


/*
****************** POUR ICI  ON MONAPULE LES COMPOSANTS DU MENU GESTION UE
*/

if(Li_Administration!=null)
{
    //
    Li_Administration.addEventListener("contextmenu", function(event) {
        event.preventDefault();

        // ici on efface toute autres boite de dialog
        boite_administration.style.top = Li_Administration.pageY+"px";
        boite_administration.style.left = "55px";
        boite_administration.classList.add("show");
      });

}

if(Li_Gestion_USER!=null)
{
    //
    Li_Gestion_USER.addEventListener("contextmenu", function(event) {
        event.preventDefault();
        boite_gestion_user.style.top = Li_Gestion_USER.pageY+"px";
        boite_gestion_user.style.left = "55px";
        boite_gestion_user.classList.add("show");
      });

}

if(Li_Gestion_UEs!=null)
{
    //
    Li_Gestion_UEs.addEventListener("contextmenu", function(event) {
        event.preventDefault();

        // ici on efface toute autres boite de dialog
        boite_gestion_UEs.style.top = Li_Gestion_UEs.pageY+"px";
        boite_gestion_UEs.style.left = "55px";
        boite_gestion_UEs.classList.add("show");
      });

}



if(Li_Gestion_Encodage!=null)
{
      //
      Li_Gestion_Encodage.addEventListener("contextmenu", function(event) {
          event.preventDefault();
  
          // ici on efface toute autres boite de dialog
          boite_gestion_cote.style.top = Li_Gestion_Encodage.pageY+"px";
          boite_gestion_cote.style.left = "55px";
          boite_gestion_cote.classList.add("show");
        });
  
}


if(Li_Gestion_Enseignants!=null)
  {
      //
      Li_Gestion_Enseignants.addEventListener("contextmenu", function(event) {
          event.preventDefault();
  
          // ici on efface toute autres boite de dialog
          boite_gestion_Enseignants.style.top = Li_Gestion_Enseignants.pageY+"px";
          boite_gestion_Enseignants.style.left = "55px";
          boite_gestion_Enseignants.classList.add("show");
        });
  
  }


// Ce bloc nous permet de désactiver le ménu contextuel une fois que l'on clique n'importe où sur la page
document.addEventListener("click", function(event)
{
  if(Li_Pereception!=null) boite_perception.classList.remove("show");
  if(Li_Budget!=null)  boite_budget.classList.remove("show");
  if(Li_Gestion_USER!=null) boite_gestion_user.classList.remove("show");
  if(Li_Gestion_UEs!=null) boite_gestion_UEs.classList.remove("show");
  if(Li_Gestion_Encodage!=null) boite_gestion_cote.classList.remove("show");
  if(Li_Gestion_Enseignants!=null) boite_gestion_Enseignants.classList.remove("show");
});

/* ********************* FIN MENU PERCEPTION ************************/



/*****************************************************************************************
 * ************* ICI LA DECLARATION DE FONCTION POUR  AFFICHER LE MONATNT EN TOUTE LETTRE
 *****************************************************************************************/

/*****************************ICI C'EST LA FONCTION QUI PERMET DE CONVERTIR UN NOMBRE EN CHANE DE CARCATERE */
// Tableaux pour les nombres de 1 à 19 et les dizaines
const nombres1a19 = [
    "", "Un", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf",
    "Dix", "Onze", "Douze", "Treize", "Quatorze", "Quinze", "Seize", "Dix-sept",
    "Dix-huit", "Dix-neuf"
  ];
const dizaines = [
    "", "", "Vingt", "Trente", "Quarante", "Cinquante", "Soixante", "Soixante",
    "Quatre-vingt", "Quatre-vingt"
  ];
  
  // Fonction pour convertir un nombre en chaîne de caractères
  function Conversion_Nombre_En_ChaineCaractere(nombre) {
    if (nombre === 0) {
      return "zéro";
    } else {
      return ConvertirNombre(nombre);
    }
  }
  
  // Fonction récursive pour convertir un nombre non nul en chaîne de caractères
  function ConvertirNombre(nombre) {
    if (nombre < 20) {
      return nombres1a19[nombre];
    } else if (nombre < 100) {
      const unite = nombre % 10;
      const dizaine = Math.floor(nombre / 10);
      
      let chaineDizaine = dizaines[dizaine];
      if (dizaine === 7 || dizaine === 9) {
        chaineDizaine = chaineDizaine.slice(0, -1); // Supprimer le 'e' final
      }
      
      let chaineUnite = "";
      if (unite === 1 || unite === 11) {
        chaineUnite = "et-" + nombres1a19[unite];
      } else if (unite > 1) {
        chaineUnite = "-" + nombres1a19[unite];
      }
      
      return chaineDizaine + chaineUnite;
    } else if (nombre < 1000) {
      const centaine = Math.floor(nombre / 100);
      const reste = nombre % 100;
      
      let chaineCentaine = nombres1a19[centaine] + " cent";
      if (centaine > 1) {
        chaineCentaine += "s";
      }
      
      let chaineReste = ConvertirNombre(reste);
      
      return chaineCentaine + " " + chaineReste;
    } else if (nombre < 1000000) {
      const millier = Math.floor(nombre / 1000);
      const reste = nombre % 1000;
      
      let chaineMillier = ConvertirNombre(millier) + " mille";
      if (millier > 1) {
        chaineMillier += "s";
      }
      
      let chaineReste = ConvertirNombre(reste);
      
      return chaineMillier + " " + chaineReste;
    } else if (nombre < 1000000000) {
      const million = Math.floor(nombre / 1000000);
      const reste = nombre % 1000000;
      
      let chaineMillion = ConvertirNombre(million) + " million";
      if (million > 1) {
        chaineMillion += "s";
      }
      
      let chaineReste = ConvertirNombre(reste);
      
      return chaineMillion + " " + chaineReste;
    } else {
      return "Nombre trop grand pour être converti.";
    }
  }
  

  /****************************************************************************
   * ************* FONCTION FAIT PARLER L'ORDINATEUR  *************************
   ****************************************************************************/
  function parler(text) 
  {
    var speech = new SpeechSynthesisUtterance();
    speech.lang = "fr-FR"; // Choisir la langue
    speech.text = text;
    window.speechSynthesis.speak(speech);
}
  