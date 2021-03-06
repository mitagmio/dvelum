Ext.ns('designer.store');


Ext.define('designer.store.sortersModel', {
    extend: 'Ext.data.Model',
    fields: [
             {name:'property',type:'string'},
             {name:'direction',type:'string'}
             ]
});

Ext.define('designer.store.filtersModel', {
    extend: 'Ext.data.Model',
    fields: [
             {name:'property',type:'string'},
             {name:'value',type:'string'}
             ]
});

Ext.define('designer.store.fieldsModel', {
    extend: 'Ext.data.Model',
    fields: [
             {name:'name',type:'string'},
             {name:'type',type:'string'}
             ]
});


Ext.define('designer.store.sortersWindow',{
    extend:'Ext.Window',
    width:500,
    height:300,
    layout:'fit',
    modal:true,
    title:desLang.sorters,
    dataGrid:null,
    dataStore:null,
    initialData:[],
    cellEditing:null,
    objectName:null,
    controllerUrl:null,

    initComponent:function(){

	this.tbar=[
	           {
	               tooltip:desLang.add,
	               iconCls:'plusIcon',
	               scope:this,
	               handler:this.addRecord
	           }        
	           ];

	this.dataStore = Ext.create('Ext.data.Store', {
	    autoDestroy: true,
	    model:'designer.store.sortersModel',
	    autoLoad:false,
	    data:this.initialData
	});

	this.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
	    clicksToEdit: 1
	});

	this.dataGrid = Ext.create('Ext.grid.Panel',{
	    columnLines: true,
	    autoHeight:true,
	    store:this.dataStore,
	    columns:[
	             {
	        	 text:desLang.field,
	        	 dataIndex:'property',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'combobox',
	        	     typeAhead: true,
	        	     triggerAction: 'all',
	        	     queryMode: 'local',
	        	     selectOnTab: true,
	        	     valueField:'name',
	        	     displayField:'name',
	        	     forceSelection:true,
	        	     store:Ext.create('Ext.data.Store',{
	        		 autoDestroy: true,
	        		 model:'designer.store.fieldsModel',
	        		 proxy: {
	        		     type: 'ajax',
	        		     url:app.createUrl([designer.controllerUrl ,'store','allfields']),
	        		     reader: {
	        			 type: 'json',
	        			 idProperty: 'name',
	        			 root: 'data'     
	        		     },
	        		     extraParams:{
	        			 object:this.objectName
	        		     },
	        		     autoLoad:true
	        		 },
	        		 sorters:[{
	        		     property: 'name',
	        		     direction: 'ASC'
	        		 }],
	        		 autoLoad:true
	        	     })
	        	 }
	             },{
	        	 text:desLang.direction,
	        	 dataIndex:'direction',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'combobox',
	        	     typeAhead: true,
	        	     triggerAction: 'all',
	        	     selectOnTab: true,
	        	     forceSelection:true,
	        	     store: [
	        	             ['ASC','ASC'],
	        	             ['DESC','DESC']
	        	             ]
	        	 }
	             },{
	        	 xtype:'actioncolumn',
	        	 width:25,
	        	 align:'center',
	        	 sortable: false,
	        	 menuDisabled:true,
	        	 items:[
	        	        {
	        	            iconCls:'deleteIcon',
	        	            tooltip:desLang.remove,
	        	            handler:function(grid , row , col){
	        	        	var store = grid.getStore();
	        	        	store.remove(store.getAt(row));
	        	            }
	        	        }
	        	        ]
	             }
	             ],
	             plugins :[this.cellEditing]
	});

	this.items = [this.dataGrid];	

	this.buttons = [
	                {
	                    text:desLang.save,
	                    handler:this.saveData,
	                    scope:this
	                },{
	                    text:desLang.close,
	                    handler:function(){
	                	this.close();
	                    },
	                    scope:this
	                }         
	                ];

	this.callParent(arguments);

	this.addEvents(
		/**
		 * Fires after data successfully saved
		 * @param string propertyName
		 * @param string json_encoded object of grid source
		 * @param boolean True to create the property if it doesn't already exist. Defaults to false.
		 */
		'dataChanged'
	);
    },
    addRecord:function(){
	var count = this.dataStore.getCount();
	var r = Ext.create('designer.store.sortersModel', {
	    field:'',
	    direction:'ASC'
	});
	this.dataStore.insert(count, r);
	r.setDirty();
	this.cellEditing.startEditByPosition({row: count, column: 0});
    },
    saveData:function(){
	this.dataStore.commitChanges();
	this.fireEvent('dataChanged', 'sorters', Ext.encode(app.collectStoreData(this.dataStore)), true);
    }
});


Ext.define('designer.store.filtersWindow',{
    extend:'Ext.Window',
    width:500,
    height:300,
    layout:'fit',
    modal:true,
    title:desLang.filters,
    dataGrid:null,
    dataStore:null,
    initialData:[],
    cellEditing:null,
    objectName:null,
    controllerUrl:null,

    initComponent:function(){

	this.tbar=[
	           {
	               tooltip:desLang.add,
	               iconCls:'plusIcon',
	               scope:this,
	               handler:this.addRecord
	           }        
	           ];

	this.dataStore = Ext.create('Ext.data.Store', {
	    autoDestroy: true,
	    model:'designer.store.filtersModel',
	    data:this.initialData,
	    autoLoad:false   
	});

	this.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
	    clicksToEdit: 1
	});

	this.dataGrid = Ext.create('Ext.grid.Panel',{
	    columnLines: true,
	    autoHeight:true,
	    store:this.dataStore,
	    columns:[
	             {
	        	 text:desLang.field,
	        	 dataIndex:'property',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'combobox',
	        	     typeAhead: true,
	        	     triggerAction: 'all',
	        	     queryMode: 'local',
	        	     selectOnTab: true,
	        	     valueField:'name',
	        	     displayField:'name',
	        	     forceSelection:true,
	        	     store:Ext.create('Ext.data.Store',{
	        		 autoDestroy: true,
	        		 model:'designer.store.fieldsModel',
	        		 proxy: {
	        		     type: 'ajax',
	        		     url:app.createUrl([designer.controllerUrl ,'store','allfields']),
	        		     reader: {
	        			 type: 'json',
	        			 idProperty: 'name',
	        			 root: 'data'     
	        		     },
	        		     extraParams:{
	        			 object:this.objectName
	        		     },
	        		     autoLoad:true
	        		 },
	        		 autoLoad:true,
	        		 sorters:[{
	        		     property: 'name',
	        		     direction: 'ASC'
	        		 }],
	        	     })
	        	 }
	             },{
	        	 text:desLang.value,
	        	 dataIndex:'value',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'textfield'
	        	 }
	             },{
	        	 xtype:'actioncolumn',
	        	 width:25,
	        	 sortable: false,
	        	 menuDisabled:true,
	        	 align:'center',
	        	 items:[
	        	        {
	        	            iconCls:'deleteIcon',
	        	            tooltip:desLang.remove,
	        	            handler:function(grid , row , col){
	        	        	var store = grid.getStore();
	        	        	store.remove(store.getAt(row));
	        	            }
	        	        }
	        	        ]
	             }
	             ],
	             plugins :[this.cellEditing]
	});

	this.items = [this.dataGrid];
	this.buttons = [
	                {
	                    text:desLang.save,
	                    handler:this.saveData,
	                    scope:this
	                },{
	                    text:desLang.cancel,
	                    handler:function(){
	                	this.close();
	                    },
	                    scope:this
	                }         
	                ];
	this.callParent(arguments);

	this.addEvents(
		/**
		 * Fires after data successfuly saved
		 * @param string propertyName
		 * @param string json_encoded object of grid source
		 * @param boolean True to create the property if it doesn't already exist. Defaults to false.
		 */
		'dataChanged'
	);
    },
    addRecord:function(){
	var count = this.dataStore.getCount();
	var r = Ext.create('designer.store.filtersModel', {
	    property:'',
	    value:''
	});
	this.dataStore.insert(count, r);
	r.setDirty();
	this.cellEditing.startEditByPosition({row: count, column: 0});
    },
    saveData:function(){
	this.dataStore.commitChanges();
	this.fireEvent('dataChanged', 'filters', Ext.encode(app.collectStoreData(this.dataStore)), true);
    }
});

Ext.define('designer.store.fieldsWindow',{
    extend:'Ext.Window',
    width:600,
    height:500,
    layout:'fit',
    modal:true,
    title:desLang.fields,
    dataGrid:null,
    dataStore:null,
    initialData:[],
    cellEditing:null,
    objectName:null,
    controllerUrl:null,
    propertiesPanel:null,
    layout:'border',

    initComponent:function(){

	var me = this;

	this.tbar=[
	           {
	               iconCls:'importOrmIcon',
	               tooltip:desLang.importOrm,
	               scope:this,
	               handler:this.importFromOrm
	           },{
	               iconCls:'importDbIcon',
	               tooltip:desLang.importDb,
	               scope:this,
	               handler:this.importFromDb
	           },{
	               tooltip:desLang.add,
	               iconCls:'plusIcon',
	               scope:this,
	               handler:this.addRecord
	           }        
	           ];

	this.dataStore = Ext.create('Ext.data.Store', {
	    autoDestroy: true,
	    model:'designer.store.fieldsModel',
	    autoLoad:true,
	    proxy:{
		type:'ajax',	    	
		url:app.createUrl([designer.controllerUrl ,'store','listfields']),
		extraParams:{
		    object:this.objectName
		},
		reader:{
		    idProperty:"name",
		    root:"data",
		    type:"json"
		}
	    },
	    sorters:[{
		property: 'name',
		direction: 'ASC'
	    }]
	});

	this.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
	    clicksToEdit: 1
	});

	this.propertiesPanel =  Ext.create('designer.properties.dataField',{
	    title:'',
	    controllerUrl: app.createUrl([designer.controllerUrl ,'datafield','']),
	    objectName:this.objectName,
	    autoLoadData:false,
	    width:380,
	    autoLoad:false,
	    title:desLang.properties,
	    layout:'fit',
	    region:'east',
	    showEvents:false,
	    split:true,
	    width:250
	});
	this.dataGrid = Ext.create('Ext.grid.Panel',{
	    region:'center',
	    columnLines: true,
	    autoHeight:true,
	    store:this.dataStore,
	    columns:[
	             {
	        	 text:desLang.field,
	        	 dataIndex:'name',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'textfield',	
	        	     vtype:'alphanum',
	        	     allowBlank:false
	        	 }
	             },{
	        	 text:desLang.type,
	        	 dataIndex:'type',
	        	 flex:1,
	        	 editor: {
	        	     xtype: 'combobox',
	        	     typeAhead: true,
	        	     selectOnFocus:true,
	        	     editable:true,
	        	     triggerAction: 'all',
	        	     anchor:'100%',
	        	     queryMode: 'local',
	        	     forceSelection:true,
	        	     displayField:'id',
	        	     valueField:'id',
	        	     store: Ext.create('Ext.data.ArrayStore',{
	        		 fields: ['id'],
	        		 data: this.propertiesPanel.fieldtypes
	        	     })
	        	 }
	             },{
	        	 xtype:'actioncolumn',
	        	 width:25,
	        	 sortable: false,
	        	 menuDisabled:true,
	        	 align:'center',
	        	 items:[
	        	        {
	        	            iconCls:'deleteIcon',
	        	            tooltip:desLang.remove,
	        	            handler:function(grid , row , col){			    			    		  
	        	        	var store = grid.getStore(); 
	        	        	me.removeField(store.getAt(row));
	        	            }
	        	        }
	        	        ]
	             }
	             ],
	             plugins :[this.cellEditing],
	             listeners:{
	        	 scope:this,
	        	 edit:function(editor , o){					
	        	     this.propertiesPanel.dataGrid.setProperty(o.field , o.value);					
	        	     this.dataStore.commitChanges();
	        	     if(o.field === 'name'){
	        		 this.propertiesPanel.setExtraParams({'id': o.value});
	        	     }
	        	 }
	             }
	});


	this.items = [this.dataGrid, this.propertiesPanel];

	this.callParent(arguments);

	this.dataGrid.getSelectionModel().on('selectionchange',function(sm , data , opts){
	    this.cellEditing.cancelEdit();
	    if(!sm.hasSelection()){
		this.propertiesPanel.resetProperties();
		this.propertiesPanel.refreshEvents();
		return;
	    }
	    this.propertiesPanel.setExtraParams({'id':sm.getSelection()[0].get('name')});
	    this.propertiesPanel.loadProperties();		
	},this);

	this.propertiesPanel.dataGrid.on('propertychange',function(source, recordId, value){			
	    if(recordId === 'name' || recordId === 'type'){
		var storeRecordId =  this.propertiesPanel.extraParams['id'];
		var index = this.dataGrid.getStore().findExact('name' , storeRecordId);
		if(index != -1)
		{
		    var record = this.dataGrid.getStore().getAt(index);
		    if(record.get(recordId) !== value)
		    {
			record.set(recordId, value);
			record.commit();
			this.fireEvent('dataChanged');
		    }
		}

	    }
	},this);

	this.addEvents(
		/**
		 * Fires after data successfully saved
		 * @param string propertyName
		 * @param string json_encoded object of grid source
		 * @param boolean True to create the property if it doesn't already exist. Defaults to false.
		 */
		'dataChanged'
	);
    },
    importFromDb:function(){
	var win = Ext.create('designer.importDBWindow',{
	    title:desLang.importDb
	});

	win.on('select',function(fields, connectionId, table ,contype){
	    this.setLoading(true);
	    Ext.Ajax.request({
		url:app.createUrl([designer.controllerUrl ,'store',''])+'importdbfields/',
		method: 'post',
		scope:this,
		params:{
		    object:this.objectName,
		    'fields[]':fields,
		    connectionId:connectionId,
		    table:table,
		    type:contype
		},
		success: function(response, request) {
		    response =  Ext.JSON.decode(response.responseText);
		    if(response.success){
			this.dataStore.load();
		    }else{
			Ext.Msg.alert(appLang.MESSAGE, response.msg);
		    }
		    this.setLoading(false);
		},
		failure:function() {
		    this.setLoading(false);
		    Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
		}
	    });
	},this);
	win.show();
    },

    removeField:function(record)
    {
	var me = this;

	Ext.Ajax.request({
	    url:app.createUrl([designer.controllerUrl ,'store','removefield']),
	    method: 'post',
	    scope:me,
	    params:{
		object:me.objectName,
		id:record.get('name')
	    },
	    success: function(response, request) {
		response =  Ext.JSON.decode(response.responseText);
		if(response.success){
		    me.dataStore.remove(record);
		}else{
		    Ext.Msg.alert(appLang.MESSAGE, response.msg);
		}
		me.setLoading(false);
	    },
	    failure:function() {
		me.setLoading(false);
		Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
	    }
	}); 
    },
    hasDirtyRecords:function(){
	var has = false;
	this.dataStore.each(function(record){
	    if(record.dirty || record.phantom){
		has = true;
	    }
	},this);  	
	return has;
    },
    addRecord:function(){
	var me = this;
	Ext.MessageBox.prompt(appLang.MESSAGE , desLang.enterFieldName,function(btn , text){
	    if(btn !='ok'){
		return;
	    }
	    me.setLoading(true);
	    Ext.Ajax.request({
		url:app.createUrl([designer.controllerUrl ,'store','addfield']),
		method: 'post',
		scope:me,
		params:{
		    object:me.objectName,
		    id:text
		},
		success: function(response, request) {
		    response =  Ext.JSON.decode(response.responseText);
		    if(response.success){
			var rec;
			var item  = response.data;
			rec = Ext.create('designer.store.fieldsModel',{name:item.name,type:item.type});
			me.dataStore.add(rec);
		    }else{
			Ext.Msg.alert(appLang.MESSAGE, response.msg);
		    }
		    me.setLoading(false);
		},
		failure:function() {
		    me.setLoading(false);
		    Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
		}
	    }); 
	});
    },

    importFromOrm:function(){
	var win = Ext.create('designer.ormSelectorWindow',{});
	win.on('select',function(objectName, fields){
	    this.setLoading(true);
	    Ext.Ajax.request({
		url:app.createUrl([designer.controllerUrl ,'store',''])+'importormfields/',
		method: 'post',
		scope:this,
		params:{
		    object:this.objectName,
		    objectName:objectName,
		    'fields[]':fields
		},
		success: function(response, request) {
		    response =  Ext.JSON.decode(response.responseText);
		    if(response.success){
			this.dataStore.load();
		    }else{
			Ext.Msg.alert(appLang.MESSAGE, response.msg);
		    }
		    this.setLoading(false);
		},
		failure:function() {
		    this.setLoading(false);
		    Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
		}
	    });
	} , this);

	win.show();
    }
});


Ext.define('designer.store.proxyWindow',{
    extend:'Ext.Window',
    width:500,
    height:500,
    layout:'border',
    modal:true,
    title:desLang.proxy,
    dataGrid:null,

    objectName:null,
    controllerUrl:null,

    proxyProperties:null,
    proxyPropertiesContainer:null,

    initComponent:function(){

	this.proxyPropertiesContainer = Ext.create('Ext.panel.Panel',{
	    region:'east',
	    width:300,
	    split:true,
	    layout:'fit'
	});

	this.dataGrid = Ext.create('Ext.grid.Panel',{
	    region:'center',
	    split:true,
	    title:appLang.proxyConfig,
	    store:Ext.create('Ext.data.Store',{
		model:'app.comboValueModel',
		proxy:{
		    url:this.controllerUrl + 'proplist',
		    extraParams:{
			object:this.objectName
		    },
		    type:'ajax',
		    reader:{
			type:'json',
			root: 'data',
			idProperty: 'id'
		    }
		},
		autoLoad:true
	    }),
	    columns:[
	             {
	        	 text:desLang.name,
	        	 dataIndex:'name',
	        	 renderer:function(value){
	        	     switch(value){
	        	     case 'proxy':
	        		 return desLang.proxyConfig;
	        		 break;
	        	     case 'reader':
	        		 return desLang.proxyReader;
	        		 break;
	        	     case 'writer':
	        		 return desLang.proxyWriter;
	        		 break;
	        	     }
	        	     return value;
	        	 },
	        	 flex:1
	             }
	             ]
	});

	this.dataGrid.getSelectionModel().on('select',
		function(rowModel ,record ,index){
	    this.typeSelected(record);
	},
	this);

	this.callParent();
	this.add([this.dataGrid , this.proxyPropertiesContainer]);		
    },
    /**
     * Config row selected
     * @param {Ext.data.Model} rec
     */
    typeSelected:function(rec)
    {
	this.proxyPropertiesContainer.removeAll();
	switch(rec.get('name'))
	{		
	case 'proxy':
	    this.proxyProperties = Ext.create('designer.properties.Panel',{
		controllerUrl:this.controllerUrl,
		objectName:this.objectName,
		showEvents:false,
		extraParams:{
		    sub:'proxy'
		},
		tbar:[
		      desLang.type,' ',
		      {
			  xtype: 'combobox',
			  typeAhead: true,
			  triggerAction: 'all',
			  selectOnTab: true,
			  forceSelection:true,
			  value:rec.get('value'),
			  displayField:'title',
			  valueField:'id',
			  queryMode:'local',
			  store:Ext.create('Ext.data.Store',{
			      model:'app.comboStringModel',
			      proxy:{
				  type:'ajax',
				  reader:{
				      type:'json'
				  }
			      },
			      data:[
			            {id:'ajax' , title:'Ajax'},
			            {id:'jsonp', title:'JsonP'},
			            {id:'direct',title:'Direct'},
			            {id:'memory' , title:'Memory'},
			            {id:'rest' , title:'Rest'},
			            {id:'sessionstorage',title:'Session Storage'},
			            {id:'localstorage',title:'Local Storage'}
			            ],
			            autoLoad:false
			  }),
			  listeners:{
			      select:{
				  fn:function(field){
				      this.changeType('proxy', field.getValue());
				  },
				  scope:this
			      }
			  }

		      }]
	    });
	    this.proxyPropertiesContainer.add(this.proxyProperties);
	    break;


	case 'reader':

	    this.proxyProperties = Ext.create('designer.properties.Panel',{
		controllerUrl:this.controllerUrl,
		objectName:this.objectName,
		showEvents:false,
		extraParams:{
		    sub:'reader'
		},
		tbar:[
		      desLang.type,' ',
		      {
			  xtype: 'combobox',
			  typeAhead: true,
			  triggerAction: 'all',
			  selectOnTab: true,
			  forceSelection:true,
			  value:rec.get('value'),
			  displayField:'title',
			  valueField:'id',
			  queryMode:'local',
			  store:Ext.create('Ext.data.Store',{
			      model:'app.comboStringModel',
			      proxy:{
				  type:'ajax',
				  reader:{
				      type:'json'
				  }
			      },
			      data:[
			            {id:'array' , title:'Array'},
			            {id:'json', title:'JSON'},
			            {id:'xml',title:'XML'}
			            ],
			            autoLoad:false
			  }),
			  listeners:{
			      select:{
				  fn:function(field){
				      this.changeType('reader' , field.getValue());
				  },
				  scope:this
			      }
			  }  	
		      }
		      ]
	    });
	    this.proxyPropertiesContainer.add(this.proxyProperties);
	    break;


	case 'writer':	
	    this.proxyProperties = Ext.create('designer.properties.Panel',{
		controllerUrl:this.controllerUrl,
		objectName:this.objectName,
		showEvents:false,
		extraParams:{
		    sub:'writer'
		},
		tbar:[
		      desLang.type,' ',				       
		      {
			  xtype: 'combobox',
			  typeAhead: true,
			  triggerAction: 'all',
			  selectOnTab: true,
			  forceSelection:true,
			  value:rec.get('value'),
			  displayField:'title',
			  valueField:'id',
			  queryMode:'local',
			  store:Ext.create('Ext.data.Store',{
			      model:'app.comboStringModel',
			      proxy:{
				  type:'ajax',
				  reader:{
				      type:'json'
				  }
			      },
			      data:[
			            {id:'json', title:'JSON'},
			            {id:'xml',title:'XML'}
			            ],
			            autoLoad:false
			  }) ,
			  listeners:{
			      select:{
				  fn:function(field){
				      this.changeType('writer', field.getValue());
				  },
				  scope:this
			      }
			  } 	
		      }
		      ]
	    });
	    this.proxyPropertiesContainer.add(this.proxyProperties);

	    break;
	}
	this.proxyProperties.forceComponentLayout();
	this.proxyProperties.doLayout();
	this.proxyProperties.dataGrid.getStore().on('load',function(store){
	    store.remove('type');
	},this);
    },
    /**
     * Change type
     * @param string sub
     * @param string value
     */
    changeType: function(sub , value){
	Ext.Ajax.request({
	    url:this.controllerUrl+'changetype',
	    method: 'post',
	    scope:this,
	    params:{
		object:this.objectName,
		sub:sub,
		type:value
	    },
	    success: function(response, request) {
		response =  Ext.JSON.decode(response.responseText);
		if(response.success){
		    this.proxyProperties.loadProperties();
		    this.dataGrid.getStore().load();
		}else{
		    Ext.Msg.alert(appLang.MESSAGE, response.msg);
		}
	    },
	    failure:function() {
		Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
	    }
	});
    }
});

Ext.define('designer.store.rootWindow',{
    extend:'Ext.Window',
    width:500,
    height:500,
    layout:'fit',
    modal:true,
    title:'root',
    dataGrid:null,
    objectName:null,
    controllerUrl:null,
    initialData:null,

    initComponent:function(){
	this.dataGrid = Ext.create('Ext.grid.property.Grid', {      
	    border:false,
	    autoScroll:true,
	    nameColumnWidth:150,
	    source:this.initialData
	});

	this.items = [this.dataGrid];

	this.buttons = [
	                {
	                    text:desLang.save,
	                    scope:this,
	                    handler:this.onDataSaved
	                },{
	                    text: desLang.cancel,
	                    scope:this,
	                    handler:this.close
	                }
	                ];

	this.addEvents(
		/**
		 * Fires after data successfuly saved
		 * @param object data
		 */
		'dataSaved'
	);


	this.callParent();
    },
    onDataSaved:function()
    {
	this.fireEvent('dataSaved',this.dataGrid.getSource());
	this.close();
    }
});