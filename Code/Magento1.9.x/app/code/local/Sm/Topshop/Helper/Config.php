<?php

class Sm_Topshop_Helper_Config extends Mage_Core_Helper_Abstract
{
	
	public function getConfig($name = null)
	{
		if (!$name) return null;

		return Mage::getStoreConfig($name, Mage::app()->getStore()->getId());
	}

	public function getGeneral($name)
	{
		return $this->getConfig('topshop_cfg/general/' . $name);
	}
	
	public function getThemeLayout($name)
	{
		return $this->getConfig('topshop_cfg/theme_layout/' . $name);
	}
	
	public function getDetailTopshop($name)
	{
		return $this->getConfig('topshop_cfg/detail_topshop/' . $name);
	}
	
	public function getProductSetting($name)
	{
		return $this->getConfig('topshop_cfg/product_setting/' . $name);
	}
	
	public function getAdvanced($name)
	{
		return $this->getConfig('topshop_cfg/advanced/' . $name);
	}
	
	public function getSocialSetting($name)
	{
		return $this->getConfig('topshop_cfg/social_setting/' . $name);
	}
	
	public function getRichSnippetsSetting($name)
	{
		return $this->getConfig('topshop_cfg/rich_snippets_setting/' . $name);
	}
	
	public function getProductListing($name)
	{
		return $this->getConfig('topshop_cfg/product_listing/' . $name);
	}
	
}