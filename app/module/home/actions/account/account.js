(function () {
  var idAccount;
  var deleteBtn;

  window.addEventListener("load", (event) => {
    idAccount = document.getElementById('id-account');
    deleteBtn = document.getElementById('delete');

    deleteBtn.addEventListener('click', deleteAccount);
  });

  function deleteAccount() {
    if (confirm('¿Estás seguro de querer borrar esta cuenta? Es un paso irreversible y se borrará tanto la cuenta como las copias de seguridad que esta tiene.')) {
      document.location.href = '/deleteAccount/' + idAccount.value;
    }
  }
})();
