<?php declare(strict_types=1);

namespace OsumiFramework\App\Filter;

use OsumiFramework\OFW\Plugins\OToken;

/**
 * Filtro de seguridad para zonas protegidas
 *
 * @param array $params Parameter array received on the call
 *
 * @param array $headers HTTP header array received on the call
 *
 * @return array Return filter status (ok / error) and information
 */
function loginFilter(array $params, array $headers): array {
	global $core;
  $token = $core->session->getParam('token');
	$ret = ['status'=>'error', 'id'=>null];

  if (!is_null($token)) {
  	$tk = new OToken($core->config->getExtra('secret'));
  	if ($tk->checkToken($token)){
  		$ret['status'] = 'ok';
  		$ret['id'] = intval($tk->getParam('id'));
  	}
  }

	return $ret;
}
