<?php declare(strict_types=1);

namespace OsumiFramework\App\Service;

use OsumiFramework\OFW\Core\OService;
use OsumiFramework\OFW\DB\ODB;
use OsumiFramework\App\Model\Subscription;

class generalService extends OService {
	function __construct() {
		$this->loadService();
	}

	/**
	 * Función para obtener la lista de suscripciones
	 *
	 * @return array Lista de suscripciones
	 */
	public function getSubscriptions(): array {
		$db = new ODB();
		$ret = [];
		$sql = "SELECT * FROM `subscription` ORDER BY `name`";
		$db->query($sql);

		while ($res = $db->next()) {
			$s = new Subscription();
			$s->update($res);
			array_push($ret, $s);
		}

		return $ret;
	}

	/**
	 * Función para obtener la lista completa de copias de seguridad de una suscripción
	 *
	 * @param Subscription $subscription Suscripción de la que obtener la lista
	 *
	 * @return array Lista de backups
	 */
	public function getSubscriptionBackupList(Subscription $subscription): array {
		$list = [];

		$accounts = $subscription->getAccounts();
		foreach ($accounts as $account) {
			$list = array_merge($list, $account->getBackups());
		}
		usort($list, fn($a, $b) => strcmp($b->get('created_at'), $a->get('created_at')));

		return $list;
	}
}
