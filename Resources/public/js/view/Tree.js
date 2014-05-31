Ext.define('melk.view.Tree', {
    extend: 'Ext.container.Viewport',

    layout: {
        type: 'border'
    },
    
    itemId: 'TreeView',
    store: null,
    
    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'treepanel',
                    rootVisible: false,
                    store: me.store
                }
            ]
        });
        
        me.callParent(arguments);
    }
    
});