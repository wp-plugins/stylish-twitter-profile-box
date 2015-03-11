<p>
	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('title')); ?>"
		name="<?php echo esc_attr($this->get_field_name('title')); ?>"
		type="text"
		placeholder="Stylish Twitter Profile Box"
		value="<?php echo $title; ?>" />
	
</p>

<p>
	<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php _e('Twitter Username:', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('username')); ?>"
		name="<?php echo esc_attr($this->get_field_name('username')); ?>"
		type="text"
		placeholder="nandmpa"
		value="<?php echo $username; ?>" />
	
</p>

<p>
	<?php _e('Twitter APP/API settings link <a href="https://apps.twitter.com/" target="_blank" />Click Here</a>', 'stpb_twitterprofilebox'); ?>
	<label for="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>"><?php _e('Consumer Key (API Key):', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>"
		name="<?php echo esc_attr($this->get_field_name('consumer_key')); ?>"
		type="text"
		value="<?php echo $consumer_key; ?>" />
	
</p>

<p>
	<label for="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>"><?php _e('Consumer Secret (API Secret):', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>"
		name="<?php echo esc_attr($this->get_field_name('consumer_secret')); ?>"
		type="text"
		value="<?php echo $consumer_secret; ?>" />
	
</p>

<p>

	<label for="<?php echo esc_attr($this->get_field_id('oauth_access_token')); ?>"><?php _e('Access Token:', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('oauth_access_token')); ?>"
		name="<?php echo esc_attr($this->get_field_name('oauth_access_token')); ?>"
		type="text"
		value="<?php echo $oauth_access_token; ?>" />
	
</p>

<p>
	<label for="<?php echo esc_attr($this->get_field_id('oauth_access_token_secret')); ?>"><?php _e('Access Token Secret:', 'stpb_twitterprofilebox'); ?></label>
	<input
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('oauth_access_token_secret')); ?>"
		name="<?php echo esc_attr($this->get_field_name('oauth_access_token_secret')); ?>"
		type="text"
		value="<?php echo $oauth_access_token_secret; ?>" />
	
</p>

<p>
	<label for="<?php echo esc_attr($this->get_field_id('request_time')); ?>"><?php _e('Cache:', 'stpb_twitterprofilebox'); ?></label>
		<?php $selected = 'selected="selected"'; ?>
	<select 
		class="widefat"
		id="<?php echo esc_attr($this->get_field_id('request_time')); ?>"
		name="<?php echo esc_attr($this->get_field_name('request_time')); ?>">
		<option value="<?php echo absint(5); ?>" <?php if ( $request_time === 5)  echo $selected; ?> ><?php _e( '5 Minutes', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(10); ?>" <?php if ( $request_time === 10)  echo $selected; ?> ><?php _e( '10 Minutes', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(15); ?>" <?php if ( $request_time === 15)  echo $selected; ?> ><?php _e( '15 Minutes', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(20); ?>" <?php if ( $request_time === 20)  echo $selected; ?> ><?php _e( '20 Minutes', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(30); ?>" <?php if ( $request_time === 30)  echo $selected; ?> ><?php _e( '30 Minutes', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(60); ?>" <?php if ( $request_time === 60)  echo $selected; ?> ><?php _e( '1 hour', 'stpb_twitterprofilebox'); ?> </option>
		<option value="<?php echo absint(300); ?>" <?php if ( $request_time === 300)  echo $selected; ?> ><?php _e( '5 hours', 'stpb_twitterprofilebox'); ?> </option>
	</select>
	
</p>
