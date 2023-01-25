<div class="list">
<?php foreach ($values['list'] as $item): ?>
  <div class="list-item">
    <label><?php echo $item->get('name') ?></label>
    <button class="btn btn-warn delete-backup" type="button" data-id="<?php echo $item->get('id') ?>">Eliminar copia</button>
  </div>
<?php endforeach ?>
</div>
