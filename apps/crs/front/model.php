<?php
/**
 * CRS Application - Model
 */

defined('WITYCMS_VERSION') or die('Access denied');

/**
 * CrsModel is the Model of the Chasse Ragequit & Safari Application
 *
 * @package Apps\Settings\crs
 * @author Thibault Vlacich <thibault@vlacich.fr>
 * @version 1.0.0-03-09-2016
 */
class CrsModel {
	/**
	 * @var WDatabase instance
	 */
	protected $db;

	public function __construct() {
		$this->db = WSystem::getDB();

		// Declare tables
		$this->db->declareTable('crs_games');
		$this->db->declareTable('crs_options');
		$this->db->declareTable('crs_players');
	}

    public function getGames() {
		$prep = $this->db->prepare("
			SELECT id FROM crs_games ORDER BY created_date DESC
		");

		$prep->execute();

		$games = array();

		while (list($id_game) = $prep->fetch()) {
			$game = $this->getGame($id_game);

			array_push($games, $game);
		}

		return $games;
	}

	public function getGame($id_game) {
		$prep = $this->db->prepare("
			SELECT target, created_date FROM crs_games WHERE id = :id_game
		");

		$prep->bindParam(':id_game', $id_game, PDO::PARAM_INT);
		$prep->execute();

        if (!($fetch = $prep->fetch())) {
            return false;
        }

		list($target, $create_date) = $fetch;

		$prep = $this->db->prepare("
			SELECT id, name, kills FROM crs_players WHERE id_game = :id_game
		");

		$prep->bindParam(':id_game', $id_game, PDO::PARAM_INT);
		$prep->execute();

		$players = $prep->fetchAll(PDO::FETCH_ASSOC);

		return array(
			'id'           => $id_game,
			'target'       => $target,
			'players'      => $players,
            'created_date' => new WDate($create_date)
		);
	}

    /**
     * Select global options
     */
    public function getOptions() {
		$options_prep = $this->db->prepare('
			SELECT name, value FROM crs_options
		');

		$options_prep->execute();

		$options = array();

		while($option = $options_prep->fetch(PDO::FETCH_ASSOC)) {
			$options[$option['name']] = $option['value'];
		}

        return $options;
    }

	public function getJSON() {
		/**
		 * Select the latest game in Database
		 */
		$game_prep = $this->db->prepare('
			SELECT id, target FROM crs_games ORDER BY created_date DESC LIMIT 1
		');

		$game_prep->execute();

		list($id_game, $target) = $game_prep->fetch();

		/**
		 * Select the players for this game
		 */
		$players_prep = $this->db->prepare('
			SELECT name, kills FROM crs_players WHERE id_game = :id_game
		');

		$players_prep->bindParam(':id_game', $id_game, PDO::PARAM_INT);

		$players_prep->execute();

		$players = $players_prep->fetchAll(PDO::FETCH_ASSOC);

		return array(
			'id_game' => $id_game,
			'target'  => $target,
			'players' => $players,
			'options' => $this->getOptions()
		);
	}
}

?>
