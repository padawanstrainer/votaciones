const D = new DOM( );
const btn = D.id('agregar_candidato');
let filas = D.queryAll( '.form-row' ).length;

const agregar_fila = function( e ){
    filas++;
    const div_row = D.create('div', { className: 'form-row' } );
    const button_delete = D.create('a', {
        className: 'button-delete',
        href: 'javascript:void(0)',
        innerHTML: 'eliminar',
        onclick: function( ){
            const cantidad = D.queryAll('.form-row' ).length;
            if( cantidad > 1 ) div_row.remove( );
        }
    } );

    const wrapper_candidato = D.create('div', { className: 'form-group' });
    const span_candidato = D.create('span', { innerHTML: 'Nombre del candidato' } );
    const input_text = D.create('input', {
        type: 'text',
        name: `candidato[${filas}]`,
        placeholder: 'Nombre del candidato',
        required: true,
        autocomplete: 'off'
    } );

    const wrapper_cbox = D.create('div', { className: 'form-group form-group-top' });
    const span_cbox = D.create('span', { innerHTML: 'Elegir categorias' } );
    const div_cbox = D.create('div', { className: 'form-group' } );

    categorias.forEach( c => {
        const cbox = D.create('input', {
            type: 'checkbox',
            name: 'categorias['+filas+'][]',
            value: c.ID,
            id: 'cbox_' + filas + '_' + c.ID
        });
        const label = D.create('label', {
            innerHTML: c.CATEGORIA,
            htmlFor: 'cbox_' + filas + '_' + c.ID
        } );
        D.append( [cbox, label], div_cbox );
    } );

    D.append( [ span_candidato, input_text ], wrapper_candidato );
    D.append( [ span_cbox, div_cbox ], wrapper_cbox );
    D.append( [ button_delete, wrapper_candidato, wrapper_cbox ], div_row );

    const btn = e.target;
    const div_buttons = btn.parentNode; 
    D.append( div_row, D.id('generated-inputs') );
    //const form = div_buttons.parentNode;
    //form.insertBefore( div_row, div_buttons );
}

btn.addEventListener('click', agregar_fila );
btn.click( );