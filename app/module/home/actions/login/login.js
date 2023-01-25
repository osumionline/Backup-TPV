(function () {
  var frm;
  var user;
  var pass;

  window.addEventListener("load", (event) => {
    frm = document.getElementById('login-frm');
    frm.addEventListener('submit', formSubmit);
    user = document.getElementById('user');
    pass = document.getElementById('pass');

    user.focus();
  });

  function formSubmit(ev) {
    ev && ev.preventDefault();
    if (user.value === '') {
      alert('¡No puedes dejar el nombre de usuario en blanco!');
      user.focus();
      return;
    }
    if (pass.value === '') {
      alert('¡No puedes dejar la contraseña en blanco!');
      pass.focus();
      return;
    }
    frm.submit();
  }
})();
