<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;

#[OModuleAction(
	url: '/',
	inlineJS: ['login']
)]
class loginAction extends OAction {
	/**
	 * Home de la aplicación Osumi TPV Backup
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$error = $this->getSession()->getParam('error');
		$show_error = 'none';
		if (!is_null($error) && $error == 'error') {
			$show_error = 'flex';
		}
		$this->getSession()->cleanSession();
		$this->getTemplate()->add('error', $show_error);
	}
}
