<?
//    extract($_POST); extract($_GET);

include('conexion.php');
include(DIRNAME(__FILE__) . DIRECTORY_SEPARATOR . "webinar-reg" . DIRECTORY_SEPARATOR . "functions.php");

$subdominio = mysql_real_escape_string($_GET['subdominio']);
$sponsor_subdominio = mysql_real_escape_string($_GET['sponsor_subdominio']);
$sponsor_param = mysql_real_escape_string($_GET['sponsor']);

if (empty($subdominio)) {
    if (!empty($sponsor_subdominio)) {
        $subdominio = $sponsor_subdominio;
        //            echo $subdominio; exit;
    }
}
//    echo $sponsor_param; exit;
$redirect_to_webinar = mysql_real_escape_string($_GET['webinar']);

if (!filter_var($subdominio, FILTER_VALIDATE_EMAIL) === false) {

    $getUserRow = $pdo_db->row("SELECT * FROM usuario WHERE email = '" . $subdominio . "' ");
    if (empty($getUserRow)) {
        header('Location: ' . VIONIKO_BASE_URL);
    } else {
        $getUserDefaultWebinar = $pdo_db->row("SELECT * FROM webinar WHERE webinar_admin_id = {$getUserRow['clave']} AND sales_funnel = 1 ");
        if (!empty($getUserDefaultWebinar)) {
            $webinar_id      = $getUserDefaultWebinar['ID'];
            $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$webinar_id} AND webinar_key = 'language'  ");
            if ($getWebinarMeta['webinar_value'] == 'english') {
                $language = '&lang=en';
            } else {
                $language = '';
            }
            $webinar_amin_id = $getUserDefaultWebinar['webinar_admin_id'];
            header('Location: ' . VIONIKO_BASE_URL . 'webinar-reg/?webinar_id=' . $webinar_id . '&admin_id=' . $webinar_amin_id . $language);
        } else {
            if (isset($getUserRow['template']) && $getUserRow['template'] != 0) {
                $getModeratorId = $pdo_db->row("SELECT moderador FROM landing_page WHERE clave = {$getUserRow['template']}");
                $getModeratorDefaultWebinar = $pdo_db->row("SELECT * FROM webinar WHERE webinar_admin_id = {$getModeratorId['moderador']} AND sales_funnel = 1 ");
                if (!empty($getModeratorDefaultWebinar)) {
                    $webinar_id      = $getModeratorDefaultWebinar['ID'];
                    $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$webinar_id} AND webinar_key = 'language'  ");
                    if ($getWebinarMeta['webinar_value'] == 'english') {
                        $language = '&lang=en';
                    } else {
                        $language = '';
                    }
                    $webinar_amin_id = $getModeratorDefaultWebinar['webinar_admin_id'];
                    header('Location: ' . VIONIKO_BASE_URL . 'webinar-reg/?webinar_id=' . $webinar_id . '&admin_id=' . $webinar_amin_id . $language);
                } else {
                    $getAminWebinar = $pdo_db->row("SELECT * FROM webinar WHERE webinar_admin_id = {$getUserRow['clave']}  ORDER BY ID DESC LIMIT 1");
                    $webinar_id      = $getAminWebinar['ID'];
                    $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$webinar_id} AND webinar_key = 'language'  ");
                    if ($getWebinarMeta['webinar_value'] == 'english') {
                        $language = '&lang=en';
                    } else {
                        $language = '';
                    }
                    $webinar_amin_id = $getAminWebinar['webinar_admin_id'];
                    header('Location: ' . VIONIKO_BASE_URL . 'webinar-reg/?webinar_id=' . $webinar_id . '&admin_id=' . $webinar_amin_id . $language);
                }
            } else {
                $getAminWebinar = $pdo_db->row("SELECT * FROM webinar WHERE webinar_admin_id = {$getUserRow['clave']}  ORDER BY ID DESC LIMIT 1");
                $webinar_id      = $getAminWebinar['ID'];
                $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$webinar_id} AND webinar_key = 'language'  ");
                if ($getWebinarMeta['webinar_value'] == 'english') {
                    $language = '&lang=en';
                } else {
                    $language = '';
                }
                $webinar_amin_id = $getAminWebinar['webinar_admin_id'];
                header('Location: ' . VIONIKO_BASE_URL . 'webinar-reg/?webinar_id=' . $webinar_id . '&admin_id=' . $webinar_amin_id . $language);
            }
        }
    }
} else {
    // Define the query
    $sql = "SELECT EXISTS(SELECT 1 FROM usuario WHERE subdominio = '$subdominio')";
    // Execute the query
    $result = mysql_query($sql);
    // Fetch the result
    $exists = mysql_result($result, 0);

    // Check if the row exists
    if ($exists) {
        $resUSU = mysql_query("SELECT clave, subdominio_template_last, subdominio_template_last_beta, subdominio_idioma, subdominio_templates, template, subdominio_templates_beta, subdominio FROM usuario WHERE subdominio = '$subdominio'", $conexion);
    } else { // Campain Subdomain block
        $resUSU = mysql_query("SELECT clave, subdominio_template_last, subdominio_template_last_beta, subdominio_idioma, subdominio_templates, template, subdominio_templates_beta, subdominio FROM usuario WHERE clave = (SELECT moderator FROM campana WHERE subdominio='$subdominio')", $conexion);
        $subdominioCampain = $subdominio;
        // var_dump("SELECT clave, usuario, orden FROM campana INNER JOIN campana_usuario ON campana.clave = campana_usuario.campana WHERE orden>=orden_next AND subdominio='$subdominio' AND acciones > 0 ORDER BY campana_usuario.orden ASC LIMIT 1");
        // exit;
        // $campana = mysql_fetch_array(mysql_query("SELECT clave, usuario, orden FROM campana INNER JOIN campana_usuario ON campana.clave = campana_usuario.campana WHERE orden=orden_next AND subdominio='$subdominio'", $conexion), MYSQL_ASSOC);
        $campana = mysql_fetch_array(mysql_query("SELECT clave, usuario, orden FROM campana INNER JOIN campana_usuario ON campana.clave = campana_usuario.campana WHERE orden>=orden_next AND subdominio='$subdominio' AND acciones > 0 ORDER BY campana_usuario.orden ASC LIMIT 1", $conexion), MYSQL_ASSOC);

        session_start();
        $_SESSION['campain'] = $campana;
    }
    // exit;


    // $resUSU = mysql_query("SELECT * FROM usuario WHERE subdominio = '$subdominio'", $conexion);
    $rowUSU = mysql_fetch_array($resUSU);
    $subdominio = $rowUSU['subdominio'];
    // echo "<pre>";
    // var_dump($rowUSU);
    // exit;

    //        $resUSU_sponsor_subdomain = mysql_query("SELECT * FROM usuario WHERE subdominio = '$sponsor_subdominio'",$conexion);
    //        $rowUSU_sponsor_subdomain = mysql_fetch_array($resUSU_sponsor_subdomain);
    //        echo mysql_num_rows($rowUSU_sponsor_subdomain); exit;
    //        echo '<pre>'; print_r($rowUSU_sponsor_subdomain); exit;
    $usuario = filter_var($rowUSU['clave'], FILTER_SANITIZE_NUMBER_INT);
    $last = $rowUSU['subdominio_template_last'];
    $last_beta = $rowUSU['subdominio_template_last_beta'];

    // redirect to werb
    if ($redirect_to_webinar) {
        $default_webinar = check_user_sales_funnel_template($usuario, "getWebinarId");
        if ($default_webinar) {
            // redirect to default webinar of admin
            $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$default_webinar} AND webinar_key = 'language'  ");
            // Subroto Start 
            $query = "SELECT * FROM usuario WHERE subdominio = '" . $subdominio . "'";
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);
            // var_dump($row);
            if ($row['subdominio_idioma'] == "eng") {
                $language = '&lang=en';
            } else {
                $language = '';
            }
            // var_dump($link);
            // Subroto End
            header('Location: ' . VIONIKO_BASE_URL . "webinar-reg/?webinar_id=" . intval($default_webinar) . "&admin_id=" . $usuario . $language);
            die();
        } else {
            $admin_moderator = getAdminModerator($usuario);
            $moderator_default_template = check_user_sales_funnel_template($admin_moderator, "getWebinarId");

            if (!$moderator_default_template) {
                echo "No Webinar Available!";
                die();
            }

            $getWebinarMeta  = $pdo_db->row("SELECT * FROM webinar_meta WHERE webinar_id = {$moderator_default_template} AND webinar_key = 'language'  ");
            if ($getWebinarMeta['webinar_value'] == 'english') {
                $language = '&lang=en';
            } else {
                $language = '';
            }

            header('Location: ' . VIONIKO_BASE_URL . "webinar-reg/?webinar_id=" . intval($moderator_default_template) . "&admin_id=" . $usuario . $language);
            die();
        }
    }

    if (mysql_num_rows($resUSU) > 0 and !empty($subdominio) and empty($sponsor_param)) {  // si es un subdominio v?lido
        // var_dump($subdominio, "p3");
        // exit;
        // echo '1'; exit;
        // var_dump($rowUSU['subdominio_idioma']); exit("Ok");
        $idioma = $rowUSU['subdominio_idioma'];
        if (empty($idioma)) $idioma = 'esp';
        $template_user = false;

        // determina el template a mostrar

        // si no tiene templates definidos en el perfil, usa el template grupal default
        // Template user der jonno kon page redirect korbe seta thik kore dey: landingpage->plantilla
        // For Moderator
        if (empty($rowUSU['subdominio_templates']) and empty($rowUSU['template'])) {
            $resTEM = mysql_query("SELECT * FROM landing_page WHERE principal = 1", $conexion);
            $rowTEM = mysql_fetch_array($resTEM);
            $template = $rowTEM['plantilla'];
            //     var_dump("SELECT * FROM landing_page WHERE principal = 1");
            //    echo $template.">>> +"; exit;
        }
        // si tiene template grupal definido
        if (!empty($rowUSU['template'])) {
            $tem = $rowUSU['template'];
            // var_dump("SELECT * FROM landing_page WHERE clave = $tem");
            $resTEM = mysql_query("SELECT * FROM landing_page WHERE clave = $tem", $conexion);
            $rowTEM = mysql_fetch_array($resTEM);
            $template = $rowTEM['plantilla'];
            $template_user = true;
            // echo $template.">>>"; exit;
        } // beta landing pages
        elseif (!empty($rowUSU['subdominio_templates_beta'])) {
            //                echo $rowUSU['subdominio_templates_beta']."|||"; exit;
            $templates = explode(',', $rowUSU['subdominio_templates_beta']);


            if (empty($last_beta)) {  // si no hay last usa el primero
                $template = trim($templates[0]);
            } else {

                // determina cual template sigue
                for ($i = 0; $i <= count($templates) - 1; $i++) {
                    if (trim($templates[$i]) == $last_beta) $template = trim($templates[$i + 1]);
                }
                // si no est? en la lista, usa el primero
                //                    if (empty($template))
                $template = trim($templates[0]);
            }  // si hay last
        } elseif (!empty($rowUSU['subdominio_templates'])) { // if not empty templates

            $templates = explode(',', $rowUSU['subdominio_templates']);


            if (empty($last)) {  // si no hay last usa el primero
                $template = trim($templates[0]);
            } else {

                // determina cual template sigue
                for ($i = 0; $i <= count($templates) - 1; $i++) {
                    if (trim($templates[$i]) == $last) $template = trim($templates[$i + 1]);
                }
                // si no est? en la lista, usa el primero
                if (empty($template)) $template = trim($templates[0]);
            }  // si hay last

        }  // si hay templates

        // echo $template; exit;
        // echo 'Last: '.$last.' Template: '.$template; exit;
        // $template = 190;
        if ($template > 164) {
            $beta_templates = array(
                165 => 1,
                166 => 2,
                167 => 3,
                168 => 4,
                169 => 5,
                170 => 6,
                171 => 7,
                172 => 8,
                173 => 9,
                174 => 10,
                175 => 11,
                176 => 12,
                177 => 13,
                179 => 14,
                180 => 15,
                181 => 16,
                182 => 17,
                183 => 18,
                184 => 19,
                185 => 20,
                186 => 21,
                187 => 22,
                188 => 23,
                189 => 24,
                190 => 25,
				191 => 26,
				192 => 27,
				193 => 28,
				194 => 29,
				195 => 30,
            );
            $params = $exists ? 'subdominio=' . $subdominio : 'campino=' . $subdominioCampain . '&subdominio=' . $subdominio;
            // var_dump($params);
            // exit;
            if ($idioma == 'esp') header('Location: landingpage/' . $beta_templates[$template] . 'beta/index_beta.php?' . $params);
            elseif ($idioma == 'eng') header('Location: landingpage/' . $beta_templates[$template] . 'beta/index_en_beta.php?' . $params);
            elseif ($idioma == 'por') header('Location: landingpage/' . $beta_templates[$template] . 'beta/index_po.php?subdominio=' . $subdominio);
        }
        //            else if($template_user && ($template >= 92 && $template <=104)){
        //                $beta_templates = array(92 => 1, 93 => 2, 94 => 3, 95 => 4, 96 => 5, 97 => 6, 98 => 7, 99 => 8,
        //                    100 => 9, 101 => 10, 102 => 11, 103 => 12, 104 => 13);
        //                if ($idioma=='esp') header('Location: landingpage/'.$beta_templates[$template].'beta/index_beta.php?subdominio='.$subdominio);
        //                elseif ($idioma=='eng') header('Location: landingpage/'.$beta_templates[$template].'beta/index_beta_en.php?subdominio='.$subdominio);
        //                elseif ($idioma=='por') header('Location: landingpage/'.$beta_templates[$template].'beta/index_po.php?subdominio='.$subdominio);
        //            }
        else {
            if ($idioma == 'esp') header('Location: landingpage/' . $template . '/index.php?subdominio=' . $subdominio);
            elseif ($idioma == 'eng') header('Location: landingpage/' . $template . '/index_en.php?subdominio=' . $subdominio);
            elseif ($idioma == 'por') header('Location: landingpage/' . $template . '/index_po.php?subdominio=' . $subdominio);
        }
    }  // si es un subdominio v?lido
    elseif (mysql_num_rows($resUSU) <= 0 and !empty($subdominio) and file_exists('./' . $subdominio)) {  // si no es un subdominio v?lido, va al directorio
        //            echo '2'; exit;
        header('Location: ' . $subdominio);
    }  // va al directorio
    elseif (mysql_num_rows($resUSU) > 0 and !empty($sponsor_param)) {
        //            echo "here"; exit;
        echo '3'; // exit;
        header('Location: ' . VIONIKO_BASE_URL . 'sponsor/?subdomain=' . $subdominio);
    } elseif (empty($subdominio)) {   // va al home
        //            echo '4'; exit;
        //            echo ">>".mysql_num_rows($rowUSU_sponsor_subdomain).">>"; exit;
        //            echo '<pre>'; print_r($rowUSU_sponsor_subdomain);
        header('Location: ' . VIONIKO_BASE_URL . 'principal.php');
    }  // va al home

    else {   // va al home
        //            echo "<<".mysql_num_rows($rowUSU_sponsor_subdomain); exit;
        //            echo '5'; exit;
        header('Location: ' . VIONIKO_BASE_URL . 'principal.php');
    } // va al home
}
