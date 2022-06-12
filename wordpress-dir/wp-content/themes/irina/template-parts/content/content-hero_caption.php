<!-- Caption <?php the_ID(); ?> -->
<div class="swiper-slide">
<div class="slider__item">
				<?php the_title( '<h1 class="title title--display-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h1>' ); ?>
			<div class="description"><div class="down-up"><?php the_excerpt(); ?></div></div>
</div>
</div>
<!-- /Caption <?php the_ID(); ?> -->
