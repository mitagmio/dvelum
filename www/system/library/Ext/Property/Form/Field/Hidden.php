<?php
class Ext_Property_Form_Field_Hidden extends Ext_Property_Form_Field_Base
{
	public $hideLabel = self::Boolean;
	public $inputType = self::String;
	
	static public $extend = 'Ext.form.field.Hidden';
	static public $xtype = ' hiddenfield';
}