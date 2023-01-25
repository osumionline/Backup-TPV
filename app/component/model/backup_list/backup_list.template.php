<?php
use OsumiFramework\App\Component\Model\BackupComponent;

foreach ($values['list'] as $i => $backup) {
  $component = new BackupComponent([ 'backup' => $backup ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
