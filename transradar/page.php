<?php 
global $path;
$path = 'page';
get_header(); ?>
</nav>
<!-- header end -->
<div class="faq">
  <div class="faq_box page">
	  <div class="header">
	  	<?php the_title(); ?>
	  </div>

	  <section>
			<?php if (have_posts()): while (have_posts()): the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</section>

	</div>
</div>
<?php get_footer(); ?>