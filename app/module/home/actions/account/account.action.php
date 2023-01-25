<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Account;
use OsumiFramework\App\Component\List\BackupListComponent;

#[OModuleAction(
	url: '/account/:id',
	filters: ['login'],
	inlineJS: ['subscription']
)]
class accountAction extends OAction {
	/**
	 * Página de una cuenta y sus copias de seguridad
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$account = new Account();
		$account->find(['id' => $req->getParamInt('id')]);
		$subscription = $account->getSubscription();
		$backup_list_component = new BackupListComponent(['list' => $account->getBackups()]);

		$this->getTemplate()->add('subscription_id',   $subscription->get('id'));
		$this->getTemplate()->add('subscription_name', $subscription->get('name'));
		$this->getTemplate()->add('account_name',      $account->get('name'));
		$this->getTemplate()->add('list',              $backup_list_component);
	}
}
