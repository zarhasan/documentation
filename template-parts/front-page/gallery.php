<?php

$images = documentation_get_field('gallery', [
    [
        'url' => documentation_assets('images/final_gallery1.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery2.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery3.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery4.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery5.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery6.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery7.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery8.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery9.jpg'),
        'alt' => 'OfficeValle',
    ],
    [
        'url' => documentation_assets('images/final_gallery10.jpg'),
        'alt' => 'OfficeValle',
    ],
]);

?>

<section x-data class="gallery mt-28">
    <div x-embla class="gallery__embla overflow-x-hidden relative">
        <button 
            x-embla:prev 
            x-bind:disabled="canScrollPrev ? false : true"
            class="embla__prev shrink-0 bg-transparent text-black w-12 h-full p-3 rounded-full absolute z-10 left-[calc(3.25rem+5%)] top-1/2 -translate-y-1/2 transition-all duration-500 ease-out-expo disabled:opacity-50 when-sm:left-0 when-sm:w-8 when-sm:h-8 when-sm:p-2 focus:bg-primary focus:text-white" 
            style="outline: none !important;">
            <?php echo documentation_svg('chevron-left'); ?>
        </button>
        <div x-embla:main.loop.1.autoplay.5000 class="gallery__embla__viewport embla__viewport">
            <div class="gallery__embla__container embla__container">
                <?php foreach ($images as $index => $image) : ?>
                    <div 
                        class="gallery__embla__slide bg-white grow-0 shrink-0 basis-4/5 h-152 md:px-10 when-sm:px-4 when-sm:h-96 when-sm:basis-5/6"
                    >
                        <img
                            class="embla__slide__img rounded-xl overflow-hidden w-full h-full object-cover transition-opacity duration-300 ease-in-out"
                            alt="<?php echo isset($image['alt']) && $image['alt'] ? $image['alt'] : ''; ?>"
                            src="<?php echo $image['url']; ?>"
                            x-bind:class="[activeIndex === <?php echo $index; ?> ? 'opacity-100' : 'opacity-25']"
                            loading="lazy"
                        />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button 
            x-embla:next 
            x-bind:disabled="canScrollNext ? false : true"
            class="embla__next shrink-0 bg-transparent text-black w-12 h-full p-3 rounded-full absolute z-100 right-[calc(3.25rem+5%)] top-1/2 -translate-y-1/2 transition-all duration-500 ease-out-expo disabled:opacity-50 when-sm:right-0 when-sm:w-8 when-sm:h-8 when-sm:p-2 focus:bg-primary focus:text-white" 
            style="outline: none !important;">
            <?php echo documentation_svg('chevron-right'); ?>
        </button>
    </div>
</section>
