<?php
/**
 * Plugin Name: Post to Question
 * Plugin URI: http://codetodeath.com/wp/plugin/post_2_question
 * Description: A wordpress plugin to add an question on question2answer site while posting.
 * Version: 1.0
 * Author: Deng Guo
 * Author URI: http://codetodeath.com
 * License: GPL2
 */

define(QA_BASE_DIR, '/Applications/MNPP/htdocs/disucss/');

require_once QA_BASE_DIR . 'qa-include/qa-base.php';

require_once QA_INCLUDE_DIR.'qa-app-users.php';
require_once QA_INCLUDE_DIR.'qa-app-posts.php';
	
function post2question($postId) {
    $post = get_post($postId);
    $tags = wp_get_post_tags($postId, array('fields' => 'names'));

    if ($post) {
        qa_post_create(
            'Q',                    // type question
            null,                   // no parentid
            $post->post_title,      // question title
            $post->post_excerpt,    // question content
            '',                     // format: plain text
            null,                   // category id
            $tags,                  // tags
            1                       // user id
        );
    }
}

add_action('publish_post', 'post2question');
