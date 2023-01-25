(function () {
  var apiKey;
  var copyKeyBtn;
  var addBtn;
  var modalBg;
  var idSubscription;
  var name;
  var cancelBtn;
  var continueBtn;
  var frm;
  var deleteBtn;

  window.addEventListener("load", (event) => {
    apiKey = document.getElementById('api-key');
    copyKeyBtn = document.getElementById('copy-api-key');
    addBtn = document.getElementById('add-btn');
    modalBg = document.getElementById('add-account');
    idSubscription = document.getElementById('id-subscription');
    name = document.getElementById('name');
    cancelBtn = document.getElementById('cancel');
    continueBtn = document.getElementById('continue');
    frm = document.getElementById('add-acc-frm');
    deleteBtn = document.getElementById('delete');

    copyKeyBtn.addEventListener('click', copyKey);
    addBtn.addEventListener('click', openAdd);
    cancelBtn.addEventListener('click', closeAdd);
    frm.addEventListener('submit', formSubmit);
    deleteBtn.addEventListener('click', deleteSubscription);
  });

  function copyKey() {
    navigator.clipboard.writeText(apiKey.innerHTML);
    alert('Clave API copiada al portapapeles.')
  }

  function openAdd() {
    modalBg.classList.remove('modal-hide');
    name.focus();
  }

  function closeAdd() {
    modalBg.classList.add('modal-hide');
  }

  function formSubmit(ev) {
    ev && ev.preventDefault();

    if (name.value === '') {
      alert('¡No puedes dejar el nombre en blanco!');
      name.focus();
      return;
    }
    frm.submit();
  }

  function deleteSubscription() {
    if (confirm('¿Estás seguro de querer borrar esta suscripción? Es un paso irreversible y se borrará tanto la suscripción, como sus cuentas y las copias de seguridad que estas tienen.')) {
      document.location.href = '/deleteSubscription/' + idSubscription.value;
    }
  }
})();
