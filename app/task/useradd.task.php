<?php declare(strict_types=1);

namespace OsumiFramework\App\Task;

use OsumiFramework\OFW\Core\OTask;
use OsumiFramework\App\Model\User;

class useraddTask extends OTask {
	public function __toString() {
		return "useradd: Tarea para crear usuarios nuevos";
	}

	public function run(array $options=[]): void {
		if (count($options)==0) {
			echo "\n\n  ERROR: Tienes que indicar el nombre de usuario y su contraseña.\n\n";
			echo "    ofw useradd usuario contraseña\n\n";
			exit;
		}
		$user = $options[0];
		$pass = $options[1];

		$u = new User();
		$u->set('username', $user);
		$u->set('pass', password_hash($pass, PASSWORD_BCRYPT));
		$u->save();

		echo "Nuevo usuario \"".$user."\" creado con id: ".$u->get('id')."\n\n";
	}
}
