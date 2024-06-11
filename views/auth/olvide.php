<div class="auth__contenido">

    <div class="auth__frase">Peliculas, Series, Musica y Mucho Más</div>

    <div class="auth__blur">
        <h2 class="auth__heading"><?php echo $titulo ?></h2>

        <?php
            include_once __DIR__ .  '/../templates/alertas.php';
        ?>

        <form class="formulario" action="/auth/olvide" method="POST">

            <div class="formulario__campo">
                <label class="formulario__label" for="email">Email</label>
                <input id="email" class="formulario__input" type="email" name="email" placeholder="Tu Email" value="<?php echo $usuario->email ?>">
            </div>

            <input class="formulario__submit formulario__submit--auth" type="submit" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a class="acciones__enlace" href="/auth/login">¿Ya tienes cuenta? Inicia Sesión</a>
            <a class="acciones__enlace" href="/auth/registro">¿Aún no tienes cuenta? Obtener una</a>
        </div>
    </div>

</div>

<?php 
    if (!empty($alertas)) { 
        if (isset($alertas['exito'])) { ?>

            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '<?php echo $alertas['exito']; ?>',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                });
            </script>

        <?php } else if (isset($alertas['error'])) { ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo $alertas['error']; ?>',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.reload();
                });
            </script>

        <?php }
    }
?>
