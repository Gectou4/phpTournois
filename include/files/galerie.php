<?php

if (preg_match("/galerie.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if (!$config['galerie']) js_goto('?page=index');

$config['gallery_path'] = "./images/album/";
$config['gallery_max_filesize'] = 2000000;

################################################################################
# Checks if a file or directory is "new"
function is_new($filename)
{
    global $config;

    if (!file_exists($filename)) return false;
    return (filectime($filename) > (time() - 7 * 24 * 3600));
}

################################################################################
# Checks for permissions on either pictures, galleries, config files, etc...

function check_perms($filename)
{
    global $strPermissionInvalide;

    if (!file_exists($filename)) return false;

    $fileperms = fileperms($filename);
    $isreadable = $fileperms & 4;

    if (is_file($filename)) {
        // pictures, thumbnails, config files and comments only need to be readable
        if (!$isreadable) show_warning("$strPermissionInvalide : $filename");
        return $isreadable;
    } elseif (is_dir($filename)) {
        // galleries need to be both readable and executable
        $isexecutable = $fileperms & 1;
        if (!$isreadable || !$isexecutable) show_warning("$strPermissionInvalide : $filename");
        return ($isreadable && $isexecutable); // ($dirperms & 5) == 5 ?
    }

    // default behavior: the filename does not exist
    return false;
}

################################################################################
# Checks if the filname exists, refers to a picture associated to a thumbnail
# and is granted the necessary access rigths

function is_picture($picture_filename, $galid)
{
    global $config;

    $picture_path = $config['gallery_path'] . "/$galid/$picture_filename";
    $thumbnail_path = $config['gallery_path'] . "/$galid/_thb_$picture_filename";

    // check filename patterns
    if (preg_match("/^_thb_*/i", $picture_filename) || (!preg_match("/.jpg$/i", $picture_filename) && !preg_match("/.png$/i", $picture_filename) && !preg_match("/.gif$/i", $picture_filename))) return false;

    // does it exist, is it a regular file and does it have the expected permissions ?
    if (!check_perms($picture_path)) return false;

    // an associated thumbnail is required... same job again !
    if (!check_perms($thumbnail_path)) {
        create_thumb($picture_path, $thumbnail_path, 100);
    }

    return true;
}

##############################################################################
# Checks if the directory corresponding the gallery is well-formed, exists
# and is granted the necessary access rights

function is_gallery($galid)
{
    global $config;
    global $strPermissionInvalide;

    $picspath = $config['gallery_path'] . "/$galid";

    // searching for hazardous patterns
    if (preg_match("!^/!", $galid) || preg_match("!\.\.!", $galid) || preg_match("!/$!", $galid)) return false;

    // does it exist, is it a directory and does it have the expected permissions ?
    if (!check_perms($picspath)) {
        return false;
    }

    return true;
}


################################################################################
# returns an array containing info about the number of pictures in a given gallery
# $array[0] = total number of pictures
# $array[1] = number of new pictures

function count_pictures($galid)
{
    global $config;

    $nbpics_total = 0;
    $nbpics_new = 0;
    $galdir = $config['gallery_path'] . "/$galid";

    $dir = @opendir($galdir);
    if (!$dir) return -1;

    while ($file = readdir($dir)) {
        if (is_picture($file, $galid)) {
            $nbpics_total++;
            if (is_new($galdir . "/" . $file)) $nbpics_new++;
        }
    }
    closedir($dir);
    $nbpics_info[0] = $nbpics_total;
    $nbpics_info[1] = $nbpics_new;

    return $nbpics_info;
}


################################################################################
# Creates a sorted array of the thumbnails to diplay for a given gallery
# $galid - the gallery ID (must be always valid)
# $filter - the filter that defines the pictures to include in the list
# returns: a sorted array containing the thumbnails' basenames of the gallery

function create_pics_array($galid)
{
    global $config;

    $picpath = $config['gallery_path'] . "/$galid/";
    $dir = opendir($picpath);

    $pics = array();
    $picsk = array();

    while ($file = readdir($dir)) {
        if (is_picture($file, $galid)) {
            $pics[$file] = $file;
        }
    }
    closedir($dir);

    if (count($pics) > 0) {
        asort($pics);
        reset($pics);
        while (list ($key, $val) = each($pics)) {
            $picsk[count($picsk)] = $key;
        }
    }

    return $picsk;
}


###############################
function create_thumb($name, $th_name, $th_height)
{
    global $config;
    global $strPermissionInvalide, $strExtensionNonSupporte;

    $im = '';
    $result = 0;

    if (extension_loaded('gd')) {
        $info = [];
        $data = @GetImageSize($name, $info);

        if ($data == NULL) {
            show_warning("$strPermissionInvalide : $name");
        } else {
            switch ($data[2])  // open permission needed
            {
                case 1:
                    $imgtype = 'GIF';
                    $im = @imagecreatefromgif($name);
                    break; // GIF
                case 2:
                    $imgtype = 'JPEG';
                    $im = @imagecreatefromjpeg($name);
                    break; // JPG
                case 3:
                    $imgtype = 'PNG';
                    $im = @imagecreatefrompng($name);
                    break;  // PNG
            }
            if ($im == '') {
                show_warning("$strExtensionNonSupporte : $imgtype");
            } else {
                $w = ImageSX($im);
                $h = ImageSY($im);
                $nw = round($w * $th_height / $h);
                $nh = $th_height;

                if (function_exists("ImageCreateTrueColor")) {   // GD 2.0 or up
                    $ni = ImageCreateTrueColor($nw, $nh);
                    ImageCopyResampled($ni, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
                } else {                           // GD version < 2
                    $ni = ImageCreate($nw, $nh);
                    ImageCopyResized($ni, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
                }

                ImageDestroy($im);
                switch ($imgtype) {
                    //case  'GIF': @ImageGif($ni,$th_name);break;
                    case  'JPG':
                        @ImageJpeg($ni, $th_name);
                        break;
                    case  'PNG':
                        @ImagePng($ni, $th_name);
                        break;
                    default:
                        @ImageJpeg($ni, $th_name);
                        break;
                }
                ImageDestroy($ni);
                $result = 'OK';
            }
        }
    }
    return $result;
}


################################################################################
# Recursive function to display all galleries as a hierarchy

function display_gallery_dir($galid, $picid = 0)
{
    global $config;
    global $strGalerieInconnue, $strCategories, $strSousCategories, $strImages, $strDescription;

    $galdir = $config['gallery_path'] . "/$galid";
    $dir = @opendir($galdir);
    $gals = array();

    while ($file = readdir($dir)) {
        // need management for unreadable dirs
        if ($file != "." && $file != ".." && is_dir("$galdir/$file")) {
            $gals[count($gals)] = $file;
        }
    }

    if (count($gals) > 0) sort($gals);
    $max = count($gals);
    $counter = 0;

    if ($galid || $max) {
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width=80%><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0 width=100%>";
        echo "<tr><td class=titlecategorie align=center>";

        if ($galid) {
            echo "<table><tr><td class=titlecategorie>$strCategories :</td>";
            echo "<td><a href=\"?page=galerie\"><img src=\"images/dir.gif\" border=0></a></td>";

            $arraygal = explode("/", $galid);
            $linkgal = "$arraygal[0]";

            for ($i = 0; $i < count($arraygal); $i++) {
                $labelgal = preg_replace("/_/", " ", $arraygal[$i]);
                echo "<td><img src=\"images/next.gif\" align=absmidlle></td><td class=titlecategorie><a href=\"?page=galerie&g=$linkgal\">$labelgal</a></td>";
                $linkgal .= "/" . $arraygal[$i + 1];
            }
            echo "</tr></table><br>";
        }

        if ($max && !$picid) {
            reset($gals);
            echo "$strSousCategories :<br>";
            echo "<table cellspacing=0 cellpadding=10 border=0>";

            while (list ($key, $val) = each($gals)) {

                $file = $val;
                $gallery_name = preg_replace("/_/", " ", $file);
                if ($galid == "") $sub_galid = $file;
                else $sub_galid = $galid . "/" . $file;
                $nbpics_info = count_pictures($sub_galid);
                $nb_pics = $nbpics_info[0];
                $nb_new_pics = $nbpics_info[1];
                $new_pictures = "";

                if ($nb_pics == $nb_new_pics && $nb_pics != 0) $new_pictures = "<img src=\"images/new.gif\" border=\"0\"> ";

                if ($counter % $config['col_categories'] == 0) echo "<tr>";
                echo "<td valign=\"top\">";

                echo "<table cellspacing=0 cellpadding=0 border=0><tr>";
                echo "<td valign=top><a href=\"?page=galerie&g=$sub_galid\"><img src=\"images/dir.gif\" border=\"0\" align=\"top\"></a>&nbsp;</td>";
                echo "<td class=\"text2\" width=120>";
                echo "<a href=\"?page=galerie&g=$sub_galid\"><b>$gallery_name</b></a> $new_pictures<br>";
                echo "<i>$strImages</i> : <b>$nb_pics</b><br>";
                $msg_file = "$galdir/$file/galerie.info";
                if (check_perms($msg_file)) {
                    echo "<i>$strDescription</i> :";
                    include_once($msg_file);
                }
                echo "</td>";
                echo "</tr></table>";
                echo "</td>";

                if ($counter % $config['col_categories'] == $config['col_categories'] - 1) echo "</tr>";
                $counter++;
            }
            echo "</table>";
        }
        echo "</td></tr></table></td></tr></table>";
        closedir($dir);
    }

}

################################################################################
function display_pic($galid, $pcid, $start = 1)
{

    global $config;
    global $strRetour, $strGalerieInconnue, $strImageInconnue;

    $zoom_factors = array(25, 50, 75, 100, 150);
    $pics = create_pics_array($galid);
    $nb_pics = count($pics);
    $picture_path = $config['gallery_path'] . "/$galid/";
    $picture_name = $pics[$pcid];
    $picture_url = $picture_path . $picture_name;
    $picture_msg = "$picture_url.info";
    $gallery_name = preg_replace("/_/", " ", $galid);
    $gallery_name = preg_replace("!/!", " >> ", $gallery_name);


    if (($pcid < 0) || ($pcid > $nb_pics - 1) || $pcid == "")
        show_erreur($strImageInconnue);
    elseif (!is_gallery($galid))
        show_erreur($strGalerieInconnue);
    elseif (!is_picture($picture_name, $galid))
        show_erreur($strImageInconnue);
    else {

        $dim = getimagesize($picture_url);
        $previous = $pcid - 1;
        $next = $pcid + 1;

        display_gallery_dir($galid, $pcid);

        echo "<table border=\"0\" cellspacing=5 align=\"center\">";
        // Client side zoom buttons
        if (count($zoom_factors) > 0) {
            echo "<tr><td align=\"center\"><A NAME=\"pic\" id=\"id_picture_navi\"></a>";

            for ($i = 0; $i < count($zoom_factors); $i++) {
                $new_height = (int)($dim[1] * $zoom_factors[$i] / 100);
                $new_width = (int)($dim[0] * $zoom_factors[$i] / 100);
                echo "<input type=\"button\" class=\"action\" value=\" " . $zoom_factors[$i] . "% \" ";
                echo "onClick=\"document.getElementById('id_picture').setAttribute('height', $new_height); ";
                echo "document.getElementById('id_picture').setAttribute('width', $new_width); ";
                echo "document.getElementById('id_picture_navi').scrollIntoView();\">\n";
            }
            echo "</td></tr>";
        }
        echo "<tr>";
        echo "<td align=\"center\" class=\"text2\">";
        if ($previous > 0) echo "<a href=\"?page=galerie&g=$galid&amp;p=$previous&amp;start=$start\"><img src=\"images/back.gif\" border=\"0\" align=\"absmiddle\"></a>";
        echo "<font color=red> " . ($pcid + 1) . "</font> / $nb_pics ";
        if ($next <= $nb_pics - 1) echo "<a href=\"?page=galerie&g=$galid&amp;p=$next&amp;start=$start\"><img src=\"images/next.gif\" border=\"0\" align=\"absmiddle\"></a>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=\"center\" class=\"text2\"><br>";

        echo "<img id=\"id_picture\" src=\"$picture_url\" WIDTH=\"$dim[0]\" HEIGHT=\"$dim[1]\" alt=\"$picture_url\" class=\"\">";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=\"center\" class=\"text2\">";
        if (check_perms($picture_msg)) {
            include_once($picture_msg);
        } else echo "&nbsp;";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=\"?page=galerie&g=$galid&start=$start\" class=action>$strRetour</a><br>";
    }
}


################################################################################
function display_thumbnails($galid, $picid, $start = 0)
{
    global $config, $s_joueur, $grade;
    global $strRetour, $strConfirmEffacerFile, $strS, $strPasDImage;

    $picspath = $config['gallery_path'] . "/$galid/";
    $pics = create_pics_array($galid);
    $nbpics = count($pics);

    if ($nbpics != 0) {

        if (!$start) $start = 0;
        $counter = 0;
        $nb_max = $config['nb_gallery_thumb'];
        $nb_total = $nbpics;

        $offset_start = $start;
        $offset_stop = $offset_start + $config['nb_gallery_thumb'];
        if ($offset_stop > $nbpics) $offset_stop = $nbpics;

        echo '<table border="0" cellpadding="3" cellspacing="2" align="center">';
        echo "<tr><td class=text2 colspan=\"" . $config['col_gallery_thumb'] . "\" align=center>" . navigateur($start, $nb_max, $nb_total, "?page=galerie&g=$galid&start=%d") . "<br><br></td></tr>";

        for ($i = $offset_start; $i < $offset_stop; $i++) {

            $picture_name = $pics[$i];
            $picurl = $picspath . $picture_name;
            $thumbname = "_thb_" . $pics[$i];
            $thumburl = $picspath . $thumbname;
            $picdim = getimagesize($picurl);
            $thumbdim = getimagesize($thumburl);
            $picsize = (int)(filesize($picurl) / 1024);
            $picindex = $i + 1; // index that is displayed

            if ($counter % $config['col_gallery_thumb'] == 0) echo "<tr>";

            echo '<td align="center" valign="top" class="text2">';
            if (is_new($picurl)) echo '<img src="images/new.gif" border="0"><br>';

            echo '<table border="0" cellspacing="0" cellpadding="0">';
            echo '<tr><td colspan="3"><img src="images/photo_top.gif" width="42" height="8"></td></tr>';
            echo '<tr>';
            echo '<td width="8" valign="top"><img src="images/photo_left.gif" height="35" width="8"></td>';
            echo '<td>';

            echo "<a href=\"?page=galerie&g=$galid&p=$i&amp;start=$start\">";
            echo "<img src=\"$thumburl\" WIDTH=\"$thumbdim[0]\" HEIGHT=\"$thumbdim[1]\" alt=\"$picture_name\" border=\"0\"></a>";
            echo '</td>';
            echo '<td width="8" valign="bottom"><img src="images/photo_right.gif" height="35" width="8"></td>';
            echo '</tr>';
            echo '<tr><td colspan="3" align="right"><img src="images/photo_bottom.gif" width="42" height="8"></td></tr>';
            echo '</table>';

            echo "[ $picdim[0]x$picdim[1] - $picsize KB ]";
            if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['q'] == 'q') echo " <a href=\"?page=galerie&op=delete&g=$galid&filename=$picture_name\" onclick=\"return confirm('$strConfirmEffacerFile');\">[$strS]</a>";

            echo "</td>";

            if ($counter % $config['col_gallery_thumb'] == $config['col_gallery_thumb'] - 1) echo "</tr>";
            $counter++;
        }

        echo "</table>";
    } elseif ($galid) {
        echo '<table cellspacing="2" cellpadding="2" border="0">';
        echo "<tr><td class=title>$strPasDImage</td></tr>";
        echo '</table>';
    }
}

################################################################################
function display_gal($galid, $start = 1)
{
    global $s_joueur, $config;
    global $strGalerieInconnue, $strUploaderFichier, $strFichier, $strEnvoyer, $strUploadFichierConsignes, $strRetour, $grade;

    if (!is_gallery($galid)) {
        show_erreur($strGalerieInconnue);
    } else {

        display_gallery_dir($galid);
        display_thumbnails($galid, "", $start);

        if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['q'] == 'q') && $galid != "") {
            echo "<form name=input action=\"?page=galerie&op=upload&g=$galid\" method=post enctype=\"multipart/form-data\">";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
            echo "<table cellspacing=1 cellpadding=0 border=0>";
            echo "<tr><td class=headerfiche>$strUploaderFichier $galid</td></tr>";
            echo "<tr><td>";
            echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
            echo "<tr>";
            echo "<td class=titlefiche>$strFichier <font color=red><b>*</b></font> :</td>";
            echo "<td class=textfiche><input type=file name=userfile size=40 maxlength=80></td>";
            echo "</tr>";
            echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strEnvoyer\"></td></tr>";
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td></tr></table>";
            echo "</form>";

            show_consignes($strUploadFichierConsignes . coolsize($config['gallery_max_filesize']));
        }

        $arraygal = explode("/", $galid);
        $linkgal = "$arraygal[0]"; // to avoid the first "/"

        if ($galid) {
            for ($i = 1; $i < count($arraygal) - 1; $i++) {
                $linkgal .= "/" . $arraygal[$i];
            }

            if (count($arraygal) == 1) $linkgal = "";

            echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=\"?page=galerie&g=$linkgal\" class=action>$strRetour</a><br>";
        } else
            echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=\"javascript:back()\" class=action>$strRetour</a><br>";

    }
}


#############
# Main
#############

echo "<p class=title>.:: $strGalerie ::.</p>";

$param_galid = isset($_GET['g']) ? $_GET['g'] : '';
$param_picid = isset($_GET['p']) ? $_GET['p'] : '';
$param_page = isset($_GET['start']) ? $_GET['start'] : '';


/********************************************************
 * Post d'un fichier
 */
if ($op == "upload") {

    /*** verification securite ***/
    //verif_admin_general($s_joueur);
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['q'] != 'q') {
        js_goto($PHP_SELF);
    }

    include_once("include/class.upload.php");
    $uploadc = new Upload();
    $uploadc->maxupload_size = $config['gallery_max_filesize'];
    $destination = $config['gallery_path'] . "/$param_galid/";
    $field_filename = trim($uploadc->getFileName("userfile"));

    if ($field_filename && (preg_match("/.jpg$/i", $field_filename) || preg_match("/.png$/", $field_filename) || preg_match("/.gif$/i", $field_filename))) {
        if ($uploadc->save($destination, "userfile", true)) {
            is_picture($field_filename, $param_galid);
            js_goto("?page=galerie&g=$param_galid");
        } else {
            show_warning($uploadc->errors);
        }
    } else {
        show_warning("$strFichierInvalide : $field_filename");
    }

} /********************************************************
 * Effacement d'un fichier
 */
elseif ($op == 'delete') {

    /*** verification securite ***/
    //verif_admin_general($s_joueur);
    if ($grade['a'] != 'a' && $grade['b'] != 'q' && $grade['c'] != 'q') {
        js_goto($PHP_SELF);
    }

    $filename = str_replace("/", "", $filename);

    @unlink($config['gallery_path'] . "/$param_galid/$filename");
    @unlink($config['gallery_path'] . "/$param_galid/_thb_$filename");

    js_goto("?page=galerie&g=$param_galid");

} /********************************************************
 * affichage main
 */
else {

    if ($param_picid == '') {
        display_gal($param_galid, $param_page);
    } else {
        display_pic($param_galid, $param_picid, $param_page);
    }
}

