<div class="list">
<?php foreach ($values['list'] as $item): ?>
  <a class="list-item" href="/account/<?php echo $item->get('id') ?>">
    <label><?php echo $item->get('name') ?></label>
    <span>Última copia: <?php echo is_null($item->get('last_copy_at')) ? 'Nunca' : $item->get('last_copy_at', 'd/m/Y H:i:s') ?></span>
  </a>
<?php endforeach ?>
</div>
