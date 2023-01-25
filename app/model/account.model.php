<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\OFW\DB\ODB;

class Account extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada cuenta'
			),
			new OModelField(
				name: 'id_subscription',
				type: OMODEL_NUM,
				nullable: false,
				ref: 'subscription.id',
				comment: 'Id de la suscripción a la que pertenece la cuenta'
			),
      new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				size: 50,
				comment: 'Nombre descriptivo de la cuenta'
			),
			new OModelField(
				name: 'last_copy_at',
				type: OMODEL_DATE,
				nullable: true,
				default: null,
				comment: 'Fecha de la última copia de la cuenta'
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

	private ?Subscription $subscription = null;

	/**
	 * Obtiene la suscripción a la que pertenece la cuenta
	 *
	 * @return Subscription Suscripción a la que pertenece la cuenta
	 */
	public function getSubscription(): Subscription {
		if (is_null($this->subscription)) {
			$this->loadSubscription();
		}
		return $this->subscription;
	}

	/**
	 * Guarda la suscripción a la que pertenece la cuenta
	 *
	 * @param Subscription $s Suscripción a la que pertenece la cuenta
	 *
	 * @return void
	 */
	public function setSubscription(Subscription $s): void {
		$this->subscription = $s;
	}

	/**
	 * Carga la suscripción a la que pertenece la cuenta
	 *
	 * @return void
	 */
	public function loadSubscription(): void {
		$subscription = new Subscription();
		$subscription->find(['id' => $this->get('id_subscription')]);
		$this->setSubscription($subscription);
	}

	private ?array $backups = null;

	/**
	 * Obtiene el listado de backups de una cuenta
	 *
	 * @return array Listado de backups
	 */
	public function getBackups(): array {
		if (is_null($this->backups)) {
			$this->loadBackups();
		}
		return $this->backups;
	}

	/**
	 * Guarda la lista de backups de una cuenta
	 *
	 * @param array $l Lista de backups
	 *
	 * @return void
	 */
	public function setBackups(array $l): void {
		$this->backups = $l;
	}

	/**
	 * Carga la lista de backups de una cuenta
	 *
	 * @return void
	 */
	public function loadBackups(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `backup` WHERE `id_account` = ? ORDER BY `created_at` DESC";
		$db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res=$db->next()) {
			$b = new Backup();
			$b->update($res);
			array_push($list, $b);
		}

		$this->setBackups($list);
	}

	/**
	 * Función para borrar una cuenta y todas sus copias de seguridad
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$backups = $this->getBackups();
		foreach ($backups as $backup) {
			$backup->deleteFull();
		}
		$this->delete();
	}
}
