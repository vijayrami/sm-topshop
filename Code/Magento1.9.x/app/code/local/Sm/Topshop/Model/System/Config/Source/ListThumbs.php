<?php
/*------------------------------------------------------------------------
 # SM Zen - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Topshop_Model_System_Config_Source_ListThumbs
{
	public function toOptionArray()
	{	
		return array(
		array('value'=>'horizontal', 'label'=>Mage::helper('topshop')->__('Horizontal')),
		array('value'=>'vertical', 'label'=>Mage::helper('topshop')->__('Vertical'))
		);
	}
}
