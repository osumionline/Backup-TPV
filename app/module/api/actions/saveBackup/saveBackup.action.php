<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Subscription;
use OsumiFramework\App\Model\Account;
use OsumiFramework\App\Model\Backup;

#[OModuleAction(
	url: '/save-backup'
)]
class saveBackupAction extends OAction {
	/**
	 * Función para guardar una copia de seguridad
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status     = 'ok';
		$api_key    = $req->getParamString('api_key');
		$id_account = $req->getParamInt('id_account');
		$file       = $req->getParam('file');

		if (is_null($api_key) || is_null($id_account) || is_null($file)) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$subscription = new Subscription();
			// Busco la suscripción por la API KEY
			if ($subscription->find(['api_key' => $api_key])) {
				$account = new Account();
				// Busco la cuenta por el ID
				if ($account->find(['id' => $id_account])) {
					// Compruebo que la cuenta pertenece a la suscripción
					if ($subscription->get('id') == $account->get('id_subscription')) {
						// Si la cuenta ya tiene el máximo de backups, borro el más antiguo
						if ($this->getConfig()->getExtra('max_backups') == $account->getNumBackups()) {
							$oldest_backup = $account->getOldestBackup();
							$oldest_backup->deleteFull();
						}
						// Creo la nueva copia de seguridad
						$backup = new Backup();
						$backup->set('id_account', $account->get('id'));
						$backup->save();

						// Guardo el archivo recibido
						$file_path = $backup->getFilePath();
						file_put_contents($file_path, $file);
					}
					else {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
