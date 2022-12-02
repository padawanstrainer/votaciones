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
    const input_text = D.create('input', {
        type: 'text',
        name: `candidato[${filas}]`,
        placeholder: 'Nombre del candidato',
        required: true
    } );
    const div_cbox = D.create('div', {
        className: 'form-group'
    } );
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

    D.append( [ button_delete, input_text, div_cbox ], div_row );

    const btn = e.target;
    const form = e.target.parentNode;
    form.insertBefore( div_row, btn );
}

btn.addEventListener('click', agregar_fila );
btn.click( );