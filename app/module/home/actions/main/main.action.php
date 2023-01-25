<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\List\SubscriptionListComponent;

#[OModuleAction(
	url: '/main',
	filters: ['login'],
	inlineJS: ['main'],
	services: ['general']
)]
class mainAction extends OAction {
	/**
	 * Página principal
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$subscription_list_component = new SubscriptionListComponent(['list' => $this->general_service->getSubscriptions()]);

		$this->getTemplate()->add('list', $subscription_list_component);
	}
}
