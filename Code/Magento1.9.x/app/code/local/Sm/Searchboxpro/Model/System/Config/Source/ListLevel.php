<?php
/*------------------------------------------------------------------------
 # SM Search Box Pro - Version 1.0
 # Copyright (c) 2013 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Searchboxpro_Model_System_Config_Source_ListLevel
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'1', 'label'=> '1' ),
			array('value'=>'2', 'label'=> '2'),
			array('value'=>'3', 'label'=> '3')
		);
	}
}