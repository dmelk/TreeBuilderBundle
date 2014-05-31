Ext.define('melk.view.FileUpload', {
    extend: 'Ext.container.Viewport',

    layout: {
        type: 'border'
    },
    
    itemId: 'fileUploadForm',
    url: '',
    method: 'POST',
    formItems: [],
    error: false,
    errorText: true,
    
    initComponent: function() {
        var me = this;
        
        var formItems = [
            {
                xtype: 'displayfield',
                fieldLabel: 'Error',
                value: me.errorText,
                hidden: !me.error
            }
        ];

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    url: me.url,
                    items: formItems.concat(me.formItems),
                    buttons: [
                        {
                            text: 'Submit',
                            formBind: true,
                            handler: function() {
                                var form = this.up('form').getForm();
                                if (form.isValid()) {
                                    form.submit({
                                        ulr: me.url,
                                        standardSubmit: true,
                                        method: me.method
                                    });
                                }
                            }
                        }
                    ]
                }
            ]
        });
        
        me.callParent(arguments);
    }
    
});