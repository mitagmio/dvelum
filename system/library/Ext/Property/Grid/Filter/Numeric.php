<?php
class Ext_Property_Grid_Filter_Numeric extends Ext_Property_Grid_Filter
{
	public $emptyText = self::String;
	public $fields = self::Object;

	static public $extend = 'Ext.grid.filters.filter.Number';
}