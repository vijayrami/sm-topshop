<?php
/*------------------------------------------------------------------------
 # SM Zen - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Topshop_Model_System_Config_Source_LightboxStyles
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'simple', 'label'=>Mage::helper('topshop')->__('Simple')),
			array('value'=>'button', 'label'=>Mage::helper('topshop')->__('Light Box With Button')),
			array('value'=>'thumbs', 'label'=>Mage::helper('topshop')->__('Light Box With Thumbs'))
		);
	}
}
