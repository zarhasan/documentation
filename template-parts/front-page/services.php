<?php


$data = documentation_get_field('services', [
    'title' => 'OUR SERVICES',
    'subtitle' => 'Tailored Services to Enhance Your Coworking <br> Experience!',
    'description' => 'Explore the services and amenities we offer to improve your coworking experience. We make sure to provide you with unmatched support for your professional needs, ensuring productivity and convenience at every step of your journey.',
    'items' => [
        [
            'title' => 'Mail & Printing',
            'image' => [
                'url' => documentation_assets('images/gallery1.jpeg'),
            ],
            'description' => 'We handle your mailing needs and document printing hassle-free with our on-site services.',
        ],
        [
            'title' => 'Fresh Brews',
            'image' => [
                'url' => documentation_assets('images/gallery2.jpeg'),
            ],
            'description' => 'Enjoy an unlimited supply of freshly brewed coffee & tea to boost your day.',
        ],
        [
            'title' => 'Reliable Wi-Fi',
            'image' => [
                'url' => documentation_assets('images/gallery3.jpeg'),
            ],
            'description' => 'We provide High-speed and reliable Wi-Fi access to ensure work goes without any trouble.',
        ],
        [
            'title' => 'Equipped Cafeteria',
            'image' => [
                'url' => documentation_assets('images/office_valle_image3.jpeg'),
            ],
            'description' => 'Our cafeteria is equipped with amenities, including a microwave, fridge, and friendly staff, for all your needs.',
        ],
        [
            'title' => 'Enhanced Security',
            'image' => [
                'url' => documentation_assets('images/gallery5.jpeg'),
            ],
            'description' => 'Secure biometric access, CCTVs, and security guards for your well-being and protection.',
        ],
        [
            'title' => 'Waiting Area',
            'image' => [
                'url' => documentation_assets('images/gallery4.jpeg'),
            ],
            'description' => 'Enjoy a cozy and well-furnished waiting area, providing a relaxed and welcoming space for clients.',
        ]
    ]
]);

?>

<div id="our-services" class="container mt-16" x-intersect:enter="sectionInView = 'our-services'" x-intersect:leave="sectionInView = ''">
    <div class="flex items-center">
        <span class="bg-yellow-700 h-px w-32"></span>
        <p class="font-semibold text-[#8F7145] text-lg ml-1"><?php echo $data['title']; ?></p>
    </div>  

    <h2 class="font-semibold pt-4 text-4xl"><?php echo $data['subtitle']; ?></h2>
    <p class="p-5 pl-0 font-medium text-xl leading-6"><?php echo $data['description']; ?></p>

    <div class="grid lg:grid-cols-3 items-start gap-8 my-12">
        <?php foreach ($data['items'] as $index => $item) : ?>
            <div
                x-data="{expanded: false}" 
                x-on:mouseenter="expanded = true"
                x-on:mouseleave="setTimeout(() => expanded = false, 250)" 
                class="rounded-2xl bg-[#E7E1D8] p-10 pb-8 group hover:bg-primary transition-all duration-500 ease-out-expo when-sm:p-5 when-sm:pb-4">
                
                <img 
                    src="<?php echo $item['image']['url']; ?>" class="rounded-2xl w-full h-80 object-cover object-center"
                    alt=""
                />

                <span class="flex justify-between items-center pt-4 gap-2">
                    <h3 class="text-[#826030] font-bold text-xl group-hover:text-white">
                        <?php echo esc_html($item['title']); ?>
                    </h3>
                    <?php echo documentation_svg('arrow-right', 'w-10 h-auto text-[#826030] group-hover:text-white'); ?>
                </span>

                <h3 
                    x-collapse
                    x-show="expanded"
                    class="group-hover:text-white font-semibold text-base">
                    <?php echo esc_html($item['description']); ?>
                </h3>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>