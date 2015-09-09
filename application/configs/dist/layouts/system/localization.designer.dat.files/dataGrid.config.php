<?php return array (
  'id' => 'dataGrid',
  'class' => 'Ext_Grid',
  'extClass' => 'Grid',
  'name' => 'dataGrid',
  'state' => 
  array (
    'config' => 
    array (
      'store' => '[new:] localizationStore',
      'columnLines' => true,
      'viewConfig' => '{enableTextSelection: true}',
      'title' => '[js:] appLang.LOCALIZATION',
      'isExtended' => true,
    ),
    'state' => 
    array (
      '_advancedPropertyValues' => 
      array (
        'groupHeaderTpl' => '{name} ({rows.length})',
        'startCollapsed' => false,
        'clicksToEdit' => 1,
        'rowBodyTpl' => '',
        'enableGroupingMenu' => true,
        'hideGroupedHeader' => false,
        'expander_rowbodytpl' => '',
        'checkboxSelection' => false,
        'editable' => true,
        'groupsummary' => false,
        'numberedRows' => false,
        'paging' => false,
        'rowexpander' => false,
        'grouping' => false,
        'summary' => false,
        'remoteRoot' => '',
      ),
    ),
    'columns' => 
    array (
      'id' => 
      array (
        'id' => 'id',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'extClass' => 'Grid_Column',
        'order' => false,
        'name' => 'id',
        'state' => 
        array (
          'config' => 
          array (
            'dataIndex' => 'key',
            'text' => '[js:] appLang.KEY',
            'itemId' => 'id',
            'width' => 228,
          ),
        ),
      ),
      'title' => 
      array (
        'id' => 'title',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'extClass' => 'Grid_Column',
        'order' => 1,
        'name' => 'title',
        'state' => 
        array (
          'config' => 
          array (
            'dataIndex' => 'title',
            'editor' => 
            Ext_Virtual::__set_state(array(
               '_class' => 'Form_Field_Textarea',
               '_config' => 
              Ext_Config::__set_state(array(
                 '_events' => false,
                 '_properties' => 
                Ext_Property_Form_Field_Textarea::__set_state(array(
                   'enterIsSpecial' => 4,
                   'preventScrollbars' => 4,
                   'allowBlank' => 4,
                   'allowOnlyWhitespace' => 4,
                   'blankText' => 2,
                   'disableKeyFilter' => 4,
                   'editable' => 4,
                   'emptyCls' => 2,
                   'emptyText' => 2,
                   'enableKeyEvents' => 4,
                   'enforceMaxLength' => 4,
                   'grow' => 4,
                   'growAppend' => 2,
                   'growMax' => 1,
                   'growMin' => 1,
                   'hideTrigger' => 4,
                   'inputWrapCls' => 2,
                   'maskRe' => 3,
                   'maxLength' => 1,
                   'maxLengthText' => 2,
                   'minLength' => 1,
                   'minLengthText' => 2,
                   'regex' => 3,
                   'regexText' => 2,
                   'repeatTriggerClick' => 4,
                   'requiredCls' => 2,
                   'selectOnFocus' => 4,
                   'stripCharsRe' => 3,
                   'triggerWrapCls' => 2,
                   'triggers' => 3,
                   'validateBlank' => 4,
                   'validator' => 3,
                   'vtype' => 2,
                   'vtypeText' => 2,
                   'submitValue' => 4,
                   'validateOnChange' => 4,
                   'validation' => 4,
                   'validationField' => 3,
                   'value' => 2,
                   'valuePublishEvent' => 2,
                   'checkChangeBuffer' => 1,
                   'checkChangeEvents' => 3,
                   'dirtyCls' => 2,
                   'fieldCls' => 2,
                   'fieldStyle' => 2,
                   'fieldSubTpl' => 3,
                   'inputAttrTpl' => 3,
                   'inputId' => 2,
                   'inputType' => 2,
                   'invalidText' => 2,
                   'isTextInput' => 4,
                   'name' => 2,
                   'readOnly' => 4,
                   'readOnlyCls' => 2,
                   'validateOnBlur' => 4,
                   'activeCounter' => 1,
                   'alignTarget' => 2,
                   'alwaysOnTop' => 1,
                   'anchor' => 2,
                   'animateShadow' => 4,
                   'autoEl' => 2,
                   'autoRender' => 4,
                   'autoShow' => 4,
                   'baseCls' => 2,
                   'bind' => 3,
                   'border' => 2,
                   'childEls' => 3,
                   'cls' => 2,
                   'columnWidth' => 1,
                   'componentCls' => 2,
                   'componentLayout' => 4,
                   'constrain' => 4,
                   'constrainTo' => 3,
                   'constraintInsets' => 2,
                   'contentEl' => 2,
                   'controller' => 3,
                   'data' => 3,
                   'defaultAlign' => 2,
                   'defaultListenerScope' => 4,
                   'disabled' => 4,
                   'disabledCls' => 2,
                   'dock' => 2,
                   'draggable' => 4,
                   'fixed' => 4,
                   'flex' => 1,
                   'floating' => 4,
                   'focusCls' => 2,
                   'focusOnToFront' => 4,
                   'formBind' => 4,
                   'frame' => 4,
                   'height' => 1,
                   'hidden' => 4,
                   'hideMode' => 2,
                   'html' => 2,
                   'id' => 2,
                   'itemId' => 2,
                   'liquidLayout' => 4,
                   'listeners' => 3,
                   'liveDrag' => 4,
                   'loader' => 3,
                   'margin' => 2,
                   'maskElement' => 2,
                   'maxHeight' => 1,
                   'maxWidth' => 1,
                   'minHeight' => 1,
                   'minWidth' => 1,
                   'modal' => 4,
                   'modelValidation' => 4,
                   'overCls' => 2,
                   'padding' => 3,
                   'plugins' => 3,
                   'publishes' => 2,
                   'reference' => 2,
                   'region' => 2,
                   'renderData' => 3,
                   'renderTo' => 2,
                   'renderTpl' => 3,
                   'resizable' => 4,
                   'resizeHandles' => 2,
                   'rtl' => 4,
                   'saveDelay' => 1,
                   'scrollable' => 2,
                   'session' => 3,
                   'shadow' => 4,
                   'shadowOffset' => 1,
                   'shim' => 4,
                   'shrinkWrap' => 1,
                   'stateEvents' => 3,
                   'stateId' => 2,
                   'stateful' => 4,
                   'style' => 2,
                   'tabIndex' => 1,
                   'toFrontOnShow' => 4,
                   'tpl' => 3,
                   'tplWriteMode' => 2,
                   'twoWayBindable' => 2,
                   'ui' => 2,
                   'uiCls' => 2,
                   'viewModel' => 2,
                   'weight' => 1,
                   'width' => 1,
                   'isExtended' => 4,
                   'activeError' => 2,
                   'activeErrorsTpl' => 3,
                   'afterBodyEl' => 2,
                   'afterLabelTextTpl' => 3,
                   'afterLabelTpl' => 3,
                   'afterSubTpl' => 3,
                   'autoFitErrors' => 4,
                   'beforeBodyEl' => 2,
                   'beforeLabelTextTpl' => 3,
                   'beforeLabelTpl' => 3,
                   'beforeSubTpl' => 3,
                   'errorMsgCls' => 2,
                   'fieldBodyCls' => 2,
                   'fieldLabel' => 2,
                   'formItemCls' => 2,
                   'hideEmptyLabel' => 4,
                   'hideLabel' => 4,
                   'invalidCls' => 2,
                   'labelAlign' => 2,
                   'labelAttrTpl' => 3,
                   'labelCls' => 2,
                   'labelClsExtra' => 2,
                   'labelPad' => 1,
                   'labelSeparator' => 2,
                   'labelStyle' => 2,
                   'labelWidth' => 1,
                   'msgTarget' => 2,
                   'preventMark' => 4,
                   'defineOnly' => 4,
                   'cols' => 1,
                   'rows' => 1,
                   'size' => 1,
                   'isFormField' => 4,
                   'autoScroll' => 4,
                   'bodyPadding' => 3,
                   'bodyCls' => 2,
                   'fieldDefaults' => 3,
                   'items' => 3,
                   'layout' => 2,
                   'maintainFlex' => 3,
                   'renderSelectors' => 3,
                   'styleHtmlCls' => 2,
                   'styleHtmlContent' => 4,
                   'zIndexManager' => 3,
                   'floatParent' => 3,
                )),
                 '_data' => 
                array (
                  'enableKeyEvents' => '',
                  'vtypeText' => '',
                  'stripCharsRe' => '',
                  'size' => '',
                  'grow' => '',
                  'growMin' => '',
                  'growMax' => '',
                  'growAppend' => '',
                  'vtype' => '',
                  'maskRe' => '',
                  'disableKeyFilter' => '',
                  'allowBlank' => '',
                  'minLength' => '',
                  'maxLength' => '',
                  'enforceMaxLength' => '',
                  'minLengthText' => '',
                  'maxLengthText' => '',
                  'selectOnFocus' => '',
                  'blankText' => '',
                  'validator' => '',
                  'regex' => '',
                  'regexText' => '',
                  'emptyText' => '',
                  'emptyCls' => '',
                  'componentLayout' => '',
                  'value' => '',
                  'isFormField' => '',
                  'name' => '',
                  'disabled' => '',
                  'submitValue' => '',
                  'validateOnChange' => '',
                  'fieldLabel' => '',
                  'fieldSubTpl' => '',
                  'inputType' => '',
                  'tabIndex' => '',
                  'invalidText' => '',
                  'fieldCls' => '',
                  'fieldStyle' => '',
                  'focusCls' => '',
                  'dirtyCls' => '',
                  'checkChangeEvents' => '',
                  'checkChangeBuffer' => '',
                  'labelAlign' => '',
                  'labelPad' => '',
                  'labelSeparator' => '',
                  'labelStyle' => '',
                  'labelWidth' => '',
                  'readOnly' => '',
                  'readOnlyCls' => '',
                  'inputId' => '',
                  'validateOnBlur' => '',
                  'autoEl' => '',
                  'autoRender' => '',
                  'anchor' => '',
                  'autoScroll' => '',
                  'autoShow' => '',
                  'baseCls' => '',
                  'border' => '',
                  'bodyPadding' => '',
                  'bodyCls' => '',
                  'childEls' => '',
                  'cls' => '',
                  'componentCls' => '',
                  'contentEl' => '',
                  'data' => '',
                  'disabledCls' => '',
                  'draggable' => '',
                  'floating' => '',
                  'focusOnToFront' => '',
                  'fieldDefaults' => '',
                  'frame' => '',
                  'height' => '100',
                  'hidden' => '',
                  'hideMode' => '',
                  'html' => '',
                  'id' => '',
                  'items' => '',
                  'itemId' => '',
                  'listeners' => '',
                  'layout' => '',
                  'loader' => '',
                  'maintainFlex' => '',
                  'margin' => '',
                  'maxHeight' => '',
                  'maxWidth' => '',
                  'minHeight' => '',
                  'minWidth' => '',
                  'overCls' => '',
                  'padding' => '',
                  'plugins' => '',
                  'renderData' => '',
                  'renderSelectors' => '',
                  'renderTo' => '',
                  'renderTpl' => '',
                  'resizable' => '',
                  'resizeHandles' => '',
                  'saveDelay' => '',
                  'shadow' => '',
                  'stateEvents' => '',
                  'stateId' => '',
                  'stateful' => '',
                  'style' => '',
                  'styleHtmlCls' => '',
                  'styleHtmlContent' => '',
                  'toFrontOnShow' => '',
                  'zIndexManager' => '',
                  'floatParent' => '',
                  'tpl' => '',
                  'tplWriteMode' => '',
                  'ui' => '',
                  'width' => '',
                  'isExtended' => '',
                ),
                 '_class' => 'Form_Field_Textarea',
              )),
               '_name' => 'dataGrid_title_editor',
               '_isExtended' => false,
               '_elements' => 
              array (
              ),
               '_listeners' => 
              array (
              ),
               '_methods' => 
              array (
              ),
               '_localEvents' => 
              array (
              ),
            )),
            'renderer' => 'Ext_Component_Renderer_System_Multiline',
            'text' => '[js:] appLang.VALUE',
            'flex' => 1,
            'itemId' => 'title',
            'width' => 1003,
          ),
        ),
      ),
      'sync' => 
      array (
        'id' => 'sync',
        'parent' => 0,
        'class' => 'Ext_Grid_Column_Boolean',
        'extClass' => 'Grid_Column_Boolean',
        'order' => 2,
        'name' => NULL,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'sync',
            'renderer' => 'Ext_Component_Renderer_System_Checkbox',
            'text' => '[js:] appLang.SYNCHRONIZED',
            'itemId' => 'sync',
            'width' => 94,
          ),
        ),
      ),
      'actions' => 
      array (
        'id' => 'actions',
        'parent' => 0,
        'class' => 'Ext_Grid_Column_Action',
        'extClass' => 'Grid_Column_Action',
        'order' => 3,
        'name' => NULL,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'id',
            'itemId' => 'actions',
            'width' => 40,
          ),
          'actions' => 
          array (
            'dataGrid_action_delete' => 
            array (
              'id' => 'dataGrid_action_delete',
              'parent' => 0,
              'class' => 'Ext_Grid_Column_Action_Button',
              'extClass' => 'Grid_Column_Action_Button',
              'order' => false,
              'state' => 
              array (
                'config' => 
                array (
                  'icon' => '[%wroot%]i/system/delete.gif',
                  'text' => 'dataGrid_action_delete',
                  'tooltip' => '[js:] appLang.DELETE',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
); 