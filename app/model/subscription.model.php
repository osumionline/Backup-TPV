<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\OFW\DB\ODB;

class Subscription extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada suscripción'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				size: 50,
				comment: 'Nombre de la suscripción'
			),
      new OModelField(
				name: 'api_key',
				type: OMODEL_TEXT,
				nullable: false,
				size: 100,
				comment: 'Clave API que se usará para acceder'
			),
			new OModelField(
				name: 'expires_at',
				type: OMODEL_DATE,
				nullable: true,
				default: null,
				comment: 'Fecha cuando expira la suscripción'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

		parent::load($model);
	}

	private ?array $accounts = null;

	/**
	 * Obtiene el listado de cuentas de una suscripción
	 *
	 * @return array Listado de cuentas
	 */
	public function getAccounts(): array {
		if (is_null($this->accounts)) {
			$this->loadAccounts();
		}
		return $this->accounts;
	}

	/**
	 * Guarda la lista de cuentas de una suscripción
	 *
	 * @param array $l Lista de cuentas
	 *
	 * @return void
	 */
	public function setAccounts(array $l): void {
		$this->accounts = $l;
	}

	/**
	 * Carga la lista de cuentas de una suscripción
	 *
	 * @return void
	 */
	public function loadAccounts(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `account` WHERE `id_subscription` = ? ORDER BY `name`";
		$db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res=$db->next()) {
			$a = new Account();
			$a->update($res);
			array_push($list, $a);
		}

		$this->setAccounts($list);
	}

	/**
	 * Función para borrar una suscripción y todos sus datos
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$accounts = $this->getAccounts();
		foreach ($accounts as $account) {
			$account->deleteFull();
		}
		$this->delete();
	}
}
