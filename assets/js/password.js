const D = new DOM( );
const btn_password = D.id('cambiar_pass');

const modal_clave = ()=>{
    document.body.classList.add( 'noscroll' );


    const modal = D.create('div', { id: 'modal', onclick: e => {
        modal.remove( );
        document.body.classList.remove( 'noscroll' );
    } } );

    const form = D.create('form', {
        onclick: e => {
            e.stopPropagation( );
        },
        onsubmit: e => {
            e.preventDefault( );

            const FD = new FormData( form );
            fetch('/assets/ajax/clave.php', {
                method: 'POST',
                body: FD
            } )
            .then( respuesta => respuesta.json() )
            .then( json => {
                if( ! json.status ){
                    const error_anterior = form.querySelector('.error');
                    if( error_anterior ){
                        error_anterior.innerText = json.msg;
                    }else{
                        const error = D.create('p', { className: 'error', innerText: json.msg } );
                        form.insertBefore( error, div );
                    }
                } else{
                    modal.remove( );
                    document.body.classList.remove( 'noscroll' );
                }
            } );
        }
    });
    const titulo = D.create('h2',{ innerHTML: 'Cambiar tu contraseña' });

    const div = D.create('div');
    const span = D.create('span', { innerText: 'Nueva clave' } );
    const input_password = D.create('input', { type: 'password', placeholder: '*******', name: 'clave', required: true });
    const a = D.create('a', { href: 'javascript:void(0)', innerText: 'ver', onclick: e => {
        input_password.type = input_password.type == 'password' ?
                                'text' :
                                'password';
    } } );

    
    const div2 = D.create('div', { className: 'buttons' });
    const btn_submit = D.create('button', { type: 'submit', innerText: 'Cambiar clave' });
    const btn_cancel = D.create('button', { type: 'button', innerText: 'Cancelar', onclick: e => {
        modal.remove( );
        document.body.classList.remove( 'noscroll' );
    } });

    D.append( [ btn_submit, btn_cancel ], div2 );
    D.append( [ span, input_password, a ], div );
    D.append( [ titulo, div, div2 ], form );
    D.append( form, modal );
    D.append( modal );
};

btn_password.addEventListener('click', modal_clave );

window.addEventListener('keyup', e => {
    const modal = D.id('modal');
    if( /^escape$/i.test( e.key ) && modal ){
        modal.remove( );
        document.body.classList.remove( 'noscroll' );
    }
} );