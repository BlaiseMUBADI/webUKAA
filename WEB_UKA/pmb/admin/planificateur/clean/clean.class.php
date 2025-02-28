<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: clean.class.php,v 1.1 2011-07-29 12:32:13 dgoron Exp $

global $class_path, $include_path;
require_once($include_path."/parser.inc.php");
require_once($class_path."/tache.class.php");

// definitions
define('INDEX_GLOBAL'			, 1);
define('INDEX_NOTICES'			, 2);
define('CLEAN_AUTHORS'			, 4);
define('CLEAN_PUBLISHERS'		, 8);
define('CLEAN_COLLECTIONS'		, 16);
define('CLEAN_SUBCOLLECTIONS'	, 32);
define('CLEAN_CATEGORIES'		, 64);
define('CLEAN_SERIES'			, 128);
define('CLEAN_RELATIONS'		, 256);
define('CLEAN_NOTICES'			, 512);
define('INDEX_ACQUISITIONS'		, 1024);
define('GEN_SIGNATURE_NOTICE'	, 2048);
define('NETTOYAGE_CLEAN_TAGS'	, 4096);
define('CLEAN_CATEGORIES_PATH'	, 8192);
define('GEN_DATE_PUBLICATION_ARTICLE'	, 16384);
define('GEN_DATE_TRI'	, 32768);
define('INDEX_DOCNUM'	, 65536);
		
class clean extends tache {
	var $id_tache;
	
	function clean($id_tache=''){
		global $base_path;
		
		parent::get_messages($base_path."/admin/planificateur/".get_class());
		$this->id_tache = $id_tache;
			
	}
	
	//formulaire spécifique au type de tâche
	function show_form ($param='') {
		global $msg, $charset, $acquisition_active, $pmb_indexation_docnum;
	
		if ($param["clean"]) {
			foreach ($param["clean"] as $name=>$value) {
				$$name = $value;
			}
		}
			
		$form_task .= "
		<div class='row'>
			<div class='colonne3'>
				<label for='bannette'>".$this->msg["planificateur_clean"]."</label>
			</div>
			<div class='colonne_suite'>
				<div class='row'>
					<input type='checkbox' value='1' name='index_global' ".($index_global == "1" ? "checked" :"").">&nbsp;<label class='etiquette' >".htmlentities($msg["nettoyage_index_global"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='2' name='index_notices' ".($index_notices == "2" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_index_notices"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='4' name='clean_authors' ".($clean_authors == "4" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_authors"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='8' name='clean_editeurs' ".($clean_editeurs == "8" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_editeurs"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='16' name='clean_collections' ".($clean_collections == "16" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_collections"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='32' name='clean_subcollections' ".($clean_subcollections == "32" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_subcollections"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='64' name='clean_categories' ".($clean_categories == "64" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_categories"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='128' name='clean_series' ".($clean_series == "128" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_series"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='hidden' value='256' name='clean_relations' />
					<input type='checkbox' value='256' name='clean_relationschk' checked disabled='disabled'/>&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_relations"], ENT_QUOTES, $charset)."</label>
					</div>
				<div class='row'>
					<input type='checkbox' value='512' name='clean_notices' ".($clean_notices == "512" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_expl"], ENT_QUOTES, $charset)."</label>
					</div>";		
			if ($acquisition_active) {
				$form_task .= "		
				<div class='row'>
					<input type='checkbox' value='1024' name='index_acquisitions' ".($index_acquisitions == "1024" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_reindex_acq"], ENT_QUOTES, $charset)."</label>
					</div>";
			}
				$form_task .= "	
					<div class='row'>
						<input type='checkbox' value='2048' name='gen_signature_notice' ".($gen_signature_notice == "2048" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["gen_signature_notice"], ENT_QUOTES, $charset)."</label>
						</div>
					<div class='row'>
						<input type='checkbox' value='4096' name='nettoyage_clean_tags' ".($nettoyage_clean_tags == "4096" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["nettoyage_clean_tags"], ENT_QUOTES, $charset)."</label>
						</div>
					<div class='row'>
						<input type='checkbox' value='8192' name='clean_categories_path' ".($clean_categories_path == "8192" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["clean_categories_path"], ENT_QUOTES, $charset)."</label>
						</div>
					<div class='row'>
						<input type='checkbox' value='16384' name='gen_date_publication_article' ".($gen_date_publication_article == "16384" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["gen_date_publication_article"], ENT_QUOTES, $charset)."</label>
						</div>
					<div class='row'>
						<input type='checkbox' value='32768' name='gen_date_tri' ".($gen_date_tri == "32768" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["gen_date_tri"], ENT_QUOTES, $charset)."</label>
						</div>";
			if($pmb_indexation_docnum){
				$form_task .= "	
				<div class='row'>
					<input type='checkbox' value='65536' name='reindex_docnum' ".($index_global == "1" ? "checked" :"").">&nbsp;<label class='etiquette'>".htmlentities($msg["docnum_reindexer"], ENT_QUOTES, $charset)."</label>
				</div>";
			}

			$form_task .= "
				</div>
			</div>";	
								
		return $form_task;
	}

	function task_execution($id_tache) {
		global $dbh, $msg, $charset, $PMBusername;
		global $acquisition_active,$pmb_indexation_docnum;
		
		if (SESSrights & ADMINISTRATION_AUTH) {
			$parameters = $this->unserialize_task_params($id_tache);
			$percent = 0;
			//progression
			$p_value = (int) 100/count($parameters["clean"]);
			$this->report[] = "<tr><th>".$this->msg["planificateur_clean"]."</th></tr>";
			$result="";
			foreach ($parameters["clean"] as $clean) {
				$this->listen_commande($id_tache, array(&$this,"traite_commande"));
				if($this->statut == WAITING) {
					$this->send_command($id_tache,RUNNING);
				}
				if ($this->statut == RUNNING) {
					switch ($clean) {
						case INDEX_GLOBAL:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_index_global"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_indexGlobal')) {
								$result .= $this->proxy->pmbesClean_indexGlobal();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexGlobal","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case INDEX_NOTICES:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_index_notices"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_indexNotices')) {
								$result .= $this->proxy->pmbesClean_indexNotices();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexNotices","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_AUTHORS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_authors"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanAuthors')) {
								$result .= $this->proxy->pmbesClean_cleanAuthors();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanAuthors","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_PUBLISHERS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_editeurs"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanPublishers')) {
								$result .= $this->proxy->pmbesClean_cleanPublishers();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanPublishers","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_COLLECTIONS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_collections"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanCollections')) {
								$result .= $this->proxy->pmbesClean_cleanCollections();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanCollections","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_SUBCOLLECTIONS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_subcollections"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanSubcollections')) {
								$result .= $this->proxy->pmbesClean_cleanSubcollections();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanSubcollections","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_CATEGORIES:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_categories"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanCategories')) {
								$result .= $this->proxy->pmbesClean_cleanCategories();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanCategories","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_SERIES:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_series"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanSeries')) {
								$result .= $this->proxy->pmbesClean_cleanSeries();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanSeries","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_RELATIONS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_relations"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanRelations')) {
								$result .= $this->proxy->pmbesClean_cleanRelations();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanRelations","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_NOTICES:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_expl"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanNotices')) {
								$result .= $this->proxy->pmbesClean_cleanNotices();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanNotices","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case INDEX_ACQUISITIONS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_reindex_acq"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if ($acquisition_active) {
								if (method_exists($this->proxy, 'pmbesClean_indexAcquisitions')) {
									$result .= $this->proxy->pmbesClean_indexAcquisitions();
									$percent += $p_value;
									$this->update_progression($id_tache, $percent);	
								} else {
									$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexAcquisitions","pmbesClean",$PMBusername)."</p>";
								}
							} else {
								$result .= "<p>".$this->msg["clean_acquisition"]."</p>";
							}
							$result .= "</td></tr>";
							break;
						case GEN_SIGNATURE_NOTICE:
							$result .= "<tr><th>".htmlentities($msg["gen_signature_notice"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_genSignatureNotice')) {
								$result .= $this->proxy->pmbesClean_genSignatureNotice();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genSignatureNotice","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case NETTOYAGE_CLEAN_TAGS:
							$result .= "<tr><th>".htmlentities($msg["nettoyage_clean_tags"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_nettoyageCleanTags')) {
								$result .= $this->proxy->pmbesClean_nettoyageCleanTags();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"nettoyageCleanTags","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case CLEAN_CATEGORIES_PATH:
							$result .= "<tr><th>".htmlentities($msg["clean_categories_path"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_cleanCategoriesPath')) {
								$result .= $this->proxy->pmbesClean_cleanCategoriesPath();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanCategoriesPath","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case GEN_DATE_PUBLICATION_ARTICLE:
							$result .= "<tr><th>".htmlentities($msg["gen_date_publication_article"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_genDatePublicationArticle')) {
								$result .= $this->proxy->pmbesClean_genDatePublicationArticle();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genDatePublicationArticle","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case GEN_DATE_TRI:
							$result .= "<tr><th>".htmlentities($msg["gen_date_tri"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if (method_exists($this->proxy, 'pmbesClean_genDateTri')) {
								$result .= $this->proxy->pmbesClean_genDateTri();
								$percent += $p_value;
								$this->update_progression($id_tache, $percent);	
							} else {
								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genDateTri","pmbesClean",$PMBusername)."</p>";
							}
							$result .= "</td></tr>";
							break;
						case INDEX_DOCNUM:
							$result .= "<tr><th>".htmlentities($msg["docnum_reindexer"], ENT_QUOTES, $charset)."</th></tr>";
							$result .= "<tr><td>";
							if ($pmb_indexation_docnum) {
								if (method_exists($this->proxy, 'pmbesClean_indexDocnum')) {
									$result .= $this->proxy->pmbesClean_indexDocnum();
									$percent += $p_value;
									$this->update_progression($id_tache, $percent);	
								} else {
									$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexDocnum","pmbesClean",$PMBusername)."</p>";
								}
							} else {
								$result .= "<p>".$this->msg["clean_indexation_docnum"]."</p>";
							}
							$result .= "</td></tr>";
							break;
					}
				}
			}
			$this->report[] = $result;
		} else {
			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
		}
		
	}
	
//	function task_execution($id_tache) {
//		global $dbh, $msg, $charset, $PMBusername;
//		global $acquisition_active,$pmb_indexation_docnum;
//		
////		if (SESSrights & ADMINISTRATION_AUTH) {
//			$parameters = $this->unserialize_task_params($id_tache);
//			$percent = 0;
//			//progression
//			$p_value = (int) 100/count($parameters["clean"]);
//			$this->report[] = "<tr><th>".$this->msg["planificateur_clean"]."</th></tr>";
//			$result="";
//			foreach ($parameters["clean"] as $clean) {
//				$this->listen_commande($id_tache, array(&$this,"traite_commande"));
//				if($this->statut == WAITING) {
//					$this->send_command($id_tache,RUNNING);
//				}
//				if ($this->statut == RUNNING) {
//					switch ($clean) {
//						case INDEX_GLOBAL:
//							$result .= "<h3>".htmlentities($msg["nettoyage_reindex_global"], ENT_QUOTES, $charset)."</h3>";
//							if (method_exists($this->proxy, 'pmbesClean_indexGlobal')) {
//								$result .= $this->proxy->pmbesClean_indexGlobal();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexGlobal","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case INDEX_NOTICES:
//							$result .= "<h3>".htmlentities($msg["nettoyage_reindex_notices"], ENT_QUOTES, $charset)."</h3>";
//							if (method_exists($this->proxy, 'pmbesClean_indexNotices')) {
//								$result .= $this->proxy->pmbesClean_indexNotices();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexNotices","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_AUTHORS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanAuthors')) {
//								$result .= $this->proxy->pmbesClean_cleanAuthors();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanAuthors","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_PUBLISHERS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanPublishers')) {
//								$result .= $this->proxy->pmbesClean_cleanPublishers();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanPublishers","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_COLLECTIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanCollections')) {
//								$result .= $this->proxy->pmbesClean_cleanCollections();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanCollections","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_SUBCOLLECTIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanSubcollections')) {
//								$result .= $this->proxy->pmbesClean_cleanSubcollections();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanSubcollections","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_CATEGORIES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanCategories')) {
//								$result .= $this->proxy->pmbesClean_cleanCategories();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanCategories","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_SERIES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanSeries')) {
//								$result .= $this->proxy->pmbesClean_cleanSeries();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanSeries","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_RELATIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanRelations')) {
//								$result .= $this->proxy->pmbesClean_cleanRelations();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanRelations","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_NOTICES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanNotices')) {
//								$result .= $this->proxy->pmbesClean_cleanNotices();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"cleanNotices","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case INDEX_ACQUISITIONS:
//							if ($acquisition_active) {
//								if (method_exists($this->proxy, 'pmbesClean_indexAcquisitions')) {
//									$result .= $this->proxy->pmbesClean_indexAcquisitions();
//									$percent += $p_value;
//									$this->update_progression($id_tache, $percent);	
//								} else {
//									$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexAcquisitions","pmbesClean",$PMBusername)."</p>";
//								}
//							} else {
//								$result .= "<p>".$this->msg["clean_acquisition"]."</p>";
//							}
//							break;
//						case GEN_SIGNATURE_NOTICE:
//							if (method_exists($this->proxy, 'pmbesClean_genSignatureNotice')) {
//								$result .= $this->proxy->pmbesClean_genSignatureNotice();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genSignatureNotice","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case NETTOYAGE_CLEAN_TAGS:
//							if (method_exists($this->proxy, 'pmbesClean_nettoyageCleanTags')) {
//								$result .= $this->proxy->pmbesClean_nettoyageCleanTags();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"nettoyageCleanTags","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case CLEAN_CATEGORIES_PATH:
//							if (method_exists($this->proxy, 'pmbesClean_nettoyageCleanTags')) {
//								$result .= $this->proxy->pmbesClean_nettoyageCleanTags();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"nettoyageCleanTags","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case GEN_DATE_PUBLICATION_ARTICLE:
//							if (method_exists($this->proxy, 'pmbesClean_genDatePublicationArticle')) {
//								$result .= $this->proxy->pmbesClean_genDatePublicationArticle();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genDatePublicationArticle","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case GEN_DATE_TRI:
//							if (method_exists($this->proxy, 'pmbesClean_genDateTri')) {
//								$result .= $this->proxy->pmbesClean_genDateTri();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$result .= "<p>".sprintf($msg["planificateur_function_rights"],"genDateTri","pmbesClean",$PMBusername)."</p>";
//							}
//							break;
//						case INDEX_DOCNUM:
//							if ($pmb_indexation_docnum) {
//								if (method_exists($this->proxy, 'pmbesClean_indexDocnum')) {
//									$result .= $this->proxy->pmbesClean_indexDocnum();
//									$percent += $p_value;
//									$this->update_progression($id_tache, $percent);	
//								} else {
//									$result .= "<p>".sprintf($msg["planificateur_function_rights"],"indexDocnum","pmbesClean",$PMBusername)."</p>";
//								}
//							} else {
//								$result .= "<p>".$this->msg["clean_indexation_docnum"]."</p>";
//							}
//							break;
//					}
//				}
//			}
//			$this->report[] = $result;
////		} else {
////			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
////		}
//		
//	}
	
	
//	function task_execution($id_tache) {
//		global $dbh, $msg, $PMBusername;
//		global $acquisition_active,$pmb_indexation_docnum;
//		
//		if (SESSrights & ADMINISTRATION_AUTH) {
//			$parameters = $this->unserialize_task_params($id_tache);
//			$percent = 0;
//			//progression
//			$p_value = (int) 100/count($parameters["clean"]);
//			$this->report[] = "<tr><th>".$this->msg["planificateur_clean"]."</th></tr>";
//			$result="";
//			foreach ($parameters["clean"] as $clean) {
//				$this->listen_commande($id_tache, array(&$this,"traite_commande"));
//				if($this->statut == WAITING) {
//					$this->send_command($id_tache,RUNNING);
//				}
//				if ($this->statut == RUNNING) {
//					switch ($clean) {
//						case INDEX_GLOBAL:
//							if (method_exists($this->proxy, 'pmbesClean_indexGlobal')) {
//								$result .= $this->proxy->pmbesClean_indexGlobal();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"indexGlobal","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case INDEX_NOTICES:
//							if (method_exists($this->proxy, 'pmbesClean_indexNotices')) {
//								$result .= $this->proxy->pmbesClean_indexNotices();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"indexNotices","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_AUTHORS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanAuthors')) {
//								$result .= $this->proxy->pmbesClean_cleanAuthors();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanAuthors","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_PUBLISHERS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanPublishers')) {
//								$result .= $this->proxy->pmbesClean_cleanPublishers();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanPublishers","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_COLLECTIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanCollections')) {
//								$result .= $this->proxy->pmbesClean_cleanCollections();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanCollections","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_SUBCOLLECTIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanSubcollections')) {
//								$result .= $this->proxy->pmbesClean_cleanSubcollections();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanSubcollections","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_CATEGORIES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanCategories')) {
//								$result .= $this->proxy->pmbesClean_cleanCategories();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanCategories","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_SERIES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanSeries')) {
//								$result .= $this->proxy->pmbesClean_cleanSeries();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanSeries","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_RELATIONS:
//							if (method_exists($this->proxy, 'pmbesClean_cleanRelations')) {
//								$result .= $this->proxy->pmbesClean_cleanRelations();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanRelations","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_NOTICES:
//							if (method_exists($this->proxy, 'pmbesClean_cleanNotices')) {
//								$result .= $this->proxy->pmbesClean_cleanNotices();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanNotices","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case INDEX_ACQUISITIONS:
//							if ($acquisition_active) {
//								if (method_exists($this->proxy, 'pmbesClean_indexAcquisitions')) {
//									$result .= $this->proxy->pmbesClean_indexAcquisitions();
//									$percent += $p_value;
//									$this->update_progression($id_tache, $percent);	
//								} else {
//									$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"indexAcquisitions","pmbesClean",$PMBusername)."</td></tr>";
//								}
//							} else {
//								$result .= "Module Acquisition non activé";
//							}
//							break;
//						case GEN_SIGNATURE_NOTICE:
//							if (method_exists($this->proxy, 'pmbesClean_genSignatureNotice')) {
//								$result .= $this->proxy->pmbesClean_genSignatureNotice();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"genSignatureNotice","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case NETTOYAGE_CLEAN_TAGS:
//							if (method_exists($this->proxy, 'pmbesClean_nettoyageCleanTags')) {
//								$result .= $this->proxy->pmbesClean_nettoyageCleanTags();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"nettoyageCleanTags","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case CLEAN_CATEGORIES_PATH:
//							if (method_exists($this->proxy, 'pmbesClean_nettoyageCleanTags')) {
//								$result .= $this->proxy->pmbesClean_nettoyageCleanTags();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"nettoyageCleanTags","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case GEN_DATE_PUBLICATION_ARTICLE:
//							if (method_exists($this->proxy, 'pmbesClean_genDatePublicationArticle')) {
//								$result .= $this->proxy->pmbesClean_genDatePublicationArticle();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"genDatePublicationArticle","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case GEN_DATE_TRI:
//							if (method_exists($this->proxy, 'pmbesClean_genDateTri')) {
//								$result .= $this->proxy->pmbesClean_genDateTri();
//								$percent += $p_value;
//								$this->update_progression($id_tache, $percent);	
//							} else {
//								$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"genDateTri","pmbesClean",$PMBusername)."</td></tr>";
//							}
//							break;
//						case INDEX_DOCNUM:
//							if ($pmb_indexation_docnum) {
//								if (method_exists($this->proxy, 'pmbesClean_indexDocnum')) {
//									$result .= $this->proxy->pmbesClean_indexDocnum();
//									$percent += $p_value;
//									$this->update_progression($id_tache, $percent);	
//								} else {
//									$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"indexDocnum","pmbesClean",$PMBusername)."</td></tr>";
//								}
//							} else {
//								$result .= "Module indexation docnum non activé";
//							}
//							break;
//					}
//				}
//			}
//		} else {
//			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
//		}

//		if (SESSrights & ADMINISTRATION_AUTH) {
//			$parameters = $this->unserialize_task_params($id_tache);
//		
//			$operations = array();
//			foreach ($parameters["clean"] as $clean) {
//				$operations[] = $clean;
//			}
//			$this->report[] = "<tr><th>".$this->msg["planificateur_clean"]."</th></tr>";
//
////			if (method_exists($this->proxy, 'pmbesClean_cleanBase')) {
//			if (method_exists($this->proxy, 'pmbesMySQL_cleanBase')) {
//				$percent = 0;
//				//progression
//				$p_value = (int) 100/count($operations);
//				foreach ($operations as $operation) {
//					$this->listen_commande($id_tache, array(&$this,"traite_commande"));
//					if($this->statut == WAITING) {
//						$this->send_command($id_tache,RUNNING);
//					}
//					if ($this->statut == RUNNING) {
//						$this->report[] = $this->proxy->pmbesMySQL_cleanBase($operation);
//						$percent += $p_value;
//						$this->update_progression($id_tache, $percent);
//					}
//				}	
////				$this->report[] = $this->proxy->pmbesMySQL_cleanBase($operations);
////				$this->update_progression($id_tache, 100);
//			} else {
//				$this->report[] = "<tr><td>".sprintf($msg["planificateur_function_rights"],"cleanBase","pmbesMySQL",$PMBusername)."</td></tr>";
//			}
//		} else {
//			$this->report[] = "<tr><th>".sprintf($msg["planificateur_rights_bad_user_rights"], $PMBusername)."</th></tr>";
//		}
//	}
	
	function traite_commande($cmd,$message) {
		
		switch ($cmd) {
			case RESUME :
				$this->send_command($this->id_tache,WAITING);
				break;
			case SUSPEND :
				$this->suspend_clean();
				break;
			case STOP :
				$this->finalize($this->id_tache);
				die();
				break;
			case FAIL :
				$this->finalize($this->id_tache);
				die();
				break;
//			case RETRY:
//				break;
		}
	}
		    
	function make_serialized_task_params() {
    	global $task_id;
    	global $index_global, $index_notices, $clean_authors, $clean_editeurs;
    	global $clean_collections, $clean_subcollections, $clean_categories;
    	global $clean_series, $clean_relations, $clean_notices, $index_acquisitions;
    	global $gen_signature_notice, $nettoyage_clean_tags, $clean_categories_path;
    	global $gen_date_publication_article, $gen_date_tri, $reindex_docnum;
    	
		$t = parent::make_serialized_task_params($task_id);
		
		$t_clean = array();
		if ($index_global) $t_clean["index_global"] = $index_global;
		if($index_notices) $t_clean["index_notices"] = $index_notices;
		if($clean_authors) $t_clean["clean_authors"] = $clean_authors;
		if($clean_editeurs) $t_clean["clean_editeurs"] = $clean_editeurs;
		if($clean_collections) $t_clean["clean_collections"] = $clean_collections;
		if($clean_subcollections) $t_clean["clean_subcollections"] = $clean_subcollections;
		if($clean_categories) $t_clean["clean_categories"] = $clean_categories;
		if($clean_series) $t_clean["clean_series"] = $clean_series;
		if($clean_notices) $t_clean["clean_notices"] = $clean_notices;
		if($index_acquisitions) $t_clean["index_acquisitions"] = $index_acquisitions;
		if($gen_signature_notice) $t_clean["gen_signature_notice"] = $gen_signature_notice;
		if($nettoyage_clean_tags) $t_clean["nettoyage_clean_tags"] = $nettoyage_clean_tags;
		if($clean_categories_path) $t_clean["clean_categories_path"] = $clean_categories_path;
		if($gen_date_publication_article) $t_clean["gen_date_publication_article"] = $gen_date_publication_article;
		if($gen_date_tri) $t_clean["gen_date_tri"] = $gen_date_tri;
		if($reindex_docnum) $t_clean["reindex_docnum"] = $reindex_docnum;
		if($clean_relations) $t_clean["clean_relations"] = $clean_relations;
    	
		$t["clean"] = $t_clean;
    	$this->types_taches->params=serialize($t);

    	return serialize($t);
	}

	function unserialize_task_params($id_tache) {
    	$params = $this->get_task_params($id_tache);
		
		return $params;
    }
    
	function suspend_clean() {
		while ($this->statut == SUSPENDED) {
			sleep(20);
			$this->listen_commande($this->id_tache, array(&$this,"traite_commande"));
		}
	}
}


