<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_build.tpl.php,v 1.4 2011-09-29 08:15:50 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], "tpl.php")) die("no access");

function cms_gen_objet_css($name){
	$objet_css="
	<input dojoType='dijit.form.NumberSpinner' value='' smallDelta='1' constraints='{min:-2000,max:2000,places:0}' id='$name' name='$name' style= 'width:80px'
		intermediateChanges='true'
	 	onchange =\"cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\"
	/>
	<select id='".$name."_def' name='".$name."_def' onchange =\"cms_change_css_format_number(this,'$name');cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\">				
		<option value='auto'>auto</option>
		<option value='px'>px</option>
		<option value='%'>%</option>
		<option value='inherit'>inherit</option>
	</select>
	";

	return $objet_css;
}

$cms_edit_css="
	<script type='text/javascript'>
		
		function cms_change_css_format_number(obj,id_number){
			obj_number=document.getElementById(id_number);
			obj_number_field=document.getElementById('widget_'+id_number);
			switch(obj.options[obj.selectedIndex].value){
				case 'auto':
					obj_number_field.style.display='none';
				break;
				case 'px': 
					obj_number_field.style.display='block';
				break;
				case '%': 
					obj_number_field.style.display='block';
				break;
				case 'inherit': 
					obj_number_field.style.display='none';
				break;
			}
		}
	
	    dojo.require('dijit.form.NumberSpinner');
	  
	</script>
	<div id='cms_edit_form' cms_edit_id='' >
		<h3>
			".$msg["cms_edit_css"]."
		</h3>
		<div class='row'>
			<span id='cms_edit_title_obj'>
		</span></div>
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_position"]."&nbsp;</label>
		</div>
		<div class='row'>
			<select id='cms_position' name='cms_position' onchange =\"cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\">				
				<option value='relative'>relative</option>
				<option value='absolute'>absolute</option>
				<option value='static'>static</option>
			</select>
		</div>					
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_left"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_left")."			
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_top"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_top")."			
		</div>			
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_zindex"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_zIndex")."			
		</div>				
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_visibility"]."&nbsp;</label>
		</div>
		<div class='row'>			
			<select id='cms_visibility' name='cms_visibility' onchange =\"cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\">				
				<option value='hidden'>hidden</option>
				<option value='visible'>visible</option>
			</select>
		</div>				
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_height"]."&nbsp;</label>			
		</div>
		<div class='row'>			
			".cms_gen_objet_css("cms_height")."			
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_width"]."&nbsp;</label>
		</div>
		<div class='row'>					
			".cms_gen_objet_css("cms_width")."	
		</div>		
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_float"]."&nbsp;</label>
		</div>
		<div class='row'>					
			<select id='cms_float' name='cms_float' onchange =\"cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\">				
				<option value='left'>left</option>
				<option value='right'>right</option>
				<option value='none'>none</option>
				<option value='inherit'>inherit</option>
			</select>
		</div>			
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_margin_top"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_margin_top")."
		</div>
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_padding_top"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_padding_top")."
		</div>	
		<div class='row'>		
			<label class='etiquette'>".$msg["cms_edit_form_margin_right"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_margin_right")."
		</div>			
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_padding_right"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_padding_right")."
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_margin_bottom"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_margin_bottom")."
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_padding_bottom"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_padding_bottom")."
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_margin_left"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_margin_left")."
		</div>					
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_padding_left"]."&nbsp;</label>
		</div>
		<div class='row'>
			".cms_gen_objet_css("cms_padding_left")."
		</div>	
		<div class='row'>
			<label class='etiquette'>".$msg["cms_edit_form_display"]."&nbsp;</label>
		</div>
		<div class='row'>			
			<select id='cms_display' name='cms_display' onchange =\"cms_change_css(document.getElementById('cms_edit_form').getAttribute('cms_edit_id'));\">				
				<option value='block'>block</option>
				<option value='none'>none</option>
			</select>
		</div>	
		
		<div class='row'>		
			<input type='button' class='bouton' name='cms_edit_form_save' id='cms_edit_form_save' value='".$msg["cms_edit_form_save"]."' onclick='' />			
		</div>	
	</div>
";

$cms_edit_objet="	
	<script type='text/javascript'>
	
		function cms_opac_loaded(){
			document.getElementById('cms_drag_activate_button').setAttribute('active','1')
			cms_drag_activate_form();
		}
		function cms_drag_activate_form(){
			if(document.getElementById('cms_drag_activate_button').getAttribute('active') ){
				cms_drag_activate(0,0,0);
				document.getElementById('cms_drag_activate_button').style.backgroundColor ='';
				document.getElementById('cms_drag_activate_button').setAttribute('active','')
				document.getElementById('cms_drag_activate_button').value='".$msg["cms_activer_drag_drop"]."';
				return;
			} else{
				document.getElementById('cms_drag_activate_button').style.backgroundColor ='#00FF00';
				document.getElementById('cms_drag_activate_button').setAttribute('active','1')
				document.getElementById('cms_drag_activate_button').value='".$msg["cms_reset_drag_drop"]."';
			}
			
			var radioButtons=document.getElementsByName('cms_dragable_type');
			var cms_dragable_type=0;
			for (var i=0; i < radioButtons.length; i ++) {	           
	            if (radioButtons[i].checked) {
                    cms_dragable_type=radioButtons[i].value;
                }
	        } 
	        
			var radioButtons=document.getElementsByName('cms_receptable_type');
			var cms_receptable_type=0;
			for (var i=0; i < radioButtons.length; i ++) {	           
	            if (radioButtons[i].checked) {
                    cms_receptable_type=radioButtons[i].value;
                }
	        } 	      
	        
			cms_drag_activate(1,cms_dragable_type,cms_receptable_type);
		}
	</script>
	<h3>
		".$msg["cms_edit_objet_selection"]."
	</h3>
	<div class='row'>
	
		<table border='0'  width='100%' cellspacing='0'>
		<tr>
			<td>"
				.$msg["cms_dragable_type"]."		
			</td>		
			<td>
				<input  type='radio' id='cms_dragable_cadre' name='cms_dragable_type' value='cadre'  ><label for='cms_dragable_cadre'>".$msg["cms_dragable_cadre"]."</label>
			</td>	
			<td>		
				<input  type='radio' id='cms_dragable_object' name='cms_dragable_type' value='object'  checked='checked'><label for='cms_dragable_object'>".$msg["cms_dragable_object"]."</label>
			</td>
		</tr>	
		<tr>
			<td>
				".$msg["cms_receptable_type"]."		
			</td>		
			<td>
				<input  type='radio' id='cms_receptable_conteneur' name='cms_receptable_type' value='conteneur' ><label for='cms_receptable_conteneur'>".$msg["cms_receptable_conteneur"]."</label>
			</td>	
			<td>		
				<input  type='radio' id='cms_receptable_cadre' name='cms_receptable_type'  value='cadre' checked='checked'><label for='cms_receptable_cadre'>".$msg["cms_receptable_cadre"]."</label>
			</td>
		</tr>	
		</table>
	</div>	
	<h3>
		".$msg["cms_edit_objet_sedition"]."
	</h3>
		
	<div class='row'>		
		<input type='button'  id='cms_drag_activate_button' active='' value='".$msg["cms_activer_drag_drop"]."'  onclick=\"cms_drag_activate_form(); return false;\">
	</div>				
	<div class='row'>
		<h3>".$msg["cms_edit_sel_objet_list"]."</h3>
	</div>		
	<div class='row' id='cms_edit_sel_objet_list'>
		<table id='cms_edit_sel_objet_list_table' border='0'  width='100%' cellspacing='0'>
		</table>
	</div>	
	<div class='row'>
		<h3>".$msg["cms_edit_sel_cadre_list"]."</h3>
	</div>
	<div class='row' id='cms_edit_sel_cadre_list'>
		<table id='cms_edit_sel_cadre_list_table' border='0'  width='100%' cellspacing='0'>
		</table>
	</div>			
	<div class='row'>
		<input type='button' class='bouton' value='".$msg["cms_memoriser_drag_drop"]."' onclick=\"cms_drag_record(); return false;\">
	</div>
";	
	

$cms_build_block_tpl="
	<script src='./javascript/cms/cms_build.js'></script>
	<script src='./javascript/cms/cms_drag_n_drop.js'></script>
	<script src='./javascript/cms/cms_drop.js'></script>
	
	<table border='0'  width='100%' cellspacing='0'>
	<tr>
		<td width='300px' >	
			$cms_edit_objet
		</td>
		<td>	
			<IFRAME name='opac_frame' id='opac_frame' src='".$opac_url_base."index.php?cms_build_activate=1' style='background-color:#FFFFFF;width:1090px;height:780px;border:1px solid #000'></IFRAME>	
		</td>
		<td width='150px' >
			$cms_edit_css
		</td>
	</tr>	
	</table>			
		
	<script type='text/javascript'>
		var cms_contener_list=new Array();
		var cms_cadre_list=new Array();
		var cms_objet_list=new Array();
		!!cms_objet_list_declaration!!
		cms_build_init();	
	</script>
";