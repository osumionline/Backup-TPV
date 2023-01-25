<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Account;
use OsumiFramework\OFW\Routing\OUrl;

#[OModuleAction(
	url: '/addAccount',
	filters: ['login']
)]
class addAccountAction extends OAction {
	/**
	 * Función para añadir una nueva cuenta
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$account = new Account();
		$account->set('id_subscription', $req->getParamInt('id-subscription'));
		$account->set('name', $req->getParamString('name'));
		$account->save();

		OUrl::goToUrl('/subscription/'.$account->get('id_subscription'));
	}
}
