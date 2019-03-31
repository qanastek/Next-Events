<h1>Paramètrage de Next Events</h1>

<?php settings_errors(); ?>

<form method="post" action="options.php">
	<?php

		/**
		*	@since 1.0.0
		*	@var $option_group  A settings group name. This should match the group name used in register_setting().
		*/
		settings_fields('ne_settings_group');

		do_settings_sections('settings_next_events'); // Nom de la page mere

		/**
		*	@since 1.0.0
		*	@var $text The text of the button
		*	@var $type The type of button. Common values: primary, secondary, delete.
		*/
		submit_button(
			'Sauvegarder',
			'primary'
		);

		/*https://www.youtube.com/watch?v=pTegcB9zMSM*/

	?>
</form>