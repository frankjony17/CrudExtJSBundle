
Ext.define('NAMESPACE', {
    extend: 'Ext.window.Window',
    xtype: 'XTYPE',

    iconCls: '',
    layout: 'fit',
    width: WIDTH,
    resizable: false,
    modal: true,

    initComponent: function () {
        var me = this;

        this.items = [{
            xtype: 'form',
            url: 'URL',
            padding: '10 10 10 10',
            frame: false,
            fieldDefaults: {
                anchor: '100%',
                allowBlank: false,
                labelAlign: 'top'
            },
            items:[{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:1,
                    margin: '0 5 0 0'
                },{
                    ITEMS:2,
                    margin: '0 5 0 0'
                },{
                    ITEMS:3
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:4,
                    margin: '0 5 0 0'
                },{
                    ITEMS:5,
                    margin: '0 5 0 0'
                },{
                    ITEMS:6
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:7,
                    margin: '0 5 0 0'
                },{
                    ITEMS:8,
                    margin: '0 5 0 0'
                },{
                    ITEMS:9
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:10,
                    margin: '0 5 0 0'
                },{
                    ITEMS:11,
                    margin: '0 5 0 0'
                },{
                    ITEMS:12
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:13,
                    margin: '0 5 0 0'
                },{
                    ITEMS:14
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:15
                }]
            },{
                xtype: 'hiddenfield',
                name: 'id'
            }]
        }];
        this.buttons = [{
            text: me.btnText,
            iconCls: 'fa fa-check'
        },{
            text: 'Cancelar',
            iconCls: 'fa fa-times',
            handler: function() {
                me.close();
            }
        }];
        this.callParent(arguments);
    }
});