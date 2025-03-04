<?php
// +-------------------------------------------------+
// � 2002-2005 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: suggestions.class.php,v 1.15 2011-08-10 10:08:27 dbellamy Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class suggestions{
	
	
	var $id_suggestion = 0;						//Identifiant de suggestion	
	var $titre  = '';							//Titre ouvrage
	var $editeur = '';							//Editeur ou diffuseur
	var $auteur = '';							//Auteur ouvrage
	var $code = '';								//ISBN, ISSN, ...				
	var $prix = '0.00';							//Prix indicatif
	var $nb = 1;								//Quantit� � commander
	var $commentaires = '';						//Commentaires sur la suggestion
	var $date_creation = '0000-00-00';			
	var $date_decision = '0000-00-00';			//Date de la d�cision
	var $statut = '1';							//Statut de la suggestion 
	var $num_produit = 0;						//Identifiant du type de produit 
	var $num_entite = 0;						//Identifiant de l'entit� sur laquelle est affect�e la suggestion
	var $num_rubrique = 0;						//Identifiant de la rubrique budgetaire d'affectation
	var $num_fournisseur = 0;					//Identifiant du fournisseur associ�
	var $num_notice = 0;						//Identifiant de notice si catalogu�e			
	var $index_suggestion = '';					//Champ de recherche fulltext
	var $url_suggestion = '';					//URL
	var $num_categ = '1';						//Categorie associee a la suggestion
	var $sugg_location = 0;					//localisation
	var $date_publi='0000-00-00';			//date de publication
	var $sugg_src=0;						//source de la suggestion
	var $sugg_explnum=0;						//explnum attach�
	
	//Constructeur.	 
	function suggestions($id_suggestion= 0) {
		
		if ($id_suggestion) {
			$this->id_suggestion = $id_suggestion;
			$this->load();	
		}

	}	
	
	
	// charge une suggestion � partir de la base.
	function load(){
	
		global $dbh;
		
		$q = "select * from suggestions left join explnum_doc_sugg on num_suggestion=id_suggestion where id_suggestion = '".$this->id_suggestion."' ";
		$r = mysql_query($q, $dbh) ;
		$obj = mysql_fetch_object($r);
		$this->titre = $obj->titre;
		$this->editeur = $obj->editeur;
		$this->auteur = $obj->auteur;
		$this->code = $obj->code;
		$this->prix = $obj->prix;
		$this->nb = $obj->nb;
		$this->commentaires = $obj->commentaires;
		$this->date_creation = $obj->date_creation;
		$this->date_decision = $obj->date_decision;
		$this->statut = $obj->statut;
		$this->num_produit = $obj->num_produit;
		$this->num_entite = $obj->num_entite;
		$this->num_rubrique  = $obj->num_rubrique ;
		$this->num_fournisseur = $obj->num_fournisseur;
		$this->num_notice = $obj->num_notice;
		$this->index_suggestion = $obj->index_suggestion;
		$this->url_suggestion = $obj->url_suggestion;
		$this->num_categ = $obj->num_categ;
		$this->sugg_location = $obj->sugg_location;
		$this->date_publi = $obj->date_publication;
		$this->sugg_src = $obj->sugg_source;
		$this->sugg_explnum = $obj->num_explnum_doc;
	}

	
	// enregistre une suggestion en base.
	function save($explnum_doc=""){
		
		global $dbh;
		
		if(($this->titre == '') || ((($this->editeur == '') && ($this->auteur == '')) && (!$this->code) && (!$this->sugg_explnum && !$explnum_doc))) 
			die("Erreur de cr�ation suggestions");
	
		if ($this->id_suggestion) {
			
			$q = "update suggestions set titre = '".addslashes($this->titre)."', editeur = '".addslashes($this->editeur)."', ";
			$q.= "auteur = '".addslashes($this->auteur)."', code = '".addslashes($this->code)."', prix = '".$this->prix."', nb = '".$this->nb."', commentaires = '".addslashes($this->commentaires)."', ";
			$q.= "date_creation = '".$this->date_creation."', date_decision = '".$this->date_decision."', statut = '".$this->statut."', ";
			$q.= "num_produit = '".$this->num_produit."', num_entite = '".$this->num_entite."', num_rubrique = '".$this->num_rubrique."', ";
			$q.= "num_fournisseur = '".$this->num_fournisseur."', num_notice = '".$this->num_notice."', "; 
			$q.= "index_suggestion = ' ".strip_empty_words($this->titre)." ".strip_empty_words($this->editeur)." ".strip_empty_words($this->auteur)." ".$this->code." ".strip_empty_words($this->commentaires)." ', ";
			$q.= "url_suggestion = '".addslashes($this->url_suggestion)."', "; 
			$q.= "num_categ = '".$this->num_categ."', ";
			$q.= "sugg_location = '".$this->sugg_location."', ";
			$q.= "date_publication = '".$this->date_publi."', ";
			$q.= "sugg_source = '".$this->sugg_src."' ";
			$q.= "where id_suggestion = '".$this->id_suggestion."' ";
			mysql_query($q, $dbh);
			
		} else {
			$q = "insert into suggestions set titre = '".addslashes($this->titre)."', editeur = '".addslashes($this->editeur)."', ";
			$q.= "auteur = '".addslashes($this->auteur)."', code = '".addslashes($this->code)."', prix = '".$this->prix."', nb = '".$this->nb."', commentaires = '".addslashes($this->commentaires)."', ";
			$q.= "date_creation = '".$this->date_creation."', date_decision = '".$this->date_decision."', statut = '".$this->statut."', ";
			$q.= "num_produit = '".$this->num_produit."', num_entite = '".$this->num_entite."', num_rubrique = '".$this->num_rubrique."', ";
			$q.= "num_fournisseur = '".$this->num_fournisseur."', num_notice = '".$this->num_notice."', "; 
			$q.= "index_suggestion = ' ".addslashes(strip_empty_words($this->titre)." ".strip_empty_words($this->editeur)." ".strip_empty_words($this->auteur)." ".$this->code." ".strip_empty_words($this->commentaires))." ', ";
			$q.= "url_suggestion = '".addslashes($this->url_suggestion)."', ";
			$q.= "num_categ = '".$this->num_categ."', ";
			$q.= "sugg_location = '".$this->sugg_location."', ";
			$q.= "date_publication = '".$this->date_publi."', ";
			$q.= "sugg_source = '".$this->sugg_src."' "; 			
			mysql_query($q, $dbh);
			$this->id_suggestion = mysql_insert_id($dbh);
		
		}
		
		if($explnum_doc){
			$explnum_doc->save();
			$req = "insert into explnum_doc_sugg set 
				num_explnum_doc='".$explnum_doc->explnum_doc_id."',
				num_suggestion='".$this->id_suggestion."'";
			mysql_query($req,$dbh);
		}
	}


	//V�rifie si une suggestion existe d�j� en base
	static function exists($origine, $titre, $auteur, $editeur, $isbn) {

		global $dbh;
		$q = "select count(1) from suggestions_origine, suggestions where origine = '".$origine."' and titre = '".$titre."' and id_suggestion = num_suggestion and auteur='".$auteur."' and editeur = '".$editeur."' and code = '".$isbn."'";
		$r = mysql_query($q, $dbh);
		return mysql_result($r, 0, 0);

	}


	//supprime une suggestion de la base
	function delete($id_suggestion= 0) {
		
		global $dbh;

		if(!$id_suggestion) $id_suggestion = $this->id_suggestion; 	

		$q = "delete from suggestions where id_suggestion = '".$id_suggestion."' ";
		$r = mysql_query($q, $dbh);
				
	}


	//Compte le nb de suggestion par statut pour une biblioth�que
	function getNbSuggestions($id_bibli=0, $statut='-1', $num_categ='-1', $mask, $aq=0) {
		
		global $dbh;
		if (!$statut) $statut='-1';
		if ($statut == '-1') { 
			$filtre1 = '1';
		} elseif ($statut == $mask) {
			$filtre1 = "(statut & '".$mask."') = '".$mask."' ";
		} else {
			$filtre1 = "(statut & '".$mask."') = 0 and (statut & '".$statut."') = '".$statut."' ";
		}
		
		if ($num_categ == '-1') {
			$filtre2 = '1';
		} else {
			$filtre2 = "num_categ = '".$num_categ."' ";
		}
			
		if (!$id_bibli) $filtre3 = '1';
			else $filtre3.= "num_entite = '".$id_bibli."' ";
		
		if (!$aq) {
			$q = "select count(1) from suggestions where 1 ";
			$q.= "and ".$filtre1." and ".$filtre2." and ".$filtre3." "; 
		} else {
			$q = $aq->get_query_count("suggestions","concat(titre,' ',editeur,' ',auteur,' ',commentaires)","index_suggestion", "id_suggestion", $filtre1." and ".$filtre2." and ".$filtre3 );
		}
		$r = mysql_query($q, $dbh); 
		return mysql_result($r, 0, 0); 
			
	}
	
	
	//Retourne une requete pour liste des suggestions par statut pour une biblioth�que
	function listSuggestions($id_bibli=0, $statut='-1', $num_categ='-1', $mask, $debut=0, $nb_per_page=0, $aq=0, $order='',$location=0) {

		if ($statut == '-1') { 
			$filtre1 = '1';
		} elseif ($statut == $mask) {
			$filtre1 = "(statut & '".$mask."') = '".$mask."' ";
		} else {
			$filtre1 = "(statut & '".$mask."') = 0 and (statut & ".$statut.") = '".$statut."' ";
		}
			
		if ($num_categ == '-1') {
			$filtre2 = '1';
		} else {
			$filtre2 = "num_categ = '".$num_categ."' ";
		}

		if (!$id_bibli) $filtre3 = '1';
			else $filtre3.= "num_entite = '".$id_bibli."' ";

		if ($location == 0) {
			$filtre4 = '1';
		} else {
			$filtre4 = "sugg_location = '".$location."' ";
		}		
		if(!$aq) {
			
			$q = "select * from suggestions where 1 ";
			$q.= "and ".$filtre1." and ".$filtre2." and ".$filtre3." and ".$filtre4 ." ";
			if(!$order) $q.="order by statut, date_creation desc ";
				else $q.= "order by".$order." ";
			
		} else {
			
			$members=$aq->get_query_members("suggestions","concat(titre,' ',editeur,' ',auteur,' ',commentaires)","index_suggestion","id_suggestion", $filtre1." and ".$filtre2." and ".$filtre3." and ".$filtre4);
			if (!$order) {
				$q = "select *, ".$members["select"]." as pert from suggestions where ".$members["where"]." and ".$members["restrict"]." order by pert desc ";	
			} else {
				$q = "select *, ".$members["select"]." as pert from suggestions where ".$members["where"]." and ".$members["restrict"]." order by ".$order.", pert desc ";
			}
		}  
		
		if (!$debut && $nb_per_page) $q.= "limit ".$nb_per_page;
		if ($debut && $nb_per_page) $q.= "limit ".$debut.",".$nb_per_page;

		return $q;				
	}

	
	//Retourne  une requete pour liste des suggestions par origine 
	//type_origine: 0=utilisateur, 1=lecteur, 2=visiteur
	function listSuggestionsByOrigine($id_origine, $type_origine='1') { 
		
		$q = "select * from suggestions_origine, suggestions where origine = '".$id_origine."' ";
		if ($type_origine != '-1') $q.= "and type_origine = '".$type_origine."' ";
		$q.= "and id_suggestion=num_suggestion order by date_suggestion ";		
		return $q;				
	}

	
	//Retourne un tableau des origines pour une suggestion
	function getOrigines($id_suggestion=0) {
		
		global $dbh;
		$tab_orig=array();
		if (!$id_suggestion) $id_suggestion = $this->id_suggestion;
		$q = "select * from suggestions_origine where num_suggestion=$id_suggestion order by date_suggestion, type_origine ";
		$r = mysql_query($q, $dbh);
			
		for($i=0;$i<mysql_num_rows($r);$i++) {
			$tab_orig[] = mysql_fetch_array($r,MYSQL_ASSOC); 
		}
		return $tab_orig;
	}
	
	
	//optimization de la table suggestions
	function optimize() {
		
		global $dbh;
		
		$opt = mysql_query('OPTIMIZE TABLE suggestions', $dbh);
		return $opt;
				
	}
	

	//R�cup�ration du docnum associ�
	function get_explnum($champ=''){
		global $dbh;
		
		$req = "select * from explnum_doc join explnum_doc_sugg on num_explnum_doc=id_explnum_doc where num_suggestion='".$this->id_suggestion."'";
		$res= mysql_query($req,$dbh);
		if(mysql_num_rows($res)){
			$tab = mysql_fetch_array($res);
			switch($champ){				
				case 'id':
					return $tab['id_explnum_doc'];
					break;
				case 'nom':
					return $tab['explnum_doc_nomfichier'];
					break;
				case 'ext';
					return $tab['explnum_doc_extfichier'];
					break;
				case 'mime';
					return $tab['explnum_doc_mimetype'];
					break;	
			}
		}
		return 0;
	}
	
				
}
?>