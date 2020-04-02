<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


add_filter('job_bm_settings_tabs','job_bm_settings_tabs_related_job');
function job_bm_settings_tabs_related_job($job_bm_settings_tab){

    $job_bm_settings_tab[] = array(
        'id' => 'related_jobs',
        'title' => sprintf(__('%s Related jobs','job-board-manager-company-profile'),'<i class="far fa-list-alt"></i>'),
        'priority' => 10,
        'active' => false,
    );

    return $job_bm_settings_tab;

}




add_action('job_bm_settings_tabs_content_related_jobs', 'job_bm_settings_tabs_content_related_jobs', 20);

if(!function_exists('job_bm_settings_tabs_content_related_jobs')) {
    function job_bm_settings_tabs_content_related_jobs($tab){

        $settings_tabs_field = new settings_tabs_field();

        $job_bm_related_jobs_by = get_option('job_bm_related_jobs_by');
        $job_bm_related_jobs_limit = get_option('job_bm_related_jobs_limit');



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Related job settings', 'job-board-manager-company-profile'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for related jobs.', 'job-board-manager-company-profile'); ?></p>

            <?php


            $args = array(
                'id'		=> 'job_bm_related_jobs_limit',
                //'parent'		=> '',
                'title'		=> __('Related jobs limit','job-board-manager-company-profile'),
                'details'	=> __('Display related job max number.','job-board-manager-company-profile'),
                'type'		=> 'text',
                'value'		=> $job_bm_related_jobs_limit,
                'default'		=> 5,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_related_jobs_by',
                //'parent'		=> '',
                'title'		=> __('Related jobs by','job-board-manager-company-profile'),
                'details'	=> __('Choose how you want to query related jobs','job-board-manager-company-profile'),
                'type'		=> 'checkbox',
                'multiple'		=> true,
                'value'		=> $job_bm_related_jobs_by,
                'default'		=> array(),
                'args'		=> array('job_category'=>__('Categories','job-board-manager-related-jobs'),'job_tag'=>__('Tags','job-board-manager-related-jobs'), 'job_type'=>__('Job type','job-board-manager-related-jobs'), 'location'=>__('Location','job-board-manager-related-jobs')),
            );

            $settings_tabs_field->generate_field($args);







            ?>


        </div>
        <?php


    }
}









add_action('job_bm_settings_save', 'job_bm_settings_save_related_jobs', 20);

if(!function_exists('job_bm_settings_save_related_jobs')) {
    function job_bm_settings_save_related_jobs($tab){


        $job_bm_related_jobs_limit = isset($_POST['job_bm_related_jobs_limit']) ? sanitize_text_field($_POST['job_bm_related_jobs_limit']) : '';
        update_option('job_bm_related_jobs_limit', $job_bm_related_jobs_limit);

        $job_bm_related_jobs_by = isset($_POST['job_bm_related_jobs_by']) ? stripslashes_deep($_POST['job_bm_related_jobs_by']) : '';
        update_option('job_bm_related_jobs_by', $job_bm_related_jobs_by);






    }
}


/*Right panel*/

add_action('job_bm_settings_tabs_right_panel_related_jobs', 'job_bm_settings_tabs_right_panel_related_jobs');

if(!function_exists('job_bm_settings_tabs_right_panel_related_jobs')) {
    function job_bm_settings_tabs_right_panel_related_jobs($id){

        ?>
        <h3>Help & Support</h3>
        <p>Please read documentation for customize Job Board Manger - Company Profile</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/documentation/job-board-manager-company-profile/?ref=dashboard">Documentation</a>

        <p>If you found any issue could not manage to solve yourself, please let us know and post your issue on forum.</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/forum/?ref=dashboard">Create Ticket</a>

        <h3>Write Reviews</h3>
        <p>If you found Job Board Manger - Company Profile help you to build something useful, please help us by
            providing your feedback and five star reviews on plugin page.</p>
        <a target="_blank" class="button" href="https://wordpress.org/support/plugin/job-board-manager-company-profile/reviews/#new-post">Rate Us <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></a>

        <h3>Shortcodes</h3>
        <p>
            <code>[job_bm_company_submit_form]</code> <br> Display company submit form, <br><a href="https://www.pickplugins.com/demo/job-board-manager/company-submit/">Demo</a>
        </p>

        <p>
            <code>[job_bm_company_edit_form]</code> <br> Display company edit form. <br><a href="https://www.pickplugins
            .com/demo/job-board-manager/company-edit/">Demo</a>
        </p>

        <p>
            <code>[job_bm_my_companies]</code> <br> Display company created by logged-in user.<br><a href="http://www.pickplugins.com/demo/job-board-manager/job-dashboard/?tabs=my_companies">Demo</a>
        </p>
        <p>
            <code>[job_bm_company_list]</code> <br> Display list of company with jobs. <br><a href="http://www.pickplugins.com/demo/job-board-manager/company-list/">Demo</a>
        </p>





        <?php

    }
}