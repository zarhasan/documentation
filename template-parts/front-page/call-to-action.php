<?php

$data = documentation_get_field('call_to_action', [
    'decorative_title' => 'GET YOUR OWN VIRTUAL OFFICE',
    'title' => 'VIRTUAL OFFICE',
    'subtitle' => 'Explore the Future of Business with a Virtual Office in New Delhi',
    'description' => 'Set up a virtual office and experience the benefits of prime location and premium services to improve your business presence today!',
    'link' => [
        'url' => '/virtual-office',
        'title' => 'SECURE YOUR VIRTUAL OFFICE ADDRESS TODAY',
    ],
    'image' => [
        'url' => documentation_assets('images/cta_image.jpeg'),
    ]
]);

?>

<div class="overflow-hidden relative z-10" x-intersect:enter="sectionInView = ''">
        <div class="infinite-scrolling-text text-8xl p-2 when-sm:text-4xl when-sm:w-full when-sm:top-14 when-sm:non-italic text-primary font-bold top-14 relative whitespace-nowrap z-10">
            <div>
                <span><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
            </div>
            <div>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
                <span aria-hidden="true"><?php echo $data['decorative_title']; ?></span>
            </div>
        </div>
        <div class="relative when-sm:flex when-sm:flex-wrap pb-24">
            <div class="w-7/12 rounded-xl bg-primary-100 when-sm:w-full when-sm:rounded-none when-sm:container">
                <div class="px-28 py-24 when-sm:px-0">
                    <div class="flex items-center">
                        <span class="bg-yellow-700 h-1 w-32"></span>
                        <h4 class="font-semibold text-[#8F7145] ml-2"><?php echo $data['title']; ?></h4>
                    </div>
                    <h2 class="pt-7 text-4xl font-extrabold when-sm:font-bold when-sm:text-xl "><?php echo $data['subtitle']; ?></h2>
                    <p class="pt-8 text-xl leading-6 when-sm:text-lg"><?php echo $data['description']; ?></p>
                    <a href="<?php echo $data['link']['url']; ?>" class="inline-block mt-12 text-lg p-6 rounded-xl font-bold bg-[#826030] text-white hover:bg-[#545454] when-sm:(w-full font-base text-sm)">
                        <?php echo $data['link']['title']; ?>
                    </a>
                </div>
            </div>

            <div class="overflow-x-hidden w-[46%] top-24 -right-7 h-[86%] rounded-2xl absolute when-sm:w-full  when-sm:relative when-sm:top-0 when-sm:left-0 when-sm:rounded-none">
                <img src="<?php echo $data['image']['url']; ?>" class="object-cover h-full w-full" alt="">
            </div>
        </div>
    </div>
</div>