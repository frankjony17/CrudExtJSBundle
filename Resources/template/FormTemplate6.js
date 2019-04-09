
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
                    ITEMS:2
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'hbox',
                items: [{
                    ITEMS:3,
                    margin: '0 5 0 0'
                },{
                    ITEMS:4
                }]
            },{
                xtype: 'container',
                border: false,
                layout: 'anchor',
                items: [{
                    ITEMS:5
                },{
                    ITEMS:6
                },{
                    xtype: 'hiddenfield',
                    name: 'id'
                }]
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