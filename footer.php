    <footer class=" h-[100px] md:h-16  flex flex-col md:flex-row items-center justify-left md:px-14 px-5 pt-6 md:pt-0 bg-blue text-gold relative ">
        <div class="flex gap-2">
            <span class="text-[35px] uppercase text-gold font-i"><?php echo esc_html(get_bloginfo('name')); ?></span>
            <span class="text-gold uppercase">art gallery</span>
        </div>
                <img class="decor-bottom absolute bottom-0 right-0 z-0 h-1/2 md:h-full w-full md:w-auto" src="<?php echo get_template_directory_uri(); 
                if(wp_is_mobile()){
                    echo '/img/decor/fd-m.svg';
                } else {
                    echo '/img/decor/flb.svg';
                }
                ?>" alt="декор">

    </footer>

    <?php wp_footer(); ?>
    </body>

    </html>