<?php
/*------------------------------------------------------------------------
 # SM Topshop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Topshop_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function indexAction()
    {
		$this->loadLayout();
        $this->renderLayout();
    } 
}
