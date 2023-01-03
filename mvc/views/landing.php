<article>
    <h1>Sobre los CastorAwards</h1>
    <p>Los CastorAwards son los "premios a la excelencia twitchera", reconociendo a los participantes del Stream de <a href='https://twitch.tv/PadawansTrainer' target='_blank'>PadawansTrainer</a> ya sean viewers, streamers o bots (por si algún día dominan el mundo).<br />
    Cabe destacar que esta premiación es un chiste interno del stream, aprovechado la excusa para poder explicar el desarrollo de una plataforma de votaciones online que quedó disponible al público en el repositorio <a href='https://github.com/padawanstrainer/votaciones' target="_blank">https://github.com/padawanstrainer/votaciones</a>.<br />
    Quien necesite hacer una votación en línea y no quiera registrarse en una plataforma a tales efectos puede usar este desarrollo base, adaptando todo lo que considere necesario a sus efectos personales.</p>
</article>

<section>
    <h2>Los CasTƟrnados</h2>
    <p>En estos momentos estamos en la fase de nominaciones, eso significa que cualquier persona registrada puede postular candidatos a las distintas ternas de los Castor Awards. <?php 
    if( count($datos['ternas']) > 0 ) echo "Las categoría de esta ceremonia, son:";
    ?></p>

    <?php if( count($datos['ternas']) > 0 ): ?>
    <ol>
        <?php foreach( $datos['ternas'] as $t ):
        echo "<li>$t[CATEGORIA]";
        if( $ceremonia_actual['VER_RESULTADOS'] ){
            echo "<b>Ganador/a:  $t[GANADOR]</b>";
        }else if( $ceremonia_actual['VOTACIONES_ACTIVAS'] ){
            $nominados = explode( "|#|", $t['NOMINADOS'] );
            echo "<ul>";
            foreach( $nominados as $n ){
                echo "<li>$n</li>";
            }
            echo "</ul>";
        }
        echo "</li>";
        endforeach; ?>
    </ol>
    <?php endif; ?>
</section>

<section class='fecha'>
    <h2>Fecha y lugar de la Ceremonia</h2>
    <div>
        <p>La ceremonia será virtual a través de https://twitch.tv/PadawansTrainer y tendrá lugar el día <?php echo $ceremonia_actual['FECHA_CEREMONIA_SPA']; ?>.<br />
    No se require confirmar asistencia, pero para participar deberás registarte en esta misma web, por medio de <a href=''>este enlace</a>, solo con tu Email.</p>
    </div>
</section>