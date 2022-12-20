const D = new DOM( );
const div = D.query('.registro-login');
const btn_registro = D.id('registrar');
const btn_login = D.id('loguear');

btn_registro.addEventListener('click', e => {
    div.classList.add('ver-registro');
} );

btn_login.addEventListener('click', e => {
    div.classList.remove('ver-registro');
} );