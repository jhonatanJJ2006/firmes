<header class="barra">

    <a href="/" class="barra__logo">Pelis</a>

    <div class="barra__sitios">

    <a href="/" class="barra__sitios--enlace <?php echo pagina_actual('/') ? 'barra__sitios--actual' : '' ?>">Home</a>
    <a id="movies" href="/movies" class="barra__sitios--enlace <?php echo pagina_actual('/movies') ? 'barra__sitios--actual' : '' ?>">Movies</a>
    <a href="/music" class="barra__sitios--enlace <?php echo pagina_actual('/music') ? 'barra__sitios--actual' : '' ?>">Music</a>

    </div>

    <div class="barra__acciones">
        <div class="barra__alertas"><i class="fa-solid fa-bell"></i></div>

        <div class="barra__usuario">
            <?php if($_SESSION) { ?>
                <div class="barra__usuario--nombre">Hi, <?php echo $_SESSION['nombre'] ?></div>
            <?php } else { ?>
                <a href="/auth/login" class="barra__login">Login</a>
            <?php } ?>
            <div class="barra__usuario--menu"><i class="fa-solid fa-bars"></i></div>

            <div class="barra__menu oculto" id="menu">
                <ul class="barra__menu--ul">
                    <li><div class="barra__menu--saludo">Hi, <?php echo $_SESSION['nombre'] ?></div></li>
                    <li class="barra__menu--li"><a class="barra__menu--a" href="#">Home</a></li>
                    <li class="barra__menu--li"><a class="barra__menu--a" href="#">Movies</a></li>
                    <li class="barra__menu--li"><a class="barra__menu--a" href="#">Music</a></li>

                    <li class="barra__menu--acciones">

                        <a class="barra__menu--acciones-like" href="#"><i class="fa-solid fa-heart barra__menu--like"></i>Favoritos</a>
                        <a class="barra__menu--acciones-time" href="#"><i class="fa-solid fa-clock barra__menu--time"></i></i>Historial</a>
                        
                        <?php if($_SESSION) { ?>
                            <div class="barra__menu--acciones-email"><?php echo $_SESSION['email'] ?></div>

                            <form class="barra__menu--form" action="/logout" method="POST">
                                <button class="barra__menu--logout" type="submit">
                                    Logout
                                </button>
                            </form>     

                        <?php } else { ?>

                            <a href="/auth/login" class="barra__menu--login">Login</a>

                        <?php } ?>

                    </li>
                </ul>
            </div>
            
        </div>

    </div>

</header>