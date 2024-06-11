<div class="movies container">

    <div class="swiper mySwiper">

        <div class="swiper-wrapper">

            <?php foreach($moviesSlider as $movie) { ?>

                <div class="swiper-slide">
    
                    <div class="slider__opciones">
                        <div class="slider__opciones--clasificacion"><?php echo $movie->clasificacion ?></div>
                        <div class="slider__opciones--guardar"><i class="fa-solid fa-heart"></i></div>
                    </div>
    
                    <picture>
                        <source srcset="/build/img/peliculas/<?php echo $movie->imagen ?>.webp" type="image/webp">
                        <img src="/build/img/peliculas/<?php echo $movie->imagen ?>.jpg" alt="Imagen info">
                    </picture>
    
                    <div class="slider">
                        <a href="#" class="slider__video">
                            <i class="fa-solid fa-play"></i>
                        </a>
    
                        <div class="slider__descripcion">
                            <div class="slider__descripcion--año"><?php echo $movie->fecha ?></div>
                            <div class="slider__descripcion--separador">/</div>
                            <div class="slider__descripcion--genero"><?php echo utf8_decode($movie->genero) ?></div>
                        </div>
                    </div>
                    
                </div>

            <?php } ?>

        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>

</div>
