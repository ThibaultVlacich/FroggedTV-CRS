<?php
/**
 * CRS Application - Model
 */

defined('WITYCMS_VERSION') or die('Access denied');

require_once APPS_DIR.DS.'crs'.DS.'front'.DS.'model.php';

/**
 * CrsAdminModel is the Admin Model of the Chasse Ragequit & Safari Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-03-09-2016
 */
class CrsAdminModel extends CrsModel {

	private $timer_format = 'H:i:s';

	public function __construct() {
		parent::__construct();
	}

    public function increase_kill_count($player_id) {
        $prep = $this->db->prepare("
            UPDATE crs_players SET kills = kills + 1 WHERE id = :player_id
        ");

        $prep->bindParam(':player_id', $player_id, PDO::PARAM_INT);

        $prep->execute();
    }

    public function decrease_kill_count($player_id) {
        $prep = $this->db->prepare("
            UPDATE crs_players SET kills = kills - 1 WHERE id = :player_id
        ");

        $prep->bindParam(':player_id', $player_id, PDO::PARAM_INT);

        $prep->execute();
    }

	public function increment_timer() {
		$prep = $this->db->prepare("
			SELECT value FROM crs_options WHERE name = 'timer'
		");

		$prep->execute();

		list($timer) = $prep->fetch();

		$timer = new WDate($timer);

		$timer->add(new DateInterval('PT1S'));

		$new_timer = $timer->format($this->timer_format);

		$prep = $this->db->prepare("
			UPDATE crs_options SET value = :value WHERE name = 'timer'
		");

		$prep->bindParam(':value', $new_timer);

		$prep->execute();

        return $new_timer;
	}

	public function createGame($target, $players) {
		$prep = $this->db->prepare("
			INSERT INTO crs_games
				(target) VALUES (:target)
		");

		$prep->bindParam(':target', $target, PDO::PARAM_INT);

		$prep->execute();

		$id_game = $this->db->lastInsertId();

		foreach ($players as $player) {
			$prep = $this->db->prepare("
				INSERT INTO crs_players
					(id_game, name, id_hero, kills) VALUES (:id_game, :name, :id_hero, 0)
			");

			$prep->bindParam(':id_game', $id_game, PDO::PARAM_INT);
			$prep->bindParam(':name', $player['name']);
			$prep->bindParam(':id_hero', $player['hero']);

			$prep->execute();
		}

        return $id_game;
	}

}

?>
