<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$data = documentation_get_field('how_we_work', [
    'title' => 'HOW WE WORK',
    'subtitle' => 'Discover Your Ideal Workspace in Just 4 Simple Steps',
    'description' => "At OfficeValle, we're on a mission to make finding your perfect workspace a breeze. That's why we've boiled it down to 4 simple steps. Let's embark on this journey together and discover the ideal workspace that suits you best!",
    'process' => [
        [
            'title' => 'Explore',
            'description' => 'Browse through our amenities, facilities, and location options to find the perfect fit.',
            'image' => [
                'url' => documentation_assets('images/how_we_work1.jpeg'),
            ],
        ],
        [
            'title' => 'Tour',
            'description' => 'Our friendly staff will guide you through the available options and answer any questions you may have.',
            'image' => [
                'url' => documentation_assets('images/how_we_work2.jpeg'),
            ],
        ],
        [
            'title' => 'Choose',
            'description' => 'Whether you prefer a dedicated desk, private office, or flexible membership, we have a variety of options to accommodate your working style and budget.',
            'image' => [
                'url' => documentation_assets('images/how_we_work3.jpeg'),
            ],
        ],
        [
            'title' => 'Join',
            'description' => 'Complete a simple registration process and become part of our thriving coworking community.',
            'image' => [
                'url' => documentation_assets('images/how_we_work4.jpeg'),
            ],
        ]
    ]
  ]);
?>

<div 
    x-data 
    x-embla 
    id="how-we-work"
    class="how-we-work container mt-20 overflow-x-hidden" 
    x-intersect.half="sectionInView = 'how-we-work'">

    <div class="flex items-center">
        <span class="bg-yellow-700 h-px w-32"></span>
        <p class="font-semibold text-[#8F7145] text-lg ml-1 uppercase">
            <?php echo $data['title']; ?>
        </p>
    </div>  

    <h2 class="font-semibold pt-4 text-4xl">
        <?php echo $data['subtitle']; ?>
    </h2>

    <p class="p-5 pl-0 font-medium text-xl leading-6">
        <?php echo $data['description']; ?>
    </p>

    <div x-embla:main class="mt-16 mb-16">
        <div class="embla__container flex flex-start gap-20 justify-start items-start">
            <?php foreach ($data['process'] as $index => $item) : ?>
                <div 
                    x-data="{expanded: false}" 
                    x-on:mouseenter="expanded = true"
                    x-on:mouseleave="expanded = false"
                    class="group how-we-work__card relative shrink-0 grow-0 basis-2/5 when-sm:basis-11/12 rounded-xl">

                    <img 
                        class="relative h-128 object-cover z-0 group-hover:scale-110 transition-all duration-500 ease-out-expo origin-top-left rounded-xl" 
                        src="<?php echo $item['image']['url']; ?>" 
                        alt=""
                    />

                    <div class="absolute inset-0 z-10 bg-primary-800 text-white p-10 flex flex-col justify-end items-start group-hover:bg-transparent transition-all duration-500 ease-out-expo rounded-xl">
                        <p class="font-bold how-we-work__card__number text-[14rem] leading-none when-sm:text-9xl">
                            <?php echo sprintf("%02d", $index + 1); ?>
                        </p>
                        
                        <div class="md:ml-8 when-sm:ml-2">
                            <h3 class="font-semibold text-4xl mb-4"><?php echo esc_html($item['title']); ?></h3>
                            <p
                                x-collapse
                                x-show="expanded"
                                class="text-xl font-medium">
                                <?php echo esc_html($item['description']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end items-center gap-2 flex-wrap mb-2">
        <?php foreach($data['process'] as $index => $item): ?>
            <button 
                class="bg-black w-4 h-4 rounded-full outline-offset-2"
                x-bind:class="{'outline outline-2 outline-primary bg-primary': activeIndex == <?php echo $index; ?> }" 
                x-embla:page="<?php echo esc_attr($index); ?>">
            </button>
        <?php endforeach; ?>
    </div>

</div>