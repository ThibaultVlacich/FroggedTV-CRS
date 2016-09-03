<?php
/**
 * CRS Application - View
 */

defined('WITYCMS_VERSION') or die('Access denied');

/**
 * CrsView is the View of the CRS Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-03-09-2016
 */
class CrsView extends WView {
	public function index($model) {
		$this->assign('css', '/apps/crs/front/css/index.css');
		$this->assign('require', 'apps!crs/crs');
	}
}

?>
