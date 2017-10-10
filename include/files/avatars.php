<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
  | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
   +---------------------------------------------------------------------+
   | This file is part of phpTournois.                                   |
   |                                                                     |
   | phpTournois is free software; you can redistribute it and/or modify |
   | it under the terms of the GNU General Public License as published by|
   | the Free Software Foundation; either version 2 of the License, or   |
   | (at your option) any later version.                                 |
   |                                                                     |
   | phpTournois is distributed in the hope that it will be useful,      |
   | but WITHOUT ANY WARRANTY; without even the implied warranty of      |
   | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       |
   | GNU General Public License for more details.                        |
   |                                                                     |
   | You should have received a copy of the GNU General Public License   |
   | along with AdminBot; if not, write to the Free Software Foundation, |
   | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA       |
   |                                                                     |
   +---------------------------------------------------------------------+
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
// mainly inspired from phpBB 2.0.6

/*** verification securite ***/
if (preg_match("/avatar.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

$config['avatars_path'] = "images/avatars";

if ($mode == 'J') {

    //if(!admin_general($s_joueur) && (empty($s_joueur) || $id != $s_joueur)) js_goto("?page=index");
    if (($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['j'] != 'j') && ($grade['z'] == '' || $id != $s_joueur)) {
        js_goto("?page=index");
    }

    /*** recupération des param�tres ***/
    $ficheX = joueur($id);
    $type = "joueurs";
} elseif ($mode == 'E') {

    //if(!admin_general($s_joueur) && (empty($s_joueur) || !equipe_manager($id,$s_joueur))) js_goto("?page=index");
    if (($grade['a'] != 'a' || $grade['b'] != 'b' || $grade['j'] != 'j') && ($grade['z'] == '' || !equipe_manager($id, $s_joueur))) {
        js_goto("?page=index");
    }

    /*** recupération des param�tres ***/
    $ficheX = equipe($id);
    $type = "equipes";

} else js_goto("?page=index");


function check_image_type($type)
{
    switch ($type) {
        case 'jpeg':
        case 'pjpeg':
        case 'jpg':
            return '.jpg';
            break;
        case 'gif':
            return '.gif';
            break;
        case 'png':
            return '.png';
            break;
        default:
            break;
    }

    return false;
}

function avatar_delete($avatar_type, $avatar_file)
{
    global $config;

    if ($avatar_type == 'U' && $avatar_file != '') {
        if (@file_exists($config['avatars_path'] . "/$avatar_file")) {
            @unlink($config['avatars_path'] . "/$avatar_file");
        }
    }

    return "avatar = '', avatar_type = 'N'";
}

function avatar_gallery($avatar_filename)
{
    global $config;

    if (file_exists($config['avatars_path'] . "/gallerie/$avatar_filename")) {
        $return = "avatar = '" . str_replace("\'", "''", $avatar_filename) . "', avatar_type = 'G'";
    }

    return $return;
}

function avatar_url($avatar_filename, &$avatar_error)
{
    global $strAvatarErreurUrl;

    if (!preg_match('#^(http)|(ftp):\/\/#i', $avatar_filename)) {
        $avatar_filename = 'http://' . $avatar_filename;
    }

    if (!preg_match('#^((http)|(ftp):\/\/[\w\-]+?\.([\w\-]+\.)+[\w]+(:[0-9]+)*\/.*?\.(gif|jpg|jpeg|png)$)#is', $avatar_filename)) {
        $avatar_error = true;
        show_erreur($strAvatarErreurUrl);
        echo "ouin";
        return;
    }

    return "avatar = '" . str_replace("\'", "''", $avatar_filename) . "', avatar_type = 'R'";

}

function avatar_upload($avatar_mode, &$current_avatar, &$current_type, $avatar_filename, $avatar_realname, $avatar_filesize, $avatar_filetype, &$avatar_error)
{
    global $config, $db;
    global $strAvatarErreurUrl, $strAvatarErreurConnexion, $strAvatarErreurData, $strAvatarErreurWrite, $strAvatarErreurFileSize, $strAvatarErreurXYSize, $strAvatarErreurFileType;


    /*** si c'est un upload remote ***/
    if ($avatar_mode == 'remote' && preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $avatar_filename, $url_ary)) {

        if (empty($url_ary[4])) {
            $avatar_error = true;
            show_erreur($strAvatarErreurUrl);
            return;
        }

        $base_get = '/' . $url_ary[4];
        $port = (!empty($url_ary[3])) ? $url_ary[3] : 80;

        if (!($fsock = @fsockopen($url_ary[2], $port, $errno, $errstr))) {
            $avatar_error = true;
            show_erreur($strAvatarErreurConnexion);
            return;
        }

        @fputs($fsock, "GET $base_get HTTP/1.1\r\n");
        @fputs($fsock, "HOST: " . $url_ary[2] . "\r\n");
        @fputs($fsock, "Connection: close\r\n\r\n");

        $avatar_data = '';
        while (!@feof($fsock)) {
            $avatar_data .= @fread($fsock, $config['avatar_filesize_max']);
        }
        @fclose($fsock);

        if (!preg_match('#Content-Length\: ([0-9]+)[^ /][\s]+#i', $avatar_data, $file_data1) || !preg_match('#Content-Type\: image/[x\-]*([a-z]+)[\s]+#i', $avatar_data, $file_data2)) {
            $avatar_error = true;
            show_erreur($strAvatarErreurData);
            return;
        }

        $avatar_filesize = $file_data1[1];
        $avatar_filetype = $file_data2[1];

        if ($avatar_filesize > 0 && $avatar_filesize < $config['avatar_filesize_max']) {
            $avatar_data = substr($avatar_data, strlen($avatar_data) - $avatar_filesize, $avatar_filesize);

            $tmp_path = $config['avatars_path'] . '/tmp';
            $tmp_filename = tempnam($tmp_path, uniqid(rand()) . '-');

            $fptr = @fopen($tmp_filename, 'wb');
            $bytes_written = @fwrite($fptr, $avatar_data, $avatar_filesize);
            @fclose($fptr);

            if ($bytes_written != $avatar_filesize) {
                @unlink($tmp_filename);
                $avatar_error = true;
                show_erreur($strAvatarErreurWrite);
                return;
            }

            list($width, $height) = @getimagesize($tmp_filename);
        } else {
            $avatar_error = true;
            show_erreur("$strAvatarErreurFileSize (" . CoolSize($config['avatar_filesize_max']) . ")");
            return;
        }
    } elseif ($avatar_mode == 'local' && file_exists($avatar_filename)) {

        if ($avatar_filesize <= $config['avatar_filesize_max'] && $avatar_filesize > 0) {
            preg_match('#image\/[x\-]*([a-z]+)#', $avatar_filetype, $avatar_filetype);
            $avatar_filetype = $avatar_filetype[1];
        } else {
            $avatar_error = true;
            show_erreur("$strAvatarErreurFileSize (" . CoolSize($config['avatar_filesize_max']) . ")");
            return;
        }

        list($width, $height) = @getimagesize($avatar_filename);
    }

    if (!($imgtype = check_image_type($avatar_filetype))) {
        $avatar_error = true;
        show_erreur("$strAvatarErreurFileType ($avatar_filetype)");
        return;
    }

    if ($width <= $config['avatar_x_max'] && $height <= $config['avatar_y_max']) {

        $new_filename = uniqid(rand()) . $imgtype;

        /*** si un avatar uploadé existe deja pour l'entité, on l'efface ***/
        if ($current_type == 'U' && $current_avatar != '') {
            if (file_exists($config['avatars_path'] . "/$current_avatar")) {
                @unlink($config['avatars_path'] . "/$current_avatar");
            }
        }

        if ($avatar_mode == 'remote') {
            @copy($tmp_filename, $config['avatars_path'] . "/$new_filename");
            @unlink($tmp_filename);
        } elseif ($avatar_mode == 'local') {
            @move_uploaded_file($avatar_filename, $config['avatars_path'] . "/$new_filename");
        }

        @chmod($config['avatars_path'] . "/$new_filename", 0777);

        $avatar_sql = "avatar = '$new_filename', avatar_type = 'U'";
    } else {
        $avatar_error = true;
        show_erreur("$strAvatarErreurXYSize (" . $config['avatar_x_max'] . "x" . $config['avatar_y_max'] . ")");
    }

    return $avatar_sql;
}


/********************************************************
 * modifier un avatar
 */
if ($op == "modify") {

    $avatar_error = false;
    $avatar_upload = (!empty($_POST['avatarurl'])) ? trim($_POST['avatarurl']) : (($_FILES['avatar']['tmp_name'] != "none") ? $_FILES['avatar']['tmp_name'] : '');
    $avatar_remoteurl = (!empty($_POST['avatarremoteurl'])) ? trim(htmlspecialchars($_POST['avatarremoteurl'])) : '';
    $avatar_gallerie = (!empty($_POST['avatargallerie'])) ? htmlspecialchars($_POST['avatargallerie']) : '';
    $avatar_name = (!empty($_FILES['avatar']['name'])) ? $_FILES['avatar']['name'] : '';
    $avatar_size = (!empty($_FILES['avatar']['size'])) ? $_FILES['avatar']['size'] : 0;
    $avatar_filetype = (!empty($_FILES['avatar']['type'])) ? $_FILES['avatar']['type'] : '';
    $avatar_mode = (!empty($avatar_name)) ? 'local' : 'remote';
    $avatar_sql = '';

    /*** si l'avatar est de type UPLOAD ***/
    if ((!empty($avatar_upload) || !empty($avatar_name)) && $config['avatar_upload']) {

        if (!empty($avatar_upload)) {
            $avatar_sql = avatar_upload($avatar_mode, $ficheX->avatar, $ficheX->avatar_type, $avatar_upload, $avatar_name, $avatar_size, $avatar_filetype, $avatar_error);
        } elseif (!empty($avatar_name)) {
            $avatar_error = true;
            show_erreur($strAvatarErreurFileSize);
        }
    } /*** si l'avatar est de type REMOTE ***/
    elseif ($avatar_remoteurl != '' && $config['avatar_remote']) {

        if (@file_exists($config['avatars_path'] . '/' . $ficheX->avatar)) {
            @unlink($config['avatars_path'] . '/' . $ficheX->avatar);
        }
        $avatar_sql = avatar_url($avatar_remoteurl, $avatar_error);
    } /*** si l'avatar est de type GALLERIE ***/
    elseif ($avatar_gallerie != '' && $config['avatar_gallerie']) {

        if (@file_exists($config['avatars_path'] . '/' . $ficheX->avatar)) {
            @unlink($config['avatars_path'] . '/' . $ficheX->avatar);
        }

        $avatar_sql = avatar_gallery($avatar_gallerie);
    }

    if (!$avatar_error) {
        if ($avatar_sql) {
            $db->update("${dbprefix}$type");
            $db->set("$avatar_sql");
            $db->where("id = $id");
            $db->exec();
        }

        if ($op_old == 'galerie') {
            echo "<script>this.opener.location=this.opener.location;this.close();</script>";
        } else {
            js_goto("?page=avatars&id=$id&mode=$mode");
        }


    }
} /********************************************************
 * Suppression d'un administration a un tournois
 */
elseif ($op == "delete") {

    $avatar_sql = avatar_delete($ficheX->avatar_type, $ficheX->avatar);

    $db->update("${dbprefix}$type");
    $db->set("$avatar_sql");
    $db->where("id = $id");
    $db->exec();

    js_goto("?page=avatars&id=$id&mode=$mode");
} /********************************************************
 * Affichage de la galerie
 */
elseif ($op == "galerie") {


    $dir = @opendir($config['avatars_path'] . '/gallerie');

    $avatar_images = array();

    while ($file = @readdir($dir)) {

        if ($file != '.' && $file != '..' && !is_file($config['avatars_path'] . '/gallerie/' . $file) && !is_link($config['avatars_path'] . '/gallerie/' . $file)) {

            $i = 0;
            $sub_dir = @opendir($config['avatars_path'] . '/gallerie/' . $file);

            while ($sub_file = @readdir($sub_dir)) {

                if (preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $sub_file)) {

                    $avatar_images[$file][$i] = $file . '/' . $sub_file;
                    $avatar_names[$file][$i] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $sub_file)));
                    $i++;
                }
            }
        }
    }

    @closedir($dir);

    @ksort($avatar_images);
    @reset($avatar_images);

    if (empty($cat)) {
        list($cat,) = each($avatar_images);
    }
    @reset($avatar_images);

    echo "$strCategorie : <select name=cat onchange=select_avatar_cat(this.value,'&mode=$mode&id=$id')>";
    while (list($key) = each($avatar_images)) {
        $selected = ($key == $cat) ? ' selected="selected"' : '';

        if (count($avatar_images[$key])) {
            echo '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
        }
    }
    echo '</select>';

    /** reinit des colonne a 1 ***/
    if (count($avatar_images[$cat]) < $config['col_avatar_gallerie'])
        $config['col_avatar_gallerie'] = 1;


    if (count($avatar_images[$cat]) != 0) {

        echo "<table class=liste><tr valign=top>";

        echo '<form method=post action="?page=avatars&op=modify">';
        echo "<input type=hidden name=id value=$id>";
        echo "<input type=hidden name=mode value=$mode>";
        echo '<input type=hidden name=avatargallerie value="">';
        echo "<input type=hidden name=op_old value=galerie>";

        for ($i = 0; $i < $config['col_avatar_gallerie']; $i++) {
            echo "<td>";
            echo "<table cellspacing=0 cellpadding=4 border=0>";

            for ($j = $i; $j < count($avatar_images[$cat]); $j = $j + $config['col_avatar_gallerie']) {
                echo "<tr>";
                echo "<td align=center>";

                echo '<table border="0" cellspacing="0" cellpadding="0">';
                echo '<tr><td colspan="3"><img src="images/photo_top.gif" width="42" height="8"></td></tr>';
                echo '<tr>';
                echo '<td width="8" valign="top"><img src="images/photo_left.gif" height="35" width="8"></td>';
                echo '<td>';

                echo '<img src="' . $config['avatars_path'] . '/gallerie/' . $avatar_images[$cat][$j] . "\" title=\"" . $avatar_names[$cat][$j] . "\">";

                echo '</td>';
                echo '<td width="8" valign="bottom"><img src="images/photo_right.gif" height="35" width="8"></td>';
                echo '</tr>';
                echo '<tr><td colspan="3" align="right"><img src="images/photo_bottom.gif" width="42" height="8"></td></tr>';
                echo '</table>';
                echo "<input type=radio name=avatar_radio value=\"" . $avatar_images[$cat][$j] . "\" style=\"border: 0px;background-color:transparent;\" onClick=\"this.form.avatargallerie.value=this.value\">";

                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</td>";
        }
        echo "</tr></table>";
        echo "<table align=center>";
        echo "<tr><td align=center><input type=submit value=\"$strValider\"> <input type=button value=\"$strAnnuler\" onclick=\"fermer_fenetre()\"></td></tr>";
        echo "</table>";
        echo "</form>";
    }
} /********************************************************
 * Affichage normal + admin
 */
else {

    echo "<p class=title>.:: $strModifierAvatar ::.</p>";

    /*** table avatar ***/
    echo "<table border=0 cellpadding=0 cellspacing=0 width=300 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche width=100%>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<form method=post action=?page=avatars&op=modify enctype=\"multipart/form-data\">";

    if ($ficheX->avatar_img) {
        echo "<tr><td class=textfiche colspan=4 align=center>$ficheX->avatar_img";
        echo "<br><input type=button class=action value=\"$strEffacer\" onclick=\"confirm('$strConfirmEffacerAvatar');location.href='?page=avatars&op=delete&id=$id&mode=$mode'\">";
        echo "</td></tr>";
    }

    echo "<input type=hidden name=id value=$id>";
    echo "<input type=hidden name=mode value=$mode>";

    /*** upload local ***/
    if ($config['avatar_upload']) {
        echo "<tr><td class=titlefiche>$strAvatarUploadLocal :</td>";
        echo "<td class=textfiche colspan=3>";
        echo "<input type=file name=avatar>";
        echo "<input type=hidden name=MAX_FILE_SIZE value=\"$config[avatar_filesize_max]\">";
        echo "</td></tr>";
    }

    /*** upload remote ***/
    if ($config['avatar_upload'] && $config['avatar_remote']) {
        echo "<tr><td class=titlefiche>$strAvatarUploadRemote :</td>";
        echo "<td class=textfiche colspan=3>";
        echo "<input type=text name=avatarurl size=40>";
        echo "</td></tr>";
    }

    /*** remote ***/
    if ($config['avatar_remote']) {
        echo "<tr><td class=titlefiche>$strAvatarLienRemote :</td>";
        echo "<td class=textfiche colspan=3>";
        echo "<input type=text name=avatarremoteurl size=40>";
        echo "</td></tr>";
    }

    /*** gallerie ***/
    if ($config['avatar_gallerie']) {
        echo "<tr><td class=titlefiche>$strAvatarGallerie :</td>";
        echo "<td class=textfiche colspan=3>";
        echo "<input type=button value=\"$strVoirGallerie\" onclick=\"ouvrir_fenetre('?page=avatars&op=galerie&mode=$mode&id=$id&header=win','avatar',400,600)\">";
        echo "</td></tr>";
    }

    echo "<tr><td class=footerfiche align=center colspan=4><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=$type&id=$id&op=$op'\"></td></tr>";
    echo "</table>";

    echo "</td></tr></table>";
    echo "</td></tr></form></table>";
}
?>
