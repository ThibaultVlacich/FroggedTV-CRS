<?php
/**
 * Crs Application - Admin View
 */

defined('WITYCMS_VERSION') or die('Access denied');

/**
 * CrsAdminView is the Admin View of the Chasse Ragequit & Safari Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-24-09-2016
 */
class CrsAdminView extends WView {
    public function games($model) {
        $this->assign('games', $model['games']);
    }

    public function game($model) {
        $this->assign($model['game']);
        $this->assign('options', $model['options']);

        $this->assign('require', 'apps!crs/game');
    }

    public function game_add($model) {
        $this->assign('heroes', $model['heroes']);
    }
}

?>
