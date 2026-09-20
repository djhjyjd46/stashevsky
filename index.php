<?php get_header(); ?>
<main class="mt-[137px] md:mt-[25dvh]">
    <?php
    if (have_rows('sections')) :
        while (have_rows('sections')) : the_row();
            $title       = get_sub_field('title');
            $subtitle    = get_sub_field('subtitle');
            $description = get_sub_field('description');
            $image       = get_sub_field('image');
            $slides      = [];
            $slides_data = get_sub_field('images');
            if ($slides_data && is_array($slides_data)) {
                foreach ($slides_data as $slide_item) {
                    if (!empty($slide_item['image'])) {
                        $slides[] = $slide_item['image'];
                    }
                }
            }
            $orientation = get_sub_field('image_orientation');
            $has_button  = get_sub_field('has_button');
            $button_text = get_sub_field('button_text');
            $row_class = ($orientation === 'right') ? 'md:flex-row-reverse' : 'md:flex-row';
            $section_id = sanitize_title($title);
    ?>
            <section id="<?php echo esc_attr($section_id); ?>" class="min-h-[75dvh] lg:min-h-[75vh] flex flex-col bg-blue overflow-hidden <?php echo esc_attr($row_class); ?> md:h-[75vh]">
                <div class="block pr-5 pl-5 md:pr-11 md:pl-16 py-10 md:py-16 md:w-1/2">
                    <h2><?php echo esc_html($title); ?></h2>
                    <p class="post"><?php echo stashevsky_kses_post_decode($subtitle); ?></p>
                    <div class="description">
                        <?php echo stashevsky_kses_post_decode($description); ?>
                    </div>
                    <?php if ($has_button) : ?>
                        <button class="btn view-events-trigger mt-7"><?php echo esc_html($button_text); ?></button>
                    <?php endif; ?>
                </div>
                <?php if ($image) : ?>
                    <div class="img w-full h-full overflow-hidden md:w-1/2">
                        <img class="w-full h-full object-cover" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                <?php elseif ($slides) : ?>
                    <div class="img-slider section-slider relative w-full h-full overflow-hidden md:w-1/2 swiper" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/img/artbg.png' ); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="slider-track swiper-wrapper h-full flex gap-0">
                            <?php foreach ($slides as $slide_index => $slide_image) : ?>
                                <div class="slide swiper-slide min-w-full h-full overflow-hidden !flex items-center justify-center">
                                    <img class="w-auto h-auto object-contain object-center max-w-[80%] max-h-[80%]" src="<?php echo esc_url($slide_image['url']); ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($slides) > 1) : ?>
                            <button type="button" class="slider-control prev swiper-button-prev absolute top-1/2 left-4 -translate-y-1/2 z-10 text-white text-2xl font-bold opacity-80 hover:opacity-100 bg-black/40 rounded-full w-10 h-10 flex items-center justify-center text-white">←</button>
                            <button type="button" class="slider-control next swiper-button-next absolute top-1/2 right-4 -translate-y-1/2 z-10 text-white text-2xl font-bold opacity-80 hover:opacity-100 bg-black/40 rounded-full w-10 h-10 flex items-center justify-center text-white">→</button>
                            <div class="slider-dots swiper-pagination absolute bottom-4 xl:bottom-8 left-1/2 -translate-x-1/2 z-10"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </section>
    <?php
        endwhile;
    endif;
    ?>
    <?php
    $contacts_title = get_field('contacts_title', 'option') ?: 'Contacts';
    $contacts_desc = get_field('contacts_description', 'option') ?: 'Contact us to learn more...';
    $address = get_field('contact_address', 'option');
    $hours = get_field('contact_hours', 'option');
    $email = get_field('contact_email', 'option');
    $phone = get_field('contact_phone', 'option');
    $whatsapp = get_field('whatsapp_link', 'option');
    $instagram = get_field('instagram_link', 'option');
    $map_iframe = get_field('map_iframe', 'option');
    ?>
    <section id="contacts" class="min-h-[75vh] flex flex-col md:flex-row-reverse md:h-[75vh] bg-blue">
        <div class="block pr-5 pl-5 md:pr-11 md:pl-16 py-10 md:py-16 md:w-1/2">
            <h2 class="mb-5"><?php echo esc_html($contacts_title); ?></h2>
            <p class="mb-9"><?php echo stashevsky_kses_post_decode($contacts_desc); ?></p>
            <div class="flex flex-col mb-0 md:mb-9">
                
                <?php if ($address): ?>
                    <div class="flex flex-col gap-1">
                        <p class="post mb-1">ADDRESS</p>
                        <p><?php echo esc_html($address); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($hours): ?>
                    <div class="flex flex-col gap-1">
                        <p class="post mb-1">WORKING HOURS</p>
                        <div><?php echo $hours; ?></div>
                    </div>
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 ">
                            <img class="size-4 object-contain" src="<?= get_template_directory_uri(); ?>/img/decor/email.svg" alt="Email">
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-gold mb-1 font-medium break-words hover:text-[#6B5933] transition-colors"><?php echo esc_html($email); ?></a>
                        </div>
                        <?php if (have_rows('contact_phones', 'option')): ?>
                            <?php while (have_rows('contact_phones', 'option')): the_row(); ?>
                                <p class="flex items-center gap-2 text-gold hover:text-[#6B5933] transition-colors ">
                                    <img class="size-4 object-contain" src="<?= get_template_directory_uri(); ?>/img/decor/phone.svg" alt="Phone">
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_sub_field('phone_number'))); ?>" class="hover:opacity-80 transition-opacity">
                                        <?php the_sub_field('phone_number'); ?>
                                    </a>
                                </p>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col gap-1">
                        <?php if (have_rows('social_links', 'option')): ?>
                            <?php while (have_rows('social_links', 'option')): the_row();
                                $s_name = get_sub_field('name');
                                $s_icon = get_sub_field('icon');
                                $s_url = get_sub_field('url');
                            ?>
                                <p class="mb-1">
                                    <a href="<?php echo esc_url($s_url); ?>" target="_blank" class="flex items-center gap-1 text-base text-gold font-medium hover:text-[#6B5933] transition-colors">
                                        <?php if ($s_icon): ?>
                                            <img src="<?php echo esc_url($s_icon['url']); ?>" alt="<?php echo esc_attr($s_name); ?>" class="w-4 h-4 object-contain">
                                        <?php endif; ?>
                                        <?php echo esc_html($s_name); ?>
                                    </a>
                                </p>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="map-container" class="gmap w-full h-[400px] md:h-full overflow-hidden md:w-1/2" data-map-loaded="false">
            <!-- Lazy load placeholder -->
            <div id="map-placeholder" class="w-full h-full bg-gray-200 flex items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <?php if ($map_iframe): ?>
                <div id="map-content" class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-none hidden">
                    <template id="map-iframe-template"><?php echo $map_iframe; ?></template>
                </div>
            <?php else: ?>
                <img id="map-image" class="w-full h-full object-cover hidden" src="<?php echo get_template_directory_uri(); ?>/img/gmap.png" alt="Google Map Placeholder">
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
if (!wp_is_mobile()):
?>
    <div id="events-modal" class="modal fixed top-0 left-0 z-20 w-full h-full bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="modal-content relative bg-blue max-w-[80%] size-full max-h-[80%] text-center grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="py-[30px] md:py-[60px] md:px-[60px] px-[30px] flex flex-col items-center">
                <h2 class="h2 whitespace-nowrap"><?php the_field('modal_title', 'option'); ?></h2>
                <p class="post"><?php the_field('modal_subtitle', 'option'); ?></p>
                <div class="event-list border-solid border-gold border-[1px] rounded-[20px] p-3 overflow-y-auto h-auto">
                    <?php if (have_rows('events', 'option')): ?>
                        <?php while (have_rows('events', 'option')): the_row(); ?>
                            <div class="event-item w-full grid grid-cols-[auto_1fr_auto] gap-4 mb-5">
                                <div class="event-date text-gold text-base"><?php the_sub_field('date'); ?></div>
                                <div class="event-desc flex flex-col items-start">
                                    <p class="mb-2 text-left"><?php the_sub_field('name'); ?></p>
                                    <div class="text-sm mb-1 description-short text-left line-clamp-2">
                                        <?php the_sub_field('description'); ?>
                                    </div>
                                    <button class="text-gold btn--transparent mb-4 show-more flex items-center gap-2">
                                        <span>Show more</span>
                                        <svg class="rotate-180 transition-transform" width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.12484 3.20832L3.20817 0.291656L0.291504 3.20832" stroke="#C89E42" stroke-width="0.583333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                                <div class="event-register">
                                    <button class="btn btn--modal mb-3 reserve-btn"
                                        data-name="<?php echo esc_attr(get_sub_field('name')); ?>"
                                        data-date="<?php echo esc_attr(get_sub_field('date')); ?>"
                                        data-spots="<?php echo esc_attr(get_sub_field('spots_text')); ?>">
                                        Reserve a Spot
                                    </button>
                                    <span class="text-sm text-gold"><?php the_sub_field('spots_text'); ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="img overflow-hidden">
                <?php $modal_img = get_field('modal_image', 'option'); ?>
                <img class="w-full h-full object-cover" src="<?php echo $modal_img ? esc_url($modal_img['url']) : get_template_directory_uri() . '/img/mission.png'; ?>" alt="event">
            </div>
            <button id="close-modal" aria-label="Close modal" class="btn--transparent absolute top-4 right-4 text-gold size-5 uppercase font-extralight flex items-center justify-center">
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.75 20.75L20.75 0.75M0.75 0.75L20.75 20.75" stroke="#C89E42" stroke-width="1.5" stroke-linecap="round"/>
</svg>
            </button>
        </div>
    </div>
<?php
else:;
?>
    <div id="events-modal" class="modal fixed top-0 left-0 z-20 w-full h-full bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="modal-content relative bg-blue max-w-[90%] size-full max-h-[90%] text-center flex flex-col">
            <div class="img max-h-[170px] overflow-hidden">
                <?php $modal_img = get_field('modal_image', 'option'); ?>
                <img class="w-full h-auto  object-cover object-center" src="<?php echo $modal_img ? esc_url($modal_img['url']) : get_template_directory_uri() . '/img/mission.png'; ?>" alt="event">
            </div>
            <div class="py-6 px-5">
                <h2 class="h2 text-[40px] "><?php the_field('modal_title', 'option'); ?></h2>
                <p class="post text-base text-center"><?php the_field('modal_subtitle', 'option'); ?></p>
                <div class="event-list border-solid border-gold border-[1px] rounded-lg p-3 overflow-y-auto h-auto flex flex-col gap-4">
                    <?php if (have_rows('events', 'option')): ?>
                        <?php while (have_rows('events', 'option')): the_row(); ?>
                            <div class="event-item w-full">
                                <div class="flex justify-between">
                                    <p class="event-name text-left"><?php the_sub_field('name'); ?></p>
                                    <span class="event-date text-gold text-sm"><?php the_sub_field('date'); ?></span>
                                </div>
                                <div class="event-desc flex flex-col items-start">
                                    <div class="text-sm mb-1 description-short text-left line-clamp-2">
                                        <?php the_sub_field('description'); ?>
                                    </div>
                                    <button class="text-gold btn--transparent mb-4 text-sm show-more flex items-center gap-2">
                                        <span>Show more</span>
                                        <svg class="rotate-180 transition-transform" width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.12484 3.20832L3.20817 0.291656L0.291504 3.20832" stroke="#C89E42" stroke-width="0.583333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                                <div class="event-register flex items-center justify-between gap-2">
                                    <button class="btn btn--modal w-[174px] mb-3 reserve-btn text-sm uppercase"
                                        data-name="<?php echo esc_attr(get_sub_field('name')); ?>"
                                        data-date="<?php echo esc_attr(get_sub_field('date')); ?>"
                                        data-spots="<?php echo esc_attr(get_sub_field('spots_text')); ?>">
                                        Reserve a Spot
                                    </button>
                                    <span class="text-sm text-gold text-left max-w-[96px]"><?php the_sub_field('spots_text'); ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <button id="close-modal" aria-label="Close modal" class="btn--transparent absolute size-4 top-4 right-4 text-gold text-[34px] uppercase font-extralight">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.75 14.75L14.75 0.75M0.75 0.75L14.75 14.75" stroke="#C89E42" stroke-width="1.5" stroke-linecap="round"/>
</svg>
            </button>
        </div>
    </div>
<?php
endif;
?>
<div id="reservation-modal" class="modal fixed top-0 left-0 z-30 w-full h-full bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="modal-content relative bg-blue w-full max-w-[90%] md:max-w-[500px] h-auto md:min-h-[630px] flex flex-col px-[30px] md:px-[60px] py-[50px] overflow-y-auto">
        <button id="close-reservation" aria-label="Close reservation modal" class="btn--transparent absolute size-4 md:size-5 top-4 right-6 text-gold text-[30px] font-extralight leading-none hover:opacity-80 transition-opacity flex items-center justify-center">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.75 20.75L20.75 0.75M0.75 0.75L20.75 20.75" stroke="#C89E42" stroke-width="1.5" stroke-linecap="round"/>
</svg>

        </button>

        <h2 class="h2 text-[48px] md:text-[54px] text-center mb-6 w-full md:whitespace-nowrap">Spot Reservation</h2>

        <div class="flex flex-col items-center gap-1 mb-6">
            <span class="post !mb-0 text-sm tracking-widest">EVENT</span>
            <span class="text-white text-base text-center" id="res-event-name">Name of event</span>
        </div>

        <div class="flex flex-col items-center gap-1 mb-10">
            <span class="post !mb-0 text-sm tracking-widest">DATA</span>
            <span class="text-white text-base text-center" id="res-event-date">24/03/2026</span>
        </div>
        <form id="reservation-form" class="w-full flex flex-col gap-6" action="#" method="POST">
            <div class="w-full relative">
                <input type="text" name="name" placeholder="Name"  class="border-bottom-1 w-full">
            </div>
            <div class="w-full relative">
                <input type="tel" name="phone" placeholder="Phone *" required class="border-bottom-1 w-full">
            </div>
            <div class="w-full relative mt-4">
                <label for="reservation-people" class="text-white text-base mb-3 block">Number of people</label>
                <div class="flex items-center justify-between">
                    <div class="flex items-center border-def rounded-[10px] h-[32px] p-3 w-[147px]">
                        <button type="button" class="btn--transparent text-white hover:text-gold w-8 h-full flex items-center justify-center text-xl pb-1 focus:outline-none" onclick="this.nextElementSibling.value = Math.max(1, Math.min(parseInt(this.nextElementSibling.value || 1, 10) - 1, parseInt(this.nextElementSibling.max || 1, 10))); this.nextElementSibling.dispatchEvent(new Event('change', { bubbles: true }));">-</button>
                        <input id="reservation-people" type="number" name="people" value="1" min="1" max="50" class="w-full bg-transparent text-white text-base text-center focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" class="btn--transparent text-white hover:text-gold w-8 h-full flex items-center justify-center text-xl pb-1 focus:outline-none" onclick="this.previousElementSibling.value = Math.min(parseInt(this.previousElementSibling.value || 1, 10) + 1, parseInt(this.previousElementSibling.max || 1, 10)); this.previousElementSibling.dispatchEvent(new Event('change', { bubbles: true }));">+</button>
                    </div>
                    <span id="res-event-spots" class="text-gold text-sm font-light">22 of 50 spots available</span>
                </div>
            </div>

            <button type="submit" class="btn w-full">RESERVE</button>
        </form>
    </div>
</div>
<div id="success-modal" class="modal fixed top-0 left-0 z-40 w-full h-full bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="modal-content relative bg-blue w-full max-w-[90%] md:max-w-[500px] h-auto min-h-[400px] flex flex-col items-center justify-center px-[30px] md:px-[60px] py-[60px]">
        <button id="close-success" class="btn--transparent absolute top-4 size-4 md:size-5 right-6 text-gold text-[30px] font-extralight leading-none hover:opacity-80 transition-opacity flex items-center justify-center">
            <img class="block w-4 h-4 md:w-5 md:h-5 object-contain" src="<?php echo get_template_directory_uri(); ?>/img/decor/close.svg" alt="Close">
        </button>

        <h2 class="h2 text-[54px] md:text-[64px] text-center mb-6 w-full">Thank You</h2>

        <p class="text-white text-base text-center mb-10 max-w-[320px]">
            We will contact you within 5 minutes<br>to confirm your reservation
        </p>

        <div class="border-[1px] border-[#444E61] rounded-[100px] p-[6px]">
            <button type="button" id="back-to-main" class="btn h-[43px] px-8 !w-auto uppercase text-sm tracking-wider">BACK TO MAIN PAGE</button>
        </div>
    </div>
</div>

<?php get_footer(); ?>