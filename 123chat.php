<?php
	/*
	Plugin Name: 123.chat - Video Chat 
	Plugin URI: https://123.chat/
	Description: 1:1 Live Video Chat for Websites & Onlineshops - GDPR/DSGVO konform - Booking/Kalender. Receive, advise and convert visitors into customers via 1: 1 live video chat! / Besucher per 1:1 Live Video Chat empfangen, beraten und zu Kunden machen!
	Version: 1.3.1
	Author: 123.chat
	License: Copyright 123.chat
	*/

	function add_123_chat_window(){
		$usr_id = chat123_get_usr_id();
		if ($usr_id && strlen($usr_id) == 36) {
			echo '<script src="https://livechat.123.chat/embedded/' . $usr_id . '.js" async></script>';
		}
	}
	add_action( 'wp_footer', 'add_123_chat_window' );



	function chat123_register_settings() {
		add_option( 'chat123_usr_id', '');
		register_setting( 'chat123_options_group', 'chat123_usr_id', 'chat123_callback' );
	}
	add_action( 'admin_init', 'chat123_register_settings' );

	function chat123_register_options_page() {
		add_options_page('123.chat', '123.chat', 'manage_options', 'chat123', 'chat123_options_page');
	}
	add_action('admin_menu', 'chat123_register_options_page');

	function chat123_get_usr_id() {
		$usr_id = strtolower(get_option('chat123_usr_id'));
		return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $usr_id) === 1 ? $usr_id : '';
	}

	function chat123_options_page() {
	?>
		<div class="wrap">
			<h2><?php echo __('Settings'); ?> > 123.chat - 1:1 Live Video Chat</h2>
			<?php screen_icon(); ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'chat123_options_group' ); ?>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="chat123_usr_id">User-ID</label></th>
							<td>
								<td><input type="text" id="chat123_usr_id" name="chat123_usr_id" class="regular-text" value="<?php echo chat123_get_usr_id(); ?>" />
								<p>Die User-ID ist hier: <b>www.123.chat > Einstellungen > WordPress Plugin</b>.</p>
								<p>The User-ID is here: <b>www.123.chat > Settings > WordPress Plugin</b>.</p>
							</td>
						</tr>
					</tbody>
				</table>

				<?php  submit_button(); ?>
			</form>
		</div>
	<?php
	} 

	function chat123_settings_link( $links ) {
		$newlinks[] = '<a href="' . admin_url( 'options-general.php?page=chat123' ) . '">' . __('Settings') . '</a>';
		return array_merge($newlinks, $links);
	}
	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'chat123_settings_link');