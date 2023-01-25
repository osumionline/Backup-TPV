<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: ['login', 'main', 'subscription', 'account', 'loginForm', 'addSubscription', 'addAccount', 'deleteSubscription'],
	type: 'html'
)]
class homeModule {}
