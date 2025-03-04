//cette m�thode est en r�alit� une r��criture de la m�thode checkAcceptance de l'objet dijit.tree.dndSource
//d�termine si l'item est d�pla�able
function cms_check_if_draggeable_item_tree(source,node){
	var item = source.tree.selectedItem;
	var type = item.type[0];
	//on peut d�placer une rubrique ou un article! 
	switch(type){
		case 'root_section' :
		case 'section' :
		case 'article' :
			return true;
			break;
		case 'articles' :
		default :
			return false;
			break;	
	}	
}

//cette m�thode est en r�alit� une r��criture de la m�thode checkItemAcceptance de l'objet dijit.tree.dndSource
//d�termine si c'est d�posable en l'endroit
function cms_check_if_item_tree_can_drop_here(target,source,position){
	var target_item = dijit.getEnclosingWidget(target).item;
	var current_item = dijit.getEnclosingWidget(target).tree.selectedItem;
	
	if(target_item.root){
		//pour le root,seulement les rubriques
		switch(current_item.type[0]){
		case "root_section" :
		case "section" :
			return true;
		default : 
			return false;
			break;
		}
	}else{
		switch(target_item.type[0]){
			case 'root_section' :
			case 'section' :
				return true;
				break;
			default :
				return false;
				break;						
		}
	}
}

function cms_child_change(parent,childs){
	if(parent.type[0] == 'section' || parent.type[0] == 'root_section'){
		var num_parent = parent.id[0];
		var children = new Array();
		var articles = new Array();
		for(i=0 ; i<childs.length ; i++){
			var child = childs[i];
			if(child.type[0] == 'section' || child.type[0] == 'root_section'){
				children.push(child.id[0]);
			}else if (child.type[0] == "article"){
				articles.push(child.id[0].replace("article_",""));
			}
		}
		cms_dnd_tree_update(num_parent,children);
		if(articles.length){
			cms_update_articles_parent(child.id[0].replace("article_",""),num_parent);
		}
	}else {
		return false;
	}
}

function cms_section_leave_root (item){
	dijit.byId('editorial_tree_container').refresh();
}

function cms_section_add_to_root(item){
	if(item.type[0] == 'section' || item.type[0] == 'root_section'){
		var num_parent = 0;
		var child = new Array();
		child.push(item.id[0]);
		cms_dnd_tree_update(num_parent,child);
		dijit.byId('editorial_tree_container').refresh();
	}
}
function cms_dnd_tree_update(num_parent,children){
	var update = new http_request();
	update.request('./ajax.php?module=cms&categ=update_section',true,'&num_parent='+num_parent+'&new_children='+children,true);
}

function cms_load_content_infos(item,node,evt){
	var content = dijit.byId('content_infos');
	var change = false;
	switch(item.type[0]){
		case "section" :
		case "root_section" :
			change =true;
			content.href = './ajax.php?module=cms&categ=get_infos&type=section&id='+item.id[0];
			break;
		case "article" :
			change =true;
			content.href = './ajax.php?module=cms&categ=get_infos&type=article&id='+item.id[0].replace("article_","");
			break;
		case "articles" :
			change = true;
			content.href = './ajax.php?module=cms&categ=get_infos&type=list_articles&id='+item.id[0].replace("articles_","");
			break;
		default :
			change =false;
			//do nothing
			break;
	}
	if(change){
		content.refresh();
	}
}

function cms_update_articles_parent(ids_articles,num_section){
	var update = new http_request();
	update.request('./ajax.php?module=cms&categ=update_article',true,'&num_section='+num_section+'&articles='+ids_articles,true,cms_articles_updated);	
}

function cms_articles_updated(response){
	dijit.byId('editorial_tree_container').refresh();
	dijit.byId('content_infos').refresh();
}


function get_icon_class(item,opened){
	var icon_class = "";
	if(item.id == 'root'){
		icon_class = (!item || this.model.mayHaveChildren(item)) ? (opened ? "dijitFolderOpened" : "dijitFolderClosed") : "dijitLeaf";
	}else {
		switch(item.type[0]){
			case "section" :
			case "root_section" :
				if(this.model.mayHaveChildren(item)){
					if(!item.icon){
						icon_class = opened ? "dijitFolderOpened" : "dijitFolderClosed";
					}else{
						icon_class = "no_icon";
					}
				}else{
					if(!item.icon){
						icon_class = "dijitFolderOpened";
					}else{
						icon_class = "no_icon";
					}
				}
				break;
			case "articles" : 
				icon_class = opened ? "dijitFolderOpened" : "dijitFolderClosed";
				break;
			case "article" :
				if(!item.icon){
					icon_class= "dijitLeaf";
				}else{
					icon_class = "no_icon";
				}
				break;
		}
	}
	return icon_class;
}


function get_label_class(item,opened){
	var label_class = "";
	if(item.icon){
		label_class = "no_icon";
	}
	return label_class;
}

function get_label(item){
	var label = this.model.getLabel(item);
	if(item.icon){
		label = "<img src='"+item.icon[0]+"' alt='plop' title='plop'/>&nbsp;"+label;
	}
	return label;
}
