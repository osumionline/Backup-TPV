<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Backup extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada backup'
			),
			new OModelField(
				name: 'id_account',
				type: OMODEL_NUM,
				nullable: false,
				ref: 'account.id',
				comment: 'Id de la cuenta que hace el backup'
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

	private ?Account $account = null;

	/**
	 * Obtiene la cuenta a la que pertenece el backup
	 *
	 * @return Account Cuenta a la que pertenece el backup
	 */
	public function getAccount(): Account {
		if (is_null($this->account)) {
			$this->loadAccount();
		}
		return $this->account;
	}

	/**
	 * Guarda la cuenta a la que pertenece el backup
	 *
	 * @param Account $a Cuenta a la que pertenece el backup
	 *
	 * @return void
	 */
	public function setAccount(Account $a): void {
		$this->account = $a;
	}

	/**
	 * Carga la cuenta a la que pertenece el backup
	 *
	 * @return void
	 */
	public function loadAccount(): void {
		$account = new Account();
		$account->find(['id' => $this->get('id_account')]);
		$this->setAccount($account);
	}

	/**
	 * Función para obtener la ruta de un archivo de una copia de seguridad
	 */
	public function getFilePath(): string {
		global $core;
		return $core->config->getExtra('files').$this->get('id').'.sql';
	}

	/**
	 * Función para borrar una copia de seguridad, el archivo y su registro
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$file_path = $this->getFilePath();
		if (file_exists($file_path)) {
			unlink($file_path);
		}
		$this->delete();
	}
}
