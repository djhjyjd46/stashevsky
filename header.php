<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        line-height: 125%;
        font-weight: 400;
        font-size: 16px;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/Montserrat-VariableFont_wght.woff2') format('woff2');
        font-weight: 100 900;
        font-style: normal;
    }

    @font-face {
        font-family: 'El Messiri';
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/ElMessiri-Regular.woff2') format('woff2');
        font-weight: 400;
        font-style: normal;
    }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php
    $header_subtitle = get_field('header_subtitle', 'option') ?: 'dubai | united arab emirates';
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = wp_get_attachment_image_src($custom_logo_id, 'full')[0] ?? get_template_directory_uri() . '/img/logo.svg';
    if (! wp_is_mobile()) : ?>
    <header class="h-[25dvh] lg:min-h-[25vh] fixed top-0 left-0 right-0 z-10 bg-blue flex flex-col gap-9">
        <div class="decor-top absolute top-0 left-0 -z-10 h-full">
            <img height="100%" src="<?php echo get_template_directory_uri(); ?>/img/decor/lt.svg" alt="">
        </div>

        <div class="up pt-6 w-full max-w-[749px] mx-auto">
            <nav id="site-navigation" class="main-navigation">
                <ul class="flex justify-between uppercase">
                    <li><a class="menu-link" href="#mission" data-section="mission">mission</a></li>
                    <li><a class="menu-link" href="#exhibitions" data-section="exhibitions">exhibitions</a></li>
                    <li><a class="menu-link" href="#art-meetings" data-section="art-meetings">art meetings</a></li>
                    <li><a class="menu-link" href="#artists" data-section="artists">artists</a></li>
                    <li><a class="menu-link" href="#our-proposals" data-section="our-proposals">our proposals</a></li>
                    <li><a class="menu-link" href="#contacts" data-section="contacts">contacts</a></li>
                </ul>
            </nav>
        </div>
        <div class="down flex items-center flex-col max-w-[749px] mx-auto">
            <div class="flex items-center gap-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <img class="w-[50px] h-[88px]" src="<?php echo esc_url($logo_url); ?>"
                        alt="<?php bloginfo('name'); ?>">
                </a>
                <h1 class="h1 text-2xl lg:text-[58px]">Demetra art gallery</h1>
            </div>
            <p class="text-gold uppercase text-[8px] xl:text-lg">
                <?php echo stashevsky_kses_post_decode($header_subtitle); ?></p>
        </div>
        <div class="decor-bottom absolute bottom-0 right-0 -z-10 h-full">
            <img height="100%" src="<?php echo get_template_directory_uri(); ?>/img/decor/rb.svg" alt="декор">
        </div>
    </header>
    <?php else: ?>
    <header class="h-[137px] fixed top-0 left-0 right-0 z-10 bg-blue flex flex-col justify-between p-4">
        <div class="decor-top absolute top-0 left-0 -z-10 h-full">
            <img height="100%" src="<?php echo get_template_directory_uri(); ?>/img/decor/l.svg" alt="декор">
        </div>
        <div class="up flex gap-1 items-center flex-col max-w-[749px] mx-auto">
            <div class="flex items-center gap-1 mb-5">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <img class="w-auto h-[35px]" src="<?php echo esc_url($logo_url); ?>"
                        alt="<?php bloginfo('name'); ?>">
                </a>
                <div class="flex flex-col items-center">
                    <h1 class="text-[25px]">Demetra art gallery</h1>
                    <p class="text-gold uppercase text-[8px] xl:text-lg mb-0">
                        <?php echo stashevsky_kses_post_decode($header_subtitle); ?></p>
                </div>
            </div>
        </div>
        <div class="down w-full mx-auto px-5">
            <nav id="site-navigation" class="main-navigation">
                <ul class="flex justify-center gap-x-5 gap-y-3 uppercase text-[12px] flex-wrap">
                    <li><a class="menu-link" href="#mission" data-section="mission">mission</a></li>
                    <li><a class="menu-link" href="#exhibitions" data-section="exhibitions">exhibitions</a></li>
                    <li><a class="menu-link" href="#art-meetings" data-section="art-meetings">art meetings</a></li>
                    <li><a class="menu-link" href="#artists" data-section="artists">artists</a></li>
                    <li><a class="menu-link" href="#our-proposals" data-section="our-proposals">our proposals</a></li>
                    <li><a class="menu-link" href="#contacts" data-section="contacts">contacts</a></li>
                </ul>
            </nav>
        </div>
        <div class="decor-bottom absolute bottom-0 right-0 -z-10 h-full">
            <img height="100%" src="<?php echo get_template_directory_uri(); ?>/img/decor/r.svg" alt="декор">
        </div>
    </header>
    <?php endif; ?>