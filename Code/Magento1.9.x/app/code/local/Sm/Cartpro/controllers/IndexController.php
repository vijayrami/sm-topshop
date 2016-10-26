<?php
/*------------------------------------------------------------------------
 # SM Cart Pro - Version 2.0.0
 # Copyright (c) 2015 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Cartpro_IndexController extends Mage_Core_Controller_Front_Action
{
	public function productAction(){
		$_path = strstr(Mage::app()->getRequest()->getRequestUri(),'/path');
		$str = str_replace("/path/",'',$_path );
		$str = (function_exists('mysql_real_escape_string')) ? mysql_real_escape_string($str) : $str;
		$coreResource = Mage::getSingleton('core/resource');
		$conn = $coreResource->getConnection('core_read');
		$select = $conn->select()
			->from(array('rp' => $coreResource->getTableName('core_url_rewrite')), new Zend_Db_Expr('product_id'))
			->where('rp.request_path in ("'.$str.'")')
			->where('rp.store_id = ?', Mage::app()->getStore()->getId());
		$productId = $conn->fetchOne($select);
		$viewHelper = Mage::helper('catalog/product_view');
		$params = new Varien_Object();
		$params->setCategoryId(false);
		$params->setSpecifyOptions(false);
		try {
			$viewHelper->prepareAndRender($productId, $this, $params);
		} catch (Exception $e) {
			if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
				if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
					$this->_redirect('');
				} elseif (!$this->getResponse()->isRedirect()) {
					$this->_forward('noRoute');
				}
			} else {
				Mage::logException($e);
				$this->_forward('noRoute');
			}
		}
	}	
}