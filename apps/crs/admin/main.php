<?php
/**
 * CRS Application - Admin Controller
 */

defined('WITYCMS_VERSION') or die('Access denied');

/**
 * CrsAdminController is the Admin Controller of the Chasse Ragequit & Safari Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-03-09-2016
 */
class CrsAdminController extends WController {
	protected function games() {
		return array(
            'games' => $this->model->getGames()
        );
	}

    protected function game(array $params) {
        $id_game = array_shift($params);

        if (!($game = $this->model->getGame($id_game))) {
            return WNote::error('game_not_found', WLang::get('Game not found'));
        }

        return array(
            'game'    => $game,
            'options' => $this->model->getOptions()
        );
    }

    protected function game_add() {
        if (WRequest::getMethod() == 'POST') {
            $data = WRequest::getAssoc(array('side', 'target', 'players'), 'POST');

            if (!in_array(null, $data)) {
                switch ($data['side']) {
                    case 'dire':
                        $target = $data['target'] + 5;
                        break;
                    case 'radiant':
                        $target = $data['target'];
                        break;
                }

                $players = array();

                foreach ($data['players'] as $index => $value) {
                    $players[] = array('name' => $value['name'], 'hero' => $value['hero']);
                }

                $id_game = $this->model->createGame($target, $players);

                $this->setHeader('Location', WRoute::getDir().'admin/crs/game/'.$id_game);
                return WNote::success('game_created', WLang::get('The game has been created successfully.'));
            }
        }

		return array(
			'heroes' => $this->model->getHeroes()
		);
	}

    protected function kill_count(array $params) {
        $player_id = array_shift($params);
        $action    = array_shift($params);

        switch ($action) {
            case "increase":
                $this->model->increase_kill_count($player_id);
                break;
            case "decrease":
                $this->model->decrease_kill_count($player_id);
                break;
        }
    }

	protected function increment_timer() {
		return array('timer' => $this->model->increment_timer());
	}
}

?>
