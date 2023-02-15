(function () {
  var idAccount;
  var deleteBtn;

  window.addEventListener("load", (event) => {
    idAccount = document.getElementById('id-account');
    deleteBtn = document.getElementById('delete');

    deleteBtn.addEventListener('click', deleteAccount);

    document.querySelectorAll('.delete-backup').forEach((x) => {
      x.addEventListener('click', deleteBackup);
    });
  });

  function deleteAccount() {
    if (confirm('¿Estás seguro de querer borrar esta cuenta? Es un paso irreversible y se borrará tanto la cuenta como las copias de seguridad que esta tiene.')) {
      document.location.href = '/deleteAccount/' + idAccount.value;
    }
  }

  function deleteBackup() {
    const id = this.dataset.id;
    const conf = confirm('¿Estás seguro de querer borrar esta copia de seguridad?');
    if (conf) {
      postData('/api/delete-backup', { id })
      .then(data => {
        if (data.status == 'ok') {
          document.querySelector('.list-item[data-id="'+id+'"]').remove();
        }
        else {
          alert('¡Ocurrió un error al borrar la copia de seguridad');
        }
      });
    }
  }
})();
