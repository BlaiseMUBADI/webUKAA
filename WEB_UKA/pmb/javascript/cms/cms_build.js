// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_build.js,v 1.2 2011-09-29 08:15:50 ngantier Exp $

var cms_build_obj_list_id=new Array(); 
var cms_build_obj_list_type=new Array();


function cms_build_findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
		}
	}
	return [curleft,curtop];
}


function cms_build_mouse_is_on(e,obj) {	
	var i;
	var pos_mouse=getCoordinate(e);
	
	var r=document.getElementById(obj);
	var pos=cms_build_findPos(r);	
	var r_x=pos[0];
	var r_y=pos[1];
	var r_width=r.offsetWidth;
	var r_height=r.offsetHeight;
	if ( ((pos_mouse[0]>r_x)&&(pos_mouse[0] < (parseFloat(r_x)+parseFloat(r_width)))) &&				
		((pos_mouse[1]>r_y)&&(pos_mouse[1] < (parseFloat(r_y)+parseFloat(r_height)))) ) 	{
		var info=new Array();	
		info["id"]=r;
		info["mouse_x"]=pos_mouse[0];		
		info["mouse_y"]=pos_mouse[1];	
		return info;
	}	
	return false;
}

function cms_change_objet_css(id){
	var obj_val=document.getElementById(id);
	var obj_val_def=document.getElementById(id+'_def');
	if(obj_val_def.options[0].selected == true){
		return 'auto';
	}else if(obj_val_def.options[3].selected == true){
		return 'inherit';
	}else if(obj_val_def.options[1].selected == true){
		return obj_val.value+'px';
	}else if(obj_val_def.options[2].selected == true){
		return obj_val.value+'%';
	}	
	
}


function cms_change_css(id){
	var obj =parent.frames['opac_frame'].document.getElementById(id);
	obj.style.left=cms_change_objet_css("cms_left");
	obj.style.top=cms_change_objet_css("cms_top");
	obj.style.top=cms_change_objet_css("cms_zIndex");
	
	obj.style.height=cms_change_objet_css("cms_height");
	obj.style.width=cms_change_objet_css("cms_width");
	
	obj.style.marginTop=cms_change_objet_css("cms_margin_top");
	obj.style.marginRight=cms_change_objet_css("cms_margin_right");
	obj.style.marginBottom=cms_change_objet_css("cms_margin_bottom");
	obj.style.marginLeft=cms_change_objet_css("cms_margin_left");
	obj.style.paddingTop=cms_change_objet_css("cms_padding_top");
	obj.style.paddingRight=cms_change_objet_css("cms_padding_right");
	obj.style.paddingBottom=cms_change_objet_css("cms_padding_bottom");
	obj.style.paddingLeft=cms_change_objet_css("cms_padding_left");

	var theselector=document.getElementById("cms_float");	
	obj.style.float=theselector.options[theselector.selectedIndex].value;
	
	var theselector=document.getElementById("cms_position");	
	obj.style.position=theselector.options[theselector.selectedIndex].value;
	var theselector=document.getElementById("cms_visibility");
	obj.style.visibility=theselector.options[theselector.selectedIndex].value;
	var theselector=document.getElementById("cms_display");
	obj.style.display=theselector.options[theselector.selectedIndex].value;		
}

function cms_gen_objet_css(id,val,id_block){

	var obj_val=document.getElementById(id);
	var obj_val_def=document.getElementById(id+'_def');
	if(val== 'auto' || val==''){
		obj_val_def.options[0].selected = true;
		obj_val_def.style.display='none';
	}else if(val== 'inherit'){
		obj_val_def.options[3].selected = true;
		obj_val_def.style.display='none';
	}else if(val.substr(val.length-2, 2)== 'px'){
		obj_val.value=val.substr(0,val.length-2)
		obj_val_def.options[1].selected = true;
		obj_val_def.style.display='block';
	}else if(val.substr(val.length-1, 1)== '%'){
		obj_val.value=val.substr(0,val.length-1)
		obj_val_def.options[2].selected = true;
		obj_val_def.style.display='block';
	}
	obj_val.onchange="cms_change_css('"+id_block+"');return false;"

	
}	
function cms_show_css_obj(id){	
	
	var cms_edit_form=document.getElementById("cms_edit_form");
	document.getElementById("cms_edit_form").setAttribute("cms_edit_id",id);
	document.getElementById("cms_edit_title_obj").innerHTML=id;	

	var obj=parent.frames['opac_frame'].document.getElementById(id);
	var style=getComputedStyle(obj);
	
	var theselector=document.getElementById("cms_position")
	for (var i=1 ; i< theselector.options.length ; i++){
		if (theselector.options[i].value == style.getPropertyValue("position")){
			theselector.options[i].selected = true;			
		}else theselector.options[i].selected = false;
	}	
	var theselector=document.getElementById("cms_float")
	for (var i=1 ; i< theselector.options.length ; i++){
		if (theselector.options[i].value == style.getPropertyValue("float")){
			theselector.options[i].selected = true;			
		}else theselector.options[i].selected = false;
	}
	var theselector=document.getElementById("cms_visibility")
	for (var i=1 ; i< theselector.options.length ; i++){
		if (theselector.options[i].value == style.getPropertyValue("visibility")){
			theselector.options[i].selected = true;
		}else theselector.options[i].selected = false;
	}	
	var theselector=document.getElementById("cms_display")
	for (var i=1 ; i< theselector.options.length ; i++){
		if (theselector.options[i].value == style.getPropertyValue("display")){
			theselector.options[i].selected = true;
		}else theselector.options[i].selected = false;
	}
	
	cms_gen_objet_css("cms_left",style.left,id);
	cms_gen_objet_css("cms_top",style.top,id);
	cms_gen_objet_css("cms_zIndex",style.zIndex,id);
	
	cms_gen_objet_css("cms_height",style.height,id);
	cms_gen_objet_css("cms_width",style.width,id);
	cms_gen_objet_css("cms_margin_top",style.getPropertyValue("margin-top"),id);
	cms_gen_objet_css("cms_margin_right",style.getPropertyValue("margin-right"),id);
	cms_gen_objet_css("cms_margin_bottom",style.getPropertyValue("margin-bottom"),id);
	cms_gen_objet_css("cms_margin_left",style.getPropertyValue("margin-left"),id);
	cms_gen_objet_css("cms_padding_top",style.getPropertyValue("padding-top"),id);
	cms_gen_objet_css("cms_padding_right",style.getPropertyValue("padding-right"),id);
	cms_gen_objet_css("cms_padding_bottom",style.getPropertyValue("padding-bottom"),id);
	cms_gen_objet_css("cms_padding_left",style.getPropertyValue("padding-left"),id);

	document.getElementById("cms_display").value=style.getPropertyValue("display");		
	document.getElementById("cms_edit_form_save").setAttribute("onclick","cms_change_css('"+id+"');return false;");
	
}
function cms_desel_all_obj(){	
	for(var i=0;i<cms_build_obj_list_id.length;i++){
		var obj=parent.frames['opac_frame'].document.getElementById(cms_build_obj_list_id[i]);
		obj.style.background="";
		obj.style.border="";
	}	
}
function cms_show_obj(id){
	cms_desel_all_obj();
	var obj=parent.frames['opac_frame'].document.getElementById(id);
	obj.style.background="#DDD";
	obj.style.border="1px dashed red";
	obj.style.visibility="visible";
	obj.style.display="block";
	
	cms_show_css_obj(id);
}

function cms_add_obj_link(node,id){
	cms_build_obj_list_id[cms_build_obj_list_id.length]=id;
	cms_build_obj_list_type[cms_build_obj_list_id.length]=node;

	var tr=document.createElement('tr');
	if(cms_build_obj_list_id.length %2) var odd_even='odd';
	else var odd_even='even';
	tr.setAttribute('class', odd_even); 
	tr.style.cursor= 'pointer';
	tr.setAttribute('onmouseout', "this.className='"+odd_even+"'"); 
	tr.setAttribute('onmouseover', "this.className='surbrillance'"); 
	tr.setAttribute("onclick", "cms_show_obj('"+id+"'); return false;");
	var tn = document.createTextNode(id);
	tr.appendChild(tn);
	document.getElementById(node+'_table').appendChild(tr);
}

function cms_deplacement_activate(){
	var cell = document.getElementById("cms_edit_sel_objet_list_table");
	while(cell.childNodes.length)	cell.removeChild(cell.firstChild);
	var cell = document.getElementById("cms_edit_sel_cadre_list_table");
	while(cell.childNodes.length)	cell.removeChild(cell.firstChild);

	cms_build_obj_list_id=new Array();
	cms_build_obj_list_type=new Array();
	
	var opac=parent.frames['opac_frame'];
	for(var i=0;i<cms_objet_list.length;i++){
		if(opac.document.getElementById(cms_objet_list[i])) cms_add_obj_link("cms_edit_sel_objet_list",cms_objet_list[i]);		
	}	
	for(var i=0;i<cms_cadre_list.length;i++){
		if(opac.document.getElementById(cms_cadre_list[i])) cms_add_obj_link("cms_edit_sel_cadre_list",cms_cadre_list[i]);
	}	

}

function cms_build_mouse_down(e) {
	//On annule tous les comportements par defaut du navigateur (ex : selection de texte)
	if (!e) var e=window.event;
	if (e.stopPropagation) {
		e.preventDefault();
		e.stopPropagation();
	} else { 
		e.cancelBubble=true;
		e.returnValue=false;
	}
    if ('which' in e) {
        switch (e.which) {
	        case 3: // right button
	        	cms_build_mouse_right(e); 
	        	return;
	        break;
        }
		
	}	
}	

function cms_drag_activate_obj(id,actif) {
	var obj=parent.frames['opac_frame'].document.getElementById(id);
	if(obj){	
		if(actif){				
			obj.setAttribute('draggable', 'yes');	
			obj.setAttribute('dragtype', 'opacdrop');	
			obj.setAttribute('oncontextmenu', 'return false');					
		} else{
			obj.setAttribute('draggable', 'no');	
			obj.setAttribute('dragtype', 'opacdrop');	
			obj.setAttribute('oncontextmenu', '');	
			
		}
		var list_id=document.getElementById('cms_edit_sel_objet_list');
	}	
}
function cms_drop_activate_obj(id,actif) {
	var obj=parent.frames['opac_frame'].document.getElementById(id);
	if(obj){		
		if(actif){									
			obj.setAttribute('recept', 'yes');
			obj.setAttribute('recepttype', 'opacdrop');
			obj.setAttribute('downlight', 'cms_block_downlight');
			obj.setAttribute('highlight', 'cms_block_highlight');	
			obj.setAttribute('oncontextmenu', 'return false');		
		} else {
			obj.setAttribute('recept', 'no');
			obj.setAttribute('recepttype', 'opacdrop');
			obj.setAttribute('downlight', '');
			obj.setAttribute('highlight', '');	
			obj.setAttribute('oncontextmenu', '');	
		}			
	}	
}	

function cms_drag_activate(actif,cms_dragable_type,cms_receptable_type) {	

	netscape.security.PrivilegeManager.enablePrivilege('UniversalBrowserRead');	
	cms_memo_opacdrop =new Array();
	
	var opac=parent.frames['opac_frame'];
	// objets déplacables
	if(cms_dragable_type=="object"){
		for(var i=0;i<cms_objet_list.length;i++){
			if(opac.document.getElementById(cms_objet_list[i])) cms_drag_activate_obj(cms_objet_list[i],actif);
		}	
	}else{
		for(var i=0;i<cms_objet_list.length;i++){
			if(opac.document.getElementById(cms_objet_list[i])) cms_drag_activate_obj(cms_objet_list[i],0);
		}	
	}
	if(cms_dragable_type=="cadre"){
		for(var i=0;i<cms_cadre_list.length;i++){
			if(opac.document.getElementById(cms_cadre_list[i])) cms_drag_activate_obj(cms_cadre_list[i],actif);
		}	
	}else{
		for(var i=0;i<cms_cadre_list.length;i++){
			if(opac.document.getElementById(cms_cadre_list[i])) cms_drag_activate_obj(cms_cadre_list[i],0);
		}	
	}
	// Récepteurs
	if(cms_receptable_type=="cadre" && cms_dragable_type!="cadre"){
		for(var i=0;i<cms_cadre_list.length;i++){
			if(opac.document.getElementById(cms_cadre_list[i])) cms_drop_activate_obj(cms_cadre_list[i],actif);
		}
	}else{
		for(var i=0;i<cms_cadre_list.length;i++){
			if(opac.document.getElementById(cms_cadre_list[i])) cms_drop_activate_obj(cms_cadre_list[i],0);
		}
	}	
	if(cms_receptable_type=="conteneur" ||  cms_dragable_type=="cadre"){
		for(var i=0;i<cms_contener_list.length;i++){
			if(opac.document.getElementById(cms_contener_list[i])) cms_drop_activate_obj(cms_contener_list[i],actif);
		}	
	}else{ 
		for(var i=0;i<cms_contener_list.length;i++){
			if(opac.document.getElementById(cms_contener_list[i])) cms_drop_activate_obj(cms_contener_list[i],0);
		}		
	}
	cms_init_drag();
	cms_deplacement_activate();
}	


function serialize (txt) {
	switch(typeof(txt)){
	case 'string':
		return 's:'+txt.length+':\"'+txt+'\";';
	case 'number':
		if(txt>=0 && String(txt).indexOf('.') == -1 && txt < 65536) return 'i:'+txt+';';
		return 'd:'+txt+';';
	case 'boolean':
		return 'b:'+( (txt)?'1':'0' )+';';
	case 'object':
		var i=0,k,ret='';
		for(k in txt){
			//alert(isNaN(k));
			if(!isNaN(k)) k = Number(k);
			ret += serialize(k)+serialize(txt[k]);
			i++;
		}
		return 'a:'+i+':{'+ret+'}';
	default:
		return 'N;';
		alert('var undefined: '+typeof(txt));return undefined;
	}
}
function cms_drag_record() {
	cms_desel_all_obj();	
	
	var page_info=new Array();
	page_info['cms_nodes']=new Array();
	page_info['cms_css']=new Array();
		
	var opac=parent.frames['opac_frame'];
	for(var i=0;i<cms_contener_list.length;i++){
		var obj_contener;
		if( obj_contener=opac.document.getElementById(cms_contener_list[i])){
			var children = obj_contener.childNodes;			
			for (var i_child = 0; i_child < children.length; i_child++) {		
				console.log(children[i_child].id)
				if(children[i_child].id){
					
					page_info['cms_nodes'][children[i_child].id]=new Array();
					page_info['cms_nodes'][children[i_child].id]['parent']=cms_contener_list[i];
					console.log('children[i_child+1]',children[i_child+1])
					if(children[i_child+1]){						
						if(children[i_child+1].id)
						    page_info['cms_nodes'][children[i_child].id]['child_after']=children[i_child+1].id;
					}
				}				
			}			
			for(var i_cadre=0;i_cadre<cms_cadre_list.length;i_cadre++){			
				
				var obj_cadre;
				if(obj_cadre=opac.document.getElementById(cms_cadre_list[i_cadre])){
					var children = obj_cadre.childNodes;
					
					for (var i_child = 0; i_child < children.length; i_child++) {
						
						if(children[i_child].id){
							
							page_info['cms_nodes'][children[i_child].id]=new Array();
							page_info['cms_nodes'][children[i_child].id]['parent']=cms_cadre_list[i_cadre];
							console.log('children[i_child+1]',children[i_child+1])
							if(children[i_child+1]){
								
								if(children[i_child+1].id)
								    page_info['cms_nodes'][children[i_child].id]['child_after']=children[i_child+1].id;
							}
						}						
					}
				}	
			}	
		}	
	}
	
	
	for(var i=0;i<cms_build_obj_list_id.length;i++){
		var obj=parent.frames['opac_frame'].document.getElementById(cms_build_obj_list_id[i]);
		if(obj){
			// le style est affecté
			if(obj.style.cssText){
				page_info['cms_css'][cms_build_obj_list_id[i]]=new Array();
				page_info['cms_css'][cms_build_obj_list_id[i]]['style']=obj.style.cssText;
			}			
		}	
	}					
	console.log('page_info',page_info);
	
	// Contexte de la page Opac: cms_build_info
	var post_data='cms_data='+serialize(page_info)+'&cms_build_info='+parent.frames['opac_frame'].document.getElementById('cms_build_info').value;	
	// Envoi du tout au serveur
	var http=new http_request();		
	var url = './ajax.php?module=cms&categ=build&sub=block&action=save';
	http.request(url,true,post_data); 
}	

function cms_drag_record_() {
	cms_desel_all_obj();	
	var page_info=new Array();
	page_info['cms_nodes']=new Array();
	page_info['cms_css']=new Array();
		console.log('cms_memo_opacdrop',cms_memo_opacdrop)
	for(var i=0;i<cms_build_obj_list_id.length;i++){
		var obj=parent.frames['opac_frame'].document.getElementById(cms_build_obj_list_id[i]);
		if(obj){
			// le style est affecté
			if(obj.style.cssText){
				page_info['cms_css'][cms_build_obj_list_id[i]]=new Array();
				page_info['cms_css'][cms_build_obj_list_id[i]]['style']=obj.style.cssText;
			}
			// Changement du dom de l'objet?
			
			var child_after="";
			if(cms_build_obj_list_type[i]=="cms_edit_sel_objet_list" && cms_memo_opacdrop[cms_build_obj_list_id[i]]){
				
				// Son père
				if(obj.parentNode.id){
					page_info['cms_nodes'][cms_build_obj_list_id[i]]=new Array();
					page_info['cms_nodes'][cms_build_obj_list_id[i]]['parent']=obj.parentNode.id;
					var children = obj.parentNode.childNodes;
					var found=0;
					for (var i_child = 0; i_child < children.length; i_child++) {
						if(children[i_child].id==obj.id){
							found=1;
						}else if(found==1){
							child_after=children[i_child].id;
							break;
						}						
					}				
					page_info['cms_nodes'][cms_build_obj_list_id[i]]['child_after']=child_after;
					page_info['cms_nodes'][cms_build_obj_list_id[i]]['move']=1;
				}	
			}	
		}	
	}					
	console.log('page_info',page_info);
	
	// Contexte de la page Opac: cms_build_info
	var post_data='cms_data='+serialize(page_info)+'&cms_build_info='+parent.frames['opac_frame'].document.getElementById('cms_build_info').value;	
	// Envoi du tout au serveur
	var http=new http_request();		
	var url = './ajax.php?module=cms&categ=build&sub=block&action=save';
	http.request(url,true,post_data); 
}	


function cms_build_init(){
	
}	
	