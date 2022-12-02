<div>
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
            <input type="email" name="usuario" 
            value="<?php echo $values['usuario'] ?? ''; ?>"
            placeholder="usuario@email.com" autocomplete="off" />
        </div>
        <div>
            <input type="password" name="clave" placeholder="*****" />
        </div>
        <button type="submit">Ingresar</button>
    </form>
</div>
<div>
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
            <input type="email" name="usuario" placeholder="usuario@email.com" autocomplete="off" />
        </div>
        <button type="submit">Registrarme</button>
    </form>
</div>