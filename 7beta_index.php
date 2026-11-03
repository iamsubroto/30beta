<? $template = 171;
include_once('../../subdominio_ini.php');
$edit_param = '';
if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
    $edit_param = "&mode=edit";
}

// Background image computation moved up to allow high-priority preloading
$usuario_temperory = $usuario;
$usuario_current = ($usuario_temp != "") ? $usuario_temp : $usuario_temperory;
$bacgkground_image_src = '';
$bg_image_raw_url = '';

if (file_exists("./../../images/landingpage/bg/" . $usuario_current . "/" . $usuario_current . ".webp")) {
    $bg_image_raw_url = '../../images/landingpage/bg/' . $usuario_current . '/' . $usuario_current . '.webp';
} else if (file_exists("./../../images/landingpage/bg/" . $usuario_current . "/" . $usuario_current . ".jpg")) {
    $bg_image_raw_url = '../../images/landingpage/bg/' . $usuario_current . '/' . $usuario_current . '.jpg';
} else if (file_exists("./../../images/landingpage/bg/" . $usuario_current . "/" . $usuario_current . ".jpeg")) {
    $bg_image_raw_url = '../../images/landingpage/bg/' . $usuario_current . '/' . $usuario_current . '.jpeg';
} else if (file_exists("./../../images/landingpage/bg/" . $usuario_current . "/" . $usuario_current . ".png")) {
    $bg_image_raw_url = '../../images/landingpage/bg/' . $usuario_current . '/' . $usuario_current . '.png';
} else if (file_exists("./../../images/landingpage/bg/" . $usuario_current . "/" . $usuario_current . ".gif")) {
    $bg_image_raw_url = '../../images/landingpage/bg/' . $usuario_current . '/' . $usuario_current . '.gif';
}
if ($bg_image_raw_url == '' && $background_image_library_url != '') {
    $bg_image_raw_url = $background_image_library_url;
}
if ($bg_image_raw_url == '') {
    if (file_exists("./../../images/default/bg/1317/1317.webp")) {
        $bg_image_raw_url = '../../images/default/bg/1317/1317.webp';
    } else if (file_exists("./../../images/default/bg/1317/1317.jpg")) {
        $bg_image_raw_url = '../../images/default/bg/1317/1317.jpg';
    } else if (file_exists("./../../images/default/bg/1317/1317.jpeg")) {
        $bg_image_raw_url = '../../images/default/bg/1317/1317.jpeg';
    } else if (file_exists("./../../images/default/bg/1317/1317.png")) {
        $bg_image_raw_url = '../../images/default/bg/1317/1317.png';
    } else if (file_exists("./../../images/default/bg/1317/1317.gif")) {
        $bg_image_raw_url = '../../images/default/bg/1317/1317.gif';
    }
    if ($bg_image_raw_url == '') {
        $bg_image_raw_url = $background_image_library_url_default;
    }
}
if (!empty($bg_image_raw_url)) {
    $bacgkground_image_src = 'background-image: url(' . $bg_image_raw_url . ')';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><? echo !empty($rowUSU['meta_titulo']) ? $rowUSU['meta_titulo'] : 'Landing Page'; ?></title>

    <meta name="description" content="<? echo !empty($rowUSU['meta_descripcion']) ? htmlspecialchars($rowUSU['meta_descripcion']) : ''; ?>" />
    <meta name="keywords" content="<? echo !empty($rowUSU['meta_palabras']) ? htmlspecialchars($rowUSU['meta_palabras']) : ''; ?>" />
    <meta name="author" content="<? echo !empty($rowUSU['nombre']) ? htmlspecialchars($rowUSU['nombre'] . ' ' . $rowUSU['apellidos']) : ''; ?>" />

    <!-- Para Facebook y otros -->
    <meta property="og:site_name" content="<? echo $rowUSU['meta_titulo']; ?>">
    <meta property="og:title" content="<? echo $rowUSU['meta_titulo']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<? echo $rowUSU['meta_descripcion']; ?>">

    <!-- Preconnect / DNS-Prefetch for Key Third Parties -->
    <link rel="preconnect" href="https://vioniko.s3.us-west-2.amazonaws.com" crossorigin>
    <link rel="dns-prefetch" href="https://vioniko.s3.us-west-2.amazonaws.com">
    <link rel="preconnect" href="https://img.youtube.com">
    <link rel="dns-prefetch" href="https://img.youtube.com">

    <?php if (!empty($bg_image_raw_url)): ?>
    <!-- Preload Hero Background Image for faster LCP -->
    <link rel="preload" as="image" href="<?php echo htmlspecialchars($bg_image_raw_url); ?>" fetchpriority="high">
    <?php endif; ?>

    <link rel="shortcut icon" href="../../favicon.ico" />

    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="css/estilos.css" />
    <link rel="stylesheet" href="../../css/landingpage/bootstrap_3.3.7_css_bootstrap.min.css">
    <link href="css/template-style.css" rel="stylesheet">

    <!-- Non-render-blocking font and editor stylesheets -->
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css"></noscript>
    <link rel="stylesheet" href="../../css/landingpage/bootstrap-colorpicker.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="../../css/landingpage/bootstrap-colorpicker.min.css"></noscript>

    <!-- Lightweight jQuery queue shim so inline scripts can run safely with deferred scripts -->
    <script>
        window._jqQ = window._jqQ || [];
        if (typeof window.$ === "undefined") {
            window.$ = window.jQuery = function(arg) {
                if (typeof arg === "function") {
                    window._jqQ.push(arg);
                }
                return {
                    ready: function(fn) { window._jqQ.push(fn); },
                    attr: function() { return this; },
                    click: function(fn) { window._jqQ.push(function(){ if (typeof jQuery !== "undefined") { jQuery(arg).click(fn); } }); return this; },
                    on: function() { return this; }
                };
            };
        }
    </script>

    <!-- Deferred JavaScript assets -->
    <script defer src="js/vendor/jquery.js"></script>
    <script defer src="js/vendor/modernizr.js"></script>
    <script defer src="js/foundation.min.js"></script>
    <script defer src="../../js/landinpage/bootstrap-colorpicker.js"></script>
    <script defer src="vendor/popper/popper.min.js"></script>
    <script defer src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <script defer src="../../js/vendor/ckeditor/ckeditor.js"></script>
    <script defer src="../../js/vendor/ckeditor/ckeditor_config.js"></script>
    <script defer src="../../js/landinpage/landing-page-editor-custom-es.js"></script>

    <?php
    include_once "../../usuarios/functions.php";
    echo getUserPixelCode($rowUSU["clave"], "fbpixel_lp");
    ?>
    <?php include_once('../../chatHandeler.php'); ?>
</head>

<body style="background: none !important;">
    <?php
    if (isset($_GET['blp_id'])) {
        $beta_landing_page_id = $_GET['blp_id'];
    }
    $video_src = '';
    if (file_exists("./../../images/landingpage/bg/" . $usuario . "/" . $usuario . ".mp4")) {
        $video_src = '../../images/landingpage/bg/' . $usuario . '/' . $usuario . '.mp4';
    }
    if ($video_src == '' && $background_image_library_url != '') {
        if (strstr($background_image_library_url, ".mp4")) {
            $video_src = $background_image_library_url;
        }
    }

    if ($youtube_bg != "") {
        $video_src = $youtube_bg;
    ?>
        <iframe id="background-video" loading="lazy" title="Background Video" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" width="640" height="360" src="https://www.youtube.com/embed/<?php echo $video_src; ?>?autohide=1&rel=0&autoplay=1&iv_load_policy=3&modestbranding=1&controls=0&showinfo=0&disablekb=1&enablejsapi=1&widgetid=1&mute=1&loop=1&playlist=<?php echo $video_src; ?>&origin=https://www.vioniko.com&modestbranding=1" style="position: fixed; inset: 0px; width: 1527.2px; height: 1259.05px; max-width: none; max-height: none; margin: -450.525px 0px 0px; z-index: -1; transform: translateY(60.2px) translateZ(0px);"></iframe>
    <?php
    } else if ($video_src != "") { ?>
        <video id="background-video1" preload="metadata" playsinline style="min-width: 100%; min-height: 100%; position: fixed; z-index: -1; <?php if ($video_src != "") { ?>display: block;<?php } else { ?> display: none; <?php } ?>" src="<?php if ($video_src != "") {
                                                                                                                                                                                                                    echo $video_src;
                                                                                                                                                                                                                } ?>" autoplay="" loop="">
        </video>
    <?php }
    ?>
    <div id="mySidenav" class="sidenav" style="display: none;">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="pane-content">
            <textarea id="mytextarea" name="mytextarea" style="display: none;"></textarea>

            <? include_once('../videoEditor.php'); ?>

            <div id="change-background-color-section">
                <div class="title">
                    <p class="pane-section-title">
                        Change Section Background Color
                    </p>
                </div>
                <div class="upload-input">
                    <div class="box-beta">
                        <a style="display: none; font-size: 15px;" href="#" class="btn-green" id="cp4">
                            Change color
                        </a>
                    </div>
                </div>

            </div>

            <form action="../../landingpage_data_save_en.php" method="post" enctype="multipart/form-data" name="forma" id="forma" class="form-horizontal">
                <input name='subdominio_titulo' class='subdominio_titulo' id='subdominio_titulo' value='<?= $titulo; ?>' type='hidden'><!-- landing page title-->
                <input name='subdominio_subtitulo' id='subdominio_subtitulo' value='<?= $subtitulo; ?>' type='hidden'><!-- landing page sub title-->
                <input name='subdominio_descripcion' id='subdominio_descripcion' value='<?= $descripcion; ?>' type='hidden'><!-- landing page textarea-->
                <input name='subdominio_puntos' id='subdominio_puntos' value='<?= $puntos; ?>' type='hidden'><!-- landing page bullet area-->
                <input name='subdominio_tituloformulario' id='subdominio_tituloformulario' value='<?= $titulo_formulario; ?>' type='hidden'><!-- landing page form title-->
                <input name='subdominio_textoformulario' id='subdominio_textoformulario' value='<?= $texto_formulario; ?>' type='hidden'><!-- landing page form sub title-->
                <input name='subdominio_boton' id='subdominio_boton' value='<?= $boton; ?>' type='hidden'><!-- landing page form submit button-->
                <input name='subdominio_video' id='subdominio_video' value='<?= $video; ?>' type='hidden'><!-- landing page iframe video-->
                <input name='videos' id='videos' value='<?= $videos; ?>' type='hidden'><!-- landing page video source -->
                <input name='language' id='language' value='esp' type='hidden'>

                <input name='subdominio_logo_bg' id='subdominio_logo_bg' value='<?php echo $logo_section_bg; ?>' type='hidden'>
                <input name='subdominio_titulo_bg' id='subdominio_titulo_bg' value='<?php echo $title_section_bg; ?>' type='hidden'>
                <input name='subdominio_subtitulo_bg' id='subdominio_subtitulo_bg' value='<?php echo $subtitle_section_bg; ?>' type='hidden'>
                <input name='subdominio_textarea_bg' id='subdominio_textarea_bg' value='<?php echo $textarea_section_bg; ?>' type='hidden'>
                <input name='subdominio_puntos_bg' id='subdominio_puntos_bg' value='<?php echo $bulleted_area_section_bg; ?>' type='hidden'>
                <input name='subdominio_form_bg' id='subdominio_form_bg' value='<?php echo $form_section_bg; ?>' type='hidden'>
                <input name='subdominio_tituloformulario_bg' id='subdominio_tituloformulario_bg' value='<?php echo $form_subtitle_bg; ?>' type='hidden'>
                <input name='subdominio_textoformulario_bg' id='subdominio_textoformulario_bg' value='<?php echo $form_subtitle_bg; ?>' type='hidden'>
                <input name='subdominio_footer_bg' id='subdominio_footer_bg' value='<?php echo $footer_section_bg; ?>' type='hidden'>
                <input name='subdominio_avatar_bg' id='subdominio_avatar_bg' value='' type='hidden'>
                <input name='subdominio_author_info_bg' id='subdominio_author_info_bg' value='' type='hidden'>
                <input name='subdominio_form_name_placeholder' id='subdominio_form_name_placeholder' value='<?php echo $form_input_name_placeholder; ?>' type='hidden'>
                <input name='subdominio_form_email_placeholder' id='subdominio_form_email_placeholder' value='<?php echo $form_input_email_placeholder; ?>' type='hidden'>
                <input name='subdominio_form_whatsapp_placeholder' id='subdominio_form_whatsapp_placeholder' value='<?php echo $form_input_whatsapp_placeholder; ?>' type='hidden'>
                <input name='subdominio_form_whatsapp_visible' id='subdominio_form_whatsapp_visible' value='<?php echo $form_input_whatsapp_visible; ?>' type='hidden'>
                <input name='subdominio_background_image_library_url' id='subdominio_background_image_library_url' value='<?php echo $background_image_library_url; ?>' type='hidden'>
                <input name='bg_LIBRARY_change_time_en' id='bg_LIBRARY_change_time_en' value='0' type='hidden'>
                <input name='bg_UPLOAD_change_time_en' id='bg_UPLOAD_change_time_en' value='0' type='hidden'>
                <input name='subdominio_form_submit_button' id='subdominio_form_submit_button' value='<?php echo $form_submit_button_bg; ?>' type='hidden'>
                <input name='short_length_cta_button_text' id='short_length_cta_button_text' value='<?php echo $short_length_cta_button_text; ?>' type='hidden'>
                <input name='full_length_cta_button_text' id='full_length_cta_button_text' value='<?php echo $full_length_cta_button_text; ?>' type='hidden'>
                <input name='short_length_cta_button_bg' id='short_length_cta_button_bg' value='<?php echo $short_length_cta_button_bg; ?>' type='hidden'>
                <input name='full_length_cta_button_bg' id='full_length_cta_button_bg' value='<?php echo $full_length_cta_button_bg; ?>' type='hidden'>
                <input name='beta_landing_page_id' id='beta_landing_page_id' value='98' type='hidden'>
                <input name='template_id' id='template_id' value='<?php echo $tem; ?>' type='hidden'>
                <!--            <input name='beta_landing_page_id' id='beta_landing_page_id' value='--><?php //echo $beta_landing_page_id; 
                                                                                                        ?><!--' type='hidden'>-->
                <input name='subdominio_textarea1' id='subdominio_textarea1' value='<?php echo $subdominio_textarea1; ?>' type='hidden'>
                <input name='subdominio_textarea1_bg' id='subdominio_textarea1_bg' value='<?php echo $subdominio_textarea1_bg; ?>' type='hidden'>
                <input name='subdominio_textarea2' id='subdominio_textarea2' value='<?php echo $subdominio_textarea2; ?>' type='hidden'>
                <input name='subdominio_textarea2_bg' id='subdominio_textarea2_bg' value='<?php echo $subdominio_textarea2_bg; ?>' type='hidden'>
                <input name='slider_images_list' id='slider_images_list' value='<?php echo $slider_images_list; ?>' type='hidden'>
                <input name='subdominio_box1_image' id='subdominio_box1_image' value='<?php echo $subdominio_box1_image; ?>' type='hidden'>
                <input name='subdominio_box2_image' id='subdominio_box2_image' value='<?php echo $subdominio_box2_image; ?>' type='hidden'>
                <input name='subdominio_box3_image' id='subdominio_box3_image' value='<?php echo $subdominio_box3_image; ?>' type='hidden'>
                <input name='subdominio_body_background_color' id='subdominio_body_background_color' value='<?php echo $subdominio_body_background_color; ?>' type='hidden'>

                <div id="change-logo-section">
                    <div class="title">
                        <p class="pane-section-title">
                            Change Logo
                        </p>
                    </div>
                    <div class="upload-input">
                        <label>Change Section logo</label>
                        <input type="file" name="sectionImageUpload" class="imageUpload" id="sectionImageUpload">
                    </div>

                </div>
                <div id="change-avatar-section">
                    <div class="title">
                        <p class="pane-section-title">
                            Change Image
                        </p>
                    </div>
                    <div id="avatar-image-upload" class="upload-input">
                        <label>Change Footer Avatar</label>
                        <input type="file" name="sectionAvatarUpload" class="imageUpload" id="sectionAvatarUpload">
                    </div>
                    <div id="box1-image-upload" class="upload-input">
                        <label>Change Box Image</label>
                        <input type="file" name="sectionBox1Upload" class="imageUpload" id="sectionBox1Upload">
                    </div>

                </div>
                <div id='change-bg-section'>
                    <div class="title">
                        <p class="pane-section-title">
                            Change Background
                        </p>
                    </div>
                    <div class="upload-input">
                        <div class="box-beta">
                            <a class="btn-green" href="#popup1">Choose Image From Library</a>
                        </div>
                    </div>
                    <div class="upload-input">
                        <div class="box-beta">
                            <a style="display: none;" href="#" class="btn-green" id="cp_background">
                                Set Background color with opactiy
                            </a>
                        </div>
                    </div>
                    <div class="or-seperator">
                        <p class="text-center or">
                            <span>OR</span>
                        </p>
                    </div>
                    <div class="upload-input">
                        <div class="box-beta">
                            <a class="btn-green" href="#popup-video">Choose Video From Library</a>
                        </div>
                    </div>
                    <div class="or-seperator">
                        <p class="text-center or">
                            <span>OR</span>
                        </p>
                    </div>
                    <div class="upload-input">
                        <label>Upload Background Image</label>
                        <!--                    Warning: POST Content-Length of 48387348 bytes exceeds the limit of 8388608 bytes in Unknown on line 0-->
                        <input type="file" accept="video/*,image/*" name="backgroundImageUpload" class="imageUpload" id="backgroundImageUpload" onchange='recordDateTime("bg_UPLOAD_change_time_en");'>
                    </div>
                    <div class="or-seperator">
                        <p class="text-center or">
                            <span>OR</span>
                        </p>
                    </div>
                    <div class="upload-input">
                        <label>Background Youtube video ID</label>
                        <input type="text" class="form-control" id="youtube_bg_en" name="youtube_bg_en" placeholder="Enter a Background Youtube video ID" value="">
                    </div>


                    <!-- skype hide option ----->


                    <div class="or-seperator">
                        <p class="text-center or">
                            <span>OR</span>
                        </p>
                    </div>
                    <div>
                        <label>Hide Skype</label><br>
                        <input type="radio" id="show_skype" <?php if ($hide_skype == 'no') {
                                                                echo 'checked';
                                                            } ?> name="hide_skype" value="no">
                        <label for="hide_skype">No</label>
                        <input type="radio" id="hide_skype" <?php if ($hide_skype == 'yes') {
                                                                echo 'checked';
                                                            } ?> name="hide_skype" value="yes">
                        <label for="show_skype">Yes</label><br>
                    </div>


                </div>
            </form>
        </div>

        <div>
            <div>
                <div id="popup1" class="overlay">
                    <div class="popup-beta">
                        <span class="close-bg"><a class="close" href="#">&times;</a></span>
                        <div class="select-file">
                            <div class="popup-inner">
                                <?php
                                $dirname = "../../images/bg/thumbnail/";
                                $images = glob($dirname . "*.jpg");
                                //                                echo '<pre>'; print_r($images); exit;
                                $i = 0;
                                foreach ($images as $image) {
                                    if ($i == 6) {
                                        break;
                                    }
                                    //                                    echo $image."<br/>";
                                    echo '<div class="popup-img">';
                                    echo '<input type="checkbox" name="">';
                                    echo '<img class="img-responsive" loading="lazy" decoding="async" width="200" height="150" alt="Background Thumbnail" src="' . $image . '"/>';
                                    echo '</div>';
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div>
                <div id="popup-video" class="overlay">
                    <div class="popup-beta">
                        <span class="close-bg"><a class="close" href="#">&times;</a></span>
                        <div class="select-file">
                            <div class="popup-inner">
                                <?php
                                // $dirname = "../../videos/bg/thumbnail/";
                                //$images = glob($dirname."*.jpg");
                                include_once('../youtube_library.php');
                                //  $images = ['fL2Xvkd-9JA', '6sgF_aqN4rM', 'Fgi1YOJT7gs', 'G8QnduC7_SU', 'R9TPrwJtKkI', 'uhc-Eh2DyR8', 'sNGQru0Egrs', 'MdTqMCNxRfY'];
                                foreach ($images as $image) {
                                    echo '<div class="popup-img">';
                                    echo '<input type="checkbox" name="" class="video-responsive" data-title="' . $image . '" data-id="https://www.youtube.com/embed/' . $image . '?autohide=1&rel=0&autoplay=1&iv_load_policy=3&modestbranding=1&controls=0&showinfo=0&disablekb=1&enablejsapi=1&widgetid=1&mute=1&loop=1&playlist=' . $image . '&origin=https://www.vioniko.com&modestbranding=1">';
                                ?>
                                    <iframe class="lazy-yt-iframe" id="youtube-video" loading="lazy" width="100%" height="220" frameborder="0" title="YouTube video preview" srcdoc="&lt;style&gt;*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img{position:absolute;width:100%;top:0;bottom:0;margin:auto;object-fit:cover}&lt;/style&gt;&lt;a href='https://www.youtube.com/embed/<?= $image; ?>?autoplay=1'&gt;&lt;img src='https://img.youtube.com/vi/<?= $image; ?>/mqdefault.jpg' alt='YouTube Video Preview' width='100%' height='220'&gt;&lt;/a&gt;"></iframe>
                                <?php
                                    //  echo '<img class="video-responsive" src="'.$image.'"/>';
                                    //                                echo '<video class="video-responsive" src="'.$image.'"></video>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Page Content -->
    <?php
    if (empty($bacgkground_image_src) && !empty($bg_image_raw_url)) {
        $bacgkground_image_src = 'background-image: url(' . $bg_image_raw_url . ')';
    }
    ?>
    <div class="content" id="content" <?php if ($video_src != "") { ?> style="background: none; background-image: none;" <?php } ?> <?php if ($bacgkground_image_src != '') { ?> style='<?php echo $bacgkground_image_src; ?>' <?php } ?>>
        <div class="layer" <?php if ($subdominio_body_background_color != "") { ?> style="background-color: <?php echo $subdominio_body_background_color; ?>;" <?php } ?>>
            <div class="main-content-inner" style="padding: 40px">
                <div class="container-fluid">
                    <!-- <div class="row">
                        <div class="large-12 columns cont-datos" align="right">
                            <span><? if ($landing) $url = 'index_en_beta.php?landing=' . $landing . $edit_param;
                                    elseif ($usuario and $version) $url = 'index_en_beta.php?usuario=' . $usuario . '&v=' . $version . $edit_param;
                                    else $url = 'index_en_beta.php?subdominio=' . $subdominio . $edit_param; ?>
                                <a href="<?= $url; ?>" class="emaillink"><img src="img/gb.png" width="16" height="11" alt=""> English</a>
                            </span>
                        </div>
                    </div> -->

                    <!-- Template Header starts -->
                    <div class="row">
                        <div class="section-bg">
                            <div class="hover-edit">
                                <div class="temp-title" data-id="landing-page-title" <?php if ($title_section_bg != '') { ?> style="background: <?php echo $title_section_bg; ?>" <?php } ?>>
                                    <?php
                                    $titulo = str_replace('<h1></h1>', '', $titulo);
                                    if (strpos($titulo, 'h1') == false) {
                                        echo '<h1>' . $titulo . '</h1>';
                                    } else {
                                        echo $titulo;
                                    }
                                    ?>
                                </div>
                                <!-- Edit Starts -->
                                <div class="edit-btn-container">
                                    <a id="title" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </div>
                                <!-- Edit Ends -->
                            </div>
                        </div>
                    </div>
                    <!-- Template Header Ends -->
                    <div class="space"></div>
                    <!-- Video/Form section Starts -->
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-12"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <? include_once('../videoPlayer.php'); ?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="section-bg">
                                <div id="popup-form" class="overlay">
                                    <div class="popup-beta">
                                        <span class="close-bg"><a class="close" href="#">&times;</a></span>
                                        <div class="popup-inner">
                                            <div class="form-new new" data-id="landing-page-whole-form" <?php if ($form_section_bg != "") { ?> style="background: <?php echo $form_section_bg; ?>" <?php } ?>>
                                                <!-- Edit Starts -->
                                                <div class="edit-btn-container" style="right: 40px; top: 43px;">
                                                    <a id="whole-form" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <!-- Edit Ends -->
                                                <div class="temp-form">
                                                    <div class="hover-edit">
                                                        <div class="form-title" data-id="landing-page-form-title" <?php if ($form_title_bg != '') { ?> style="background: <?php //echo $form_title_bg;
                                                                                                                                                                            ?>" <?php } ?>>
                                                            <h2><?= $titulo_formulario; ?></h2>
                                                        </div>
                                                        <!-- Edit Starts -->
                                                        <div class="edit-btn-container">
                                                            <a id="form-title" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </div>
                                                        <!-- Edit Ends -->
                                                    </div>
                                                    <div class="hover-edit">
                                                        <div class="form-subtitle" data-id="landing-page-form-sub-title" <?php if ($form_subtitle_bg != '') { ?> style="background: <?php //echo $form_subtitle_bg;
                                                                                                                                                                                    ?>" <?php } ?>>
                                                            <h6><?= $texto_formulario; ?></h6>
                                                        </div>
                                                        <!-- Edit Starts -->
                                                        <div class="edit-btn-container">
                                                            <a id="form-subtitle" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </div>
                                                        <!-- Edit Ends -->
                                                    </div>
                                                    <form action="<?php echo $result ?>" method="post" class="cf op-optin-validation" data-abide>
                                                        <div class=" hover-edit">
                                                            <div class="form-group">
                                                                <input type="text" name="nombre" class="form-control" id="name" required placeholder="<?php echo ($form_input_name_placeholder != "") ? $form_input_name_placeholder : 'Ingresa tu Nombre' ?>" data-id="form-name-placeholder">
                                                                <small class="error-beta" style="display: none;">You must enter your name.</small>
                                                            </div>
                                                            <!-- Edit Starts -->
                                                            <div class="edit-btn-container">
                                                                <a id="form-name" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            </div>
                                                            <!-- Edit Ends -->
                                                        </div>
                                                        <div class=" hover-edit">
                                                            <div class="form-group">
                                                                <input type="email" name="email" class="form-control" required id="e-mail" placeholder="<?php echo ($form_input_email_placeholder != "") ? $form_input_email_placeholder : 'Ingresa tu E-mail' ?>" data-id="form-email-placeholder">
                                                                <small class="error-beta" style="display: none;">You must enter a e-mail.</small>
                                                            </div>
                                                            <!-- Edit Starts -->
                                                            <div class="edit-btn-container">
                                                                <a id="form-email" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            </div>
                                                            <!-- Edit Ends -->
                                                        </div>
                                                        <?php //if($form_input_whatsapp_visible != '1'){ 
                                                        ?>
                                                        <div class="hover-edit" id="whatsapp_field_div" <?php if ($form_input_whatsapp_visible == '1') { ?> style="display: none" <?php } ?>>
                                                            <div class="form-group">
                                                                <input type="tel" class="form-control" id="whatsapp" placeholder="<?php echo ($form_input_whatsapp_placeholder != "") ? $form_input_whatsapp_placeholder : 'Ingresa tu whatsapp' ?>" data-id="form-whatsapp-placeholder">
                                                            </div>
                                                            <!-- Edit Starts -->
                                                            <div class="edit-btn-container">
                                                                <a id="form-whatsapp" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);" onclick="(($(this).parent('.edit-btn-container')).parent('.hover-edit')).hide(); $('#whatsapp_field_div').hide();$('#whatsapp_show_again').removeAttr('checked'); $('#whatsapp_show_again_div').show(); $('#subdominio_form_whatsapp_visible').val(1);" class="dlt-btn"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                            <!-- Edit Ends -->
                                                        </div>
                                                        <?php //if($form_input_whatsapp_visible == '1'){ 
                                                        ?>
                                                        <div class="hover-edit12" id="whatsapp_show_again_div" <?php if ($form_input_whatsapp_visible == '1') { ?> style="display: block;" <?php } ?> style="display: none;">
                                                            <div class="form-group">
                                                                <input type="checkbox" style="opacity:1; position: relative;" name="whatsapp_show_again" id="whatsapp_show_again" value="whatsapp_show_again">Show whatsapp field
                                                            </div>
                                                        </div>
                                                        <?php //} 
                                                        ?>
                                                        <div class="hover-edit">
                                                            <div class="form-group">
                                                                <button <?php if ($form_submit_button_bg != '') { ?> style="background: <?php echo $form_submit_button_bg; ?>" <?php } ?> type="submit" data-id="landing-page-form-submit-button" class="btn btn-default btn-submit"><?= $boton; ?></button>
                                                            </div>
                                                            <!-- Edit Starts -->
                                                            <div class="edit-btn-container">
                                                                <a id="form-submit" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                <!--                                        <a href="#" class="dlt-btn"><i class="fa fa-trash"></i></a>-->
                                                            </div>
                                                            <!-- Edit Ends -->
                                                        </div>
                                                        <!-- TERMINA TITULO DEL BOTON DEL FORMULARIO-->
                                                        <input type="hidden" name="pais" id="pais" value="<? echo $geo["geoplugin_countryName"]; ?>">
                                                        <input type="hidden" name="ciudad" id="ciudad" value="<? echo $geo["geoplugin_city"]; ?>">
                                                        <input type="hidden" name="estado" id="estado" value="<? echo $geo["geoplugin_regionName"]; ?>">
                                                        <? include('../campana_user.php'); ?>
                                                        <input type="hidden" name="usuario" id="usuario" value="<?= $userIdBySubdomain; ?>">
                                                        <input type="hidden" name="template" id="template" value="<?= $template; ?>">
                                                        <input type="hidden" name="idioma" id="idioma" value="es">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hover-edit">
                                    <div class="temp-text" data-id="landing-page-text-area" <?php if ($textarea_section_bg != "") { ?> style="background: <?php echo $textarea_section_bg; ?>" <?php } ?>>
                                        <?= $descripcion; ?>
                                    </div>
                                    <!-- Edit Starts -->
                                    <div class="edit-btn-container">
                                        <a id="text-area" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </div>
                                    <!-- Edit Ends -->
                                </div>
                                <div class="cta-button-under-form" style="margin: 1em 0px;">
                                    <div class="hover-edit">
                                        <div class="form-group">
                                            <button <?php if ($short_length_cta_button_bg != '') { ?> style="width: 100%; background: <?php echo $short_length_cta_button_bg; ?>" <?php } ?> type="button" onclick="window.location.href='#popup-form'" class="btn btn-default btn-submit" data-id="form-short-width-cta-button" style="width: 100%;"><?php if ($short_length_cta_button_text != '') {
                                                                                                                                                                                                                                                                                                                                                            echo $short_length_cta_button_text;
                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                            echo 'CTA Button';
                                                                                                                                                                                                                                                                                                                                                        } ?></button>
                                        </div>
                                        <!-- Edit Starts -->
                                        <div class="edit-btn-container">
                                            <a id="cta-button-short" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </div>
                                        <!-- Edit Ends -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12"></div>
                    </div>
                    <!-- Video/Form section Ends -->
                    <div class="space"></div>
                    <!-- Text section Starts -->
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="section-bg">
                                    <div class="hover-edit">
                                        <div class="temp-bullets" data-id="landing-page-bullet-area" <?php if ($bulleted_area_section_bg != "") { ?> style="background: <?php echo $bulleted_area_section_bg; ?>" <?php } ?>>
                                            <?= $puntos; ?>
                                        </div>
                                        <!-- Edit Starts -->
                                        <div class="edit-btn-container">
                                            <a id="bullets-area" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </div>
                                        <!-- Edit Ends -->
                                    </div>
                                </div>
                            </div>
                            <?php
                            $box_image_src = 'img/free-ebook-cover.jpg';

                            if (file_exists("./box1_10767.png")) {
                                $box_image_src = 'box1_10767.png';
                            }

                            if (file_exists("../../images/default/landingpage/box1_1317.webp")) {
                                $box_image_src = '../../images/default/landingpage/box1_1317.webp';
                            } else if (file_exists("../../images/default/landingpage/box1_1317.jpg")) {
                                $box_image_src = '../../images/default/landingpage/box1_1317.jpg';
                            } else if (file_exists("../../images/default/landingpage/box1_1317.jpeg")) {
                                $box_image_src = '../../images/default/landingpage/box1_1317.jpeg';
                            } else if (file_exists("../../images/default/landingpage/box1_1317.png")) {
                                $box_image_src = '../../images/default/landingpage/box1_1317.png';
                            } else if (file_exists("../../images/default/landingpage/box1_1317.gif")) {
                                $box_image_src = '../../images/default/landingpage/box1_1317.gif';
                            }

                            if (file_exists("../../images/landingpage/box1_" . $usuario . ".webp")) {
                                $box_image_src = '../../images/landingpage/box1_' . $usuario . '.webp';
                            } else if (file_exists("../../images/landingpage/box1_" . $usuario . ".jpg")) {
                                $box_image_src = '../../images/landingpage/box1_' . $usuario . '.jpg';
                            } else if (file_exists("../../images/landingpage/box1_" . $usuario . ".jpeg")) {
                                $box_image_src = '../../images/landingpage/box1_' . $usuario . '.jpeg';
                            } else if (file_exists("../../images/landingpage/box1_" . $usuario . ".png")) {
                                $box_image_src = '../../images/landingpage/box1_' . $usuario . '.png';
                            } else if (file_exists("../../images/landingpage/box1_" . $usuario . ".gif")) {
                                $box_image_src = '../../images/landingpage/box1_' . $usuario . '.gif';
                            }
                            if ($subdominio_box1_image == 1) {
                                $box_image_src = '../../images/bg/transparent.png';
                            }
                            ?>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="section-bg">
                                    <div class="hover-edit">
                                        <div class="temp-box" data-id="landing-page-box-1">
                                            <img width="300" height="300" loading="lazy" decoding="async" style="height:300px; max-width:100%; object-fit:contain;" src="<?php echo $box_image_src; ?>" alt="Landing Page Box Image" />
                                        </div>
                                        <!-- Edit Starts -->
                                        <div class="edit-btn-container">
                                            <a id="box-1" onclick="imageSectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0);" onclick="$('#subdominio_box1_image').val('1'); ($(this).parent('.edit-btn-container')).parent('.hover-edit').find('img').attr('src', '../../images/bg/transparent.png');" class="dlt-btn"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <!-- Edit Ends -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                    <!-- Text section Ends -->
                    <div class="space"></div>
                    <!-- footer starts -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-bg">
                                <div class="row temp-footer-beta temp-footer" id="site_whole_footer" <?php if ($hide_skype == 'yes') {
                                                                                                            echo 'style="display:none"';
                                                                                                        } ?>
                                    data-id="landing-page-whole-footer" <?php if ($footer_section_bg != '') { ?> style="background: <?php echo $footer_section_bg; ?>" <?php } ?>>
                                    <!--                        <div></div>-->
                                    <div class="edit-btn-container">
                                        <a id="footer-whole-section" onclick="sectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-11">
                                        <div class="hover-edit">
                                            <div class="author-img">
                                                <? if (file_exists('./../../images/avatars/' . $rowUSU['clave'] . '.webp'))
                                                    echo '<img src="../../images/avatars/' . $rowUSU['clave'] . '.webp" class="imagen" alt="Avatar" width="110" height="110" loading="lazy" decoding="async">';
                                                else if (file_exists('./../../images/avatars/' . $rowUSU['clave'] . '.jpg'))
                                                    echo '<img src="../../images/avatars/' . $rowUSU['clave'] . '.jpg" class="imagen" alt="Avatar" width="110" height="110" loading="lazy" decoding="async">';
                                                else if (file_exists('./../../images/avatars/' . $rowUSU['clave'] . '.jpeg'))
                                                    echo '<img src="../../images/avatars/' . $rowUSU['clave'] . '.jpeg" class="imagen" alt="Avatar" width="110" height="110" loading="lazy" decoding="async">';
                                                else if (file_exists('./../../images/avatars/' . $rowUSU['clave'] . '.png'))
                                                    echo '<img src="../../images/avatars/' . $rowUSU['clave'] . '.png" class="imagen" alt="Avatar" width="110" height="110" loading="lazy" decoding="async">';
                                                else if (file_exists('./../../images/avatars/' . $rowUSU['clave'] . '.gif'))
                                                    echo '<img src="../../images/avatars/' . $rowUSU['clave'] . '.gif" class="imagen" alt="Avatar" width="110" height="110" loading="lazy" decoding="async">';
                                                ?>
                                            </div>
                                            <div class="edit-btn-container">
                                                <a id="footer-avatar" onclick="imageSectionEdit(this.id); openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-5 col-xs-12">
                                        <div class="hover-edit12">
                                            <div class="author-desc">
                                                <p class="author-name"><? echo $rowUSU['nombre'] . ' ' . $rowUSU['apellidos']; ?></p>
                                                <p class="author-phone"><? if (!empty($rowUSU['telefono_oficina']) and $rowUSU['pubtel'] == 1) echo '' . $rowUSU['telefono_oficina']; ?></p>
                                                <p class="author-mail">
                                                    <a href="mailto:<? echo $rowUSU['email']; ?>" class=""><? echo $rowUSU['email']; ?></a>
                                                </p>
                                                <p>
                                                    <a href="https://wa.me/<?= $rowUSU['telefono_ip']; ?>" aria-label="Contact by WhatsApp">
                                                        <img src="https://vioniko.com/landingpage/whatsapp.png" style="border: none;" width="25" height="25" alt="Call by whatsapp" loading="lazy" decoding="async" />
                                                    </a>
                                                    <!--                                        <a href="#"><i class="fa fa-2x fa-skype" aria-hidden="true"></i></a>-->
                                                </p>
                                            </div>
                                            <!--                                <div class="edit-btn-container">-->
                                            <!--                                    <a id="footer-author-info" onclick=" sectionEdit(this.id);openNav()" href="javascript:void(0);" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                            <!--                                </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                    <!-- footer ends -->
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php include_once('../restore-content.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Process queued jQuery ready callbacks once deferred jQuery is loaded
            if (window._jqQ && window._jqQ.length && typeof jQuery !== "undefined") {
                while (window._jqQ.length) {
                    var fn = window._jqQ.shift();
                    try { fn(jQuery); } catch (e) { console.error(e); }
                }
            }
            // Skype visibility controls
            var hideSkype = document.getElementById('hide_skype');
            var showSkype = document.getElementById('show_skype');
            var siteFooter = document.getElementById('site_whole_footer');
            if (hideSkype && siteFooter) {
                hideSkype.addEventListener('click', function() { siteFooter.style.display = 'none'; });
            }
            if (showSkype && siteFooter) {
                showSkype.addEventListener('click', function() { siteFooter.style.display = 'block'; });
            }
        });
    </script>
</body>

</html>