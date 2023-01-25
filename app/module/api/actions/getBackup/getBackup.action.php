<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Subscription;

#[OModuleAction(
	url: '/get-backup'
)]
class getBackupAction extends OAction {
	/**
	 * Función para descargar un backup
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$api_key = $req->getParamString('api_key');
		$id      = $req->getParamInt('id');

		if (is_null($api_key) || is_null($id)) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$subscription = new Subscription();
			// Busco la suscripción por la API KEY
			if ($subscription->find(['api_key' => $api_key])) {
				$backup = new Backup();
				// Busco el backup por el id
				if ($backup->find(['id' => $id])) {
					$account = $backup->getAccount();
					// Compruebo que el backup es de la suscripcion usando la cuenta
					if ($account->get('id_subscription') == $subscription->get('id')) {
						$file_path = $backup->getFilePath();
						header('Content-Type: application/sql');
						header('Content-length: '.filesize($file_path));
						header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\"");
						readfile($file_path);
						exit;
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
