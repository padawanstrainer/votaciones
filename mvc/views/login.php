<div>
    <div class='registro-login'>
        <form method="post" action="/auth/login">
            <h3>Accede al sistema</h3>
            <?php 
            $values = [];
        
            if( isset( $_SESSION['error_login'] ) ){
                $values = $_SESSION['inputs_login'] ?? [];
                echo "<p class='error'>$_SESSION[error_login]</p>";

                unset($_SESSION['inputs_login']);
                unset($_SESSION['error_login']);
            }
            ?>
            <div>
                <span>Tu correo electrónico</span>
                <input type="email" name="usuario" 
                value="<?php echo $values['usuario'] ?? ''; ?>"
                placeholder="usuario@email.com" autocomplete="off" />
            </div>
            <div>
                <span>Tu clave de acceso</span>
                <input type="password" name="clave" placeholder="*****" />
            </div>
            <div class='buttons'>
                <button type="submit">Ingresar</button>
                <button type="button" id="registrar">Registro</button>
            </div>
            <p class='legend'>¿Olvidaste tu contraseña, wn? <a href='#'>recuperá tu clave</a></p>
        </form>

        <form method="post" action="/auth/register">
            <h3>Registrate!</h3>
            <?php 
        
            if( isset( $_SESSION['error_register'] ) ){
                echo "<p class='error'>$_SESSION[error_register]</p>";
                unset($_SESSION['error_register']);
            }
            ?>
            <p>Ingresá tu correo electrónico y te va a llegar una clave temporal que después vas a poder cambiar en el panel de usuario, para acceder a la plataforma</p>
            <div>
                <span>Tu correo electrónico</span>
                <input type="email" name="usuario" placeholder="usuario@email.com" autocomplete="off" />
            </div>
            <div class='buttons'>
                <button type="submit">Registrarme</button>
                <button type="button" id="loguear">Ingresar</button>
            </div>
        </form>
    </div>
</div>

<script src="/assets/js/dom.js"></script>
<script src="/assets/js/login.js"></script>