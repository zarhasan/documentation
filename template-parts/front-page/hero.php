<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$hero = documentation_get_field('hero', [
  'title' => 'A <em>Space</em> Designed For <em>You</em>',
  'cta' => [
    'url' => '/contact-us',
    'title' => 'Book Your Seat',
  ],
  'image' => [
    'url' => documentation_assets('images/final.svg'),
  ],
  'image_mobile' => [
    'url' => documentation_assets('images/mobile_image_1.svg'),
  ]
]);

?>

<section class="home-hero relative md:-mt-32 z-10" x-intersect="sectionInView = ''">
  <img class="when-sm:hidden" src="<?php echo $hero['image']['url']; ?>" alt="">
  <img class="md:hidden" src="<?php echo $hero['image_mobile']['url']; ?>" alt="">

  <div class="w-full absolute left-0 md:top-44 when-sm:relative">
    <div class="container">
      <h1 class="home-hero__title font-bold md:text-7xl md:w-112">
        <?php echo $hero['title']; ?>
      </h1>

      <a
        class="inline-block mt-8 rounded-full px-9 py-5 text-white bg-[#8F7145] text-xl font-semibold group transition hover:(ease-in delay-200 scale-110 duration-300) border-b-4 border-b-[#826030] border-l-8 border-l-[#826030]"
        href="<?php echo $hero['cta']['url']; ?>">
        <span><?php echo $hero['cta']['title']; ?></span>  
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-[3rem] inline-flex ml-4" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M5 12l14 0" />
          <path d="M13 18l6 -6" />
          <path d="M13 6l6 6" />
        </svg>
      </a>
    </div>
  </div>
</section>
