<?php

if (!is_active_sidebar( 'documentation-blog-sidebar' )) {
	return;
} 


if ( is_customize_preview() ) {
	echo '<div id="documentation-sidebar-control"></div>';
}

?>

<div class="documentation_blog__sidebar w-full">
	<aside id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'documentation-blog-sidebar' ); ?>
	</aside>
</div>