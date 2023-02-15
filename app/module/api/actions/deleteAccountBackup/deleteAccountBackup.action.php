<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Backup;

#[OModuleAction(
	url: '/delete-account-backup'
)]
class deleteAccountBackupAction extends OAction {
	/**
	 * Función para borrar una copia de seguridad desde el TPV
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$api_key = $req->getParamString('api_key');

		if (is_null($id) || is_null($api_key)) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$backup = new Backup();
			if ($backup->find(['id' => $id])) {
				$account      = $backup->getAccount();
				$subscription = $account->getSubscription();
				if ($subscription->get('api_key') == $api_key) {
					$backup->deleteFull();
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
