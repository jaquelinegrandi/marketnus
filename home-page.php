<section class="nous-section" id="nous" aria-labelledby="nous-title">

    <div class="section-container nous-container">

        <!-- =========================================
             INTRODUCCIÓN
        ========================================== -->

        <div class="nous-introduction">

            <div class="section-subtitle section-marker--light">

                <span
                    class="subtitle-marker"
                    aria-hidden="true"
                ></span>

                <span>Nous</span>

            </div>


            <h2 class="nous-title" id="nous-title">

                Ideas que
                <br>

                <span class="text-highlight">
                    mueven ideas.
                </span>

            </h2>


            <p class="nous-description">

                Tendencias, herramientas y estrategias
                para que sigas un paso por delante.

            </p>


            <a
                href="<?php
                    echo esc_url(
                        get_permalink(
                            get_option('page_for_posts')
                        )
                    );
                ?>"
                class="text-link"
                aria-label="Ver todos los artículos del blog"
            >

                <span>
                    Ver todos los artículos
                </span>

                <i
                    class="bi bi-arrow-right"
                    aria-hidden="true"
                ></i>

            </a>

        </div>


        <!-- =========================================
             ARTÍCULOS
        ========================================== -->

        <div class="articles-wrapper">

            <div class="articles-grid">


                <?php

                /*
                 * =====================================
                 * BUSCAR LOS 3 ARTÍCULOS MÁS RECIENTES
                 * =====================================
                 */

                $nous_articles = new WP_Query(
                    array(

                        'post_type'      => 'post',

                        'posts_per_page' => 3,

                        'post_status'    => 'publish',

                        'orderby'        => 'date',

                        'order'          => 'DESC',

                    )
                );


                /*
                 * =====================================
                 * SI EXISTEN ARTÍCULOS
                 * =====================================
                 */

                if ( $nous_articles->have_posts() ) :

                    $article_number = 1;


                    while ( $nous_articles->have_posts() ) :

                        $nous_articles->the_post();


                        /*
                         * NÚMERO
                         * 001 / 002 / 003
                         */

                        $article_id = str_pad(
                            $article_number,
                            3,
                            '0',
                            STR_PAD_LEFT
                        );


                        /*
                         * CATEGORÍA
                         */

                        $categories = get_the_category();

                        $category_name = ! empty($categories)
                            ? $categories[0]->name
                            : 'Marketnus';


                        /*
                         * TIEMPO DE LECTURA
                         */

                        $content = get_the_content();

                        $word_count = str_word_count(
                            wp_strip_all_tags($content)
                        );

                        $reading_time = max(
                            1,
                            ceil($word_count / 200)
                        );

                        ?>


                        <!-- =================================
                             TARJETA DEL ARTÍCULO
                        ================================== -->

                        <article
                            class="article-card"
                            id="article-<?php
                                echo esc_attr(
                                    get_the_ID()
                                );
                            ?>"
                        >

                            <a
                                href="<?php
                                    the_permalink();
                                ?>"
                                class="article-card-link"
                                aria-label="<?php
                                    echo esc_attr(
                                        get_the_title()
                                    );
                                ?>"
                            >


                                <!-- =========================
                                     IMAGEN
                                ========================== -->

                                <div class="article-image">

                                    <?php

                                    if ( has_post_thumbnail() ) :

                                        the_post_thumbnail(
                                            'large',
                                            array(

                                                'alt' =>
                                                    esc_attr(
                                                        get_the_title()
                                                    ),

                                                'loading' =>
                                                    $article_number === 1
                                                        ? 'eager'
                                                        : 'lazy',

                                                'decoding' =>
                                                    'async',

                                            )
                                        );

                                    else :

                                        ?>

                                        <img
                                            src="<?php
                                                echo esc_url(
                                                    get_template_directory_uri()
                                                    . '/assets/images/article-placeholder.webp'
                                                );
                                            ?>"
                                            alt="Marketnus - artículo de Nous"
                                            loading="lazy"
                                            decoding="async"
                                        >

                                        <?php

                                    endif;

                                    ?>

                                </div>


                                <!-- =========================
                                     CONTENIDO
                                ========================== -->

                                <div class="article-content">


                                    <!-- META -->

                                    <div class="article-meta">

                                        <span>

                                            Nous /

                                            <?php
                                            echo esc_html(
                                                $article_id
                                            );
                                            ?>

                                        </span>

                                    </div>


                                    <!-- TÍTULO -->

                                    <h3 class="article-title">

                                        <?php
                                        echo esc_html(
                                            get_the_title()
                                        );
                                        ?>

                                    </h3>


                                    <!-- FOOTER -->

                                    <div class="article-footer">


                                        <!-- TIEMPO DE LECTURA -->

                                        <span>

                                            <i
                                                class="bi bi-clock"
                                                aria-hidden="true"
                                            ></i>

                                            <?php
                                            echo esc_html(
                                                $reading_time . ' min'
                                            );
                                            ?>

                                        </span>


                                        <!-- CATEGORÍA -->

                                        <span>

                                            <i
                                                class="bi bi-circle-fill"
                                                aria-hidden="true"
                                            ></i>

                                            <?php
                                            echo esc_html(
                                                $category_name
                                            );
                                            ?>

                                        </span>


                                    </div>

                                </div>


                            </a>

                        </article>


                        <?php

                        /*
                         * SIGUIENTE ARTÍCULO
                         */

                        $article_number++;

                    endwhile;


                    /*
                     * RESTAURAR EL LOOP PRINCIPAL
                     */

                    wp_reset_postdata();


                else :

                    ?>


                    <!-- =================================
                         SI NO HAY ARTÍCULOS
                    ================================== -->

                    <article class="article-card article-card--empty">

                        <div class="article-content">

                            <div class="article-meta">

                                <span>
                                    Nous
                                </span>

                            </div>


                            <h3 class="article-title">

                                Próximamente nuevas ideas.

                            </h3>


                            <p>

                                Estamos preparando nuevos contenidos
                                para ayudarte a seguir avanzando.

                            </p>

                        </div>

                    </article>


                    <?php

                endif;

                ?>


            </div>


            <!-- =========================================
                 BOTÓN VER MÁS
            ========================================== -->

            <a
                href="<?php
                    echo esc_url(
                        get_permalink(
                            get_option('page_for_posts')
                        )
                    );
                ?>"
                class="articles-next"
                aria-label="Ver más artículos"
            >

                <i
                    class="bi bi-arrow-right"
                    aria-hidden="true"
                ></i>

            </a>


        </div>

    </div>

</section>