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
require_once 'post-2-question-options.php';
	
function post2question($postId) {
    $post = get_post($postId);
    $tags = wp_get_post_tags($postId, array('fields' => 'names'));

    if ($post) {
        $qId = qa_post_create(
            'Q',                    // type question
            null,                   // no parentid
            $post->post_title,      // question title
            $post->post_excerpt,    // question content
            '',                     // format: plain text
            null,                   // category id
            $tags,                  // tags
            1                       // user id
        );

        if ($qId) {
          add_post_meta($postId, 'disucss_qId', $qId);
        }
    }
}

add_action('publish_post', 'post2question');

function p2q_add_discuss_btn($content) {
  if (get_option('p2q_btn_switch')) {
    if ($discuss_btn = p2q_get_discuss_btn()) {
      return $discuss_btn . $content;
    }
  }
  return $content;
}

add_filter('the_content', 'p2q_add_discuss_btn');

function p2q_get_discuss_btn() {
  $cur_post = get_post();
  if ( $cur_post->post_type == 'post' ) {
    $qId = get_post_meta($cur_post->ID, 'disucss_qId', true);
    if ( $qId ) {
      $btn_url = get_option('p2q_url_prefix') . $qId;
      return '<a id="q2a_btn" target="_blank" href="' . $btn_url . '">disucss</a>';
    }
  }
  return null;
}
