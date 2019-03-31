<?php
	
	// Devise
	$currency_fc = esc_attr( get_option('default_price') );

	if ($currency_fc == "")
	{
		$currency_fc = "€";
	}

	// Language
	$language = strip_tags(strtolower(esc_attr(get_option('locale_fc'))));

	// Cas de vacuité
	// Default language
	if ($language == "")
	{
		$language = 'fr';
	}

	// Events Color
	$events_colors = esc_attr( get_option('colors_fc') );

	// Cas de vacuité
	if (strtolower(esc_attr(get_option('colors_fc'))) == "") {
		$events_colors = '#3c9ccf';
	}

	// Events Views
	$events_views_1 = esc_attr( get_option('views_1_fc') );
	$events_views_2 = esc_attr( get_option('views_2_fc') );
	$events_views_3 = esc_attr( get_option('views_3_fc') );
	$events_views_4 = esc_attr( get_option('views_4_fc') );

	// Cas de vacuité
	if ($events_views_1 == "" and $events_views_2 == "" and $events_views_3 == "" and $events_views_4 == "")
	{
		$events_views_1 = "";
		$events_views_2 = "agendaWeek";
		$events_views_3 = "month";
		$events_views_4 = "";
	}

	// Hour start
	$hour_start = esc_attr( get_option('hour_start_fc') );

	// cas de vacuité
	if ($hour_start == "")
	{
		$hour_start = "07:00";
	}

	// Hour end
	$hour_end = esc_attr( get_option('hour_end_fc') );

	// cas de vacuité
	if ($hour_end == "")
	{
		$hour_end = "18:30";
	}

	// Numéro de semaine
	$stauts_week_nbr = esc_attr( get_option('week_nbr_fc') );

	// Cas de vacuité
	if ($stauts_week_nbr == "")
	{
		$stauts_week_nbr = "false";
	}

	// Premier jour de la semaine
	$first_day = esc_attr( get_option('first_day_fc') );

	// Cas de vacuité
	if ($first_day == "")
	{
		$first_day = "1";
	}

	// Activer ou non les week end
	$weekend_status = esc_attr( get_option('weekends_fc') );

	// Cas de vacuité
	if ($weekend_status == "")
	{
		$weekend_status = "false";
	}

	$text_color = esc_attr( get_option('text_color_fc') );

	// Cas de vacuité
	if ($text_color == "")
	{
		$text_color = "white";
	}

	$links_color_var = esc_attr(get_option('links_color_fc'));

	// Cas de vacuité
	if ($links_color_var == "")
	{
		$links_color_var = "white";
	}

?>

<script type="text/javascript">
	
	jQuery(function ($) {

	    $('#calendar').fullCalendar({
	      defaultDate: <?php echo "'".date("Y-m-d")."'"; ?>,
	      editable: false,
	      locale: <?php echo "'" . $language . "'"; ?>,
	      header: {
			left: 'prev,next today',
			center: 'title',
			right: '<?php
				if ($events_views_1 != NULL) { echo $events_views_1 . ',';}
				if ($events_views_2 != NULL) { echo $events_views_2 . ',';}
				if ($events_views_3 != NULL) { echo $events_views_3 . ',';}
				if ($events_views_4 != NULL) { echo $events_views_4;}
			?>'
		  },
		  buttonIcons: false,
		  weekNumbers: <?php echo $stauts_week_nbr; ?>,
		  navLinks: false,
		  allDay: false,
	      eventLimit: false,
	      minTime: '<?php echo $hour_start; ?>',
	      maxTime: '<?php echo $hour_end; ?>',
	      showNonCurrentDates: false,
	      fixedWeekCount: false,
	      slotDuration: '00:30:00',
	      firstDay: <?php echo $first_day; ?>,
	      weekends: <?php echo $weekend_status; ?>,
	      timeFormat: 'H(:mm)',
		  eventRender: function(event, element) {
			    element.find(".fc-title").remove();
			    element.find(".fc-time").remove();
			    var new_description =   
			        "<span style='padding-bottom: 5px; font-weight: 500; letter-spacing: 1px;'>" + moment(event.start).format("HH:mm") + ' - '
			        + moment(event.end).format("HH:mm") + "</span>" + '<br/>'
			        + "<span style='font-weight: 300; text-transform: uppercase;'>" + event.title + "</span>" + '<br/>'
			        + "</i> <span style='font-weight: 500;'> Lieu: " + "</span>" + "<span style='font-weight: 400; text-transform: none;'>" + event.adress + "</span>" + "<br/>"
			        + "<span style='font-weight: 500;'>" + "Participation: " + "</span>" + "<span style='font-weight: 400;'>" + event.price + " <?php echo $currency_fc; ?> </span>" + "<br/>"
			        + " <a href=' " + event.url + " 'style='font-weight: 400; color: " + '<?php echo $links_color_var; ?>' + " !important;'> lire la suite </a>"
			    ;
			    element.append(new_description);
			},
	      events: [

	      	<?php $loop = new WP_Query( array( 
				'post_type' => 'next_events',  
				'post_status' => array( 'future', 'publish' ),
			) ); ?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				{
					<?php

						// Heure de départ de l'event
						if (get_field( "event_date_start" ))
						{
							$date_start = get_field( "event_date_start" );

							if (get_field( "heure_de_debut" ))
							{
								$hour_start = get_field( "heure_de_debut" );
							}
							else
							{
								$hour_start = '07:30:00';
							}
						}

						// Heure de fin de l'event
						if (get_field( "event_date_end" ))
						{
							$date_end = get_field( "event_date_end" );

							if (get_field( "heure_de_fin" ))
							{
								$hour_end = get_field( "heure_de_fin" );
							}
							else
							{
								$hour_end = '18:30:00';
							}
						}

					?>
		          title: '<?php
		          	$ne_title_fc   = get_the_title();
		          	$ne_title_fc = mb_strimwidth($ne_title_fc, 0, 125, ' . . . ');
		          	$ne_title_fc = strip_tags($ne_title_fc);
		          	$ne_title_fc = preg_replace( '/\r|\n/', ' ', $ne_title_fc );
		          	echo $ne_title_fc;
		          ?>',
		          start: '<?php echo $date_start.'T'.$hour_start; ?>',
		          end: '<?php echo $date_end.'T'.$hour_end; ?>',
		          price: '<?php echo get_field( "price" ); ?>',
		          adress: '<?php echo get_field( "lieu" ); ?>',
		          description: "<?php 
			          $ne_content_fc = get_the_content();
			          $ne_content_fc = mb_strimwidth($ne_content_fc, 0, 125, ' . . . ');
			          $ne_content_fc = strip_tags($ne_content_fc);
			          $ne_content_fc = preg_replace( '/\r|\n/', ' ', $ne_content_fc );
			          echo esc_html($ne_content_fc);
		          ?>",
		          url: '<?php echo get_post_permalink(get_the_ID()); ?>',
		          color: '<?php echo $events_colors; ?>',
	  			  textColor: '<?php echo $text_color; ?>',
		        },
			<?php endwhile; wp_reset_query(); ?>

	      ],
    });

  });

</script>