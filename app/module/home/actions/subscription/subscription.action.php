<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Subscription;
use OsumiFramework\App\Component\List\AccountListComponent;

#[OModuleAction(
	url: '/subscription/:id',
	filters: ['login'],
	inlineJS: ['subscription']
)]
class subscriptionAction extends OAction {
	/**
	 * Página con el detalle de una suscripción
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id = $req->getParamInt('id');

		$subscription = new Subscription();
		$subscription->find(['id' => $id]);

		$account_list_component = new AccountListComponent(['list' => $subscription->getAccounts()]);

		$this->getTemplate()->add('name',    $subscription->get('name'));
		$this->getTemplate()->add('api_key', $subscription->get('api_key'));
		$this->getTemplate()->add('expires', is_null($subscription->get('expires_at')) ? 'Nunca' : $subscription->get('expires_at', 'd/m/Y'));
		$this->getTemplate()->add('list',    $account_list_component);
		$this->getTemplate()->add('id',      $subscription->get('id'));
	}
}
