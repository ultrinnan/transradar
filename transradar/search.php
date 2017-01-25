<?php get_header(); ?>
	<div id="content">
		<h2 class="content-heading"><?php printf( __('Результаты поиска по запросу: "%s"', 'default'), get_search_query() ); ?></h2>
		<section>
			<?php if (have_posts()): while (have_posts()): the_post(); ?>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php the_excerpt(); ?></p>
				<hr>
			<?php endwhile;	else:?>
				<p><?php echo __('Хм... Ничего не нашлось... Может поищем еще?', 'transradar'); ?></p>
			<?php endif; ?>
		</section>
	</div>
<?php get_footer(); ?>