<?php
/**
 * CRS Application - Front Controller
 */

defined('WITYCMS_VERSION') or die('Access denied');

/**
 * CrsController is the Controller of the Chasse Ragequit & Safari Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-03-09-2016
 */
class CrsController extends WController {

	protected function overlay() {
		return $this->model->getJSON();
	}

	protected function pick() {
		return $this->model->getJSON();
	}

}

?>
