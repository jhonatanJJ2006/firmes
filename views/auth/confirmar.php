<div class="auth__contenido--mensaje">

    <main class="auth__blur--mensaje">

        <h2 class="auth__heading"><?php echo $titulo ?></h2>
        <p class="auth__texto">Tu Cuenta en Pelis</p>

        <?php if($alerta) { ?>

            <div class=" acciones acciones--centrar">
                <a class="acciones__enlace" href="/auth/login">Iniciar Sesión</a>
            </div>

        <?php } else  { ?>

            <script>
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El token no es válido.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.reload();
                });

            </script>

        <?php } ?>

    </main>

</div>


