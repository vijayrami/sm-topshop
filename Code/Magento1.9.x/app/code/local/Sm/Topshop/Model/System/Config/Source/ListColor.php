<?php
/*------------------------------------------------------------------------
 # SM Zen - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Topshop_Model_System_Config_Source_ListColor
{
	public function toOptionArray()
	{	
		return array(
		array('value'=>'blue', 'label'=>Mage::helper('topshop')->__('Blue')),
		array('value'=>'brown', 'label'=>Mage::helper('topshop')->__('Brown')),
		array('value'=>'cyan', 'label'=>Mage::helper('topshop')->__('Cyan')),
		array('value'=>'orange', 'label'=>Mage::helper('topshop')->__('Orange')),
		array('value'=>'pink', 'label'=>Mage::helper('topshop')->__('Pink')),
		array('value'=>'green', 'label'=>Mage::helper('topshop')->__('Green')),
		array('value'=>'teal', 'label'=>Mage::helper('topshop')->__('Teal')),
		array('value'=>'red', 'label'=>Mage::helper('topshop')->__('Red'))
		);
	}
}
