<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Subscription;
use OsumiFramework\App\Component\Model\BackupListComponent;

#[OModuleAction(
	url: '/get-backups',
	services: ['general']
)]
class getBackupsAction extends OAction {
	/**
	 * Función para obtener la lista de copias de seguridad de una suscripción
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$api_key = $req->getParamString('api_key');
		$backup_list_component = new BackupListComponent(['list' => []]);

		if (is_null($api_key)) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$subscription = new Subscription();
			// Busco la suscripción por la API KEY
			if ($subscription->find(['api_key' => $api_key])) {
				$backup_list_component->setValue('list', $this->general_service->getSubscriptionBackupList($subscription));
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $backup_list_component);
	}
}
