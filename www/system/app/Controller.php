<?php
/*
 * DVelum project http://code.google.com/p/dvelum/ , http://dvelum.net Copyright
 * (C) 2011-2013 Kirill A Egorov This program is free software: you can
 * redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version. This program is distributed
 * in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details. You should have received
 * a copy of the GNU General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 */
/**
 * Base class for implementing controllers (DVelum 0.9 and higher)
 */
abstract class Controller
{
  /**
   * Adapter connecting to the default database
   * 
   * @var Zend_Db_Adapter_Abstract
   */
  protected static $_defaultDb;
  /**
   * Link to Page object
   * 
   * @var Page
   */
  protected $_page;
  
  /**
   * Adapter connecting to the current object database
   * 
   * @var Zend_Db_Adapter_Abstract
   */
  protected $_db;
  
  /**
   * Link to Resource object
   * 
   * @var Resource
   */
  protected $_resource;
  
  /**
   * Localization dictionary
   * 
   * @var Lang
   */
  protected $_lang;
  
  /**
   * Link to router
   * 
   * @var Router
   */
  protected $_router;
  
  /**
   * Application config
   * @var Config_Abstract
   */
  protected $_configMain;

  public function __construct()
  {
    $this->_page = Page::getInstance();
    $this->_resource = Resource::getInstance();
    $this->_lang = Lang::lang();
    $this->_db = static::$_defaultDb;
    $this->_configMain = Registry::get('main' , 'config');
  }

  /**
   * Set adapter connecting to the default database
   * @param Zend_Db_Adapter_Abstract $db          
   */
  static public function setDefaultDb(Zend_Db_Adapter_Abstract $db)
  {
    self::$_defaultDb = $db;
  }

  /**
   * Set adapter connecting to the current object database
   * @param Zend_Db_Adapter_Abstract $db          
   */
  public function setDb(Zend_Db_Adapter_Abstract $db)
  {
    $this->_db = $db;
  }

  /**
   * Set link to router
   * @param Router $router          
   */
  public function setRouter(Router $router)
  {
    $this->_router = $router;
  }

  /**
   * Default action
   * (Is to be set in child classes)
   */
  abstract function indexAction();
}