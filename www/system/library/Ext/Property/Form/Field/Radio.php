<?php
class Ext_Property_Form_Field_Radio extends Ext_Property_Form_Field_Checkbox
{
    public $uncheckedValue = self :: String;
    
    static public $extend = 'Ext.form.field.Radio';
	static public $xtype = 'radio';
}