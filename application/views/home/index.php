<?php if (!isset($this)) { exit(header('HTTP/1.0 403 Forbidden')); }
if (!empty($_SESSION['logged_user'])): ?>
<section class="section columns">

    <section class="section column ">
        <form method="post" id="pics_form" enctype="multipart/form-data" name="pics_form">
<!--            <input type="hidden" name="form" value="pics_form" id="">-->
            <input type="hidden" name="hidden" id="hidden">
            <?php foreach ($this->super_img as $cat) : ?>
                <label class="radio_img">
                    <input type="radio" name="select_super" id="r" value="<?= htmlspecialchars($cat['img_path'], ENT_QUOTES); ?>">
                    <figure class="box image is-256x256 ">
                        <img class="super_img" id="catImage" src="<?= htmlspecialchars(URL . $cat['img_path'], ENT_QUOTES); ?>" >
                    </figure>
                </label>
            <?php endforeach; ?>
        </form>
    </section>

    <section class="section column is-three-fifths-desktop is-two-fifths-tablet">
        <div class="box" id="content">
            <div class="notification" id="no_camera" style="display: none;">Access to camera denied.</div>

            <video class="" id="video" style="border-radius: 1%">Video stream not available.</video>
            <canvas id="canvas" style="display: none"></canvas>
            <div class="output" >
                <img id="photo" src="" >
            </div>
        </div>

        <section class="section ">
            <div class="notification" id="errorUpload" style="display: none;">Sorry, there was an error uploading your file.</div>


            <section class="section buttons field is-grouped ">

                <span class="button is-dark" id="upload" style="display: none">Take picture</span>
                <span class="button is-dark" id="startbutton"  >Take photo</span>
                <input class="button" type="file" accept="image/gif, image/jpeg, image/png, image/jpg" name="fileToUpload" id="fileToUpload" form="pics_form">

                <button form="save_form" class="button is-dark " id="save" style="display: none; float: right">save</button>

                <button form="form_discard" class="button is-dark" id="discard" style="display: none; float: left" >discard</button>


                <form id="save_form" method="POST" action="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>home/imageSave">
                    <input type="hidden" name="form" value="save_form" id="">
                    <input type="hidden" id="img_tosave" name="img_tosave">
                    <input type="hidden" id="save_img" name="save_img" value="save_img">
                </form>
                <form id="form_discard" action="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>home/header/">
                </form>

            </section>
            <div class="notification" id="errorTake" style="display: none;">Please, select an image first.</div>


        </section>

    </section>

    <section class="section column shot_box">
        <div class="shot_container box" style="padding: 4%">
        <?php if ($this->user_img) :
            foreach ($this->user_img as $img) : ?>
                <div class="tile box" style="padding: 5%">
                    <form method="post" action="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>home/deleteImg/<?= htmlspecialchars($img['id'], ENT_QUOTES) ?>"
                          name="<?= htmlspecialchars($img['id'], ENT_QUOTES) ?>_form">
                        <figure class="image is-256x256 ">
                            <button class="delete is-medium" title="Delete image"> </button>
                            <img class="" src="<?= htmlspecialchars($img['image'], ENT_QUOTES); ?>" style="border-radius: 2%">
                        </figure>
                    </form>
                </div>
            <?php endforeach;
        else :?>
            <div class="home_unlogged">
                Your shots will appear here.
            </div>
        <?php endif; ?>
        </div>
    </section>
    <script src="<?= htmlspecialchars(URL, ENT_QUOTES)?>assets/js/capture.js"></script>
    <?php $this->image_merge();
elseif (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'register_right') : ?>
    <section class="section title is-4">Check your mail</section>
<?php unset ($_SESSION['log_error']);
elseif (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'activation_right') : ?>
    <section class="section title is-4">Welcome!</section>
    <?php unset ($_SESSION['log_error']);
elseif (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'activation_wrong') : ?>
    <section class="section title is-4">We encountered a problem during your registration </section>
    <?php unset ($_SESSION['log_error']);
else : ?>
    <section class="section home_unlogged title is-4" id="log_err">
        You must be logged to view this page.
    </section>
</section>
<?php endif;
?>
<?php


