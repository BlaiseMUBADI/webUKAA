<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_editorial_tree.tpl.php,v 1.1 2011-09-14 08:44:11 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) die("no access");
		
$cms_editorial_tree_layout= "
		<script type='text/javascript' src='./javascript/cms/cms_tree_dnd.js'></script>
		<script type='text/javascript'>
			dojo.require('dijit.layout.ContentPane');
			dojo.require('dijit.tree.ForestStoreModel');
			dojo.require('dojo.data.ItemFileWriteStore');
    		dojo.require('dijit.Tree');
    		dojo.require('dijit.tree.dndSource');  		
		</script>
		<div class='colonne3'>
			<div id='editorial_tree_container' href='./ajax.php?module=cms&categ=get_tree' dojoType='dijit.layout.ContentPane'></div>
		</div>	
		<div class='colonne-suite'>
			<div id='content_infos' dojoType='dijit.layout.ContentPane'></div>
		</div>";

$cms_editorial_tree_content ="
		<div id='section_tree'>
			<script type='text/javascript'>
    		 	var store = new dojo.data.ItemFileWriteStore({
    	        	url: './ajax.php?module=cms&categ=list_sections'
        		});
        		
        		var treeModel = new dijit.tree.ForestStoreModel({
            		store: store,
            		query: {
		                'type': 'root_section'
	            	},
    	        	rootId: 'root',
        	    	rootLabel: 'Racine',
            		childrenAttrs: ['children']
        		});
	
    	    	var cms_editorial_tree = new dijit.Tree({
	    	        model: treeModel,
	    	        openOnDblClick : true,
	    	        getIconClass : get_icon_class,
	    	        getLabelClass : get_label_class,
	    	        getLabel : get_label,
	   	            _createTreeNode: function(args) {
                        var tnode = new dijit._TreeNode(args);
                        tnode.labelNode.innerHTML = args.label;
                        return tnode;
                    },
	    	        
	            	dndController: 'dijit.tree.dndSource'
	    		    },
	        		'section_tree'
    	    	);
    	    	cms_editorial_tree.dndController.checkItemAcceptance = cms_check_if_item_tree_can_drop_here;
    	    	cms_editorial_tree.dndController.checkAcceptance = cms_check_if_draggeable_item_tree;
				dojo.connect(cms_editorial_tree,'onClick',cms_load_content_infos);	
				dojo.connect(treeModel, 'onAddToRoot', cms_section_add_to_root);
        		dojo.connect(treeModel, 'onLeaveRoot', cms_section_leave_root);
				dojo.connect(treeModel, 'onChildrenChange', cms_child_change);
			</script>
		</div>";
