<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Subscription;
use OsumiFramework\OFW\Routing\OUrl;

#[OModuleAction(
	url: '/deleteSubscription/:id',
	filters: ['login']
)]
class deleteSubscriptionAction extends OAction {
	/**
	 * Función para borrar una suscripción
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$subscription = new Subscription();
		$subscription->find(['id' => $req->getParamInt('id')]);
		$subscription->deleteFull();

		OUrl::goToUrl('/main');
	}
}
