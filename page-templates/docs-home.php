<?php

/**
 * Template Name: Docs (Home)
 *
 */

$theme_options = get_option('documentation_options', documentation_get_default_options());

get_template_part('page-templates/docs', !empty($theme_options['docs_home_layout']) ? $theme_options['docs_home_layout'] : 'default'); 

?>