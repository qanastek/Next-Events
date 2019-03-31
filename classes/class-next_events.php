<?php
/**
 * NextEvents Class
 *
 * @package NextEvents
 * @author Labrak Yanis
 * @since 1.0.0
 */

// Script anti injection
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/*Class principale*/
class NextEvents
{

	/*Permet d'initaliser le plugin*/
	function next_events_init()
	{

		/**
		*	Initialisation du CSS et JS
		*
		*	@since 1.0.0
		*
		*/
		/*FullCalendarJS CSS*/
    	wp_enqueue_style( 'fullcalendar-min', plugin_dir_url( __FILE__ ) . '../css/fullcalendar.css', array(), "ne_fullcalendar_css_1.0.0" , 'all' );

		/*MomentJS*/
    	wp_enqueue_script( 'moment', plugin_dir_url( __FILE__ ) . '../js/moment.min.js', array(), "ne_momentjs_1.0.0", true );

		/*FullCalendarJS JavaScript*/
    	wp_enqueue_script( 'pierre_de_coubertin_wp-fullcalendar', plugin_dir_url( __FILE__ ) . '../js/fullcalendar.min.js', array(), "ne_fullcalendar_js_1.0.0", true );
    	wp_enqueue_script( 'pierre_de_coubertin_wp-fullcalendar_locales', plugin_dir_url( __FILE__ ) . '../js/locale-all.js', array(), "ne_fullcalendar_locales_1.0.0", true );

    	/**
		*	Initialisation des labels du type en Français
		*
		*	@since 1.0.0
		*
		*/
		$labels = array(

			/*Nom du type*/
			'name' => 'Évènements à venir',

			/*Nom court du type*/
			'singular_name' => 'Évènement à venir',
			
			/*Boutton ajouter*/
			'add_new' => 'Ajouter un évènement',

			/*Boutton ajouter un nouveau évènement*/
			'add_new_item' => 'Ajouter un nouveau évènement',

			/*Boutton modifier un évènement existant*/
			'edit_item' => 'Modifié un évènement',

			/*Boutton nouveau évènement*/
			'new_item' => 'Nouveau évènement',

			/*Boutton voir tout les évènements existant*/
			'viex_item' => "Voir l'évènement",

			/*Placeholde de l'input de recherche*/
			'search_items' => 'Rechercher un évènement',

			/*Erreur quand il n'y à pas d'évènement de créer*/
			'not_found' => 'Aucun évènement trouver',

			/*Erreur quand il n'y à pas d'évènement dans la corbeille*/
			'not_found_in_trash' => 'Aucun évènement trouver dans la corbeille',

			'parent_item_colon' => '',

			/*Nom du plugin dans la sidebar*/
			'menu_name' => 'Évènements à venir',
		);

		/**
		*	Création d'un nouveau type de post.
		*
		*	@since 1.0.0
		*
		*	@param string $post_type  Nom du nouveau type de post
		*	@param array  $args 	  Arguments permettant de paramétrer le type de post
		*/
		register_post_type( "next_events", array(

			/*Visible par les auteurs*/
			'public' => true,

			/*Tout le monde peux voir les permaliens*/
			"publicly_queryable" => true,
			
			/*Les textes correspondants à chaque labels*/
			'labels' => $labels,

			/*Type de post*/
			"capability_type" => "post",

			/*Inputs wordpress authoriser*/
			"supports" => array('title', 'thumbnail', 'editor', 'post-formats'),

			/*Icones du plugin*/
			"menu_icon" => "dashicons-calendar-alt",

		) );
	}

	/* Fonction d'affichage des évènements à venir. */
	function next_events_show()
	{

		// Ont utilise FullCalendarJS pour afficher les futurs évènements dans le calendrier
		echo "<div id='calendar'></div>";

		// Le script php pour la récupération des posts
		require('script_fullcalendar.php');
	}

}

/*
-------------------Start of fields-------------------
*/

function next_events_admin_page()
{

	/**
	*	Création de l'onglet dans l'admin panel
	*
	*	@since 1.0.0
	*
	*	@var  $page_title Titre de la page
	*	@var  $menu_title Nom dans le menu
	*	@var  $capability Qui a accès à ce menu
	*	@var  $menu_slug Le slug du menu
	*	@var  $function La fonction qui va généré le contenu de la page
	*	@var  $icon_url Icon dans le menu
	*	@var  $position Position dans le menu
	*
	*	need to be 20 by 20 pixels
	*	get_template_directory_uri() . '/img/plant.png' . '?1.0.0'
	*/
	add_menu_page(
		'Configuration de Next Events', // Title dans la barre de chrome
		'Next Events', // titre de la page
		'manage_options',
		'settings_next_events', // id de la page
		'next_events_create_main_page',
		'dashicons-calendar-alt',
		150
	);

	add_action('admin_init', 'ne_custom_settings');

}

function ne_custom_settings()
{

	/*
		Needed functions for:
		
		Allday
		Time Format
		Slot duration
	*/

	/**
	*	@var $id String for use in the 'id' attribute of tags.
	*	@var $title Title of the section.
	*	@var $callback
	*	@var $page
	*/
	add_settings_section(
		'ne_settings_section',
		'', // Vide pas de nom de section
		'ne_section_gui',
		'settings_next_events' // Nom de la page mere
	);

	/*------------------------------------------------------*/

	// Currency
	add_settings_field(
		'ne_currency', // id du field
		'Choisissez votre devise', // titre
		'currency_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Languages
	add_settings_field(
		'language_ne', // id du field
		'Choisissez votre langue', // titre
		'locale_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Colors events
	add_settings_field(
		'colors_events_ne', // id du field
		'Choisissez la couleur des évènements', // titre
		'colors_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Select views
	add_settings_field(
		'views_events_ne', // id du field
		'Choisissez les vues que vous authorisé', // titre
		'views_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Start Day
	add_settings_field(
		'start_events_ne', // id du field
		"Heure à laquelle les journées commence", // titre
		'start_day_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// End Day
	add_settings_field(
		'end_events_ne', // id du field
		"Heure à laquelle les journées termine", // titre
		'end_day_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Numéro des semaines
	add_settings_field(
		'week_nbr_ne', // id du field
		"Voulez vous affiche les numéros des semaines ?", // titre
		'week_nbr_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Premier jours de la semaine
	add_settings_field(
		'first_day_ne', // id du field
		"Premier jour de la semaine", // titre
		'first_day_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// ON / OFF weekend
	add_settings_field(
		'weekend_ne', // id du field
		"Voulez vous voir les weekend ?", // titre
		'weekend_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Text Color
	add_settings_field(
		'text_color_ne', // id du field
		"Couleur du text", // titre
		'text_color_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	// Links Color
	add_settings_field(
		'links_colors_ne', // id du field
		"Couleur des liens", // titre
		'links_colors_gui', // callback
		'settings_next_events', // page mere
		'ne_settings_section' // id de la section
	);

	/*--------------------------------------------------------------*/

	/**
	*	@var champs_1 Id du groupe
	*	@var champs_2 Id du paramètre
	*/
	// Currency
	register_setting(
		'ne_settings_group',
		'default_price'
	);

	// Languages
	register_setting(
		'ne_settings_group',
		'locale_fc'
	);

	// Couleurs des events
	register_setting(
		'ne_settings_group',
		'colors_fc'
	);

	// Select views
	register_setting(
		'ne_settings_group',
		'views_1_fc'
	);
	register_setting(
		'ne_settings_group',
		'views_2_fc'
	);
	register_setting(
		'ne_settings_group',
		'views_3_fc'
	);
	register_setting(
		'ne_settings_group',
		'views_4_fc'
	);

	// Hour start of the day
	register_setting(
		'ne_settings_group',
		'hour_start_fc'
	);

	// Hour end of the day
	register_setting(
		'ne_settings_group',
		'hour_end_fc'
	);

	// Numéro de la semaine
	register_setting(
		'ne_settings_group',
		'week_nbr_fc'
	);

	// Premier jour de la semaine
	register_setting(
		'ne_settings_group',
		'first_day_fc'
	);

	// ON / OFF weekend
	register_setting(
		'ne_settings_group',
		'weekends_fc'
	);

	// Text color
	register_setting(
		'ne_settings_group',
		'text_color_fc'
	);

	// Links color
	register_setting(
		'ne_settings_group',
		'links_color_fc'
	);

}

function currency_gui()
{

	/*Currency*/
	echo ('
		<select name="default_price">
			<option value="€" selected>€ EUR</option>	/*Europe*/
	    	<option value="$">$ USD</option>	/*USA and other*/
	    	<option value="¥">¥ CNY</option>	/*China*/
	    	<option value="£">£ GBP</option>	/*UK*/
	    	<option value="¥">¥ JPY</option>	/*Japan*/
	    	<option value="₩">₩ KRW</option>	/*South Korea*/
	    	<option value="₹">₹ INR</option>	/*India*/
	    	<option value="R$">R$ BRL</option>	/*Brasil*/
	    	<option value="₪">₪ ILS</option>	/*Israel*/
	    	<option value="₽">₽ RUB</option>	/*Russia*/

	    	<option value="CHF">CHF</option>	/*Swissland*/
	    	<option value="DH">MAD</option>		/*Morocco*/
	    	<option value="DA">DZD</option>		/*Algeria*/
	    	<option value="DT">DT</option>		/*Tunisia*/
	    	<option value="AED">AED</option>	/*AED*/
	    </select>
    ');

}

function locale_gui()
{

	/*Locale*/
    echo ('
		<select name="locale_fc">
	      <option value="en">en</option>
	      <option value="af">af</option>
	      <option value="ar-dz">ar-dz</option>
	      <option value="ar-kw">ar-kw</option>
	      <option value="ar-ly">ar-ly</option>
	      <option value="ar-ma">ar-ma</option>
	      <option value="ar-sa">ar-sa</option>
	      <option value="ar-tn">ar-tn</option>
	      <option value="ar">ar</option>
	      <option value="bg">bg</option>
	      <option value="bs">bs</option>
	      <option value="ca">ca</option>
	      <option value="cs">cs</option>
	      <option value="da">da</option>
	      <option value="de-at">de-at</option>
	      <option value="de-ch">de-ch</option>
	      <option value="de">de</option>
	      <option value="el">el</option>
	      <option value="en-au">en-au</option>
	      <option value="en-ca">en-ca</option>
	      <option value="en-gb">en-gb</option>
	      <option value="en-ie">en-ie</option>
	      <option value="en-nz">en-nz</option>
	      <option value="es-do">es-do</option>
	      <option value="es-us">es-us</option>
	      <option value="es">es</option>
	      <option value="et">et</option>
	      <option value="eu">eu</option>
	      <option value="fa">fa</option>
	      <option value="fi">fi</option>
	      <option value="fr-ca">fr-ca</option>
	      <option value="fr-ch">fr-ch</option>
	      <option value="fr" selected>fr</option>
	      <option value="gl">gl</option>
	      <option value="he">he</option>
	      <option value="hi">hi</option>
	      <option value="hr">hr</option>
	      <option value="hu">hu</option>
	      <option value="id">id</option>
	      <option value="is">is</option>
	      <option value="it">it</option>
	      <option value="ja">ja</option>
	      <option value="ka">ka</option>
	      <option value="kk">kk</option>
	      <option value="ko">ko</option>
	      <option value="lb">lb</option>
	      <option value="lt">lt</option>
	      <option value="lv">lv</option>
	      <option value="mk">mk</option>
	      <option value="ms-my">ms-my</option>
	      <option value="ms">ms</option>
	      <option value="nb">nb</option>
	      <option value="nl-be">nl-be</option>
	      <option value="nl">nl</option>
	      <option value="nn">nn</option>
	      <option value="pl">pl</option>
	      <option value="pt-br">pt-br</option>
	      <option value="pt">pt</option>
	      <option value="ro">ro</option>
	      <option value="ru">ru</option>
	      <option value="sk">sk</option>
	      <option value="sl">sl</option>
	      <option value="sq">sq</option>
	      <option value="sr-cyrl">sr-cyrl</option>
	      <option value="sr">sr</option>
	      <option value="sv">sv</option>
	      <option value="th">th</option>
	      <option value="tr">tr</option>
	      <option value="uk">uk</option>
	      <option value="vi">vi</option>
	      <option value="zh-cn">zh-cn</option>
	      <option value="zh-tw">zh-tw</option>
	    </select>
    ');

}

function colors_gui()
{
	echo "<div style='display: grid; grid-template-columns: auto auto auto auto auto;'>";

	/*Color 1*/
	echo "<div style='padding-bottom: 3em;'><label for='color_1' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #FF5D73;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_1' name='colors_fc' value='#FF5D73'";
		if (esc_attr(get_option('colors_fc')) == '#FF5D73')
		{
			echo "checked";
		}
	echo "></div>";

	/*Color 2*/
	echo "<div style='padding-bottom: 3em;'><label for='color_2' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #63c095;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_2' name='colors_fc' value='#63c095'";
		if (esc_attr(get_option('colors_fc')) == '#63c095')
		{
			echo "checked";
		}
	echo "></div>";

	/*Color 3*/
	echo "<div style='padding-bottom: 3em;'><label for='color_3' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #11c2e3;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_3' name='colors_fc' value='#11c2e3'";
		if (esc_attr(get_option('colors_fc')) == '#11c2e3')
		{
			echo "checked";
		}
	echo "></div>";

	/*Color 4*/
	echo "<div style='padding-bottom: 3em;'><label for='color_4' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #3c9ccf;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_4' name='colors_fc' value='#3c9ccf'";
		if (esc_attr(get_option('colors_fc')) == '#3c9ccf')
		{
			echo "checked";
		}
	echo "></div> ";

	/*Color 5*/
	echo "<div style='padding-bottom: 3em;'><label for='color_5' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #fbd582;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_5' name='colors_fc' value='#fbd582'";
		if (esc_attr(get_option('colors_fc')) == '#fbd582')
		{
			echo "checked";
		}
	echo "></div> ";

	/*Color 6*/
	echo "<div style='padding-bottom: 3em;'><label for='color_6' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #ffc376;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_6' name='colors_fc' value='#ffc376'";
		if (esc_attr(get_option('colors_fc')) == '#ffc376')
		{
			echo "checked";
		}
	echo "></div> ";

	/*Color 7*/
	echo "<div style='padding-bottom: 3em;'><label for='color_7' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #f4a86a;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_7' name='colors_fc' value='#f4a86a'";
		if (esc_attr(get_option('colors_fc')) == '#f4a86a')
		{
			echo "checked";
		}
	echo "></div> ";

	/*Color 8*/
	echo "<div style='padding-bottom: 3em;'><label for='color_8' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #f4816a;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_8' name='colors_fc' value='#f4816a'";
		if (esc_attr(get_option('colors_fc')) == '#f4816a')
		{
			echo "checked";
		}
	echo "></div> ";

	/*Color 9*/
	echo "<div style='padding-bottom: 3em;'><label for='color_9' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #88cfe1;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_9' name='colors_fc' value='#88cfe1'";
		if (esc_attr(get_option('colors_fc')) == '#88cfe1')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "</div>";

}

function views_gui()
{

	/*CheckBox 1*/
	echo " <div style='padding-bottom: 0.75em;'> <input type='checkbox' id='check_1' name='views_1_fc' value='agendaDay' ";
		if (esc_attr(get_option('views_1_fc')) == 'agendaDay')
		{
			echo "checked";
		}
	echo " > <label for='check_1'>Quotidien</label> </div>";

	/*CheckBox 2*/
	echo "	<div style='padding-bottom: 0.75em;'> <input type='checkbox' id='check_2' name='views_2_fc' value='agendaWeek' ";
		if (esc_attr(get_option('views_2_fc')) == 'agendaWeek')
		{
			echo "checked";
		}
	echo "	> <label for='check_2'>Hebdomadaire</label> </div> ";

	/*CheckBox 3*/
	echo "	<div style='padding-bottom: 0.75em;'> <input type='checkbox' id='check_3' name='views_3_fc' value='month'";
		if (esc_attr(get_option('views_3_fc')) == 'month')
		{
			echo "checked";
		}
	echo "	> <label for='check_3'>Mensuel</label> </div>";

	/*CheckBox 4*/
	echo "	<div style='padding-bottom: 0.75em;'> <input type='checkbox' id='check_4' name='views_4_fc' value='listWeek' ";
		if (esc_attr(get_option('views_4_fc')) == 'listWeek')
		{
			echo "checked";
		}
	echo "	> <label for='check_4'>Planning</label> </div> ";
}

function start_day_gui()
{
	// 07:30
	echo "<input type='time' name='hour_start_fc' min='07:00' max='13:00' value='";
		if (esc_attr(get_option('hour_start_fc')))
		{
			echo esc_attr(get_option('hour_start_fc'));
		}
		else
		{
			echo '08:00';
		}
	echo "'>";

	echo "<br><p class='description'>Par defaut 08:00</p>";
}

function end_day_gui()
{
	echo "<input type='time' name='hour_end_fc' min='11:00' max='20:00' value='";
		if (esc_attr(get_option('hour_end_fc')))
		{
			echo esc_attr(get_option('hour_end_fc'));
		}
		else
		{
			echo '18:00';
		}
	echo "'>";

	echo "<br><p class='description'>Par defaut 18:00</p>";
}

function week_nbr_gui()
{
	$statuts_week_numbers = esc_attr(get_option('week_nbr_fc'));

	echo " <div style='padding-bottom: 0.75em;'> <label for='true_week_nbr'>Activer</label> <input type='radio' id='true_week_nbr' name='week_nbr_fc' value='true' ";

		if ($statuts_week_numbers == 'true')
		{
			echo "checked";
		}

	echo " > ";

	echo " <label for='false_week_nbr'>Désactiver</label> <input type='radio' id='false_week_nbr' name='week_nbr_fc' value='false' ";

		if ($statuts_week_numbers == 'false')
		{
			echo "checked";
		}

	echo "> </div> ";
}

function first_day_gui()
{
	echo '
		<select name="first_day_fc">

	      <option value="1" selected>Lundi</option>
	      <option value="2">Mardi</option>

	      <option value="3">Mercredi</option>
	      <option value="4">Jeudi</option>

	      <option value="5">Vendredi</option>
	      <option value="6">Samedi</option>

	      <option value="7">Dimanche</option>

	    </select>
	';
}

function weekend_gui()
{
	$status_weekend = esc_attr(get_option('weekends_fc'));

	echo " <div style='padding-bottom: 0.75em;'> <label for='enable_weekend'>Activer</label> <input type='radio' id='enable_weekend' name='weekends_fc' value='true' ";

		if ($status_weekend == 'true')
		{
			echo "checked";
		}

	echo ">";

	echo "  <label for='disable_weekend'>Désactiver</label> <input type='radio' id='disable_weekend' name='weekends_fc' value='false' ";

		if ($status_weekend == 'false')
		{
			echo "checked";
		}

	echo " > </div>";
}

function text_color_gui()
{
	$text_color_var = esc_attr(get_option('text_color_fc'));

	echo "<div style='display: grid; grid-template-columns: auto auto auto auto auto;'>";

	echo "<div style='padding-bottom: 3em;'><label for='color_text_1' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #ffffff;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_text_1' name='text_color_fc' value='#ffffff'";
		if (esc_attr(get_option('text_color_fc')) == '#ffffff')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "<div style='padding-bottom: 3em;'><label for='color_text_2' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #6B6B6B;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_text_2' name='text_color_fc' value='#6B6B6B'";
		if (esc_attr(get_option('text_color_fc')) == '#6B6B6B')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "<div style='padding-bottom: 3em;'><label for='color_text_3' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #000000;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_text_3' name='text_color_fc' value='#000000'";
		if (esc_attr(get_option('text_color_fc')) == '#000000')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "</div> ";

}

function links_colors_gui()
{
	$links_color_var = esc_attr(get_option('links_color_fc'));

	echo "<div style='display: grid; grid-template-columns: auto auto auto auto auto;'>";

	echo "<div style='padding-bottom: 3em;'><label for='color_links_1' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #ffffff;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_links_1' name='links_color_fc' value='#ffffff'";
		if (esc_attr(get_option('links_color_fc')) == '#ffffff')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "<div style='padding-bottom: 3em;'><label for='color_links_2' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #6B6B6B;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_links_2' name='links_color_fc' value='#6B6B6B'";
		if (esc_attr(get_option('links_color_fc')) == '#6B6B6B')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "<div style='padding-bottom: 3em;'><label for='color_links_3' style='margin-right: 3%; padding-bottom: 1.5em; background-color: #000000;'>&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</label><input type='radio' id='color_links_3' name='links_color_fc' value='#000000'";
		if (esc_attr(get_option('links_color_fc')) == '#000000')
		{
			echo "checked";
		}
	echo "></div> ";

	echo "</div> ";

}

// GUI de la section
function ne_section_gui()
{
	// Vide car ont ne veut pas de titre de section
	echo '';
}

// Lance NextEvents Admin Page
add_action( 'admin_menu', 'next_events_admin_page' );

/*
-------------------End of fields-------------------
*/

function next_events_create_main_page()
{

	require('main_admin_render.php');

}

/**
*	Encapsulation de la fonction 'next_events_show' pour être utilisé par la fonction add_shortcode.
*
*	@since 1.0.0
*/
function next_events_calendar()
{
	$next_events = new NextEvents;
	$next_events->next_events_show();
}

/**
*	Création du shortcode pour la fonction 'next_events_calendar'.
*
*	@since 1.0.0
*
*	@param string      $tag    Nom donner au shortcode
*	@param string      $func   Nom de la fonction exécuté par le shortcode
*
*/
add_shortcode($tag = 'next_events', $func = 'next_events_calendar');

/*-------------NextEvents Custom Input-------------*/

class Next_Events_Metabox
{
	private $screen = array(
		'next_events',
	);
	private $meta_fields = array(
		array(
			'label' => 'Date de départ',
			'id' => 'event_date_start',
			'type' => 'date',
		),
		array(
			'label' => 'Heure de départ',
			'id' => 'heure_de_debut',
			'type' => 'time',
		),
		array(
			'label' => 'Date de fin',
			'id' => 'event_date_end',
			'type' => 'date',
		),
		array(
			'label' => 'Heure de fin',
			'id' => 'heure_de_fin',
			'type' => 'time',
		),
		array(
			'label' => 'Coût de participation',
			'id' => 'price',
			'default' => '0',
			'type' => 'number',
		),
		array(
			'label' => 'Lieu',
			'id' => 'lieu',
			'type' => 'text',
		),
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'champs',
				__( 'Informations', 'textdomain' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'champs_data', 'champs_nonce' );
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s" required>',
						$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}
	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['champs_nonce'] ) )
			return $post_id;
		$nonce = $_POST['champs_nonce'];
		if ( !wp_verify_nonce( $nonce, 'champs_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('Next_Events_Metabox')) {
	new Next_Events_Metabox;
};