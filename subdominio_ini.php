<?
include('conexion.php');
$subdominio = mysql_real_escape_string($_GET['subdominio']);
$usuario = (int) mysql_real_escape_string($_GET['usuario']);
$version = (int) mysql_real_escape_string($_GET['v']);
// var_dump($_GET); // Ivivanco or imm

// Determina la localización del prospecto
// $user_ip = getenv('REMOTE_ADDR');
// $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
// $city = $geo["geoplugin_city"];
// $region = $geo["geoplugin_regionName"];
// $country = $geo["geoplugin_countryName"];

$ip = $_SERVER['HTTP_CF_CONNECTING_IP']; // '124.109.48.236';
$http_sec_fetch_site = $_SERVER['HTTP_SEC_FETCH_SITE']; //http_sec_fetch_site
// http://www.geoplugin.net/extras/nearby.gp?ip=
// https://ipinfo.io/37.111.225.191/json
$token = 'fa915079cae29a';
$url = "https://ipinfo.io/{$ip}?token={$token}";
$json = file_get_contents($url);
$ip_data = json_decode($json);
// $location = $ip_data->region . ", " . $ip_data->country;
// var_dump($ip_data);
// exit();

$geo["geoplugin_countryName"] = $ip_data->country;
$geo["geoplugin_city"] = $ip_data->city;
$geo["geoplugin_regionName"] = $ip_data->region;


$admin = $_SESSION['admin_valido'];
$landing = (int) mysql_real_escape_string($_GET['landing']);
// var_dump($admin, $landing); exit(); // NULL int(0)
if (!empty($landing) and !empty($admin)) {
	// si se ejecuta desde el administrador de templates
	// var_dump($admin, $landing); exit(); // NULL int(0)

	$resLAN = mysql_query("SELECT * FROM landing_page WHERE clave = $landing", $conexion);
	$rowLAN = mysql_fetch_array($resLAN);

	$autoresponders = $rowLAN['autoresponders'];
	$videos = $rowLAN['videos'];
	$subdominio_idioma = $rowLAN['subdominio_idioma'];
	$titulo = $rowLAN['titulo'];
	$titulo_en = $rowLAN['titulo_en'];
	$subtitulo = $rowLAN['subtitulo'];
	$subtitulo_en = $rowLAN['subtitulo_en'];
	$descripcion = $rowLAN['descripcion'];
	$descripcion_en = $rowLAN['descripcion_en'];
	$puntos = $rowLAN['puntos'];
	$puntos_en = $rowLAN['puntos_en'];
	$array_puntos = explode(chr(10), $puntos);
	$array_puntos_en = explode(chr(10), $puntos_en);
	$video = $rowLAN['video'];
	$video_en = $rowLAN['video_en'];
	$titulo_formulario = $rowLAN['titulo_formulario'];
	$titulo_formulario_en = $rowLAN['titulo_formulario_en'];
	$texto_formulario = $rowLAN['texto_formulario'];
	$texto_formulario_en = $rowLAN['texto_formulario_en'];
	$boton = $rowLAN['boton'];
	$boton_en = $rowLAN['boton_en'];


	//testing variable
	$boton_en1 = $boton_en;



	$bg_video = $rowLAN['bg_video'];
	//backgound color
	$logo_section_bg = $rowLAN['logo_section_bg'];
	$title_section_bg = $rowLAN['title_section_bg'];
	$subtitle_section_bg = $rowLAN['subtitle_section_bg'];
	$form_title_bg = $rowLAN['form_title_bg'];
	$form_subtitle_bg = $rowLAN['form_subtitle_bg'];
	$form_input_name_placeholder = $rowLAN['form_input_name_placeholder'];
	$form_input_email_placeholder = $rowLAN['form_input_email_placeholder'];
	$form_input_whatsapp_placeholder = $rowLAN['form_input_whatsapp_placeholder'];
	$form_input_whatsapp_visible = $rowLAN['form_input_whatsapp_visible'];
	$background_image_library_url = $rowLAN['background_image_library_url'];
	$footer_section_bg = $rowLAN['footer_section_bg'];
	$form_section_bg = $rowLAN['form_section_bg'];
	$form_submit_button_bg = $rowLAN['form_submit_button_bg'];
	$textarea_section_bg = $rowLAN['textarea_section_bg'];
	$bulleted_area_section_bg = $rowLAN['bulleted_area_section_bg'];
	$slider_images_list = $rowLAN['slider_images_list'];
	$short_length_cta_button_text = $rowLAN['short_length_cta_button_text'];
	$short_length_cta_button_bg = $rowLAN['short_length_cta_button_bg'];
	$full_length_cta_button_text = $rowLAN['full_length_cta_button_text'];
	$full_length_cta_button_bg = $rowLAN['full_length_cta_button_bg'];
	$subdominio_textarea1 = $rowLAN['subdominio_textarea1'];
	$subdominio_textarea2 = $rowLAN['subdominio_textarea2'];
	$subdominio_textarea1_bg = $rowLAN['subdominio_textarea1_bg'];
	$subdominio_textarea2_bg = $rowLAN['subdominio_textarea2_bg'];
	$subdominio_box1_image = $rowLAN['subdominio_box1_image'];
	$subdominio_box2_image = $rowLAN['subdominio_box2_image'];
	$subdominio_box3_image = $rowLAN['subdominio_box3_image'];
	$footer_show_hide = $rowLAN['footer_show_hide'];
	$phone_number_required = $rowLAN['phone_number_required'];
	$footer_show_hide_en = $rowLAN['footer_show_hide_en'];
	$phone_number_required_en = $rowLAN['phone_number_required_en'];


	$logo_section_bg_en = $rowLAN['logo_section_bg_en'];
	$title_section_bg_en = $rowLAN['title_section_bg_en'];
	$subtitle_section_bg_en = $rowLAN['subtitle_section_bg_en'];
	$form_title_bg_en = $rowLAN['form_title_bg_en'];
	$form_subtitle_bg_en = $rowLAN['form_subtitle_bg_en'];
	$form_input_name_placeholder_en = $rowLAN['form_input_name_placeholder_en'];
	$form_input_email_placeholder_en = $rowLAN['form_input_email_placeholder_en'];
	$form_input_whatsapp_placeholder_en = $rowLAN['form_input_whatsapp_placeholder_en'];
	$form_input_whatsapp_visible_en = $rowLAN['form_input_whatsapp_visible_en'];
	$background_image_library_url_en = $rowLAN['background_image_library_url_en'];
	$footer_section_bg_en = $rowLAN['footer_section_bg_en'];
	$form_section_bg_en = $rowLAN['form_section_bg_en'];
	$form_submit_button_bg_en = $rowLAN['form_submit_button_bg_en'];
	$textarea_section_bg_en = $rowLAN['textarea_section_bg_en'];
	$bulleted_area_section_bg_en = $rowLAN['bulleted_area_section_bg_en'];
	$slider_images_list_en = $rowLAN['slider_images_list_en'];
	$short_length_cta_button_text_en = $rowLAN['short_length_cta_button_text_en'];
	$short_length_cta_button_bg_en = $rowLAN['short_length_cta_button_bg_en'];
	$full_length_cta_button_text_en = $rowLAN['full_length_cta_button_text_en'];
	$full_length_cta_button_bg_en = $rowLAN['full_length_cta_button_bg_en'];
	$subdominio_textarea1_en = $rowLAN['subdominio_textarea1_en'];
	$subdominio_textarea2_en = $rowLAN['subdominio_textarea2_en'];
	$subdominio_textarea1_bg_en = $rowLAN['subdominio_textarea1_bg_en'];
	$subdominio_textarea2_bg_en = $rowLAN['subdominio_textarea2_bg_en'];
	$subdominio_box1_image_en = $rowLAN['subdominio_box1_image_en'];
	$subdominio_box2_image_en = $rowLAN['subdominio_box2_image_en'];
	$subdominio_box3_image_en = $rowLAN['subdominio_box3_image_en'];
	$subdominio_body_background_color = $rowLAN['subdominio_body_background_color'];
	$subdominio_footer_description = $rowLAN['subdominio_footer_description'];
	$subdominio_footer_description_en = $rowLAN['subdominio_footer_description_en'];
	$subdominio_box1_image_description = $rowLAN['subdominio_box1_image_description'];
	$subdominio_box2_image_description = $rowLAN['subdominio_box2_image_description'];
	$subdominio_box3_image_description = $rowLAN['subdominio_box3_image_description'];
	$subdominio_webinar_presentador1_title = $rowLAN['subdominio_webinar_presentador1_title'];
	$subdominio_webinar_presentador2_title = $rowLAN['subdominio_webinar_presentador2_title'];
	$subdominio_single_image_description = $rowLAN['subdominio_single_image_description'];
	$subdominio_footer_links = $rowLAN['subdominio_footer_links'];
	$single_image_description_bg = $rowLAN['single_image_description_bg'];
	$single_image_description_bg_en = $rowLAN['single_image_description_bg_en'];

	$subdominio_box1_image_description_en = $rowLAN['subdominio_box1_image_description_en'];
	$subdominio_box2_image_description_en = $rowLAN['subdominio_box2_image_description_en'];
	$subdominio_box3_image_description_en = $rowLAN['subdominio_box3_image_description_en'];
	$subdominio_webinar_presentador1_title_en = $rowLAN['subdominio_webinar_presentador1_title_en'];
	$subdominio_webinar_presentador2_title_en = $rowLAN['subdominio_webinar_presentador2_title_en'];
	$subdominio_single_image_description_en = $rowLAN['subdominio_single_image_description_en'];
	$subdominio_footer_links_en = $rowLAN['subdominio_footer_links_en'];


	$tour_titulo1 = $rowLAN['tour_titulo1'];
	$tour_video1 = $rowLAN['tour_video1'];
	$tour_tiempo1 = $rowLAN['tour_tiempo1'];
	$tour_titulo2 = $rowLAN['tour_titulo2'];
	$tour_video2 = $rowLAN['tour_video2'];
	$tour_tiempo2 = $rowLAN['tour_tiempo2'];
	$tour_titulo3 = $rowLAN['tour_titulo3'];
	$tour_video3 = $rowLAN['tour_video3'];
	$tour_tiempo3 = $rowLAN['tour_tiempo3'];
	$tour_titulo4 = $rowLAN['tour_titulo4'];
	$tour_video4 = $rowLAN['tour_video4'];
	$tour_tiempo4 = $rowLAN['tour_tiempo4'];
	$tour_titulo5 = $rowLAN['tour_titulo5'];
	$tour_video5 = $rowLAN['tour_video5'];
	$tour_tiempo5 = $rowLAN['tour_tiempo5'];
	$tour_titulo6 = $rowLAN['tour_titulo6'];
	$tour_video6 = $rowLAN['tour_video6'];
	$tour_tiempo6 = $rowLAN['tour_tiempo6'];

	$tour_titulo1_en = $rowLAN['tour_titulo1_en'];
	$tour_video1_en = $rowLAN['tour_video1_en'];
	$tour_tiempo1_en = $rowLAN['tour_tiempo1_en'];
	$tour_titulo2_en = $rowLAN['tour_titulo2_en'];
	$tour_video2_en = $rowLAN['tour_video2_en'];
	$tour_tiempo2_en = $rowLAN['tour_tiempo2_en'];
	$tour_titulo3_en = $rowLAN['tour_titulo3_en'];
	$tour_video3_en = $rowLAN['tour_video3_en'];
	$tour_tiempo3_en = $rowLAN['tour_tiempo3_en'];
	$tour_titulo4_en = $rowLAN['tour_titulo4_en'];
	$tour_video4_en = $rowLAN['tour_video4_en'];
	$tour_tiempo4_en = $rowLAN['tour_tiempo4_en'];
	$tour_titulo5_en = $rowLAN['tour_titulo5_en'];
	$tour_video5_en = $rowLAN['tour_video5_en'];
	$tour_tiempo5_en = $rowLAN['tour_tiempo5_en'];
	$tour_titulo6_en = $rowLAN['tour_titulo6_en'];
	$tour_video6_en = $rowLAN['tour_video6_en'];
	$tour_tiempo6_en = $rowLAN['tour_tiempo6_en'];

	$comments_id = $rowLAN['comments_id'];
	$fbcomments_app = $rowLAN['fbcomments_app'];

	$subdominio_mes = $rowLAN['subdominio_mes'];
	$subdominio_dia = $rowLAN['subdominio_dia'];
	$subdominio_ano = $rowLAN['subdominio_ano'];
	$subdominio_hora = $rowLAN['subdominio_hora'];
	$subdominio_minuto = $rowLAN['subdominio_minuto'];
	$landing_page_cta_button_timer_en = $rowLAN['landing_page_cta_button_timer_en'];
	$landing_page_cta_button_timer = $rowLAN['landing_page_cta_button_timer'];
	$youtube_bg = $rowLAN['youtube_bg'];
	$youtube_bg_en = $rowLAN['youtube_bg_en'];


	// busca si tiene logotipo
	$dir = '../../images/templates/';
	if (file_exists($dir . $landing . '.jpg')) $logotipo = '<img class="logo" src="' . $dir . $landing . '.jpg" alt="">';
	elseif (file_exists($dir . $landing . '.gif')) $logotipo = '<img class="logo" src="' . $dir . $landing . '.gif" alt="">';
	elseif (file_exists($dir . $landing . '.png')) $logotipo = '<img class="logo" src="' . $dir . $landing . '.png" alt="">';
	else $logotipo = '<img class="logo" src="../../images/landingpage/logo.png" width="170" height="53" alt="">';

	if (file_exists($dir . $landing . '_en.jpg')) $logotipo_en = '<img class="logo" src="' . $dir . $landing . '_en.jpg" alt="">';
	elseif (file_exists($dir . $landing . '_en.gif')) $logotipo_en = '<img class="logo" src="' . $dir . $landing . '_en.gif" alt="">';
	elseif (file_exists($dir . $landing . '_en.png')) $logotipo_en = '<img class="logo" src="' . $dir . $landing . '_en.png" alt="">';
	else $logotipo_en = '<img class="logo" src="../../images/landingpage/logo.png" width="170" height="53" alt="">';
} else {  // si se ejecuta desde el subdominio


	if ($usuario > 0) {  // si es preview desde el perfil
		$resUSU = mysql_query("SELECT * FROM usuario WHERE clave=$usuario", $conexion);
		$test = $usuario;
		$rowUSU = mysql_fetch_array($resUSU);
	} else {

		$resUSU = mysql_query("SELECT * FROM usuario WHERE subdominio='$subdominio'", $conexion);
		$rowUSU = mysql_fetch_array($resUSU);
		$usuario = $rowUSU['clave']; // echo $usuario . " - " . $template; exit; // 1317 - 165




		// si no es un subdominio válido, va al home
		if (mysql_num_rows($resUSU) <= 0 or empty($subdominio)) header('Location: ../../principal.php');

		// acumula la visita
		$resHIT = mysql_query("SELECT * FROM template_hits WHERE usuario=$usuario AND template=$template", $conexion);
		$rowHIT = mysql_fetch_array($resHIT);
		if (mysql_num_rows($resHIT) > 0) { // acumula la visita
			$resultado = mysql_query("UPDATE template_hits SET visitas=visitas+1 WHERE usuario=$usuario AND template=$template", $conexion);
			//-----subroto-16-feb-2017-start-----------------//
			$resultado1 = mysql_query("INSERT template_hits_detail (user_id, template_id) VALUES ($usuario, $template)", $conexion);
			//-----subroto-16-feb-2017-end-----------------//
		} else {  // registra la primera visita
			$resultado = mysql_query("INSERT template_hits (usuario, template, visitas) VALUES ($usuario, $template, 1)", $conexion);
		}

		// actualiza el last template
		$resultado = mysql_query("UPDATE usuario SET subdominio_template_last=$template, act=1-act WHERE clave=$usuario", $conexion);
		// var_dump("UPDATE usuario SET subdominio_template_last=$template, act=1-act WHERE clave=$usuario"); exit("a");
		// "UPDATE usuario SET subdominio_template_last=165, act=1-act WHERE clave=11718"
		if ($template > 164) {
			$resultado12 = mysql_query("UPDATE usuario SET subdominio_template_last_beta=$template, act=1-act WHERE clave=$usuario", $conexion);
		}

		// determina si muestra los datos version 1 o 2 de su propio perfil, o los datos de un template grupal

		$version = 0;
		// var_dump($rowUSU['subdominio_templates'], $rowUSU['subdominio_custom']); exit("b");
		// string(4) " 74," string(1) "1" - imm
		// string(2) "19" string(1) "0"
		// string(3) "162" string(1) "1" - ebook
		// string(3) "162" string(1) "0" - elebook
		// string(3) "162" string(1) "0" b
		// si no tiene templates definidos en el perfil, usa la version 1
		if (!empty($rowUSU['subdominio_templates']) and $rowUSU['subdominio_custom'] == 1) {
			//				if($rowUSU['subdominio_templates_beta'] != ""){
			//                    $templates=explode(',',$rowUSU['subdominio_templates_beta']);
			//				}else{
			$templates = explode(',', $rowUSU['subdominio_templates']);
			//				}
			if ($templates[0] == $template) $version = 1;
			elseif ($templates[1] == $template) $version = 2;
			else $version = 1;
		}

		// var_dump($version);	 exit();

	}

	/*
		// revisa si el usuario tiene asignado un template, si no, usa el template principal
		$landing = $rowUSU['template'];
		if (!empty($landing)) {
			$resLAN = mysql_query("SELECT * FROM landing_page WHERE clave = $landing",$conexion);
			$rowLAN = mysql_fetch_array($resLAN);		
		} else {
			$resLAN = mysql_query("SELECT * FROM landing_page WHERE principal = 1",$conexion);
			$rowLAN = mysql_fetch_array($resLAN);
			$landing = $rowLAN['clave'];
		}
*/

	$resLAN = mysql_query("SELECT * FROM landing_page WHERE principal = 1", $conexion);
	$rowLAN = mysql_fetch_array($resLAN);

	if ($version == 1 or $version == 0) {

		if ($rowUSU['subdominio_custom'] == 0) {
			$tem = $rowLAN['clave'];
			$autoresponders = $rowLAN['autoresponders'];
			$videos = $rowLAN['videos'];
			$subdominio_idioma = $rowLAN['subdominio_idioma'];
			$titulo = $rowLAN['titulo'];
			$titulo_en = $rowLAN['titulo_en'];
			$subtitulo = $rowLAN['subtitulo'];
			$subtitulo_en = $rowLAN['subtitulo_en'];
			$descripcion = $rowLAN['descripcion'];
			$descripcion_en = $rowLAN['descripcion_en'];
			$puntos = $rowLAN['puntos'];
			$array_puntos = explode(chr(10), $puntos);
			$puntos_en = $rowLAN['puntos_en'];
			$array_puntos_en = explode(chr(10), $puntos_en);
			$video = $rowLAN['video'];
			$video_en = $rowLAN['video_en'];
			$titulo_formulario = $rowLAN['titulo_formulario'];
			$titulo_formulario_en = $rowLAN['titulo_formulario_en'];
			$texto_formulario = $rowLAN['texto_formulario'];
			$texto_formulario_en = $rowLAN['texto_formulario_en'];
			$boton = $rowLAN['boton'];
			$boton_en = $rowLAN['boton_en'];

			//testing variable
			$boton_en2 = $boton_en;


			$bg_video = $rowLAN['bg_video'];

			//backgound color
			$logo_section_bg = $rowLAN['logo_section_bg'];
			$title_section_bg = $rowLAN['title_section_bg'];
			$subtitle_section_bg = $rowLAN['subtitle_section_bg'];
			$form_title_bg = $rowLAN['form_title_bg'];
			$form_subtitle_bg = $rowLAN['form_subtitle_bg'];
			$form_input_name_placeholder = $rowLAN['form_input_name_placeholder'];
			$form_input_email_placeholder = $rowLAN['form_input_email_placeholder'];
			$form_input_whatsapp_placeholder = $rowLAN['form_input_whatsapp_placeholder'];
			$form_input_whatsapp_visible = $rowLAN['form_input_whatsapp_visible'];
			$background_image_library_url = $rowLAN['background_image_library_url'];
			$footer_section_bg = $rowLAN['footer_section_bg'];
			$form_section_bg = $rowLAN['form_section_bg'];
			$form_submit_button_bg = $rowLAN['form_submit_button_bg'];
			$textarea_section_bg = $rowLAN['textarea_section_bg'];
			$bulleted_area_section_bg = $rowLAN['bulleted_area_section_bg'];
			$short_length_cta_button_text = $rowLAN['short_length_cta_button_text'];
			$short_length_cta_button_bg = $rowLAN['short_length_cta_button_bg'];
			$full_length_cta_button_text = $rowLAN['full_length_cta_button_text'];
			$full_length_cta_button_bg = $rowLAN['full_length_cta_button_bg'];
			$subdominio_textarea1 = $rowLAN['subdominio_textarea1'];
			$subdominio_textarea2 = $rowLAN['subdominio_textarea2'];
			$subdominio_textarea1_bg = $rowLAN['subdominio_textarea1_bg'];
			$subdominio_textarea2_bg = $rowLAN['subdominio_textarea2_bg'];
			$subdominio_box1_image = $rowLAN['subdominio_box1_image'];
			$subdominio_box2_image = $rowLAN['subdominio_box2_image'];
			$subdominio_box3_image = $rowLAN['subdominio_box3_image'];
			$footer_show_hide = $rowLAN['footer_show_hide'];
			$phone_number_required = $rowLAN['phone_number_required'];
			$footer_show_hide_en = $rowLAN['footer_show_hide_en'];
			$phone_number_required_en = $rowLAN['phone_number_required_en'];

			$logo_section_bg_en = $rowLAN['logo_section_bg_en'];
			$title_section_bg_en = $rowLAN['title_section_bg_en'];
			$subtitle_section_bg_en = $rowLAN['subtitle_section_bg_en'];
			$form_title_bg_en = $rowLAN['form_title_bg_en'];
			$form_subtitle_bg_en = $rowLAN['form_subtitle_bg_en'];
			$form_input_name_placeholder_en = $rowLAN['form_input_name_placeholder_en'];
			$form_input_email_placeholder_en = $rowLAN['form_input_email_placeholder_en'];
			$form_input_whatsapp_placeholder_en = $rowLAN['form_input_whatsapp_placeholder_en'];
			$form_input_whatsapp_visible_en = $rowLAN['form_input_whatsapp_visible_en'];
			$background_image_library_url_en = $rowLAN['background_image_library_url_en'];
			$footer_section_bg_en = $rowLAN['footer_section_bg_en'];
			$form_section_bg_en = $rowLAN['form_section_bg_en'];
			$form_submit_button_bg_en = $rowLAN['form_submit_button_bg_en'];
			$textarea_section_bg_en = $rowLAN['textarea_section_bg_en'];
			$bulleted_area_section_bg_en = $rowLAN['bulleted_area_section_bg_en'];
			$slider_images_list_en = $rowLAN['slider_images_list_en'];
			$short_length_cta_button_text_en = $rowLAN['short_length_cta_button_text_en'];
			$short_length_cta_button_bg_en = $rowLAN['short_length_cta_button_bg_en'];
			$full_length_cta_button_text_en = $rowLAN['full_length_cta_button_text_en'];
			$full_length_cta_button_bg_en = $rowLAN['full_length_cta_button_bg_en'];
			$subdominio_textarea1_en = $rowLAN['subdominio_textarea1_en'];
			$subdominio_textarea2_en = $rowLAN['subdominio_textarea2_en'];
			$subdominio_textarea1_bg_en = $rowLAN['subdominio_textarea1_bg_en'];
			$subdominio_textarea2_bg_en = $rowLAN['subdominio_textarea2_bg_en'];
			$subdominio_box1_image_en = $rowLAN['subdominio_box1_image_en'];
			$subdominio_box2_image_en = $rowLAN['subdominio_box2_image_en'];
			$subdominio_box3_image_en = $rowLAN['subdominio_box3_image_en'];
			$subdominio_body_background_color = $rowLAN['subdominio_body_background_color'];
			$subdominio_footer_description = $rowLAN['subdominio_footer_description'];
			$subdominio_footer_description_en = $rowLAN['subdominio_footer_description_en'];
			$subdominio_box1_image_description = $rowLAN['subdominio_box1_image_description'];
			$subdominio_box2_image_description = $rowLAN['subdominio_box2_image_description'];
			$subdominio_box3_image_description = $rowLAN['subdominio_box3_image_description'];
			$subdominio_webinar_presentador1_title = $rowLAN['subdominio_webinar_presentador1_title'];
			$subdominio_webinar_presentador2_title = $rowLAN['subdominio_webinar_presentador2_title'];
			$subdominio_single_image_description = $rowLAN['subdominio_single_image_description'];
			$subdominio_footer_links = $rowLAN['subdominio_footer_links'];
			$single_image_description_bg = $rowLAN['single_image_description_bg'];
			$single_image_description_bg_en = $rowLAN['single_image_description_bg_en'];

			$subdominio_box1_image_description_en = $rowLAN['subdominio_box1_image_description_en'];
			$subdominio_box2_image_description_en = $rowLAN['subdominio_box2_image_description_en'];
			$subdominio_box3_image_description_en = $rowLAN['subdominio_box3_image_description_en'];
			$subdominio_webinar_presentador1_title_en = $rowLAN['subdominio_webinar_presentador1_title_en'];
			$subdominio_webinar_presentador2_title_en = $rowLAN['subdominio_webinar_presentador2_title_en'];
			$subdominio_single_image_description_en = $rowLAN['subdominio_single_image_description_en'];
			$subdominio_footer_links_en = $rowLAN['subdominio_footer_links_en'];

			$tour_titulo1 = $rowLAN['tour_titulo1'];
			$tour_video1 = $rowLAN['tour_video1'];
			$tour_tiempo1 = $rowLAN['tour_tiempo1'];
			$tour_titulo2 = $rowLAN['tour_titulo2'];
			$tour_video2 = $rowLAN['tour_video2'];
			$tour_tiempo2 = $rowLAN['tour_tiempo2'];
			$tour_titulo3 = $rowLAN['tour_titulo3'];
			$tour_video3 = $rowLAN['tour_video3'];
			$tour_tiempo3 = $rowLAN['tour_tiempo3'];
			$tour_titulo4 = $rowLAN['tour_titulo4'];
			$tour_video4 = $rowLAN['tour_video4'];
			$tour_tiempo4 = $rowLAN['tour_tiempo4'];
			$tour_titulo5 = $rowLAN['tour_titulo5'];
			$tour_video5 = $rowLAN['tour_video5'];
			$tour_tiempo5 = $rowLAN['tour_tiempo5'];
			$tour_titulo6 = $rowLAN['tour_titulo6'];
			$tour_video6 = $rowLAN['tour_video6'];
			$tour_tiempo6 = $rowLAN['tour_tiempo6'];

			$tour_titulo1_en = $rowLAN['tour_titulo1_en'];
			$tour_video1_en = $rowLAN['tour_video1_en'];
			$tour_tiempo1_en = $rowLAN['tour_tiempo1_en'];
			$tour_titulo2_en = $rowLAN['tour_titulo2_en'];
			$tour_video2_en = $rowLAN['tour_video2_en'];
			$tour_tiempo2_en = $rowLAN['tour_tiempo2_en'];
			$tour_titulo3_en = $rowLAN['tour_titulo3_en'];
			$tour_video3_en = $rowLAN['tour_video3_en'];
			$tour_tiempo3_en = $rowLAN['tour_tiempo3_en'];
			$tour_titulo4_en = $rowLAN['tour_titulo4_en'];
			$tour_video4_en = $rowLAN['tour_video4_en'];
			$tour_tiempo4_en = $rowLAN['tour_tiempo4_en'];
			$tour_titulo5_en = $rowLAN['tour_titulo5_en'];
			$tour_video5_en = $rowLAN['tour_video5_en'];
			$tour_tiempo5_en = $rowLAN['tour_tiempo5_en'];
			$tour_titulo6_en = $rowLAN['tour_titulo6_en'];
			$tour_video6_en = $rowLAN['tour_video6_en'];
			$tour_tiempo6_en = $rowLAN['tour_tiempo6_en'];

			$comments_id = $rowLAN['comments_id'];
			$fbcomments_app = $rowLAN['fbcomments_app'];

			$subdominio_mes = $rowLAN['subdominio_mes'];
			$subdominio_dia = $rowLAN['subdominio_dia'];
			$subdominio_ano = $rowLAN['subdominio_ano'];
			$subdominio_hora = $rowLAN['subdominio_hora'];
			$subdominio_minuto = $rowLAN['subdominio_minuto'];
			$landing_page_cta_button_timer_en = $rowLAN['landing_page_cta_button_timer_en'];
			$landing_page_cta_button_timer = $rowLAN['landing_page_cta_button_timer'];
			$youtube_bg = $rowLAN['youtube_bg'];
			$youtube_bg_en = $rowLAN['youtube_bg_en'];
		} else { // Moderator Data
			$autoresponders = $rowUSU['autoresponders'];
			$videos = $rowUSU['videos'];
			$subdominio_idioma = $rowUSU['subdominio_idioma'];
			// $titulo = $rowUSU['subdominio_titulo'] . " Sub"; Landing page showing from here
			$titulo = $rowUSU['subdominio_titulo'];
			$titulo_en = $rowUSU['subdominio_titulo_en'];
			$subtitulo = $rowUSU['subdominio_subtitulo'];
			$subtitulo_en = $rowUSU['subdominio_subtitulo_en'];
			$descripcion = $rowUSU['subdominio_descripcion'];
			$descripcion_en = $rowUSU['subdominio_descripcion_en'];
			$puntos = $rowUSU['subdominio_puntos'];
			$array_puntos = explode(chr(10), $puntos);
			$puntos_en = $rowUSU['subdominio_puntos_en'];
			$array_puntos_en = explode(chr(10), $puntos_en);
			$video = $rowUSU['subdominio_video'];
			$video_en = $rowUSU['subdominio_video_en'];
			$titulo_formulario = $rowUSU['subdominio_tituloformulario'];
			$titulo_formulario_en = $rowUSU['subdominio_tituloformulario_en'];
			$texto_formulario = $rowUSU['subdominio_textoformulario'];
			$texto_formulario_en = $rowUSU['subdominio_textoformulario_en'];
			$boton = $rowUSU['subdominio_boton'];
			$boton_en = $rowUSU['subdominio_boton_en'];

			$hide_skype_en = $rowUSU['hide_skype_en'];

			//testing variable
			//$boton_en =  'Submit';


			$bg_video = $rowUSU['subdominio_bg_video'];

			//backgound color
			$logo_section_bg = $rowUSU['logo_section_bg'];
			$title_section_bg = $rowUSU['title_section_bg'];
			$subtitle_section_bg = $rowUSU['subtitle_section_bg'];
			$form_title_bg = $rowUSU['form_title_bg'];
			$form_subtitle_bg = $rowUSU['form_subtitle_bg'];
			$form_input_name_placeholder = $rowUSU['form_input_name_placeholder'];
			$form_input_email_placeholder = $rowUSU['form_input_email_placeholder'];
			$form_input_whatsapp_placeholder = $rowUSU['form_input_whatsapp_placeholder'];
			$form_input_whatsapp_visible = $rowUSU['form_input_whatsapp_visible'];
			$background_image_library_url = $rowUSU['background_image_library_url'];
			$footer_section_bg = $rowUSU['footer_section_bg'];
			$form_section_bg = $rowUSU['form_section_bg'];
			$form_submit_button_bg = $rowUSU['form_submit_button_bg'];
			$textarea_section_bg = $rowUSU['textarea_section_bg'];
			$bulleted_area_section_bg = $rowUSU['bulleted_area_section_bg'];
			$slider_images_list = $rowUSU['slider_images_list'];
			$short_length_cta_button_text = $rowUSU['short_length_cta_button_text'];
			$short_length_cta_button_bg = $rowUSU['short_length_cta_button_bg'];
			$full_length_cta_button_text = $rowUSU['full_length_cta_button_text'];
			$full_length_cta_button_bg = $rowUSU['full_length_cta_button_bg'];
			$subdominio_textarea1 = $rowUSU['subdominio_textarea1'];
			$subdominio_textarea2 = $rowUSU['subdominio_textarea2'];
			$subdominio_textarea1_bg = $rowUSU['subdominio_textarea1_bg'];
			$subdominio_textarea2_bg = $rowUSU['subdominio_textarea2_bg'];
			$subdominio_box1_image = $rowUSU['subdominio_box1_image'];
			$subdominio_box2_image = $rowUSU['subdominio_box2_image'];
			$subdominio_box3_image = $rowUSU['subdominio_box3_image'];
			$footer_show_hide = $rowUSU['footer_show_hide'];
			$phone_number_required = $rowUSU['phone_number_required'];
			$footer_show_hide_en = $rowUSU['footer_show_hide_en'];
			$phone_number_required_en = $rowUSU['phone_number_required_en'];

			$logo_section_bg_en = $rowUSU['logo_section_bg_en'];
			$title_section_bg_en = $rowUSU['title_section_bg_en'];
			$subtitle_section_bg_en = $rowUSU['subtitle_section_bg_en'];
			$form_title_bg_en = $rowUSU['form_title_bg_en'];
			$form_subtitle_bg_en = $rowUSU['form_subtitle_bg_en'];
			$form_input_name_placeholder_en = $rowUSU['form_input_name_placeholder_en'];
			$form_input_email_placeholder_en = $rowUSU['form_input_email_placeholder_en'];
			$form_input_whatsapp_placeholder_en = $rowUSU['form_input_whatsapp_placeholder_en'];
			$form_input_whatsapp_visible_en = $rowUSU['form_input_whatsapp_visible_en'];
			$background_image_library_url_en = $rowUSU['background_image_library_url_en'];
			$footer_section_bg_en = $rowUSU['footer_section_bg_en'];
			$form_section_bg_en = $rowUSU['form_section_bg_en'];
			$form_submit_button_bg_en = $rowUSU['form_submit_button_bg_en'];
			$textarea_section_bg_en = $rowUSU['textarea_section_bg_en'];
			$bulleted_area_section_bg_en = $rowUSU['bulleted_area_section_bg_en'];
			$slider_images_list_en = $rowUSU['slider_images_list_en'];
			$short_length_cta_button_text_en = $rowUSU['short_length_cta_button_text_en'];
			$short_length_cta_button_bg_en = $rowUSU['short_length_cta_button_bg_en'];
			$full_length_cta_button_text_en = $rowUSU['full_length_cta_button_text_en'];
			$full_length_cta_button_bg_en = $rowUSU['full_length_cta_button_bg_en'];
			$subdominio_textarea1_en = $rowUSU['subdominio_textarea1_en'];
			$subdominio_textarea2_en = $rowUSU['subdominio_textarea2_en'];
			$subdominio_textarea1_bg_en = $rowUSU['subdominio_textarea1_bg_en'];
			$subdominio_textarea2_bg_en = $rowUSU['subdominio_textarea2_bg_en'];
			$subdominio_box1_image_en = $rowUSU['subdominio_box1_image_en'];
			$subdominio_box2_image_en = $rowUSU['subdominio_box2_image_en'];
			$subdominio_box3_image_en = $rowUSU['subdominio_box3_image_en'];
			$subdominio_body_background_color = $rowUSU['subdominio_body_background_color'];
			$subdominio_footer_description = $rowUSU['subdominio_footer_description'];
			$subdominio_footer_description_en = $rowUSU['subdominio_footer_description_en'];
			$subdominio_box1_image_description = $rowUSU['subdominio_box1_image_description'];
			$subdominio_box2_image_description = $rowUSU['subdominio_box2_image_description'];
			$subdominio_box3_image_description = $rowUSU['subdominio_box3_image_description'];
			$subdominio_webinar_presentador1_title = $rowUSU['subdominio_webinar_presentador1_title'];
			$subdominio_webinar_presentador2_title = $rowUSU['subdominio_webinar_presentador2_title'];
			$subdominio_single_image_description = $rowUSU['subdominio_single_image_description'];
			$subdominio_footer_links = $rowUSU['subdominio_footer_links'];
			$single_image_description_bg = $rowUSU['single_image_description_bg'];
			$single_image_description_bg_en = $rowUSU['single_image_description_bg_en'];

			$subdominio_box1_image_description_en = $rowUSU['subdominio_box1_image_description_en'];
			$subdominio_box2_image_description_en = $rowUSU['subdominio_box2_image_description_en'];
			$subdominio_box3_image_description_en = $rowUSU['subdominio_box3_image_description_en'];
			$subdominio_webinar_presentador1_title_en = $rowUSU['subdominio_webinar_presentador1_title_en'];
			$subdominio_webinar_presentador2_title_en = $rowUSU['subdominio_webinar_presentador2_title_en'];
			$subdominio_single_image_description_en = $rowUSU['subdominio_single_image_description_en'];
			$subdominio_footer_links_en = $rowUSU['subdominio_footer_links_en'];

			$tour_titulo1 = $rowUSU['tour_titulo1'];
			$tour_video1 = $rowUSU['tour_video1'];
			$tour_tiempo1 = $rowUSU['tour_tiempo1'];
			$tour_titulo2 = $rowUSU['tour_titulo2'];
			$tour_video2 = $rowUSU['tour_video2'];
			$tour_tiempo2 = $rowUSU['tour_tiempo2'];
			$tour_titulo3 = $rowUSU['tour_titulo3'];
			$tour_video3 = $rowUSU['tour_video3'];
			$tour_tiempo3 = $rowUSU['tour_tiempo3'];
			$tour_titulo4 = $rowUSU['tour_titulo4'];
			$tour_video4 = $rowUSU['tour_video4'];
			$tour_tiempo4 = $rowUSU['tour_tiempo4'];
			$tour_titulo5 = $rowUSU['tour_titulo5'];
			$tour_video5 = $rowUSU['tour_video5'];
			$tour_tiempo5 = $rowUSU['tour_tiempo5'];
			$tour_titulo6 = $rowUSU['tour_titulo6'];
			$tour_video6 = $rowUSU['tour_video6'];
			$tour_tiempo6 = $rowUSU['tour_tiempo6'];
			$tour_titulo1_en = $rowUSU['tour_titulo1_en'];
			$tour_video1_en = $rowUSU['tour_video1_en'];
			$tour_tiempo1_en = $rowUSU['tour_tiempo1_en'];
			$tour_titulo2_en = $rowUSU['tour_titulo2_en'];
			$tour_video2_en = $rowUSU['tour_video2_en'];
			$tour_tiempo2_en = $rowUSU['tour_tiempo2_en'];
			$tour_titulo3_en = $rowUSU['tour_titulo3_en'];
			$tour_video3_en = $rowUSU['tour_video3_en'];
			$tour_tiempo3_en = $rowUSU['tour_tiempo3_en'];
			$tour_titulo4_en = $rowUSU['tour_titulo4_en'];
			$tour_video4_en = $rowUSU['tour_video4_en'];
			$tour_tiempo4_en = $rowUSU['tour_tiempo4_en'];
			$tour_titulo5_en = $rowUSU['tour_titulo5_en'];
			$tour_video5_en = $rowUSU['tour_video5_en'];
			$tour_tiempo5_en = $rowUSU['tour_tiempo5_en'];
			$tour_titulo6_en = $rowUSU['tour_titulo6_en'];
			$tour_video6_en = $rowUSU['tour_video6_en'];
			$tour_tiempo6_en = $rowUSU['tour_tiempo6_en'];
			$comments_id = $rowUSU['comments_id'];
			$fbcomments_app = $rowUSU['fbcomments_app'];

			$subdominio_mes = $rowUSU['subdominio_mes'];
			$subdominio_dia = $rowUSU['subdominio_dia'];
			$subdominio_ano = $rowUSU['subdominio_ano'];
			$subdominio_hora = $rowUSU['subdominio_hora'];
			$subdominio_minuto = $rowUSU['subdominio_minuto'];
			$landing_page_cta_button_timer_en = $rowUSU['landing_page_cta_button_timer_en'];
			$landing_page_cta_button_timer = $rowUSU['landing_page_cta_button_timer'];
			$hide_skype = $rowUSU['hide_skype'];
			$youtube_bg = $rowUSU['youtube_bg'];
			$youtube_bg_en = $rowUSU['youtube_bg_en'];
		}


		/*	
			if ($rowUSU['subdominio_custom']==0 OR $landing) $videos = $rowLAN['videos'];
				else $videos = $rowUSU['videos'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo = $rowLAN['titulo'];
				else $titulo = $rowUSU['subdominio_titulo'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_en = $rowLAN['titulo_en'];
				else $titulo_en = $rowUSU['subdominio_titulo_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $subtitulo = $rowLAN['subtitulo'];
				else $subtitulo = $rowUSU['subdominio_subtitulo'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $subtitulo_en = $rowLAN['subtitulo_en'];
				else $subtitulo_en = $rowUSU['subdominio_subtitulo_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $descripcion = $rowLAN['descripcion'];
				else $descripcion = $rowUSU['subdominio_descripcion'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $descripcion_en = $rowLAN['descripcion_en'];
				else $descripcion_en = $rowUSU['subdominio_descripcion_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $puntos = $rowLAN['puntos'];
				else $puntos = $rowUSU['subdominio_puntos'];
			$array_puntos = explode(chr(10),$puntos);
			if ($rowUSU['subdominio_custom']==0 OR $landing) $puntos_en = $rowLAN['puntos_en'];
				else $puntos_en = $rowUSU['subdominio_puntos_en'];
			$array_puntos_en = explode(chr(10),$puntos_en);
			if ($rowUSU['subdominio_custom']==0 OR $landing) $video = $rowLAN['video'];
				else $video = $rowUSU['subdominio_video'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $video_en = $rowLAN['video_en'];
				else $video_en = $rowUSU['subdominio_video_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_formulario = $rowLAN['titulo_formulario'];
				else $titulo_formulario = $rowUSU['subdominio_tituloformulario'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_formulario_en = $rowLAN['titulo_formulario_en'];
				else $titulo_formulario_en = $rowUSU['subdominio_tituloformulario_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $texto_formulario = $rowLAN['texto_formulario'];
				else $texto_formulario = $rowUSU['subdominio_textoformulario'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $texto_formulario_en = $rowLAN['texto_formulario_en'];
				else $texto_formulario_en = $rowUSU['subdominio_textoformulario_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $boton = $rowLAN['boton'];
				else $boton = $rowUSU['subdominio_boton'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $boton_en = $rowLAN['boton_en'];
				else $boton_en = $rowUSU['subdominio_boton_en'];
*/
	} elseif ($version == 2) {

		if ($rowUSU['subdominio_custom'] == 0) {
			$tem = $rowLAN['clave'];
			$autoresponders = $rowLAN['autoresponders'];
			$videos = $rowLAN['videos'];
			$subdominio_idioma = $rowLAN['subdominio_idioma'];
			$titulo = $rowLAN['titulo'];
			$titulo_en = $rowLAN['titulo_en'];
			$subtitulo = $rowLAN['subtitulo'];
			$subtitulo_en = $rowLAN['subtitulo_en'];
			$descripcion = $rowLAN['descripcion'];
			$descripcion_en = $rowLAN['descripcion_en'];
			$puntos = $rowLAN['puntos'];
			$array_puntos = explode(chr(10), $puntos);
			$puntos_en = $rowLAN['puntos_en'];
			$array_puntos_en = explode(chr(10), $puntos_en);
			$video = $rowLAN['video'];
			$video_en = $rowLAN['video_en'];
			$titulo_formulario = $rowLAN['titulo_formulario'];
			$titulo_formulario_en = $rowLAN['titulo_formulario_en'];
			$texto_formulario = $rowLAN['texto_formulario'];
			$texto_formulario_en = $rowLAN['texto_formulario_en'];
			$boton = $rowLAN['boton'];
			$boton_en = $rowLAN['boton_en'];
			//testing variable
			$boton_en4 = $boton_en;


			$bg_video = $rowLAN['bg_video'];

			//backgound color
			$logo_section_bg = $rowLAN['logo_section_bg'];
			$title_section_bg = $rowLAN['title_section_bg'];
			$subtitle_section_bg = $rowLAN['subtitle_section_bg'];
			$form_title_bg = $rowLAN['form_title_bg'];
			$form_subtitle_bg = $rowLAN['form_subtitle_bg'];
			$form_input_name_placeholder = $rowLAN['form_input_name_placeholder'];
			$form_input_email_placeholder = $rowLAN['form_input_email_placeholder'];
			$form_input_whatsapp_placeholder = $rowLAN['form_input_whatsapp_placeholder'];
			$form_input_whatsapp_visible = $rowLAN['form_input_whatsapp_visible'];
			$background_image_library_url = $rowLAN['background_image_library_url'];
			$footer_section_bg = $rowLAN['footer_section_bg'];
			$form_section_bg = $rowLAN['form_section_bg'];
			$form_submit_button_bg = $rowLAN['form_submit_button_bg'];
			$textarea_section_bg = $rowLAN['textarea_section_bg'];
			$bulleted_area_section_bg = $rowLAN['bulleted_area_section_bg'];
			$slider_images_list = $rowLAN['slider_images_list'];
			$short_length_cta_button_text = $rowLAN['short_length_cta_button_text'];
			$short_length_cta_button_bg = $rowLAN['short_length_cta_button_bg'];
			$full_length_cta_button_text = $rowLAN['full_length_cta_button_text'];
			$full_length_cta_button_bg = $rowLAN['full_length_cta_button_bg'];
			$subdominio_textarea1 = $rowLAN['subdominio_textarea1'];
			$subdominio_textarea2 = $rowLAN['subdominio_textarea2'];
			$subdominio_textarea1_bg = $rowLAN['subdominio_textarea1_bg'];
			$subdominio_textarea2_bg = $rowLAN['subdominio_textarea2_bg'];
			$subdominio_box1_image = $rowLAN['subdominio_box1_image'];
			$subdominio_box2_image = $rowLAN['subdominio_box2_image'];
			$subdominio_box3_image = $rowLAN['subdominio_box3_image'];
			$footer_show_hide = $rowLAN['footer_show_hide'];
			$phone_number_required = $rowLAN['phone_number_required'];
			$footer_show_hide_en = $rowLAN['footer_show_hide_en'];
			$phone_number_required_en = $rowLAN['phone_number_required_en'];

			$logo_section_bg_en = $rowLAN['logo_section_bg_en'];
			$title_section_bg_en = $rowLAN['title_section_bg_en'];
			$subtitle_section_bg_en = $rowLAN['subtitle_section_bg_en'];
			$form_title_bg_en = $rowLAN['form_title_bg_en'];
			$form_subtitle_bg_en = $rowLAN['form_subtitle_bg_en'];
			$form_input_name_placeholder_en = $rowLAN['form_input_name_placeholder_en'];
			$form_input_email_placeholder_en = $rowLAN['form_input_email_placeholder_en'];
			$form_input_whatsapp_placeholder_en = $rowLAN['form_input_whatsapp_placeholder_en'];
			$form_input_whatsapp_visible_en = $rowLAN['form_input_whatsapp_visible_en'];
			$background_image_library_url_en = $rowLAN['background_image_library_url_en'];
			$footer_section_bg_en = $rowLAN['footer_section_bg_en'];
			$form_section_bg_en = $rowLAN['form_section_bg_en'];
			$form_submit_button_bg_en = $rowLAN['form_submit_button_bg_en'];
			$textarea_section_bg_en = $rowLAN['textarea_section_bg_en'];
			$bulleted_area_section_bg_en = $rowLAN['bulleted_area_section_bg_en'];
			$slider_images_list_en = $rowLAN['slider_images_list_en'];
			$short_length_cta_button_text_en = $rowLAN['short_length_cta_button_text_en'];
			$short_length_cta_button_bg_en = $rowLAN['short_length_cta_button_bg_en'];
			$full_length_cta_button_text_en = $rowLAN['full_length_cta_button_text_en'];
			$full_length_cta_button_bg_en = $rowLAN['full_length_cta_button_bg_en'];
			$subdominio_textarea1_en = $rowLAN['subdominio_textarea1_en'];
			$subdominio_textarea2_en = $rowLAN['subdominio_textarea2_en'];
			$subdominio_textarea1_bg_en = $rowLAN['subdominio_textarea1_bg_en'];
			$subdominio_textarea2_bg_en = $rowLAN['subdominio_textarea2_bg_en'];
			$subdominio_box1_image_en = $rowLAN['subdominio_box1_image_en'];
			$subdominio_box2_image_en = $rowLAN['subdominio_box2_image_en'];
			$subdominio_box3_image_en = $rowLAN['subdominio_box3_image_en'];
			$subdominio_body_background_color = $rowLAN['subdominio_body_background_color'];
			$subdominio_footer_description = $rowLAN['subdominio_footer_description'];
			$subdominio_footer_description_en = $rowLAN['subdominio_footer_description_en'];
			$subdominio_box1_image_description = $rowLAN['subdominio_box1_image_description'];
			$subdominio_box2_image_description = $rowLAN['subdominio_box2_image_description'];
			$subdominio_box3_image_description = $rowLAN['subdominio_box3_image_description'];
			$subdominio_webinar_presentador1_title = $rowLAN['subdominio_webinar_presentador1_title'];
			$subdominio_webinar_presentador2_title = $rowLAN['subdominio_webinar_presentador2_title'];
			$subdominio_single_image_description = $rowLAN['subdominio_single_image_description'];
			$subdominio_footer_links = $rowLAN['subdominio_footer_links'];
			$single_image_description_bg = $rowLAN['single_image_description_bg'];
			$single_image_description_bg_en = $rowLAN['single_image_description_bg_en'];

			$subdominio_box1_image_description_en = $rowLAN['subdominio_box1_image_description_en'];
			$subdominio_box2_image_description_en = $rowLAN['subdominio_box2_image_description_en'];
			$subdominio_box3_image_description_en = $rowLAN['subdominio_box3_image_description_en'];
			$subdominio_webinar_presentador1_title_en = $rowLAN['subdominio_webinar_presentador1_title_en'];
			$subdominio_webinar_presentador2_title_en = $rowLAN['subdominio_webinar_presentador2_title_en'];
			$subdominio_single_image_description_en = $rowLAN['subdominio_single_image_description_en'];
			$subdominio_footer_links_en = $rowLAN['subdominio_footer_links_en'];

			$tour_titulo1 = $rowLAN['tour_titulo1'];
			$tour_video1 = $rowLAN['tour_video1'];
			$tour_tiempo1 = $rowLAN['tour_tiempo1'];
			$tour_titulo2 = $rowLAN['tour_titulo2'];
			$tour_video2 = $rowLAN['tour_video2'];
			$tour_tiempo2 = $rowLAN['tour_tiempo2'];
			$tour_titulo3 = $rowLAN['tour_titulo3'];
			$tour_video3 = $rowLAN['tour_video3'];
			$tour_tiempo3 = $rowLAN['tour_tiempo3'];
			$tour_titulo4 = $rowLAN['tour_titulo4'];
			$tour_video4 = $rowLAN['tour_video4'];
			$tour_tiempo4 = $rowLAN['tour_tiempo4'];
			$tour_titulo5 = $rowLAN['tour_titulo5'];
			$tour_video5 = $rowLAN['tour_video5'];
			$tour_tiempo5 = $rowLAN['tour_tiempo5'];
			$tour_titulo6 = $rowLAN['tour_titulo6'];
			$tour_video6 = $rowLAN['tour_video6'];
			$tour_tiempo6 = $rowLAN['tour_tiempo6'];

			$tour_titulo1_en = $rowLAN['tour_titulo1_en'];
			$tour_video1_en = $rowLAN['tour_video1_en'];
			$tour_tiempo1_en = $rowLAN['tour_tiempo1_en'];
			$tour_titulo2_en = $rowLAN['tour_titulo2_en'];
			$tour_video2_en = $rowLAN['tour_video2_en'];
			$tour_tiempo2_en = $rowLAN['tour_tiempo2_en'];
			$tour_titulo3_en = $rowLAN['tour_titulo3_en'];
			$tour_video3_en = $rowLAN['tour_video3_en'];
			$tour_tiempo3_en = $rowLAN['tour_tiempo3_en'];
			$tour_titulo4_en = $rowLAN['tour_titulo4_en'];
			$tour_video4_en = $rowLAN['tour_video4_en'];
			$tour_tiempo4_en = $rowLAN['tour_tiempo4_en'];
			$tour_titulo5_en = $rowLAN['tour_titulo5_en'];
			$tour_video5_en = $rowLAN['tour_video5_en'];
			$tour_tiempo5_en = $rowLAN['tour_tiempo5_en'];
			$tour_titulo6_en = $rowLAN['tour_titulo6_en'];
			$tour_video6_en = $rowLAN['tour_video6_en'];
			$tour_tiempo6_en = $rowLAN['tour_tiempo6_en'];

			$comments_id = $rowLAN['comments_id'];
			$fbcomments_app = $rowLAN['fbcomments_app'];

			$subdominio_mes = $rowLAN['subdominio_mes'];
			$subdominio_dia = $rowLAN['subdominio_dia'];
			$subdominio_ano = $rowLAN['subdominio_ano'];
			$subdominio_hora = $rowLAN['subdominio_hora'];
			$subdominio_minuto = $rowLAN['subdominio_minuto'];
			$landing_page_cta_button_timer_en = $rowLAN['landing_page_cta_button_timer_en'];
			$landing_page_cta_button_timer = $rowLAN['landing_page_cta_button_timer'];
			$youtube_bg = $rowLAN['youtube_bg'];
			$youtube_bg_en = $rowLAN['youtube_bg_en'];
		} else {
			$autoresponders = $rowUSU['autoresponders'];
			$videos = $rowUSU['videos'];
			$subdominio_idioma = $rowUSU['subdominio_idioma'];
			$titulo = $rowUSU['subdominio_titulo2'];
			$titulo_en = $rowUSU['subdominio_titulo2_en'];
			$subtitulo = $rowUSU['subdominio_subtitulo2'];
			$subtitulo_en = $rowUSU['subdominio_subtitulo2_en'];
			$descripcion = $rowUSU['subdominio_descripcion2'];
			$descripcion_en = $rowUSU['subdominio_descripcion2_en'];
			$puntos = $rowUSU['subdominio_puntos2'];
			$array_puntos = explode(chr(10), $puntos);
			$puntos_en = $rowUSU['subdominio_puntos2_en'];
			$array_puntos_en = explode(chr(10), $puntos_en);
			$video = $rowUSU['subdominio_video2'];
			$video_en = $rowUSU['subdominio_video2_en'];
			$titulo_formulario = $rowUSU['subdominio_tituloformulario2'];
			$titulo_formulario_en = $rowUSU['subdominio_tituloformulario2_en'];
			$texto_formulario = $rowUSU['subdominio_textoformulario2'];
			$texto_formulario_en = $rowUSU['subdominio_textoformulario2_en'];
			$boton = $rowUSU['subdominio_boton2'];
			$boton_en = $rowUSU['subdominio_boton2_en'];

			//testing variable
			$boton_en5 = $boton_en;



			$bg_video = $rowUSU['subdominio_bg_video2'];

			//backgound color
			$logo_section_bg = $rowUSU['logo_section_bg'];
			$title_section_bg = $rowUSU['title_section_bg'];
			$subtitle_section_bg = $rowUSU['subtitle_section_bg'];
			$form_title_bg = $rowUSU['form_title_bg'];
			$form_subtitle_bg = $rowUSU['form_subtitle_bg'];
			$form_input_name_placeholder = $rowUSU['form_input_name_placeholder'];
			$form_input_email_placeholder = $rowUSU['form_input_email_placeholder'];
			$form_input_whatsapp_placeholder = $rowUSU['form_input_whatsapp_placeholder'];
			$form_input_whatsapp_visible = $rowUSU['form_input_whatsapp_visible'];
			$background_image_library_url = $rowUSU['background_image_library_url'];
			$footer_section_bg = $rowUSU['footer_section_bg'];
			$form_section_bg = $rowUSU['form_section_bg'];
			$form_submit_button_bg = $rowUSU['form_submit_button_bg'];
			$textarea_section_bg = $rowUSU['textarea_section_bg'];
			$bulleted_area_section_bg = $rowUSU['bulleted_area_section_bg'];
			$slider_images_list = $rowUSU['slider_images_list'];
			$short_length_cta_button_text = $rowUSU['short_length_cta_button_text'];
			$short_length_cta_button_bg = $rowUSU['short_length_cta_button_bg'];
			$full_length_cta_button_text = $rowUSU['full_length_cta_button_text'];
			$full_length_cta_button_bg = $rowUSU['full_length_cta_button_bg'];
			$subdominio_textarea1 = $rowUSU['subdominio_textarea1'];
			$subdominio_textarea2 = $rowUSU['subdominio_textarea2'];
			$subdominio_textarea1_bg = $rowUSU['subdominio_textarea1_bg'];
			$subdominio_textarea2_bg = $rowUSU['subdominio_textarea2_bg'];
			$subdominio_box1_image = $rowUSU['subdominio_box1_image'];
			$subdominio_box2_image = $rowUSU['subdominio_box2_image'];
			$subdominio_box3_image = $rowUSU['subdominio_box3_image'];
			$footer_show_hide = $rowUSU['footer_show_hide'];
			$phone_number_required = $rowUSU['phone_number_required'];
			$footer_show_hide_en = $rowUSU['footer_show_hide_en'];
			$phone_number_required_en = $rowUSU['phone_number_required_en'];

			$logo_section_bg_en = $rowUSU['logo_section_bg_en'];
			$title_section_bg_en = $rowUSU['title_section_bg_en'];
			$subtitle_section_bg_en = $rowUSU['subtitle_section_bg_en'];
			$form_title_bg_en = $rowUSU['form_title_bg_en'];
			$form_subtitle_bg_en = $rowUSU['form_subtitle_bg_en'];
			$form_input_name_placeholder_en = $rowUSU['form_input_name_placeholder_en'];
			$form_input_email_placeholder_en = $rowUSU['form_input_email_placeholder_en'];
			$form_input_whatsapp_placeholder_en = $rowUSU['form_input_whatsapp_placeholder_en'];
			$form_input_whatsapp_visible_en = $rowUSU['form_input_whatsapp_visible_en'];
			$background_image_library_url_en = $rowUSU['background_image_library_url_en'];
			$footer_section_bg_en = $rowUSU['footer_section_bg_en'];
			$form_section_bg_en = $rowUSU['form_section_bg_en'];
			$form_submit_button_bg_en = $rowUSU['form_submit_button_bg_en'];
			$textarea_section_bg_en = $rowUSU['textarea_section_bg_en'];
			$bulleted_area_section_bg_en = $rowUSU['bulleted_area_section_bg_en'];
			$slider_images_list_en = $rowUSU['slider_images_list_en'];
			$short_length_cta_button_text_en = $rowUSU['short_length_cta_button_text_en'];
			$short_length_cta_button_bg_en = $rowUSU['short_length_cta_button_bg_en'];
			$full_length_cta_button_text_en = $rowUSU['full_length_cta_button_text_en'];
			$full_length_cta_button_bg_en = $rowUSU['full_length_cta_button_bg_en'];
			$subdominio_textarea1_en = $rowUSU['subdominio_textarea1_en'];
			$subdominio_textarea2_en = $rowUSU['subdominio_textarea2_en'];
			$subdominio_textarea1_bg_en = $rowUSU['subdominio_textarea1_bg_en'];
			$subdominio_textarea2_bg_en = $rowUSU['subdominio_textarea2_bg_en'];
			$subdominio_box1_image_en = $rowLAN['subdominio_box1_image_en'];
			$subdominio_box2_image_en = $rowLAN['subdominio_box2_image_en'];
			$subdominio_box3_image_en = $rowLAN['subdominio_box3_image_en'];
			$subdominio_body_background_color = $rowLAN['subdominio_body_background_color'];
			$subdominio_footer_description = $rowLAN['subdominio_footer_description'];
			$subdominio_footer_description_en = $rowLAN['subdominio_footer_description_en'];
			$subdominio_box1_image_description = $rowLAN['subdominio_box1_image_description'];
			$subdominio_box2_image_description = $rowLAN['subdominio_box2_image_description'];
			$subdominio_box3_image_description = $rowLAN['subdominio_box3_image_description'];
			$subdominio_webinar_presentador1_title = $rowLAN['subdominio_webinar_presentador1_title'];
			$subdominio_webinar_presentador2_title = $rowLAN['subdominio_webinar_presentador2_title'];
			$subdominio_single_image_description = $rowLAN['subdominio_single_image_description'];
			$subdominio_footer_links = $rowLAN['subdominio_footer_links'];
			$single_image_description_bg = $rowLAN['single_image_description_bg'];
			$single_image_description_bg_en = $rowLAN['single_image_description_bg_en'];

			$subdominio_box1_image_description_en = $rowLAN['subdominio_box1_image_description_en'];
			$subdominio_box2_image_description_en = $rowLAN['subdominio_box2_image_description_en'];
			$subdominio_box3_image_description_en = $rowLAN['subdominio_box3_image_description_en'];
			$subdominio_webinar_presentador1_title_en = $rowLAN['subdominio_webinar_presentador1_title_en'];
			$subdominio_webinar_presentador2_title_en = $rowLAN['subdominio_webinar_presentador2_title_en'];
			$subdominio_single_image_description_en = $rowLAN['subdominio_single_image_description_en'];
			$subdominio_footer_links_en = $rowLAN['subdominio_footer_links_en'];

			$tour_titulo1 = $rowUSU['tour_titulo1'];
			$tour_video1 = $rowUSU['tour_video1'];
			$tour_tiempo1 = $rowUSU['tour_tiempo1'];
			$tour_titulo2 = $rowUSU['tour_titulo2'];
			$tour_video2 = $rowUSU['tour_video2'];
			$tour_tiempo2 = $rowUSU['tour_tiempo2'];
			$tour_titulo3 = $rowUSU['tour_titulo3'];
			$tour_video3 = $rowUSU['tour_video3'];
			$tour_tiempo3 = $rowUSU['tour_tiempo3'];
			$tour_titulo4 = $rowUSU['tour_titulo4'];
			$tour_video4 = $rowUSU['tour_video4'];
			$tour_tiempo4 = $rowUSU['tour_tiempo4'];
			$tour_titulo5 = $rowUSU['tour_titulo5'];
			$tour_video5 = $rowUSU['tour_video5'];
			$tour_tiempo5 = $rowUSU['tour_tiempo5'];
			$tour_titulo6 = $rowUSU['tour_titulo6'];
			$tour_video6 = $rowUSU['tour_video6'];
			$tour_tiempo6 = $rowUSU['tour_tiempo6'];
			$tour_titulo1_en = $rowUSU['tour_titulo1_en'];
			$tour_video1_en = $rowUSU['tour_video1_en'];
			$tour_tiempo1_en = $rowUSU['tour_tiempo1_en'];
			$tour_titulo2_en = $rowUSU['tour_titulo2_en'];
			$tour_video2_en = $rowUSU['tour_video2_en'];
			$tour_tiempo2_en = $rowUSU['tour_tiempo2_en'];
			$tour_titulo3_en = $rowUSU['tour_titulo3_en'];
			$tour_video3_en = $rowUSU['tour_video3_en'];
			$tour_tiempo3_en = $rowUSU['tour_tiempo3_en'];
			$tour_titulo4_en = $rowUSU['tour_titulo4_en'];
			$tour_video4_en = $rowUSU['tour_video4_en'];
			$tour_tiempo4_en = $rowUSU['tour_tiempo4_en'];
			$tour_titulo5_en = $rowUSU['tour_titulo5_en'];
			$tour_video5_en = $rowUSU['tour_video5_en'];
			$tour_tiempo5_en = $rowUSU['tour_tiempo5_en'];
			$tour_titulo6_en = $rowUSU['tour_titulo6_en'];
			$tour_video6_en = $rowUSU['tour_video6_en'];
			$tour_tiempo6_en = $rowUSU['tour_tiempo6_en'];
			$comments_id = $rowUSU['comments_id'];
			$fbcomments_app = $rowUSU['fbcomments_app'];

			$subdominio_mes2 = $rowUSU['subdominio_mes2'];
			$subdominio_dia2 = $rowUSU['subdominio_dia2'];
			$subdominio_ano2 = $rowUSU['subdominio_ano2'];
			$subdominio_hora2 = $rowUSU['subdominio_hora2'];
			$subdominio_minuto2 = $rowUSU['subdominio_minuto2'];
			$landing_page_cta_button_timer_en = $rowUSU['landing_page_cta_button_timer_en'];
			$landing_page_cta_button_timer = $rowUSU['landing_page_cta_button_timer'];
			$youtube_bg = $rowUSU['youtube_bg'];
			$youtube_bg_en = $rowUSU['youtube_bg_en'];
		}

		/*	
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo = $rowLAN['titulo'];
				else $titulo = $rowUSU['subdominio_titulo2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_en = $rowLAN['titulo_en'];
				else $titulo_en = $rowUSU['subdominio_titulo2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $subtitulo = $rowLAN['subtitulo'];
				else $subtitulo = $rowUSU['subdominio_subtitulo2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $subtitulo_en = $rowLAN['subtitulo_en'];
				else $subtitulo_en = $rowUSU['subdominio_subtitulo2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $descripcion = $rowLAN['descripcion'];
				else $descripcion = $rowUSU['subdominio_descripcion2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $descripcion_en = $rowLAN['descripcion_en'];
				else $descripcion_en = $rowUSU['subdominio_descripcion2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $puntos = $rowLAN['puntos'];
				else $puntos = $rowUSU['subdominio_puntos2'];
			$array_puntos = explode(chr(10),$puntos);
			if ($rowUSU['subdominio_custom']==0 OR $landing) $puntos_en = $rowLAN['puntos_en'];
				else $puntos_en = $rowUSU['subdominio_puntos2_en'];
			$array_puntos_en = explode(chr(10),$puntos_en);
			if ($rowUSU['subdominio_custom']==0 OR $landing) $video = $rowLAN['video'];
				else $video = $rowUSU['subdominio_video2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $video_en = $rowLAN['video_en'];
				else $video_en = $rowUSU['subdominio_video2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_formulario = $rowLAN['titulo_formulario'];
				else $titulo_formulario = $rowUSU['subdominio_tituloformulario2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $titulo_formulario_en = $rowLAN['titulo_formulario_en'];
				else $titulo_formulario_en = $rowUSU['subdominio_tituloformulario2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $texto_formulario = $rowLAN['texto_formulario'];
				else $texto_formulario = $rowUSU['subdominio_textoformulario2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $texto_formulario_en = $rowLAN['texto_formulario_en'];
				else $texto_formulario_en = $rowUSU['subdominio_textoformulario2_en'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $boton = $rowLAN['boton'];
				else $boton = $rowUSU['subdominio_boton2'];
			if ($rowUSU['subdominio_custom']==0 OR $landing) $boton_en = $rowLAN['boton_en'];
				else $boton_en = $rowUSU['subdominio_boton2_en'];
*/
	}




	// si el usuario tiene definido un template

	if (!empty($rowUSU['template'])) { // Template user data
		$grupal = TRUE;
		$tem = $rowUSU['template'];
		$resTEM = mysql_query("SELECT * FROM landing_page WHERE clave = $tem", $conexion);
		$rowTEM = mysql_fetch_array($resTEM);
		$autoresponders = $rowTEM['autoresponders'];
		$videos = $rowTEM['videos'];
		$subdominio_idioma = $rowTEM['subdominio_idioma'];
		$titulo = $rowTEM['titulo'];
		$titulo_en = $rowTEM['titulo_en'];
		$subtitulo = $rowTEM['subtitulo'];
		$subtitulo_en = $rowTEM['subtitulo_en'];
		$descripcion = $rowTEM['descripcion'];
		$descripcion_en = $rowTEM['descripcion_en'];
		$puntos = $rowTEM['puntos'];
		$moderador = $rowTEM['moderador']; // added by subroto 01/12/2024  // Template user data block
		$array_puntos = explode(chr(10), $puntos);
		$puntos_en = $rowTEM['puntos_en'];
		$array_puntos_en = explode(chr(10), $puntos_en);
		$video = $rowTEM['video'];
		$video_en = $rowTEM['video_en'];
		$titulo_formulario = $rowTEM['titulo_formulario'];
		$titulo_formulario_en = $rowTEM['titulo_formulario_en'];
		$texto_formulario = $rowTEM['texto_formulario'];
		$texto_formulario_en = $rowTEM['texto_formulario_en'];
		$boton = $rowTEM['boton'];
		$boton_en = $rowTEM['boton_en'];

		//testing variable
		$boton_en6 = $boton_en;



		$bg_video = $rowTEM['bg_video'];

		//backgound color
		$logo_section_bg = $rowTEM['logo_section_bg'];
		$title_section_bg = $rowTEM['title_section_bg'];
		$subtitle_section_bg = $rowTEM['subtitle_section_bg'];
		$form_title_bg = $rowTEM['form_title_bg'];
		$form_subtitle_bg = $rowTEM['form_subtitle_bg'];
		$form_input_name_placeholder = $rowTEM['form_input_name_placeholder'];
		$form_input_email_placeholder = $rowTEM['form_input_email_placeholder'];
		$form_input_whatsapp_placeholder = $rowTEM['form_input_whatsapp_placeholder'];
		$form_input_whatsapp_visible = $rowTEM['form_input_whatsapp_visible'];
		$background_image_library_url = $rowTEM['background_image_library_url'];
		$footer_section_bg = $rowTEM['footer_section_bg'];
		$form_section_bg = $rowTEM['form_section_bg'];
		$form_submit_button_bg = $rowTEM['form_submit_button_bg'];
		$textarea_section_bg = $rowTEM['textarea_section_bg'];
		$bulleted_area_section_bg = $rowTEM['bulleted_area_section_bg'];
		$slider_images_list = $rowTEM['slider_images_list'];
		$short_length_cta_button_text = $rowTEM['short_length_cta_button_text'];
		$short_length_cta_button_bg = $rowTEM['short_length_cta_button_bg'];
		$full_length_cta_button_text = $rowTEM['full_length_cta_button_text'];
		$full_length_cta_button_bg = $rowTEM['full_length_cta_button_bg'];
		$subdominio_textarea1 = $rowTEM['subdominio_textarea1'];
		$subdominio_textarea2 = $rowTEM['subdominio_textarea2'];
		$subdominio_textarea1_bg = $rowTEM['subdominio_textarea1_bg'];
		$subdominio_textarea2_bg = $rowTEM['subdominio_textarea2_bg'];
		$subdominio_box1_image = $rowTEM['subdominio_box1_image'];
		$subdominio_box2_image = $rowTEM['subdominio_box2_image'];
		$subdominio_box3_image = $rowTEM['subdominio_box3_image'];
		$footer_show_hide = $rowTEM['footer_show_hide'];
		$phone_number_required = $rowTEM['phone_number_required'];
		$footer_show_hide_en = $rowTEM['footer_show_hide_en'];
		$phone_number_required_en = $rowTEM['phone_number_required_en'];

		$logo_section_bg_en = $rowTEM['logo_section_bg_en'];
		$title_section_bg_en = $rowTEM['title_section_bg_en'];
		$subtitle_section_bg_en = $rowTEM['subtitle_section_bg_en'];
		$form_title_bg_en = $rowTEM['form_title_bg_en'];
		$form_subtitle_bg_en = $rowTEM['form_subtitle_bg_en'];
		$form_input_name_placeholder_en = $rowTEM['form_input_name_placeholder_en'];
		$form_input_email_placeholder_en = $rowTEM['form_input_email_placeholder_en'];
		$form_input_whatsapp_placeholder_en = $rowTEM['form_input_whatsapp_placeholder_en'];
		$form_input_whatsapp_visible_en = $rowTEM['form_input_whatsapp_visible_en'];
		$background_image_library_url_en = $rowTEM['background_image_library_url_en'];
		$footer_section_bg_en = $rowTEM['footer_section_bg_en'];
		$form_section_bg_en = $rowTEM['form_section_bg_en'];
		$form_submit_button_bg_en = $rowTEM['form_submit_button_bg_en'];
		$textarea_section_bg_en = $rowTEM['textarea_section_bg_en'];
		$bulleted_area_section_bg_en = $rowTEM['bulleted_area_section_bg_en'];
		$slider_images_list_en = $rowTEM['slider_images_list_en'];
		$short_length_cta_button_text_en = $rowTEM['short_length_cta_button_text_en'];
		$short_length_cta_button_bg_en = $rowTEM['short_length_cta_button_bg_en'];
		$full_length_cta_button_text_en = $rowTEM['full_length_cta_button_text_en'];
		$full_length_cta_button_bg_en = $rowTEM['full_length_cta_button_bg_en'];
		$subdominio_textarea1_en = $rowTEM['subdominio_textarea1_en'];
		$subdominio_textarea2_en = $rowTEM['subdominio_textarea2_en'];
		$subdominio_textarea1_bg_en = $rowTEM['subdominio_textarea1_bg_en'];
		$subdominio_textarea2_bg_en = $rowTEM['subdominio_textarea2_bg_en'];
		$subdominio_box1_image_en = $rowTEM['subdominio_box1_image_en'];
		$subdominio_box2_image_en = $rowTEM['subdominio_box2_image_en'];
		$subdominio_box3_image_en = $rowTEM['subdominio_box3_image_en'];
		$subdominio_body_background_color = $rowTEM['subdominio_body_background_color'];
		$subdominio_footer_description = $rowTEM['subdominio_footer_description'];
		$subdominio_footer_description_en = $rowTEM['subdominio_footer_description_en'];
		$subdominio_box1_image_description = $rowTEM['subdominio_box1_image_description'];
		$subdominio_box2_image_description = $rowTEM['subdominio_box2_image_description'];
		$subdominio_box3_image_description = $rowTEM['subdominio_box3_image_description'];
		$subdominio_webinar_presentador1_title = $rowTEM['subdominio_webinar_presentador1_title'];
		$subdominio_webinar_presentador2_title = $rowTEM['subdominio_webinar_presentador2_title'];
		$subdominio_single_image_description = $rowTEM['subdominio_single_image_description'];
		$subdominio_footer_links = $rowTEM['subdominio_footer_links'];
		$single_image_description_bg = $rowTEM['single_image_description_bg'];
		$single_image_description_bg_en = $rowTEM['single_image_description_bg_en'];

		$subdominio_box1_image_description_en = $rowTEM['subdominio_box1_image_description_en'];
		$subdominio_box2_image_description_en = $rowTEM['subdominio_box2_image_description_en'];
		$subdominio_box3_image_description_en = $rowTEM['subdominio_box3_image_description_en'];
		$subdominio_webinar_presentador1_title_en = $rowTEM['subdominio_webinar_presentador1_title_en'];
		$subdominio_webinar_presentador2_title_en = $rowTEM['subdominio_webinar_presentador2_title_en'];
		$subdominio_single_image_description_en = $rowTEM['subdominio_single_image_description_en'];
		$subdominio_footer_links_en = $rowTEM['subdominio_footer_links_en'];

		$tour_titulo1 = $rowTEM['tour_titulo1'];
		$tour_video1 = $rowTEM['tour_video1'];
		$tour_tiempo1 = $rowTEM['tour_tiempo1'];
		$tour_titulo2 = $rowTEM['tour_titulo2'];
		$tour_video2 = $rowTEM['tour_video2'];
		$tour_tiempo2 = $rowTEM['tour_tiempo2'];
		$tour_titulo3 = $rowTEM['tour_titulo3'];
		$tour_video3 = $rowTEM['tour_video3'];
		$tour_tiempo3 = $rowTEM['tour_tiempo3'];
		$tour_titulo4 = $rowTEM['tour_titulo4'];
		$tour_video4 = $rowTEM['tour_video4'];
		$tour_tiempo4 = $rowTEM['tour_tiempo4'];
		$tour_titulo5 = $rowTEM['tour_titulo5'];
		$tour_video5 = $rowTEM['tour_video5'];
		$tour_tiempo5 = $rowTEM['tour_tiempo5'];
		$tour_titulo6 = $rowTEM['tour_titulo6'];
		$tour_video6 = $rowTEM['tour_video6'];
		$tour_tiempo6 = $rowTEM['tour_tiempo6'];
		$tour_titulo1_en = $rowTEM['tour_titulo1_en'];
		$tour_video1_en = $rowTEM['tour_video1_en'];
		$tour_tiempo1_en = $rowTEM['tour_tiempo1_en'];
		$tour_titulo2_en = $rowTEM['tour_titulo2_en'];
		$tour_video2_en = $rowTEM['tour_video2_en'];
		$tour_tiempo2_en = $rowTEM['tour_tiempo2_en'];
		$tour_titulo3_en = $rowTEM['tour_titulo3_en'];
		$tour_video3_en = $rowTEM['tour_video3_en'];
		$tour_tiempo3_en = $rowTEM['tour_tiempo3_en'];
		$tour_titulo4_en = $rowTEM['tour_titulo4_en'];
		$tour_video4_en = $rowTEM['tour_video4_en'];
		$tour_tiempo4_en = $rowTEM['tour_tiempo4_en'];
		$tour_titulo5_en = $rowTEM['tour_titulo5_en'];
		$tour_video5_en = $rowTEM['tour_video5_en'];
		$tour_tiempo5_en = $rowTEM['tour_tiempo5_en'];
		$tour_titulo6_en = $rowTEM['tour_titulo6_en'];
		$tour_video6_en = $rowTEM['tour_video6_en'];
		$tour_tiempo6_en = $rowTEM['tour_tiempo6_en'];
		$comments_id = $rowTEM['comments_id'];
		$fbcomments_app = $rowTEM['fbcomments_app'];

		$subdominio_mes = $rowTEM['subdominio_mes'];
		$subdominio_dia = $rowTEM['subdominio_dia'];
		$subdominio_ano = $rowTEM['subdominio_ano'];
		$subdominio_hora = $rowTEM['subdominio_hora'];
		$subdominio_minuto = $rowTEM['subdominio_minuto'];
		$landing_page_cta_button_timer_en = $rowTEM['landing_page_cta_button_timer_en'];
		$landing_page_cta_button_timer = $rowTEM['landing_page_cta_button_timer'];
		$usuario_temp = $rowTEM['moderador'];
		//            echo $rowTEM['full_length_cta_button_text']; echo '<br/>';

		$resUSU123 = mysql_query("SELECT background_image_library_url,full_length_cta_button_text, full_length_cta_button_bg FROM usuario WHERE clave = $usuario_temp", $conexion);
		$rowUSU123 = mysql_fetch_array($resUSU123);
		$full_length_cta_button_text = $rowUSU123['full_length_cta_button_text'];
		$background_image_library_url = $rowUSU123['background_image_library_url'];
		$full_length_cta_button_bg = $rowUSU123['full_length_cta_button_bg'];
		$youtube_bg = $rowTEM['youtube_bg'];
		$youtube_bg_en = $rowTEM['youtube_bg_en'];
	}
	//        echo $full_length_cta_button_text; exit;

	if ($tem) {

		// busca si el landingpage tiene logotipo personalizado
		$dir = '../../images/templates/';

		if (file_exists($dir . $tem . '.jpg')) $logotipo = '<img class="logo" src="' . $dir . $tem . '.jpg" alt="">';
		elseif (file_exists($dir . $tem . '.gif')) $logotipo = '<img class="logo" src="' . $dir . $tem . '.gif" alt="">';
		elseif (file_exists($dir . $tem . '.png')) $logotipo = '<img class="logo" src="' . $dir . $tem . '.png" alt="">';
		else $logotipo = '<img class="logo" src="../../images/default/templates/' . $template . '.png" height="53" alt="">';

		if (file_exists($dir . $tem . '_en.jpg')) $logotipo_en = '<img class="logo" src="' . $dir . $tem . '_en.jpg" alt="">';
		elseif (file_exists($dir . $tem . '_en.gif')) $logotipo_en = '<img class="logo" src="' . $dir . $tem . '_en.gif" alt="">';
		elseif (file_exists($dir . $tem . '_en.png')) $logotipo_en = '<img class="logo" src="' . $dir . $tem . '_en.png" alt="">';
		else $logotipo_en = '<img class="logo" src="../../images/default/templates/' . $template . '_en.png" height="53" alt="">';

		// echo $logotipo; exit();
		// echo 'LOGO:'.$dir.$tem.'.jpg';

	} else {

		$dir = '../../images/landingpage/logos/';

		if (file_exists($dir . $usuario . '.jpg')) $logotipo = '<img class="logo" src="' . $dir . $usuario . '.jpg" alt="">';
		elseif (file_exists($dir . $usuario . '.gif')) $logotipo = '<img class="logo" src="' . $dir . $usuario . '.gif" alt="">';
		elseif (file_exists($dir . $usuario . '.png')) $logotipo = '<img class="logo" src="' . $dir . $usuario . '.png" alt="">';
		else $logotipo = '<img class="logo" src="../../images/default/templates/' . $template . '.png"  height="53" alt="">';

		if (file_exists($dir . $usuario . '_en.jpg')) $logotipo_en = '<img class="logo" src="' . $dir . $usuario . '_en.jpg" alt="">';
		elseif (file_exists($dir . $usuario . '_en.gif')) $logotipo_en = '<img class="logo" src="' . $dir . $usuario . '_en.gif" alt="">';
		elseif (file_exists($dir . $usuario . '_en.png')) $logotipo_en = '<img class="logo" src="' . $dir . $usuario . '_en.png" alt="">';
		else if (file_exists("../../images/default/templates/" . $template . "_en.png")) {
			$logotipo_en = '<img class="logo" src="../../images/default/templates/' . $template . '_en.png" height="53" alt="">';
		}
		if (file_exists("../../images/default/templates/" . $template . "_en.jpg")) {
			$logotipo_en = '<img class="logo" src="../../images/default/templates/' . $template . '_en.jpg" height="53" alt="">';
		} else if (file_exists("../../images/default/templates/" . $template . "_en.jpeg")) {
			$logotipo_en = '<img class="logo" src="../../images/default/templates/' . $template . '_en.jpeg" height="53" alt="">';
		} else if (file_exists("../../images/default/templates/" . $template . "_en.gif")) {
			$logotipo_en = '<img class="logo" src="../../images/default/templates/' . $template . '_en.gif" height="53" alt="">';
		}
		// echo $dir.$usuario; exit();
	}
}  // si se ejecuta desde subdominio o perfil del usuario


// selecciona el dominio (Cuentas Marca Propia)
$resADMIN = mysql_query("SELECT url_dominio FROM admin WHERE clave = '1'", $conexion);
$rowADMIN = mysql_fetch_array($resADMIN);


// Define el autoresponder
if ($autoresponders == 'getresponse') {
	$result = "../../registro_prospecto_subdominio_getresponse.php";
} else if ($autoresponders == 'aweber') {
	$result = "../../registro_prospecto_subdominio_aweber.php";
} else if ($autoresponders == 'mailchimp') {
	$result = "../../registro_prospecto_subdominio_mailchimp.php";
} else if ($autoresponders == 'autoresponder') {
	$result = "../../registro_prospecto_subdominio_autoresponder.php";
} else {
	$result = "../../registro_prospecto_subdominio_getresponse.php";
}

if (isset($_GET['campino'])) {
	$result = "../../registro_prospecto_subdominio_getresponse.php";
}

$default_query = mysql_query("SELECT * FROM landing_page_default_values WHERE landing_page = $template LIMIT 1", $conexion);
$default_values = mysql_fetch_array($default_query);
if ($default_values) {
	if ($videos == "") {
		$videos = $default_values['videos']; //
	}
	if ($titulo == "") {
		$titulo = $default_values['subdominio_titulo']; //
	}
	if ($titulo_en == "") {
		$titulo_en = $default_values['subdominio_titulo_en']; //

	}
	if ($subtitulo == "") {
		$subtitulo = $default_values['subdominio_subtitulo']; //

	}
	if ($subtitulo_en == "") {
		$subtitulo_en = $default_values['subdominio_subtitulo_en']; //

	}
	if ($descripcion == "") {
		$descripcion = $default_values['subdominio_descripcion']; //

	}
	if ($descripcion_en == "") {
		$descripcion_en = $default_values['subdominio_descripcion_en']; //

	}
	if ($puntos == "") {
		$puntos = $default_values['subdominio_puntos']; //
		$array_puntos = explode(chr(10), $puntos);
	}
	if ($puntos_en == "") {
		$puntos_en = $default_values['subdominio_puntos_en']; //
		$array_puntos_en = explode(chr(10), $puntos_en);
	}
	if ($video == "") {
		$video = $default_values['subdominio_video']; //

	}
	if ($video_en == "") {
		$video_en = $default_values['subdominio_video_en']; //

	}
	if ($titulo_formulario == "") {
		$titulo_formulario = $default_values['subdominio_tituloformulario']; //

	}
	if ($titulo_formulario_en == "") {
		$titulo_formulario_en = $default_values['subdominio_tituloformulario_en']; //

	}
	if ($texto_formulario == "") {
		$texto_formulario = $default_values['subdominio_textoformulario']; //

	}
	if ($texto_formulario_en == "") {
		$texto_formulario_en = $default_values['subdominio_textoformulario_en']; //

	}
	if ($boton == "") {
		$boton = $default_values['subdominio_boton']; //

	}
	if ($boton_en == "") {
		$boton_en = $default_values['subdominio_boton_en']; //

		//testing variable
		$boton_en7 = $boton_en;
	}
	if ($bg_video == "") {
		$bg_video = $default_values['bg_video'];
	}
	if ($logo_section_bg == "") {
		$logo_section_bg = $default_values['logo_section_bg']; //

	}
	if ($title_section_bg == "") {
		$title_section_bg = $default_values['title_section_bg']; //

	}
	if ($subtitle_section_bg == "") {
		$subtitle_section_bg = $default_values['subtitle_section_bg']; //

	}
	if ($form_title_bg == "") {
		$form_title_bg = $default_values['form_title_bg']; //

	}
	if ($form_subtitle_bg == "") {
		$form_subtitle_bg = $default_values['form_subtitle_bg']; //

	}
	if ($form_input_name_placeholder == "") {
		$form_input_name_placeholder = $default_values['form_input_name_placeholder']; //

	}
	if ($form_input_email_placeholder == "") {
		$form_input_email_placeholder = $default_values['form_input_email_placeholder']; //

	}
	if ($form_input_whatsapp_placeholder == "") {
		$form_input_whatsapp_placeholder = $default_values['form_input_whatsapp_placeholder']; //

	}
	if ($form_input_whatsapp_visible == "") {
		$form_input_whatsapp_visible = $default_values['form_input_whatsapp_visible']; //

	}
	if ($background_image_library_url == "") {
		$background_image_library_url_default = $default_values['background_image_library_url']; //

	}
	if ($footer_section_bg == "") {
		$footer_section_bg = $default_values['footer_section_bg']; //

	}
	if ($form_section_bg == "") {
		$form_section_bg = $default_values['form_section_bg']; //

	}
	if ($form_submit_button_bg == "") {
		$form_submit_button_bg = $default_values['form_submit_button_bg']; //

	}
	if ($textarea_section_bg == "") {
		$textarea_section_bg = $default_values['textarea_section_bg']; //

	}
	if ($bulleted_area_section_bg == "") {
		$bulleted_area_section_bg = $default_values['bulleted_area_section_bg']; //

	}

	if ($slider_images_list == "") {
		$slider_images_list = $default_values['slider_images_list']; //

	}

	if ($short_length_cta_button_text == "") {
		$short_length_cta_button_text = $default_values['short_length_cta_button_text']; //

	}

	if ($short_length_cta_button_bg == "") {
		$short_length_cta_button_bg = $default_values['short_length_cta_button_bg']; //

	}

	if ($full_length_cta_button_text == "") {
		$full_length_cta_button_text = $default_values['full_length_cta_button_text']; //

	}

	if ($full_length_cta_button_bg == "") {
		$full_length_cta_button_bg = $default_values['full_length_cta_button_bg']; //

	}

	if ($subdominio_textarea1 == "") {
		$subdominio_textarea1 = $default_values['subdominio_textarea1']; //

	}

	if ($subdominio_textarea2 == "") {
		$subdominio_textarea2 = $default_values['subdominio_textarea2']; //

	}

	if ($subdominio_textarea1_bg == "") {
		$subdominio_textarea1_bg = $default_values['subdominio_textarea1_bg']; //

	}

	if ($subdominio_textarea2_bg == "") {
		$subdominio_textarea2_bg = $default_values['subdominio_textarea2_bg']; //

	}

	if ($subdominio_box1_image == "") {
		$subdominio_box1_image = $default_values['subdominio_box1_image']; //

	}

	if ($subdominio_box2_image == "") {
		$subdominio_box2_image = $default_values['subdominio_box2_image']; //

	}
	if ($subdominio_box3_image == "") {
		$subdominio_box3_image = $default_values['subdominio_box3_image']; //

	}

	if ($footer_show_hide == "") {
		$footer_show_hide = $default_values['footer_show_hide']; //

	}

	if ($phone_number_required == "") {
		$phone_number_required = $default_values['phone_number_required']; //

	}

	if ($footer_show_hide_en == "") {
		$footer_show_hide_en = $default_values['footer_show_hide_en']; //

	}

	if ($phone_number_required_en == "") {
		$phone_number_required_en = $default_values['phone_number_required_en']; //

	}

	if ($logo_section_bg_en == "") {
		$logo_section_bg_en = $default_values['logo_section_bg_en']; //

	}

	if ($title_section_bg_en == "") {
		$title_section_bg_en = $default_values['title_section_bg_en']; //

	}

	if ($subtitle_section_bg_en == "") {
		$subtitle_section_bg_en = $default_values['subtitle_section_bg_en']; //

	}

	if ($form_title_bg_en == "") {
		$form_title_bg_en = $default_values['form_title_bg_en']; //

	}

	if ($form_subtitle_bg_en == "") {
		$form_subtitle_bg_en = $default_values['form_subtitle_bg_en']; //

	}

	if ($form_input_name_placeholder_en == "") {
		$form_input_name_placeholder_en = $default_values['form_input_name_placeholder_en']; //

	}

	if ($form_input_email_placeholder_en == "") {
		$form_input_email_placeholder_en = $default_values['form_input_email_placeholder_en']; //

	}

	if ($form_input_whatsapp_placeholder_en == "") {
		$form_input_whatsapp_placeholder_en = $default_values['form_input_whatsapp_placeholder_en']; //

	}
	if ($form_input_whatsapp_visible_en == "") {
		$form_input_whatsapp_visible_en = $default_values['form_input_whatsapp_visible_en']; //

	}

	if ($background_image_library_url_en == "") {
		$background_image_library_url_en = $default_values['background_image_library_url_en']; //

	}
	if ($footer_section_bg_en == "") {
		$footer_section_bg_en = $default_values['footer_section_bg_en']; //

	}
	if ($form_section_bg_en == "") {
		$form_section_bg_en = $default_values['form_section_bg_en']; //

	}
	if ($form_submit_button_bg_en == "") {
		$form_submit_button_bg_en = $default_values['form_submit_button_bg_en']; //

	}
	if ($textarea_section_bg_en == "") {
		$textarea_section_bg_en = $default_values['textarea_section_bg_en']; //

	}
	if ($bulleted_area_section_bg_en == "") {
		$bulleted_area_section_bg_en = $default_values['bulleted_area_section_bg_en']; //

	}
	if ($slider_images_list_en = "") {
		$slider_images_list_en = $default_values['slider_images_list_en']; //

	}
	if ($short_length_cta_button_text_en == "") {
		$short_length_cta_button_text_en = $default_values['short_length_cta_button_text_en']; //

	}
	if ($short_length_cta_button_bg_en == "") {
		$short_length_cta_button_bg_en = $default_values['short_length_cta_button_bg_en']; //

	}
	if ($full_length_cta_button_text_en == "") {
		$full_length_cta_button_text_en = $default_values['full_length_cta_button_text_en']; //

	}
	if ($full_length_cta_button_bg_en == "") {
		$full_length_cta_button_bg_en = $default_values['full_length_cta_button_bg_en']; //

	}
	if ($subdominio_textarea1_en == "") {
		$subdominio_textarea1_en = $default_values['subdominio_textarea1_en']; //

	}
	if ($subdominio_textarea2_en == "") {
		$subdominio_textarea2_en = $default_values['subdominio_textarea2_en']; //

	}
	if ($subdominio_textarea1_bg_en == "") {
		$subdominio_textarea1_bg_en = $default_values['subdominio_textarea1_bg_en']; //

	}
	if ($subdominio_textarea2_bg_en == "") {
		$subdominio_textarea2_bg_en = $default_values['subdominio_textarea2_bg_en']; //

	}
	if ($subdominio_box1_image_en == "") {
		$subdominio_box1_image_en = $default_values['subdominio_box1_image_en']; //

	}
	if ($subdominio_box2_image_en == "") {
		$subdominio_box2_image_en = $default_values['subdominio_box2_image_en']; //

	}
	if ($subdominio_box3_image_en == "") {
		$subdominio_box3_image_en = $default_values['subdominio_box3_image_en']; //

	}
	if ($subdominio_body_background_color == "") {
		$subdominio_body_background_color = $default_values['subdominio_body_background_color']; //

	}
	if ($subdominio_footer_description == "") {
		$subdominio_footer_description = $default_values['subdominio_footer_description']; //

	}
	if ($subdominio_footer_description_en == "") {
		$subdominio_footer_description_en = $default_values['subdominio_footer_description_en']; //

	}
	if ($subdominio_box1_image_description == "") {
		$subdominio_box1_image_description = $default_values['subdominio_box1_image_description']; //

	}
	if ($subdominio_box2_image_description == "") {
		$subdominio_box2_image_description = $default_values['subdominio_box2_image_description']; //

	}
	if ($subdominio_box3_image_description == "") {
		$subdominio_box3_image_description = $default_values['subdominio_box3_image_description']; //

	}
	if ($subdominio_webinar_presentador1_title == "") {
		$subdominio_webinar_presentador1_title = $default_values['subdominio_webinar_presentador1_title']; //

	}
	if ($subdominio_webinar_presentador2_title == "") {
		$subdominio_webinar_presentador2_title = $default_values['subdominio_webinar_presentador2_title']; //

	}
	if ($subdominio_single_image_description == "") {
		$subdominio_single_image_description = $default_values['subdominio_single_image_description']; //

	}
	if ($subdominio_footer_links == "") {
		$subdominio_footer_links = $default_values['subdominio_footer_links']; //

	}
	if ($single_image_description_bg == "") {
		$single_image_description_bg = $default_values['single_image_description_bg']; //

	}
	if ($single_image_description_bg_en == "") {
		$single_image_description_bg_en = $default_values['single_image_description_bg_en']; //

	}
	if ($subdominio_box1_image_description_en == "") {
		$subdominio_box1_image_description_en = $default_values['subdominio_box1_image_description_en']; //

	}
	if ($subdominio_box2_image_description_en == "") {
		$subdominio_box2_image_description_en = $default_values['subdominio_box2_image_description_en']; //

	}
	if ($subdominio_box3_image_description_en == "") {
		$subdominio_box3_image_description_en = $default_values['subdominio_box3_image_description_en']; ///

	}
	if ($subdominio_webinar_presentador1_title_en == "") {
		$subdominio_webinar_presentador1_title_en = $default_values['subdominio_webinar_presentador1_title_en']; //

	}
	if ($subdominio_webinar_presentador2_title_en == "") {
		$subdominio_webinar_presentador2_title_en = $default_values['subdominio_webinar_presentador2_title_en']; //

	}
	if ($subdominio_single_image_description_en == "") {
		$subdominio_single_image_description_en = $default_values['subdominio_single_image_description_en']; //

	}
	if ($subdominio_footer_links_en == "") {
		$subdominio_footer_links_en = $default_values['subdominio_footer_links_en']; //

	}
}


// Some default values for 25beta Landing page ~Subroto
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$needle = "landingpage/25beta";
// Check if "tour/3beta" is present in the URL
if (strpos($url, $needle) !== false) {
	header('Content-Type: text/html; charset=utf-8');

	function checkNull($input)
	{
		$cleanedString = preg_replace('/<\/?(p|h1|h2|h3|h4|h5|h6)>/', '', $input);
		//  var_dump("After p " . $cleanedString);
		$cleanedString = preg_replace('/<!--.*?-->/', '', $cleanedString);
		//  var_dump("After Coment " . $cleanedString);
		$cleanedString = str_replace('&nbsp;', '', $cleanedString);
		$cleanedString = preg_replace('/\s+/', '', $cleanedString);
		$cleanedString = preg_replace('/<br\s*\/?>/i', '', $cleanedString);
		//  var_dump($cleanedString);

		return strlen($cleanedString) != 0;  // 7 != 0 // ab // 2 != 0
	}

	// Remove special character
	function formatSpanish($string, $defaultValue)
	{
		$string = checkNull($string) ? $string : $defaultValue;
		return mb_convert_encoding($string, 'UTF-8', 'UTF-8');
	}

	$puntos = formatSpanish($puntos, '<p style="text-align:center"><span style="color:#f1c40f"><u><strong>ATENCIÓN:</strong></u></span> ¿Estás cansado de no conseguir clientes para tu negocio multinivel?</p>');
	$titulo = formatSpanish($titulo, 'Guía Gratis Revela...');
	$subtitulo = formatSpanish($subtitulo, 'El sistema efectivo para atraer clientes a tu negocio');
	$titulo_formulario = formatSpanish($titulo_formulario, 'Con esta guía aprenderás:');
	$texto_formulario = formatSpanish($texto_formulario, '<ul>
	<li>Identificar tu publico objetivo.</li>
	<li>Crear una estrategia de Prospeccion eficaz.</li>
	<li>Convertir prospectos en clientes / Afiliados.</li>
	<li>Crear contenido atractivo y enfocado.</li>
</ul>');
	$boton = formatSpanish($boton, '<p>Sí, Quiero La Guía Gratis</p><small class="sc-bxivhb fcOruc">¡Comienza a prospectar de manera Efectiva!</small>');
	$descripcion = formatSpanish($descripcion, '<p><strong>¡Hola!, Soy Luis R Landeros</strong></p>
<p>Emprendedor de multinivel que ha experimentado el dolor de luchar por conseguir y convertir prospectos en clientes y afiliados para mi negocio multinivel.</p>
<p>&nbsp;</p>
<p>Sé lo frustrante que puede ser invertir tiempo y esfuerzo en la prospección y ver pocos resultados.</p>
<p>&nbsp;</p>
<p>Me costaba mucho identificar mi publico objetivo, perdia mucho tiempo en personas que no estaban interesadas, la competencia era abrumadora y me hacia falta una estrategia de marketing adecuada.</p>
<p>&nbsp;</p>
<p><strong>¿Te identificas con esto?</strong></p>
<p>&nbsp;</p>
<p>Si es así, no te preocupes.Yo también pasé por esa situación, pero todo cambió cuando comencé a aplicar lo aprendido en la <strong>"Guía para Emprendedores de Multinivel.</strong></p>
<p>&nbsp;</p>
<p>¡No pierdas la oportunidad de descargar esta guía y alcanza el éxito en el mundo del emprendimiento multinivel!</p>');
	$subdominio_textarea1 = formatSpanish($subdominio_textarea1, 'Con Nuestra Guía Gratis Podrás Aprender de Manera Clara y Concisa a:');
	$subdominio_box1_image_description = formatSpanish($subdominio_box1_image_description, '<p><strong>Identificar tu Público Objetivo Multinivel:</strong></p>
<p>Descubre cómo identificar a tu público objetivo en el mundo del emprendimiento multinivel y conectarte con ellos de manera efectiva para aumentar las posibilidades de éxito en tu negocio.</p>');
	$subdominio_box2_image_description = formatSpanish($subdominio_box2_image_description, '<p><strong>Crear Contenido Atractivo para el Multinivel:</strong></p>
<p>Aprende cómo crear contenido de valor y atractivo para tu público objetivo en el mundo del emprendimiento multinivel que permitará aumentar la atracción tanto de clientes y afiliados.</p>');
	$subdominio_box3_image_description = formatSpanish($subdominio_box3_image_description, '<p><strong>Estrategias de Prospección para Multinivel:</strong></p>
<p>Descubre técnicas efectivas para la prospección y la identificación de clientes potenciales en el mundo del emprendimiento multinivel para aumentar tus posibilidades de éxito en tu negocio.</p>');
	$subdominio_single_image_description = formatSpanish($subdominio_single_image_description, '<p><strong>Descarga la guía ahora y comienza a atraer clientes sin esfuerzo</strong></p>
<p>Deja de luchar por conseguir y convertir prospectos en clientes y afiliados, y da el primer paso hacia el éxito en el mundo del emprendimiento multinivel.</p>');
	$subdominio_textarea2 = formatSpanish($subdominio_textarea2, 'Recuerda que el éxito en el multinivel es una travesía continua de aprendizaje, adaptación y crecimiento. Mantén tu pasión encendida, mantente enfocado(a) en tus metas y nunca subestimes el poder de tu dedicación y esfuerzo.');
	$short_length_cta_button_text = formatSpanish($short_length_cta_button_text, '<p style="text-align:center"><a href="https://www.sistema24x7.com/terminos">Términos y Condiciones</a>&nbsp;|&nbsp;<a href="https://www.sistema24x7.com/privacidad">Politica de Privacidad</a></p>');
	$subdominio_footer_description = formatSpanish($subdominio_footer_description, '<p>Este sitio no forma parte del sitio web de Facebook, Instagram o de Meta Platforms, Inc. Además, este sitio NO cuenta con el respaldo de Facebook ni de Instagram de ninguna manera. FACEBOOK e INSTAGRAM son marcas registradas de Meta Platforms, Inc.</p>
<p>Copyright 2024 Luis R Landero &trade;. Todos Los Derechos Reservados.</p>
<p>Diseñado por: webggio.com</p>');
}
