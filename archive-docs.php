<?php

$theme_options = get_option('documentation_options', documentation_get_default_options());

get_template_part('page-templates/docs', 'default'); 

?>