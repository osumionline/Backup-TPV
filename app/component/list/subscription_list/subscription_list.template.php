<div class="list">
<?php foreach ($values['list'] as $item): ?>
  <a class="list-item" href="/subscription/<?php echo $item->get('id') ?>">
    <label><?php echo $item->get('name') ?></label>
    <span>Expira: <?php echo is_null($item->get('expires_at')) ? 'Nunca' : $item->get('expires_at', 'd/m/Y') ?></span>
  </a>
<?php endforeach ?>
</div>
