<?php
/*------------------------------------------------------------------------
 # SM Custom - Version 1.0.0
 # Copyright (c) 2015 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Custom_Block_List extends Mage_Catalog_Block_Product_Abstract
{
	protected $_config = null;
	protected $_storeId = null;

	public function __construct($attr)
	{
		parent::__construct($attr);
		$this->_config = $this->_getCfg($attr);
		if (!$this->_getConfig('active', 1)) return;
		$this->_storeId = Mage::app()->getStore()->getId();
	}

	public function _getCfg($attr = null)
	{
		// get default config.xml
		$defaults = array();
		$def_cfgs = Mage::getConfig()
			->loadModulesConfiguration('config.xml')
			->getNode('default/custom_cfg')->asArray();
		if (empty($def_cfgs)) return;
		$groups = array();
		foreach ($def_cfgs as $def_key => $def_cfg) {
			$groups[] = $def_key;
			foreach ($def_cfg as $_def_key => $cfg) {
				$defaults[$_def_key] = $cfg;
			}
		}

		// get configs after change
		$_configs = (array)Mage::getStoreConfig("custom_cfg");
		if (empty($_configs)) return;
		$cfgs = array();

		foreach ($groups as $group) {
			$_cfgs = Mage::getStoreConfig('custom_cfg/' . $group . '');
			foreach ($_cfgs as $_key => $_cfg) {
				$cfgs[$_key] = $_cfg;
			}
		}

		// get output config
		$configs = array();
		foreach ($defaults as $key => $def) {
			if (isset($defaults[$key])) {
				$configs[$key] = $cfgs[$key];
			} else {
				unset($cfgs[$key]);
			}
		}
		$this->_config = ($attr != null) ? array_merge($configs, $attr) : $configs;
		return $this->_config;
	}

	public function _getConfig($name = null, $value_def = null)
	{
		if (is_null($this->_config)) $this->_getCfg();
		if (!is_null($name)) {
			$value_def = isset($this->_config[$name]) ? $this->_config[$name] : $value_def;
			return $value_def;
		}
		return $this->_config;
	}


	public function _setConfig($name, $value = null)
	{
		if (is_null($this->_config)) $this->_getCfg();
		if (is_array($name)) {
			$this->_config = array_merge($this->_config, $name);
			return;
		}
		if (!empty($name) && isset($this->_config[$name])) {
			$this->_config[$name] = $value;
		}
		return true;
	}


	protected function _toHtml()
	{
		if (!$this->_getConfig('active', 1)) return;
		return parent::_toHtml();
	}

	public function _getProductMedia()
	{
		$items = $this->_getConfig('product_additem');
		$items = unserialize($items);
		if (empty($items)) return;
		return $items;
	}

	public function _getProducts()
	{
		$helper = Mage::helper('custom/data');
		$items = $this->_getProductMedia();	
		$list = array();
		$i = 0;
		if (!empty($items)) {
			foreach ($items as $item) {
				$i++;
				$item['id'] = $i;
				$item['image'] = (strpos($item['image'], 'http') !== false) ? $item['image'] : Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $item['image'];
				$description = $helper->_cleanText($item['content']);					
				$item['description'] = $description;
				unset($item['content']);
				$list[] = (object)$item;
			}
		}
		return $list;
	}

}