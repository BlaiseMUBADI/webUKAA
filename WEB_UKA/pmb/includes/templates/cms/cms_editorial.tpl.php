<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_editorial.tpl.php,v 1.1 2011-09-14 08:44:11 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) die("no access");

$cms_editorial_form_tpl = "
	<form name='!!cms_editorial_form_name!!' class='cms_editorial_form' action='./cms.php?categ=!!type!!&sub=save' id='!!cms_editorial_form_id!!' method='post' !!cms_editorial_form_attr!!>
		<h3>!!form_title!!</h3>
		<div class='form-contenu'>
			<input type='hidden' name='cms_editorial_form_obj_id' id='cms_editorial_form_obj_id' value='!!cms_editorial_form_obj_id!!' />
			!!fields!!
			<div class='row'>&nbsp;</div>
		</div>
		<div class='row'>
			<div class='left'>
				<input type='hidden' name='cms_editorial_form_delete' value='0' />
				<input type='submit' class='button' value='".$msg['cms_editorial_form_save']."' onclick='document.forms[\"!!cms_editorial_form_name!!\"].cms_editorial_form_delete.value=0;'/>
				!!cms_editorial_form_suppr!!
				!!cms_editorial_suite!!
			</div>
		</div>
		<div class='row'></div>
	</form>";

$cms_editorial_form_del_button_tpl ="
			<input type='submit' class='button' onclick='document.forms[\"!!cms_editorial_form_name!!\"].cms_editorial_form_delete.value=1;document.forms[\"!!cms_editorial_form_name!!\"].action=\"$base_path/cms.php?categ=sections&sub=del\"' value='".$msg['cms_editorial_form_delete']."'/>
";

$cms_editorial_parent_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_parent'>".$msg['cms_editorial_form_parent']."</label>
					</div>
					<div class='row'>
						<select name='cms_editorial_form_parent' id='cms_editorial_form_parent'>
							!!cms_editorial_form_parent_options!!
						</select> 
					</div>
				</div>
			</div>";


$cms_editorial_title_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_title'>".$msg['cms_editorial_form_title']."</label>
					</div>
					<div class='row'>
						<input type='text' name='cms_editorial_form_title' id='cms_editorial_form_title' value=\"!!cms_editorial_form_title!!\" size='36'/>
					</div>
				</div>
			</div>";

$cms_editorial_resume_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_resume'>".$msg['cms_editorial_form_resume']."</label>
					</div> 
					<div class='row'>
						<textarea name='cms_editorial_form_resume' id='cms_editorial_form_resume' rows='5' class='saisie-80em' wrap='virtual'>!!cms_editorial_form_resume!!</textarea>
					</div>
				</div>
			</div>";

$cms_editorial_contenu_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_contenu'>".$msg['cms_editorial_form_contenu']."</label>
					</div> 
					<div class='row'>
						<textarea name='cms_editorial_form_contenu' id='cms_editorial_form_contenu' rows='15' class='saisie-80em' wrap='virtual'>!!cms_editorial_form_contenu!!</textarea>
					</div>
				</div>
			</div>";

$cms_editorial_desc_field = "
			<div class='row'>
				<div class='colonne'>
				    <div class='row'>
    				   	<label for='cms_editorial_form_desc'>".$msg['cms_editorial_form_desc']."</label>
    				</div>
    				<div class='row'>
    					!!cms_categs!!
    					<div id='addcateg'/></div>
					</div>
				</div>
			</div>
			<script type='text/javascript'>
				ajax_parse_dom();
				function add_categ() {
			        template = document.getElementById('addcateg');
			        categ=document.createElement('div');
			        categ.className='row';
			
			        suffixe = eval('document.!!cms_editorial_form_name!!.max_categ.value')
			        nom_id = 'f_categ'+suffixe
			        f_categ = document.createElement('input');
			        f_categ.setAttribute('name',nom_id);
			        f_categ.setAttribute('id',nom_id);
			        f_categ.setAttribute('type','text');
			        f_categ.className='saisie-80emr';
			        f_categ.setAttribute('value','');
					f_categ.setAttribute('completion','categories_mul');
			        f_categ.setAttribute('autfield','f_categ_id'+suffixe);
			 
			        del_f_categ = document.createElement('input');
			        del_f_categ.setAttribute('id','del_f_categ'+suffixe);
			        del_f_categ.onclick=fonction_raz_categ;
			        del_f_categ.setAttribute('type','button');
			        del_f_categ.className='bouton';
			        del_f_categ.setAttribute('readonly','');
			        del_f_categ.setAttribute('value','$msg[raz]');
			
			        f_categ_id = document.createElement('input');
			        f_categ_id.name='f_categ_id'+suffixe;
			        f_categ_id.setAttribute('type','hidden');
			        f_categ_id.setAttribute('id','f_categ_id'+suffixe);
			        f_categ_id.setAttribute('value','');
			
			        categ.appendChild(f_categ);
			        space=document.createTextNode(' ');
			        categ.appendChild(space);
			        categ.appendChild(del_f_categ);
			        categ.appendChild(f_categ_id);
			
			        template.appendChild(categ);
			
			        document.!!cms_editorial_form_name!!.max_categ.value=suffixe*1+1*1 ;
			        ajax_pack_element(f_categ);
			    }
			    function fonction_selecteur_categ() {
			        name=this.getAttribute('id').substring(4);
			        name_id = name.substr(0,7)+'_id'+name.substr(7);
			        openPopUp('./select.php?what=categorie&caller=!!cms_editorial_form_name!!&p1='+name_id+'&p2='+name+'&dyn=1', 'select_categ', 700, 500, -2, -2, 'scrollbars=yes, toolbar=no, dependent=yes, resizable=yes');
			    }
			    function fonction_raz_categ() {
			        name=this.getAttribute('id').substring(4);
			        name_id = name.substr(0,7)+'_id'+name.substr(7);
			        document.getElementById(name_id).value=0;
			        document.getElementById(name).value='';
			    }    
			</script>";

$cms_editorial_first_desc = "
			    <div class='row'>
			     	<input type='hidden' name='max_categ' value=\"!!max_categ!!\" />
			        <input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
			
			        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
			        <input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=categorie&caller='+this.form.name+'&p1=f_categ_id!!icateg!!&p2=f_categ!!icateg!!&dyn=1&parent=0&deb_rech=', 'select_categ', 700, 500, -2, -2, '$select_categ_prop')\" />
			        <input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
			        <input type='button' class='bouton' value='+' onClick=\"add_categ();\"/>
			    </div>";
$cms_editorial_other_desc = "
			    <div class='row'>
			        <input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
			
			        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
			        <input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
			    </div>";

$cms_editorial_publication_state_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_publication_state'>".$msg['cms_editorial_form_publication_state']."</label>
					</div> 
					<div class='row'>
						<select name='cms_editorial_form_publication_state' id='cms_editorial_form_publication_state'>
							!!cms_editorial_form_publications_states_options!!
						</select>
					</div>
				</div>
			</div>
";

$cms_editorial_dates_field = "
			<div class='row'>
				<div class='colonne'>
					<div class='row'>
						<label for='cms_editorial_form_start_date'>".$msg['cms_editorial_form_start_date']."</label>
					</div> 
					<div class='row'>
						<input type='hidden' name='cms_editorial_form_start_date_value' id='cms_editorial_form_start_date_value' value='!!cms_editorial_form_start_date_value!!' />
						<input type='button' class='button' id='cms_editorial_form_start_date' name='cms_editorial_form_start_date' onclick='openPopUp(\"$base_path/select.php?what=calendrier&caller=\"+this.form.name+\"& date_caller=!!day!!&param1=cms_editorial_form_start_date_value&param2=cms_editorial_form_start_date&auto_submit=no\");' value='!!cms_editorial_form_start_date!!'/>
						<input type='button' onclick=\"this.form.elements['cms_editorial_form_start_date'].value='".$msg['no_date']."'; this.form.elements['cms_editorial_form_start_date_value'].value='';\"  value='X' class='bouton'>
					</div>
				</div>
			</div>
			<div class='row'>	
				<div class='colonne2'>
					<div class='row'>
						<label for='cms_editorial_form_end_date'>".$msg['cms_editorial_form_end_date']."</label>
					</div> 
					<div class='row'>
						<input type='hidden' name='cms_editorial_form_end_date_value' id='cms_editorial_form_end_date_value' value='!!cms_editorial_form_end_date_value!!' />
						<input type='button' class='button' id='cms_editorial_form_end_date' name='cms_editorial_form_end_date' onclick='openPopUp(\"$base_path/select.php?what=calendrier&caller=\"+this.form.name+\"&date_caller=!!day!!&param1=cms_editorial_form_end_date_value&param2=cms_editorial_form_end_date&auto_submit=no\");' value='!!cms_editorial_form_end_date!!'/>
						<input type='button' onclick=\"this.form.elements['cms_editorial_form_end_date'].value='".$msg['no_date']."'; this.form.elements['cms_editorial_form_end_date_value'].value='';\"  value='X' class='bouton'>
					</div>
				</div>			
			</div>	
";