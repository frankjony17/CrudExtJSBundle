
Ext.define('NAMESPACE', {
    extend: 'Ext.grid.Panel',
    xtype: 'XTYPE',
    /* Config options */
    width: 'WIDTH',
    border: BORDER,
    selType: 'SELTYPE',
    autoScroll: AUTOSCROLL,
    scrollable: 'SCROLLABLE',
    /* Store */
    store: STORE,
    /* Columns */
    columns: COLUMNS,
    /* TollBar */
    tbar : [{
        text: 'Adicionar',
        tooltip: 'Adicionar TOOLBAR',
        iconCls: 'fa fa-plus',
        action: 'add'
    },{
        text: 'Eliminar',
        tooltip: 'Eliminar TOOLBAR',
        iconCls: 'fa fa-trash',
        action: 'remove'
    }, '->', {
        tooltip: 'Ayuda relacionada con TOOLBAR',
        iconCls: 'fa fa-info',
        action: 'help'
    }]
});