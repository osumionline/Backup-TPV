<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Account;
use OsumiFramework\OFW\Routing\OUrl;

#[OModuleAction(
	url: '/deleteAccount/:id'
)]
class deleteAccountAction extends OAction {
	/**
	 * Función para borrar una cuenta y sus copias de seguridad
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$account = new Account();
		$account->find(['id' => $req->getParamInt('id')]);
		$id_subscription = $account->get('id_subscription');
		$account->deleteFull();

		OUrl::goToUrl('/subscription/'.$id_subscription);
	}
}
