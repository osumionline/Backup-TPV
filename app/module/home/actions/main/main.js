(function () {
  var addBtn;
  var modalBg;
  var name;
  var cancelBtn;
  var continueBtn;
  var frm;

  window.addEventListener("load", (event) => {
    addBtn = document.getElementById('add-btn');
    modalBg = document.getElementById('add-subscription');
    name = document.getElementById('name');
    cancelBtn = document.getElementById('cancel');
    continueBtn = document.getElementById('continue');
    frm = document.getElementById('add-subs-frm');

    addBtn.addEventListener('click', openAdd);
    cancelBtn.addEventListener('click', closeAdd);
    frm.addEventListener('submit', formSubmit);
  });

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
})();
