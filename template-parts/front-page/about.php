<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$data = documentation_get_field('about', [
    'title' => 'ONE DESK AT A TIME',
    'subtitle' => 'Empowering Professionals to Thrive in a Collaborative Workspace',
    'content' => "
        <p>At <strong>OfficeValle</strong>, our mission is to provide you with the most efficient working space. Whether you are a Freelancer, an Entrepreneur, or a Work-from-Home Professional, our services and facilities are tailored to help you succeed. We are coworking that cares for your success and this shows in our dedication to maintain a stringent standard.</p>
        <p>At OfficeValle, our primary goal is to offer working professionals the most efficient workspace. Whether you're a Freelancer, Entrepreneur, or Work-from-Home Professional, our tailored services and facilities are designed to support your success.
        </p>
        <p>We care about your achievements and it is reflected in our commitment to maintaining stringent standards. Our collaborative environment fosters networking opportunities, creativity, and a sense of community for you. Join us at OfficeValle, where work meets passion, and success is a shared journey.
        </p>
    ",
    'counter' => 70,
    'counter_title' => 'SEATS AND COUNTING',
    'counter_subtitle' => 'Expanding Seating Capacity for Your Convenience!',
  ]);
?>

<div 
    x-cloak
    x-data="{sections: ['about-us', 'how-we-work', 'our-services']}"
    x-show="sections.includes(sectionInView)"
    x-transition:enter-start="-translate-x-4 opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-4 opacity-0"
    class="w-40 h-screen items-center fixed left-0 top-0 origin-center z-1 transition-all ease-out-expo duration-500 hidden 2xl:block"
>
    <a x-bind:href="`#${sections[sections.indexOf(sectionInView) - 1]}`" class="absolute top-0 h-20 w-20 left-10 text-[#8F7145CC]">
        <?php echo documentation_svg('chevron-up'); ?>
    </a>

    <h2 class="aboutus absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <span class="inline-block text-7xl whitespace-nowrap transform -rotate-90 origin-center" x-text="sectionInView.replace(/-/g, ' ').toUpperCase()">ABOUT US</span>
    </h2>

    <a x-bind:href="`#${sections[sections.indexOf(sectionInView) + 1]}`" class="absolute bottom-0 h-20 w-20 left-10 text-[#8F7145CC]">
        <?php echo documentation_svg('chevron-down'); ?>
    </a>
</div>

<div id="about-us" class="container flex items-stretch when-sm:flex-wrap" x-intersect.half="sectionInView = 'about-us'">
    <div class="w-full lg:w-1/2 h-screen">
        <img src="<?php echo documentation_assets('images/OfficeValle_Edited.jpeg') ?>" class="w-full h-[95%] object-cover rounded-xl " alt="">
    </div>

    <div class="w-full lg:w-1/2 pl-20 when-sm:mt-5 when-sm:pl-0">
        <div class="flex items-center">
            <span class="bg-yellow-700 h-px w-32"></span>
            <h4 class="font-semibold text-[#8F7145] ml-1"><?php echo $data['title']; ?></h4>
        </div>

        <h1 class="pt-6 text-4xl font-bold"><?php echo $data['subtitle']; ?></h1>
        
        <div class="mt-8 mb-16 text-xl space-y-4 leading-6 when-sm:mb-2" >
            <?php echo $data['content']; ?>
        </div>
        <div class="flex items-center justify-start when-sm:flex-wrap" x-data="{ current: 1 }" x-init="() => { setInterval(() => { current < <?php echo $data['counter']; ?> ? current++ : clearInterval() }, 50) }">
            <div class="inline-flex relative w-60 overflow-hidden h-36">
                <template x-for="number in <?php echo $data['counter']; ?>">
                    <span 
                        x-show="current === number" 
                        x-text="number"
                        class="absolute left-0 top-0 text-9xl text-[#826030] font-bold inline-block transition-all duration-200 ease-in-out">
                    </span>
                </template>
            </div>
            
            <div>
                <h3 class="text-yellow-900 text-lg font-semibold">SEATS AND COUNTING</h3>
                <h3 class="text-lg mt-2">Expanding Seating Capacity for Your Convenience!</h3>
            </div>
        </div>
    </div>
</div>