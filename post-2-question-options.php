<?php
// option page ui
// register options
function post2question_option_init() {
  register_setting('p2q_options', 'p2q_url_prefix');
  register_setting('p2q_options', 'p2q_btn_switch');
}

add_action('admin_init', 'post2question_option_init');

function post2question_option_ui() {
  ?>
  <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Post to Question Settings</h2>
    <p>Welcome to the Post2Question Plugin. Here you can edit many options used by the plugin.</p>
    <form id="wp-plugin-post-2-question-option-form" action="options.php" method="post">
      <?php settings_fields('p2q_options'); ?>
      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">
              <label for="p2q_url_prefix">Url Prefix</label>
            </th>
            <td>
              <input type="text" id="p2q_url_prefix" name="p2q_url_prefix" class="regular-text code" value="<?php echo esc_attr(get_option('p2q_url_prefix'));?>" />
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="p2q_btn_switch">Append Button to Content</label>
            </th>
            <td>
            <input type="checkbox" id="p2q_btn_switch" name="p2q_btn_switch" <?php 
echo get_option('p2q_btn_switch') ? 'checked' : ''; ?> />
            </td>
          </tr>
        </tbody>
      </table>
      <p class="submit">
        <input type="submit" name="submit" value="Save Changes" class="button button-primary"/>
      </p>
    </form>
  </div>
  <?php
}

function post2question_option_hook() {
  add_options_page('Post to Question Setting', 'Post2Question', 'manage_options', 'wp-plugin-post-2-question', 'post2question_option_ui');
}

add_action('admin_menu', 'post2question_option_hook');
