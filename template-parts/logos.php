<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

 
$data = [
    "client_logos" => get_theme_mod('client_logos', [])
];

?>


<section x-data="{viewCount: 4}" class="container bg-primary-100 py-8 mt-16">
    <div class="text-center">
        <h2>Our Clients</h2>
        <p>Empowering Brands With our Accessibility Expertise</p>
    </div>

    <div class="grid lg:grid-cols-4 gap-8 mt-8">
        <?php foreach($data['client_logos'] as $index => $logo): ?>
            <div 
                class="h-28 bg-white justify-center items-center py-4 px-12 rounded-lg"
                x-bind:class="[viewCount > <?php echo $index; ?> ? 'flex' : 'hidden']">
                <img class="w-auto h-auto max-h-full max-w-full" src="<?php echo esc_url($logo['image']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($logo['image']['id'], '_wp_attachment_image_alt', true)); ?>" />
            </div>
        <?php endforeach; ?>
    </div>

    <div class="flex justify-center items-center mt-8">
        <button 
            x-show="viewCount < <?php echo count($data['client_logos']); ?>" 
            class="inline-flex justify-center items-center text-primary whitespace-nowrap font-semibold gap-1"
            x-on:click="viewCount = <?php echo count($data['client_logos']); ?>">
            View All
            <span class="w-5 h-5 inline-flex justify-center items-center"><?php echo documentation_svg('chevron-down'); ?></span>
        </button>
    </div>
</section>