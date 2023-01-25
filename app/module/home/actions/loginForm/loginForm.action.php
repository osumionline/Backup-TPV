<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\User;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\OFW\Routing\OUrl;

#[OModuleAction(
	url: '/login'
)]
class loginFormAction extends OAction {
	/**
	 * Función para comprobar un inicio de sesión
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$user = $req->getParamString('user');
		$pass = $req->getParamString('pass');

		if (is_null($user) || is_null($pass)) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$u = new User();
			if ($u->find(['username' => $user])) {
				if (!password_verify($pass, $u->get('pass'))) {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		if ($status == 'ok') {
			$tk = new OToken($this->getConfig()->getExtra('secret'));
			$tk->addParam('id', $u->get('id'));
			$tk->addParam('username', $u->get('username'));
			$tk->addParam('exp',   time() + (24 * 60 * 60));
			$token = $tk->getToken();
			$this->getSession()->addParam('token', $token);
			OUrl::goToUrl('/main');
		}
		else {
			$this->getSession()->addParam('error', 'error');
			OUrl::goToUrl('/');
		}
	}
}
