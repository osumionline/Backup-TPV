<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Tools\OTools;
use OsumiFramework\App\Model\Subscription;
use OsumiFramework\OFW\Routing\OUrl;

#[OModuleAction(
	url: '/addSubscription',
	filters: ['login']
)]
class addSubscriptionAction extends OAction {
	/**
	 * Función para añadir una nueva suscripción
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$api_key_first  = OTools::getRandomCharacters(['num' => 30, 'lower' => true, 'upper' => true, 'numbers' => true]);
		$api_key_second = OTools::getRandomCharacters(['num' => 10, 'lower' => true, 'upper' => true, 'numbers' => true]);
		$api_key_third  = OTools::getRandomCharacters(['num' => 30, 'lower' => true, 'upper' => true, 'numbers' => true]);

		$subs = new Subscription();
		$subs->set('name', $req->getParamString('name'));
		$subs->set('api_key', $api_key_first.'-'.$api_key_second.'-'.$api_key_third);
		$subs->set('expires_at', null);
		$subs->save();

		OUrl::goToUrl('/main');
	}
}
