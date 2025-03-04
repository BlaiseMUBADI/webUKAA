<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: perio_a2z.tpl.php,v 1.14.2.5 2012-03-14 08:51:34 jpermanne Exp $

if (stristr($_SERVER['REQUEST_URI'], "tpl.php")) die("no access");

// ce fichier contient les templates  utile � la navigation des p�rio A to Z

$onglet_a2z="
	<li id='onglet_!!onglet_num!!' class='!!onglet_class!!'>		
		<a href='#' onclick=\"show_onglet('!!onglet_num!!_1'); return false;\">!!onglet_label!!</a>
	</li>
";

$ongletSub_a2z="
	<div id='ongletSub_!!onglet_num!!' style='display:!!ongletSub_display!!'>		
		!!ongletSub_list!!
	</div>
";

$ongletSubList_a2z="
	<li id='ongletSub_!!onglet_num!!_!!ongletSub_num!!' class='isbd_public_inactive'>		
		<a href='#' onclick=\"show_onglet('!!onglet_num!!_!!ongletSub_num!!'); return false;\">!!ongletSub_label!!</a>
	</li>
";

$a2z_perio="
	<tr><td>!!abt_actif!!</td><td><a href='#' onclick=\"reset_fields();show_perio('!!id!!'); return false;\">!!perio_title!!</a></td></tr>
";

$a2z_tpl_ajax="	
	<table class='a2z_contens'>
		<tr>
			<td valign='top'>
				<div class='a2z_perio_list'>
					<table class='a2z_perio_list'>!!a2z_perio_list!!</table>
				</div> 				
			</td>	
			<td class='a2z_perio'><div id='a2z_perio'>!!perio_display!!</div></td>
		</tr>
	</table> 
";

$a2z_tpl="
  <script src='".$include_path."/javascript/ajax.js'></script>
	
	<h3><span>".$msg["a2z_title"]."</span></h3>
	<label for='perio_a2z_search'>".$msg["142"]."</label>&nbsp;<input type='text' id='perio_a2z_search' name='perio_a2z_search' completion='perio_a2z' autfield='perio_a2z_onglet' listfield='location,surloc' expand_mode='1' autexclude='".(0|$abt_actif)."' callback='search_change_onglet'/>				
	<input type='hidden' id='perio_a2z_onglet' value='' name='perio_a2z_onglet'/>
	<script type='text/javascript'>
		
		var memo_onglet=new Array();		
			
		function reset_fields(){
			if(document.getElementById('bull_date_start')) document.getElementById('bull_date_start').value='';
			if(document.getElementById('bull_date_end'))document.getElementById('bull_date_end').value='';
			if(document.getElementById('bull_num_deb'))document.getElementById('bull_num_deb').value='';
			if(document.getElementById('bull_num_end'))document.getElementById('bull_num_end').value='';			
			if(document.getElementById('page'))document.getElementById('page').value=1;		
		}
		
		function show_perio(perio_id) {		
			var bull_date_start='';
			var bull_date_end=''; 
			var bull_num_deb='';
			var bull_num_end='';
			var page='';
			var location='';
			
			if(document.getElementById('bull_date_start')) bull_date_start = document.getElementById('bull_date_start').value;
			if(document.getElementById('bull_date_end')) bull_date_end = document.getElementById('bull_date_end').value;
			if(document.getElementById('bull_num_deb')) bull_num_deb = document.getElementById('bull_num_deb').value;
			if(document.getElementById('bull_num_end')) bull_num_end = document.getElementById('bull_num_end').value;			
			if(document.getElementById('page')) page = document.getElementById('page').value;
			if(document.getElementById('location')) location = document.getElementById('location').value;
			
			var url= './ajax.php?module=ajax&categ=perio_a2z&sub=get_perio&id=' + perio_id;
			url+='&bull_date_start='+bull_date_start;
			url+='&bull_date_end='+bull_date_end;
			url+='&bull_date_start='+bull_date_start;
			url+='&bull_num_deb='+bull_num_deb;
			url+='&bull_num_end='+bull_num_end;
			url+='&page='+page;
			url+='&location='+location;
			
			var id = document.getElementById('a2z_perio');
			id.innerHTML =  '<div style=\"width:100%; height:30px;text-align:center\"><img style=\"padding 0 auto;\" src=\"./images/patience.gif\" id=\"collapseall\" border=\"0\"><\/div>' ;		
			
			// On initialise la classe:
			var req = new http_request();
			// Ex�cution de la requette
			if(req.request(url)) return 0;	
				
			// contenu
			id.innerHTML = req.get_text();
			".($opac_notice_enrichment ? "getEnrichment(id.firstChild.getAttribute('id').replace(/[^0-9]*/ig,''));" : "")."
			return 1;				
		}		
		
		function show_onglet(onglet) {
		
			var myArray = onglet.split('_');
			var onglet_num = myArray[0];
			var ongletSub_num = myArray[1];
			
			// contenu
			var id = document.getElementById('a2z_contens');
			
			if(!memo_onglet[onglet]){
												
				var location = document.getElementById('location').value;						
				var surlocation = document.getElementById('surloc').value;
				var abt_actif = 0;
				if(document.getElementById('a2z_abt_actif').checked == true)abt_actif=1;		
				id.innerHTML =  '<div style=\"width:100%; height:30px;text-align:center\"><img style=\"padding 0 auto;\" src=\"./images/patience.gif\" id=\"collapseall\" border=\"0\"><\/div>' ;		
				var url= './ajax.php?module=ajax&categ=perio_a2z&sub=get_onglet&onglet_sel=' + onglet;
				url+='&location='+location;
				url+='&surloc='+surlocation;
				url+='&abt_actif='+abt_actif;
				// On initialise la classe:
				var req = new http_request();
				// Ex�cution de la requette
				if(req.request(url))return 0;	
				memo_onglet[onglet]= req.get_text();
				
			}	
			
			id.innerHTML = memo_onglet[onglet];
			".($opac_notice_enrichment ? "getEnrichment(document.getElementById('a2z_perio').firstChild.getAttribute('id').replace(/[^0-9]*/ig,''));" : "")."
			
			var i=1;			
			while(myOnglet=document.getElementById('onglet_' + i)){					
				myOnglet.setAttribute('class', 'isbd_public_inactive');
				i++;
			}	
			document.getElementById('onglet_'+onglet_num).setAttribute('class', 'isbd_public_active');
			
			i=1;
			while(myOngletSub=document.getElementById('ongletSub_' + i)){					
				myOngletSub.setAttribute('style', 'display:none');
				i++;
			}	
			document.getElementById('ongletSub_'+onglet_num).setAttribute('style', 'display:block');
			
			i=1;
			while(myOngletSubList=document.getElementById('ongletSub_' + onglet_num + '_' + i)){					
				myOngletSubList.setAttribute('class', 'isbd_public_inactive');
				i++;
			}	
			//On est oblig� de tester : certaines lettres n'ont pas de sous-liste
			var myList = document.getElementById('ongletSub_' + onglet_num + '_' + ongletSub_num);
			if(myList)myList.setAttribute('class', 'isbd_public_active');
		
			return 1;						
		}	
		
		function search_change_onglet(id) {
			var elt=document.getElementById('perio_a2z_onglet').value;
			var onglperio=elt.split('.');
			show_onglet(onglperio[0]);
			reset_fields(); show_perio(onglperio[1]);
		}
		
		function reload_all() {
			var location = document.getElementById('location').value;						
			var surlocation = document.getElementById('surloc').value;						
			var abt_actif = 0;
			if(document.getElementById('a2z_abt_actif').checked == true)abt_actif=1;		
			
			document.getElementById('perio_a2z_search').setAttribute('autexclude', abt_actif);
			var id = document.getElementById('perio_a2z');
			id.innerHTML =  '<div style=\"width:100%; height:30px;text-align:center\"><img style=\"padding 0 auto;\" src=\"./images/patience.gif\" id=\"collapseall\" border=\"0\"><\/div>' ;
			
			var url= './ajax.php?module=ajax&categ=perio_a2z&sub=reload'
			url+='&location='+location;
			url+='&surloc='+surlocation;
			url+='&abt_actif='+abt_actif;
			
			// On initialise la classe:
			var req = new http_request();
			// Ex�cution de la requette
			if(req.request(url))return 0;	
					
			id.innerHTML = req.get_text();						
			ajax_pack_element(document.getElementById('perio_a2z_search'));				
		}			
	</script>
		
	<input type=\"hidden\" name=\"location\" id=\"location\" value=\"!!location!!\">\n
	<input type=\"hidden\" name=\"surloc\" id=\"surloc\"value=\"!!surlocation!!\">\n

	<ul id='onglets_isbd_public'>	
		<li><span id='span_a2z_abt_actif'><input type='checkbox'  !!check_abt_actif!! name='a2z_abt_actif' id='a2z_abt_actif' onclick=\"memo_onglet=new Array(); reload_all(); \" >".$msg["a2z_abt_actif_filter"]."</span></li>  	
		<div class='row'>!!a2z_onglets_list!!</div>
		<div class='row'>!!a2z_onglets_sublist!!</div>	   
	</ul>
	<div class='row'></div>
	<div id='a2z_contens'>		
		$a2z_tpl_ajax		
	</div>	
	<script type='text/javascript'>ajax_parse_dom();</script>
";		
					
$a2z_bull_search="	
	<script type='text/javascript' src='./includes/javascript/http_request.js'></script>		
	<script type='text/javascript'>
		
		function bull_search() {		
			var url= './ajax.php?module=ajax&categ=perio_a2z&sub=get_perio&id=';
			var id = document.getElementById('a2z_perio');
			id.innerHTML =  '<div style=\"width:100%; height:30px;text-align:center\"><img style=\"padding 0 auto;\" src=\"./images/patience.gif\" id=\"collapseall\" border=\"0\"></div>' ;
			// On initialise la classe:
			var req = new http_request();
			// Ex�cution de la requette
			if(req.request(url)){
				// Il y a une erreur. Afficher le message retourn�
				alert ( req.get_text() );			
			}else { 
				// contenu
				id.innerHTML = req.get_text();
				return 1;	
			}			
		}	
	</script>
	
	<a name='tab_bulletin'></a>
	<h3>$msg[perio_list_bulletins]</h3>
	<div id='form_search_bull'>
		<div class='row'></div>\n
			<script src='./includes/javascript/ajax.js'></script>
			<form name=\"form_values\" action=\"./index.php?lvl=notice_display&id=$id\" method=\"post\" onsubmit=\"if (document.getElementById('onglet_isbd$id').className=='isbd_public_active') document.form_values.premier.value='ISBD'; else document.form_values.premier.value='PUBLIC';document.form_values.page.value=1;\">\n
				<input type=\"hidden\" name=\"premier\" value=\"\">\n
				<input type=\"hidden\" name=\"page\" value=\"$page\">\n
				<table>
					<tr>
						<td align='left' rowspan='2'><strong>".$msg["search_bull"]."&nbsp;:&nbsp;</strong></td>
						<td align='right'><strong>".$msg["search_per_bull_num"]." : ".$msg["search_bull_start"]."</strong></td>
						<td >$num_field_start</td>						
						<td ><strong>".$msg["search_bull_end"]."</strong> $numfield_end</td>
					</tr>
					<tr>
						<td align='right'><strong>".$msg["search_per_bull_date"]." : ".$msg["search_bull_start"]."</strong></td>
						<td>$date_debut</td>
						<td><strong>".$msg["search_bull_end"]."</strong> $date_fin</td>
						<td>&nbsp;&nbsp;<input type='button' value='".$msg["142"]."' onclick='submit();'></td>
					</tr>
				</table>
			</form>
		<div class='row'></div><br />
	</div>\n
	
";			
	