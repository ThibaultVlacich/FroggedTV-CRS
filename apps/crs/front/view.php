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

	public function overlay($model) {
		$this->assign('css', '/apps/crs/front/css/overlay.css');
		$this->assign('require', 'apps!crs/overlay');
	}

	public function pick($model) {
		$this->assign('css', '/apps/crs/front/css/pick.css');
		$this->assign('require', 'apps!crs/pick');

		$this->assignDefault(array(
			'id_game' => 0,
			'target'  => 0,
			'players' => array(),
			'options' => array()
		), $model);
	}

}

?>
