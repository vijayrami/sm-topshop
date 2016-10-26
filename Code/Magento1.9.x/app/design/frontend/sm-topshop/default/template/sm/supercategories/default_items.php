<?php
/*------------------------------------------------------------------------
 # SM Super Categories - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/
$config = Mage::helper('topshop/config');
$effect_style = $config->getProductListing('effect_style'); 
$display_nav = $config->getProductListing('show_nav');
$display_dot = $config->getProductListing('show_dot');
$limit = $config->getProductListing('slide_limit');
$helper = Mage::helper('supercategories/data');
$posttext = $this->_getConfig('posttext');
$item_page = $this->_getConfig('product_limitation_a_slider');
if ($this->_isAjax()) {
	$catid = $this->getRequest()->getPost('categoryid');
	$start = (int)$this->getRequest()->getPost('ajax_reslisting_start');
	$list = $this->getListCriterionFilter($catid);
	$child_items = $list[$catid]->child;
	$posttext = $this->getRequest()->getPost('posttext');
	$item_page = $this->getRequest()->getPost('item_page');
}
$small_image_config = array(
	'type' => $this->_getConfig('imgcfg_type'),
	'width' => $this->_getConfig('imgcfg_width'),
	'height' => $this->_getConfig('imgcfg_height'),
	'quality' => 90,
	'function' => ($this->_getConfig('imgcfg_function') == 'none') ? null : 'resize',
	'function_mode' => ($this->_getConfig('imgcfg_function') == 'none') ? null : substr($this->_getConfig('imgcfg_function'), 7),
	'transparency' => $this->_getConfig('imgcfg_transparency', 1) ? true : false,
	'background' => $this->_getConfig('imgcfg_background'));

if (!empty($child_items)) {

	$k = 0;
	if( $item_page == 6 || $item_page == 2) {
		$class_item_slide = "slide-4col";
	}else {
		$class_item_slide = "slide-3col";
	}
	foreach ($child_items as $item) {
		$k++; 
		if($k == 1 ) { ?>
			<div class="ltabs-item-slide <?php echo $class_item_slide; ?>">
		<?php } ?>
			<div class="ltabs-item new-ltabs-item item">
				<div class="item-inner">
					<?php
					if ( $this->_getConfig('product_image_display', 1) == 1 ) {
						?>
						<div class="box-image">
							<?php if($effect_style == 'default'){?>
								<div class="effect-default">
									<a class="rspl-image">
										<img title="<?php echo $item->title; ?>"
											 alt="<?php echo $item->title; ?>"
											 src="<?php echo $item->_image; ?>"/>
									</a>
								</div>						
							<?php } else if($effect_style == 'thumbs'){?>
								<div class="effect-thumbs">
									<a title="<?php echo $item->title; ?>" href="<?php echo $item->link ?>" class="product-image">
										<img alt="<?php echo $item->title; ?>" src="<?php echo $item->_image; ?>"/>
													 
										<?php if($item->getThumbnail() != $item->getSmallImage()) { ?> 
											<img class="second-image" src="<?php echo $this->helper('catalog/image')->init($item, 'thumbnail')->resize(270, 320); ?>" alt="<?php echo $this->stripTags($this->getImageLabel($item, 'small_image'), null, true) ?>" />
										<?php } ?>
									</a>
								</div>
							<?php } else if($effect_style == 'slider'){?>
								<div class="effect-slider">	
									<div class="image-slider-product">
										<?php $rand_slider = rand().time();?>
										<div class="slider-thumbs-listing slider-img-thumb-listing-<?php echo $rand_slider;?>">
											<?php $_media = Mage::getModel('catalog/product')->load($item->getId())->getMediaGalleryImages() ?>
											<?php $i=0; foreach($_media as $_img): $i++;?>
												<div class="item_listing">
													<a href="<?php echo $item->link ?>" title="<?php echo $item->title;?>">
														<img  src="<?php echo $this->helper('catalog/image')->init($item, 'image', $_img->getFile())->resize(270, 320); ?>" alt="<?php echo $this->stripTags($this->getImageLabel($item, 'small_image'), null, true); ?>" />
													</a>
												</div>
												<?php if($i == $limit && $limit != 0) break;?>
											<?php endforeach; ?>
										</div>
										
											<script>
												jQuery.noConflict();
												jQuery('.slider-img-thumb-listing-<?php echo $rand_slider;?>').lightSlider({
													loop: false,
													vertical:false,
													slideMargin: 0,
													item: 1,

													<?php if($display_nav){?>
														controls : true, // Show next and prev buttons
													<?php } else { ?>
														controls : false,
													<?php } ?>

													<?php if($display_dot){?>
														pager: true,
													<?php } else {?>
														pager: false,
													<?php } ?>
												}); 
											</script>
									</div>
				
								</div>
							<?php } ?>
							
							<div class="bottom-action-out-wrap">
								<div class="bottom-action-out">
									<div class="bottom-action">
										<a style="display:none;" class="rspl-image" href="<?php echo $item->link ?>"> </a>
										
										<?php if ((int)$this->_getConfig('product_addcart_display', 1)) { ?>
											<?php if ($item->isSaleable()) { ?>
												<button class="btn-action btn-cart" type="button" title="<?php echo $this->__('Add to Cart') ?>" onclick="setLocation('<?php echo $this->getAddToCartUrl($item) ?>')">
													<span>
														<span> <?php echo $this->__('Add to Cart') ?> </span>
													</span>
												</button>
											<?php } else { ?>
												<p class="availability out-of-stock"><span><?php echo $this->__('Out of stock') ?></span></p>
											<?php } ?>
										<?php } ?>
										
										<?php if ((int)$this->_getConfig('product_addwishlist_display', 1) || (int)$this->_getConfig('product_addcompare_display', 1)) { ?>
												<?php if ((int)$this->_getConfig('product_addcompare_display', 1)) { ?>
													<?php if ($_compareUrl = $this->getAddToCompareUrl($item)) { ?>
														<a data-toggle="tooltip" data-placement="top" class="btn-action link-compare" title="<?php echo $this->__('Compare') ?>" href="<?php echo $_compareUrl ?>">
															<span><?php echo $this->__('Compare') ?></span>
														</a>
													<?php } ?>
												<?php } ?>
												
												<?php if ((int)$this->_getConfig('product_addwishlist_display', 1)) { ?>
													<?php if ($this->helper('wishlist')->isAllow()) { ?>
														<a data-toggle="tooltip" data-placement="top" class="btn-action link-wishlist" title="<?php echo $this->__('Wishlist') ?>" href="<?php echo $this->helper('wishlist')->getAddUrl($item) ?>">
															<span><?php echo $this->__('Wishlist') ?></span>
														</a>
													<?php } ?>
												<?php } ?>
										<?php } ?>
										
									</div>						
								</div>										
							</div>		
							
							<!--LABEL PRODUCT-->
							<?php
							$id_product = Mage::getModel('catalog/product')->load($item->getId());
							$specialprice = $id_product->getSpecialPrice();
							$specialPriceFromDate = $id_product->getSpecialFromDate();
							$specialPriceToDate = $id_product->getSpecialToDate();
							$today = time();

							if ($specialprice) {
								if ($today >= strtotime($specialPriceFromDate) && $today <= strtotime($specialPriceToDate) || $today >= strtotime($specialPriceFromDate) && is_null($specialPriceToDate)) { ?>
									<div class="label-product label-sale">
										<span class="sale-product-icon">
											<?php echo $this->__('Sale'); ?>
										</span>
									</div>
								<?php }
							}?>

							<?php
							$now = date("Y-m-d");
							$newsFrom = substr($item->getData('news_from_date'), 0, 10);
							$newsTo = substr($item->getData('news_to_date'), 0, 10);
							if ($newsTo != '' || $newsFrom != '') {
								if (($newsTo != '' && $newsFrom != '' && $now >= $newsFrom && $now <= $newsTo) || ($newsTo == '' && $now >= $newsFrom) || ($newsFrom == '' && $now <= $newsTo)) {?>
										<div class="label-product label-new">
											<span class="new-product-icon"><?php echo $this->__('New'); ?></span>
										</div>
								<?php }
							} ?>
							
							<!--END LABEL PRODUCT-->						
						</div>
					<?php
					}?>
					<div class="box-info">
						<?php if ($this->_getConfig('product_title_display', 1) == 1) {
							?>
							<h2 class="product-name">
								<a href="<?php echo $item->link ?>" <?php echo $helper->parseTarget($this->_getConfig('product_links_target', '_self')) ?> title="<?php echo $item->title ?>">
									<?php echo $helper->truncate($item->title, $this->_getConfig('product_title_maxlength', 25)); ?>
								</a>
							</h2>
						<?php } ?>	

						<?php if ((int)$this->_getConfig('product_reviews_count')) { ?>
							<?php echo $this->getReviewsSummaryHtml($item, "short", true); ?>
						<?php } ?>
						
						<?php if ((int)$this->_getConfig('product_price_display', 1)) { ?>
							<?php echo $this->getPriceHtml($item, true); ?>
						<?php } ?>	
						
						<?php if ($this->_getConfig('product_description_display', 1) == 1 && $helper->_trimEncode($item->_description) != '') { ?>
							<div class="item-desc">
								<?php echo $item->_description; ?>
							</div>
						<?php } ?>
						
						<?php if ((int)$this->_getConfig('product_readmore_display', 1)) { ?>
							<div class="item-readmore">
								<a href="<?php echo $item->link; ?>"
								   title="<?php echo $item->title ?>" <?php echo $helper->parseTarget($this->_getConfig('product_links_target', '_self')); ?> >
									<?php echo $this->_getConfig('product_readmore_text', 'Detail'); ?>
								</a>
							</div>
						<?php } ?>
						
					</div>

				</div>
			</div>
			<?php if (!empty($posttext)) { ?>
				<?php if($k % $item_page == 1) {?>
				<div class="ltabs-item new-ltabs-item item item-virtual">
					<div class="item-inner">
					<?php echo $this->getLayout()->createBlock('cms/block')->setBlockId($posttext)->toHtml(); ?>
					</div>
				</div>
				<?php } ?>
			<?php } ?>			
			
			
		<?php 
		if($k % $item_page == 0 && $k < count($child_items)) { ?>
			</div>
			<div class="ltabs-item-slide <?php echo $class_item_slide; ?>">
		<?php } 

		if($k > count($child_items)) { ?>
		</div>
		<?php } 
	}
}?>

