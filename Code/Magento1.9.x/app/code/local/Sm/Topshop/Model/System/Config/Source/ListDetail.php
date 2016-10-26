<?php
/*------------------------------------------------------------------------
 # SM Zen - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Topshop_Model_System_Config_Source_ListDetail
{
	public function toOptionArray()
	{	
		return array(
		array('value'=>'1', 'label'=>Mage::helper('topshop')->__('Style 1')),
		array('value'=>'2', 'label'=>Mage::helper('topshop')->__('Style 2')),
		array('value'=>'3', 'label'=>Mage::helper('topshop')->__('Style 3'))
		);
	}
}