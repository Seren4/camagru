<?php

class Home extends Controller
{
    public $super_img = null;
    public $user_img = null;

    public function index()
    {
        if (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'wrong')
            header('location: ' . URL_WITH_INDEX_FILE . 'userArea/login');
        elseif (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'register_wrong')
            header('location: ' . URL_WITH_INDEX_FILE . 'userArea/register');
        if (!empty($_SESSION['logged_user']))
        {
            $this->super_img = $this->model->show_super_img();
            $this->user_img = $this->model->show_user_gallery();
        }
        $_SESSION['currpage'] = 1;
        require APP . 'views/_templates/header.php';
        require APP . 'views/home/index.php';
        require APP . 'views/_templates/footer.php';
    }

    public function imageSave()
    {
        $check = false;
        $image = null;
        if (isset($_POST['save_img']) AND $_POST['save_img'] == "save_img" AND !empty($_POST['img_tosave']))
        {
            $check = getimagesize($_POST['img_tosave']);
            if ($check !== false)
            {
                $image = $_POST['img_tosave'];
                $this->model->image_save($image);
            }
        }
    }

    public function deleteImg($index)
    {
        $login = !empty($_SESSION['logged_user']) ? $_SESSION['logged_user'] : null;
        if (!$login)
            header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
        if (is_numeric($index) AND $login)
            $this->model->deleteImg($index, $login);
    }

    public function header()
    {
        header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
    }


    public function image_merge()
    {
        $destination = null;
        $source = null;
        $check_upload = false;
        $check_photo = false;
        $uploadOk = 0;

        if (!empty($_POST['select_super']))
        {
            if (!empty($_POST['hidden']))
            {
                $check_photo = getimagesize($_POST['hidden']);
                if ($check_photo !== false)
                    $destination = imagecreatefrompng($_POST['hidden']);
            }
            elseif (is_uploaded_file($_FILES["fileToUpload"]["tmp_name"]))
            {
                $check_upload = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check_upload !== false)
                    $uploadOk = 1;

                if ($_FILES["fileToUpload"]["size"] > 5000000)
                    $uploadOk = 0;

                $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));

                if ($imageFileType != "jpg" AND $imageFileType != "png"
                    AND $imageFileType != "jpeg" AND $imageFileType != "gif")
                    $uploadOk = 0;

                if ($uploadOk == 1)
                {
                    $img = file_get_contents($_FILES['fileToUpload']['tmp_name']);
                    $destination = imagecreatefromstring($img);
                }
                else
                {
                    ?>
                    <script>
                    document.getElementById('content').style.display = 'none';
                    document.getElementById('startbutton').style.display = 'none';
                    document.getElementById('fileToUpload').style.display = 'none';
                    document.getElementById('errorUpload').style.display = 'block';
                    document.getElementById('discard').style.display = 'block';
                    document.getElementById('no_camera').style.display = 'none';
                    </script>
                    <?php
                }
            }
            if ($destination)
            {
                $source = imagecreatefrompng(ROOT . $_POST['select_super']);
                $largeur_source = imagesx($source);
                $hauteur_source = imagesy($source);
                imagealphablending($source, true);
                imagesavealpha($source, true);
                $largeur_destination = imagesx($destination);
                $hauteur_destination = imagesy($destination);

                $destination_x = ($largeur_destination - $largeur_source) / 2;
                $destination_y = ($hauteur_destination - $hauteur_source) / 2;

                imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
                ob_start();
                imagepng($destination);
                $image_data = ob_get_contents();
                ob_end_clean();
                $var = 'data:image/png;base64,' . base64_encode($image_data);
                ?>
                <script>
                    document.getElementById('photo').setAttribute('src', '<?= $var; ?>');
                    document.getElementById('video').style.display = 'none';
                    document.getElementById('startbutton').style.display = 'none';
                    document.getElementById('upload').style.display = 'none';
                    document.getElementById('fileToUpload').style.display = 'none';
                    document.getElementById('photo').style.display = 'inline-block';
                    document.getElementById('discard').style.display = 'block';
                    document.getElementById('save').style.display = 'block';
                    document.getElementById('no_camera').style.display = 'none';
                </script>
                <?php
                }
            }
        }



}
