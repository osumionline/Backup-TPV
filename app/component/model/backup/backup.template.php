<?php if (is_null($values['backup'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['backup']->get('id') ?>,
	"idAccount": <?php echo $values['backup']->get('id_account') ?>,
	"account": "<?php echo urlencode($values['backup']->getAccount()->getName()) ?>",
	"date": "<?php echo $values['backup']->get('created_at', 'd/m/Y H:i') ?>"
}
<?php endif ?>
