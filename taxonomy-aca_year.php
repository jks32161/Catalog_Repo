<?php 
/**
 * Template Name: Planning by Year Template
 */ 

$type = get_query_var( 'post_type' );
$year = get_query_var( 'aca_year' );

if(!isset($type) || $type == ''){
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	if ( false !== strpos($url, 'staract') ) {
		$type = 'staract';
	} 
	else {
		$type = 'plans';
	}

}

get_header(); ?>



<div class="row" id="subnav-wrap">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="section-content page-title-section">
					<a class="dept-title-small" href="<?php echo site_url('/plan/'.$type); ?>"><?php echo ucwords($type); ?></a>
					<h1 class="prog-title"><?php echo $year; ?></h1>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="main-section" class = "main">
	<div class="container" id="wrap">
		<div class="row small-marg-top small-marg-bottom">
			<div class="col-xs-12">

				<?php 
				$terms = get_terms('department_shortname');
				foreach($terms as $term) : if($term->parent != 0) :
					
					$query_plans = new WP_Query(array(
						'post_type' => $type, 
						'orderby' => 'title', 
						'order' => 'ASC',  
						'department_shortname' => $term->slug, 
						'aca_year' => $year,));
						
					if($query_plans->have_posts()) :
						
						echo '<span class="section-title"><span><h2>'.$term->description.'</h2></span></span>';
						
						while($query_plans->have_posts()) : $query_plans->the_post(); ?>
								
						<p><a href="<?php the_permalink();?>"/><?php echo ucwords(strtolower(get_the_title())); ?></a></p>

					<?php endwhile; ?>
				<?php endif; endif; endforeach;?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
</div>



<?php get_footer(); ?>