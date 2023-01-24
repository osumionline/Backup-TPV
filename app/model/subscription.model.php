<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Subscription extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada suscripción'
			),
      new OModelField(
				name: 'api_key',
				type: OMODEL_TEXT,
				nullable: false,
				size: 100,
				comment: 'Clave API que se usará para acceder'
			),
			new OModelField(
				name: 'expires_at',
				type: OMODEL_DATE,
				nullable: true,
				default: null,
				comment: 'Fecha cuando expira la suscripción'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

		parent::load($model);
	}
}
