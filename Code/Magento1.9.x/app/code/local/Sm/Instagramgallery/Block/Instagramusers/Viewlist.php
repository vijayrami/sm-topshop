<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 20-07-2015
 * Time: 0:42
 */

ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
class Sm_Instagramgallery_Block_Instagramusers_Viewlist extends Mage_Core_Block_Abstract
{
	protected $_config = null;
	protected $hash = null;

	public function __construct($attr)
	{
		parent::_construct($attr);
		$this->_config = $this->_getCfg($attr);
	}

	public function _getCfg($attr = null)
	{
		// get default config.xml
		$defaults = array();
		$def_cfgs = Mage::getConfig()
			->loadModulesConfiguration('config.xml')
			->getNode('default/instagramgallery')->asArray();
		if (empty($def_cfgs)) return;
		$groups = array();
		foreach ($def_cfgs as $def_key => $def_cfg) {
			$groups[] = $def_key;
			foreach ($def_cfg as $_def_key => $cfg) {
				$defaults[$_def_key] = $cfg;
			}
		}

		// get configs after change
		$_configs = (array)Mage::getStoreConfig("instagramgallery");
		if (empty($_configs)) return;
		$cfgs = array();

		foreach ($groups as $group) {
			$_cfgs = Mage::getStoreConfig('instagramgallery/' . $group . '');
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
		$output  = '';
		$helper = Mage::helper('instagramgallery');
		if($helper->enabledInstagramgallery())
		{
			$users_id = $helper->usersInstagram();
			$access_token = (string)$helper->accessToken();

			$title = $helper->titleInstagram();
			$limit_image = $helper->limitImage();

			/* For devices screen width than 1200px */
			$num_cols = $helper->numcolsScreen1200() ? $helper->numcolsScreen1200() : '3';

			/* For devices screen width from 992px to 1199px */
			$num_cols1 = $helper->numcolsScreen992() ? $helper->numcolsScreen992() : '3';

			/* For devices screen width from 768px to 991px */
			$num_cols2 = $helper->numcolsScreen768() ? $helper->numcolsScreen768() : '2';

			/* For devices screen width less than 768px */
			$num_cols3 = $helper->numcolsScreenLesThan768() ? $helper->numcolsScreenLesThan768() : '1';

			$class = "cols{$num_cols} cols1{$num_cols1} cols2{$num_cols2} cols3{$num_cols3} ";

			$output .= "<div class='block container_instagramusers' style='width: 100%;height: auto; position: relative; display: inline-block;'>";
			$output .= "<div class='block-title'><strong><span>{$title}</span></strong></div>";
			$output .= "<div id='divinstagramusers' class='block-content' style='width: 100%;height: auto; position: relative; display: inline-block;'>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= $this->getMediaInstagramUsers($users_id, (string)$access_token, $limit_image, $class);
		}

		$use_cache = (int)$this->_getConfig('use_cache');
		$cache_time = (int)$this->_getConfig('cache_time');
		$folder_cache = dirname(dirname(__FILE__)).'/Cache/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777);
		if (!class_exists('Cache_Lite'))
			require_once($this->getBaseDir() .  'lib' . DS .  'Sm' .DS . 'Instagramgallery' .DS . 'Cache_Lite' . DS . 'Lite.php');
		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($this->getConfig()) );
			if (!empty($this->hash) && $data = $Cache_Lite->get($this->hash)) {
				return  $data;
			} else {
				$template_file = $this->getTemplate();
				$template_file = (!empty($output)) ? $output : $template_file;
				$this->setTemplate($output);
				$data = parent::_toHtml();
				$Cache_Lite->save($output);
			}
		}else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);
			$template_file = $this->getTemplate();
			$template_file = (!empty($output)) ? $output : $template_file;
			$this->setTemplate($output);
		}
		return $output;
	}

	public function getMediaInstagramUsers($users_id, $access_token, $limit_image, $class)
	{
		return "<script type='text/javascript'>
			jQuery(document).ready(function ($) {
				var users_id = $users_id;
				var access_token = '$access_token';
				var limit_image = $limit_image;
				var class_ins = '$class';
				var url;
				url = 'https://api.instagram.com/v1/users/'+users_id+'/media/recent?access_token='+access_token;
				$.ajax({
					method: 'GET',
					dataType: 'jsonp',
					cache: false,
					url: url,
					success: function(response){
					if (response.data && (response.data.length > 0))
					{
						if (response.data.length >= limit_image)
						{
							for (var i = 0; i < limit_image; i++)
							{
								$('#divinstagramusers').append('<div class=\"instagram_users img_users '+class_ins+'\"><a class=\"instagram_gallery_image\" rel=\"instagram_gallery\" data-href=\"'+response.data[i].link+'\" href=\"'+response.data[i].images.low_resolution.url+'?taken-by='+response.data[i].user.username+'\"><img id=\"'+response.data[i].id+'\" class=\"image_users\" src=\"'+ response.data[i].images.low_resolution.url +'\" alt=\"\" /></a></div>');
							}
						}
						else
						{
							for (var i = 0; i < response.data.length; i++)
							{
								$('#divinstagramusers').append('<div class=\"instagram_users img_users '+class_ins+'\"><a class=\"instagram_gallery_image\" rel=\"instagram_gallery\" data-href=\"'+response.data[i].link+'\" href=\"'+response.data[i].images.low_resolution.url+'?taken-by='+response.data[i].user.username+'\"><img id=\"'+response.data[i].id+'\" class=\"image_users\" src=\"'+ response.data[i].images.low_resolution.url +'\" alt=\"\" /></a></div>');
							}
						}
						$('#divinstagramusers').append('<script type=\"text/javascript\">'+
								'jQuery(\".instagram_gallery_image\").fancybox({' +
								    'prevEffect	 : \'elastic\','+
						            'nextEffect	 : \'elastic\', '+
									'padding	 : 5,' +
						            'helpers: {' +
						                'thumbs	: {' +
						                    'width	: 50,' +
						                    'height	: 50' +
						                '}' +
									'}	'+
								'});' +
								 '<'+'/script>');
					}
					else
					{
						$('#divinstagramusers').append('<p class=\"no_image\">Instagram Users dont have image</p>');
					}
				},
				error: function(response) {
					$('divinstagramusers').insert('Error');
				}
				});
			});
		</script>";
	}
}