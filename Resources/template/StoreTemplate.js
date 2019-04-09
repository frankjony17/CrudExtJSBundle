
Ext.define('NAMESPACE', {
    extend: 'Ext.data.Store',
    /* Config */
    fields: FIELDS,
    autoLoad: true,
    sorters: 'SORTERS',
    proxy : {
        type : 'ajax',
        url: 'URL',
        reader : {
            type            : 'json',
            root            : 'data',
            totalProperty   : 'total',
            successProperty : 'success'
        }
    }
});
