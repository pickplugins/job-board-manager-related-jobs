<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 
	




add_action('job_bm_single_job_main', 'job_bm_single_job_main_related_jobs', 50);

function job_bm_single_job_main_related_jobs(){

    $current_job_id = get_the_id();

    $meta_query = array();
    $tax_query = array();

    $atts = array();
    $job_bm_related_jobs_by = get_option('job_bm_related_jobs_by');
    $job_bm_related_jobs_limit = (int) get_option('job_bm_related_jobs_limit', 5);

    //echo '<pre>'.var_export($job_bm_related_jobs_by, true).'</pre>';



    if(!empty($job_bm_related_jobs_by) && is_array($job_bm_related_jobs_by))
    foreach ($job_bm_related_jobs_by as $jobs_by_index => $jobs_by):

        if($jobs_by == 'job_category'){
            $category = get_the_terms($current_job_id, 'job_category');

            //echo '<pre>'.var_export($category[0], true).'</pre>';


            if(!empty($category[0])){
                $tax_query[] = array(
                    'taxonomy' => 'job_category',
                    'field'    => 'term_id',
                    'terms'    => $category[0]->term_id,
                    //'operator'    => '',
                );
            }



        }elseif ($jobs_by == 'job_tag'){

            $category = get_the_terms($current_job_id, 'job_tag');

            //echo '<pre>'.var_export($category[0], true).'</pre>';


            if(!empty($category[0])){
                $tax_query[] = array(
                    'taxonomy' => 'job_tag',
                    'field'    => 'term_id',
                    'terms'    => $category[0]->term_id,
                    //'operator'    => '',
                );
            }

        }elseif ($jobs_by == 'job_type'){

            $job_bm_job_type = get_post_meta($current_job_id, 'job_bm_job_type', true);

            $meta_query[] = array(
                'key' => 'job_bm_job_type',
                'value' => $job_bm_job_type,
                'compare' => 'LIKE',
            );

        }elseif ($jobs_by == 'location'){
            $job_bm_location = get_post_meta($current_job_id, 'job_bm_location', true);

            $meta_query[] = array(
                'key' => 'job_bm_location',
                'value' => $job_bm_location,
                'compare' => 'LIKE',
            );

        }



    endforeach;






    $query_args = array (
        'post_type' => 'job',
        'post_status' => 'publish',
        'orderby' => 'date',
        'post__not_in' => array($current_job_id),
        'meta_query' => $meta_query,
        'tax_query' => $tax_query,
        'order' => 'DESC',
        'posts_per_page' => $job_bm_related_jobs_limit,

    );

    if(empty($job_bm_related_jobs_by)){
        $query_args['orderby'] = 'rand';
    }


    $query_args = apply_filters('job_bm_related_jobs_query_args',$query_args);

    //echo '<pre>'.var_export($query_args, true).'</pre>';


    $wp_query = new WP_Query($query_args);


    ?>
    <h3><?php echo __('Related Jobs','job-board-manager-related-jobs'); ?></h3>

    <div class="related-jobs">

        <?php

        do_action('job_bm_related_jobs_loop_before', $wp_query);


        if ( $wp_query->have_posts() ) :
            $count = 1;

            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $job_id = get_the_ID();
                $atts['loop_count'] = $count;
                do_action('job_bm_related_jobs_loop', $job_id, $atts);


                $count++;
            endwhile;
            do_action('job_bm_related_jobs_loop_after', $wp_query);
            wp_reset_query();
        else:

            do_action('job_bm_related_jobs_loop_no_post');

        endif;

        ?>


    </div>
    <?php

    //echo do_shortcode('[job_bm_archive display_search="no" display_pagination="no"]');
	
	?>

    <style type="text/css">
        .related-jobs{}

        .related-jobs .single {
            clear: both;
            display: block;
            margin: 15px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .related-jobs .company_logo {
            width: 50px;
            height: 50px;
            overflow: hidden;
            float: left;
            margin-right: 15px;
        }
        .related-jobs .title {
            font-size: 15px;

        }

        .related-jobs a {
            text-decoration: none;

        }
        .related-jobs .company-name {
            display: inline-block;
            margin-right: 10px;
        }


        .related-jobs .job-meta {
            display: inline-block;
        }
        .related-jobs .job-meta span{
            display: inline-block;
            margin-right: 15px;
        }


    </style>
    <?php
	
	}



add_action('job_bm_related_jobs_loop','job_bm_related_jobs_loop_item', 90,2);
function job_bm_related_jobs_loop_item($job_id, $atts){

    $class_job_bm_functions = new class_job_bm_functions();
    $job_status_list = $class_job_bm_functions->job_status_list();
    $job_type_list = $class_job_bm_functions->job_type_list();

    $job_bm_company_logo = get_post_meta($job_id,'job_bm_company_logo', true);
    $job_bm_location = get_post_meta($job_id,'job_bm_location', true);
    $job_bm_job_type = get_post_meta($job_id,'job_bm_job_type', true);
    $job_bm_job_status = get_post_meta($job_id,'job_bm_job_status', true);
    $post_date = get_the_time( 'U', $job_id );
    $job_bm_company_name = get_post_meta($job_id,'job_bm_company_name', true);



    ?>
    <div class="single">
        <div class="company_logo">
            <img src="<?php echo $job_bm_company_logo; ?>">
        </div>
        <div class="title"><a href="<?php echo get_permalink($job_id); ?>"><?php echo get_the_title($job_id); ?></a></div>

        <div class="job-meta">
            <?php if(!empty($job_bm_company_name)):?>
            <span class="company-name"><?php echo $job_bm_company_name; ?></span>
            <?php endif; ?>

            <?php if(isset($job_type_list[$job_bm_job_type])):?>
            <span class="meta-item job_type freelance"><i class="fas fa-briefcase"></i>  <?php echo $job_type_list[$job_bm_job_type]; ?></span>
            <?php endif; ?>

            <?php if(isset($job_status_list[$job_bm_job_status])):?>
            <span class=" meta-item job_status open"><i class="fas fa-traffic-light"></i> <?php echo $job_status_list[$job_bm_job_status]; ?></span>
            <?php endif; ?>
            <?php if(!empty($job_bm_location)):?>
            <span class="job-location meta-item"><i class="fas fa-map-marker-alt"></i> <?php echo $job_bm_location; ?></span>
            <?php endif; ?>

            <span class="job-post-date meta-item"><i class="far fa-calendar-alt"></i> <?php echo sprintf(__('Posted %s ago','job-board-manager'), human_time_diff( $post_date, current_time( 'timestamp' ) ) )?></span>
        </div>
    </div>
    <?php

}
	