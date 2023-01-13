const D = new DOM( );
const div = D.query('.registro-login');
const btn_registro = D.id('registrar');
const btn_login = D.id('loguear');
const btn_recuperar = D.id('recuperar');
const form_reg = D.id('registro');

btn_registro.addEventListener('click', e => {
    div.classList.add('ver-registro');
} );

btn_login.addEventListener('click', e => {
    div.classList.remove('ver-registro');
} );


btn_recuperar.addEventListener('click', e => {
    //1 - crear el form nuevo para recuperar pass
    const form_rec = D.create( 'form', {
        method: 'post',
        action: '/auth/retrieve',
        onsubmit: e => {
            e.preventDefault( );
            const error_anterior = D.query('.error');
            if( error_anterior ) error_anterior.remove( );
            
            const datos = new FormData( form_rec );

            fetch( form_rec.action,
            {
                method: form_rec.method,
                body: datos
            } )
            .then( r => r.json( ) )
            .then( j => {
                if( ! j.status ){
                    const error = D.create('p', { className: 'error', innerHTML: j.msg } );
                    form_rec.insertBefore( error, p );
                }
                console.log( j );
            } );
            console.log('intentaste mandar el form');
        }
    } );
    const titulo = D.create('h3', { innerHTML : 'Recuperar Clave' } );
    const p = D.create('p', { innerHTML: 'Ingresá tu correo electrónico, y te enviaremos un mail con tu nueva contraseña de acceso' } );
    const div_email = D.create('div');
    const span = D.create('span', { innerHTML: 'Tu correo electrónico' } );
    const input = D.create('input', { type: "email", name:"email", placeholder: "usuario@email.com", autocomplete: "off", required: true } );

    const div_btns = D.create('div', { className: 'buttons' });
    const btn_submit = D.create('button', { type: 'submit', innerHTML: 'Recuperar!' } );
    const btn_cancel = D.create('button', 
    {
        type: 'button',
        innerHTML: 'Cancelar',
        onclick: e => {
            div.classList.remove('ver-registro');
            setTimeout( function( ){
                div.replaceChild( form_reg, form_rec );
            }, 300 );
        } 

    } );


    D.append( [ btn_submit, btn_cancel ], div_btns );
    D.append( [ span, input ], div_email );
    D.append( [ titulo, p, div_email, div_btns ], form_rec );

    console.log(form_rec);
    //2 - reemplazar el form de registro (viejo) x el de recuperar (nuevo)
    div.replaceChild( form_rec, form_reg );

    //3 - asignar la clase que mueve el panel del castor
    div.classList.add('ver-registro');
} );