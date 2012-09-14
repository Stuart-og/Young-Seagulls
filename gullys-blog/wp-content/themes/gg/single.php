<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>
<div class="grid_1 position-fix1" id="sidebar"> 
<div id="gg-side-top"></div> <!-- /#gg-side-top -->
<div id="gg-side-middle">
<?php get_sidebar(); ?>
</div>
<div id="gg-side-bottom"></div>
</div>

<!-- //////////////////////////////////////////START/CONTENT/HERE/////////////////////////////////////////////////// -->      
        <div class="grid_3 position-fix">     
            <div id="gg-common-top"></div> <!-- /#gg-common-top -->
      		<div id="gg-common-middle">



	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<div class="date">
                <span class="day"><?php the_time('jS') ?></span>
                <span class="month"><?php the_time('F') ?></span>
                </div>
                
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

				<div class="entry">
				<?php the_content(); ?>
				</div>

				<p class="postmetadata"><?php the_tags('<strong>Tags:</strong> ', ', ', '<br />'); ?> <strong>Posted in:</strong> <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
            
            <?php comments_template(); ?>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="button alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="button alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
	<div class="clearer"></div>
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>

	<?php endif; ?>

</div> <!-- /#gg-common-niddle -->
      	<div id="gg-common-bottom"></div> <!-- /#gg-common-bottom -->
        
        </div>      
        <div class="clearer"></div>
<!-- //////////////////////////////////////////END/OF/CONTENT//////////////////////////////////////////////////// -->    

<?php get_footer(); ?>
	
