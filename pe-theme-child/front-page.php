<?php
/**
 * Template for homepage
 * 
 * 
 */
get_header();
?>
<div id="barba-wrapper" data-barba="wrapper">  
    <?php get_template_part('template-parts/loading'); ?>

    <div class="barba-container" data-barba="container" data-barba-namespace="home">        
        <div class="page-container">            
            <main id="site-content" role="main">
                <h1>Home</h1>
            </main>
        </div>
    </div>


<?php get_footer();
