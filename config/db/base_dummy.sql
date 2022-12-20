INSERT INTO usuarios (EMAIL, CLAVE, ES_ADMIN, FECHA_ALTA )
VALUES 
    ('german@email.com', SHA1('1234'), 1, NOW() ),
    ('fabitodev@email.com', SHA1('1234'), 0, NOW() ),
    ('naboletti@email.com', SHA1('1234'), 0, NOW() );

INSERT INTO ceremonias SET
    NOMBRE ='CastAwards 2022',
    FECHA_NOMINACIONES_INICIO = '2022-12-11',
    FECHA_NOMINACIONES_FIN = '2022-12-17 23:59:59',
    FECHA_VOTACIONES_INICIO = '2022-12-20',
    FECHA_VOTACIONES_FIN = '2022-12-31 23:59:59',
    FECHA_RESULTADOS_VISIBLES = '2023-01-13 01:00:00',
    FECHA_CEREMONIA = '2023-01-11 11:00:00',
    FECHA_ALTA = NOW( ),
    CEREMONIA_ACTUAL = 1
; 

INSERT INTO categorias ( CATEGORIA, ORDEN, FKCEREMONIA )
VALUES 
    ( 'Maricon del año', 1, 1 ),
    ( 'Banneo potencial', 2, 1 );


INSERT INTO nominaciones ( NOMINADO, ACTIVO, FECHA_ALTA, FKUSUARIO, FKCATEGORIA, UUID )
VALUES 
    ( 'Josecito el lloron', 1, NOW( ), 2, 1, UUID_SHORT( ) ),
    ( 'La llorona', 1, NOW( ), 3, 1, UUID_SHORT( ) ),
    ( 'Blur el lágimas', 1, NOW( ), 1, 1, UUID_SHORT( ) );


INSERT INTO nominaciones ( NOMINADO, ACTIVO, FECHA_ALTA, FKUSUARIO, FKCATEGORIA, UUID )
VALUES 
    ( 'OMFGNoTeAguantoMas', 1, NOW( ), 2, 2, UUID_SHORT( ) ),
    ( 'FabriiFerroni (porque podemos)', 1, NOW( ), 3, 2, UUID_SHORT( ) ),
    ( 'TamCelis', 1, NOW( ), 1, 2, UUID_SHORT( ) );


INSERT INTO votos VALUES -- votos de prueba para el llorón
    ( 1, 1 ),
    ( 2, 2 ),
    ( 3, 2 );

INSERT INTO votos VALUES -- votos de prueba para el banneo
    ( 1, 4 ),
    ( 2, 4 ),
    ( 3, 4 );