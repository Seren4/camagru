<?php if (!isset($this)) { exit(header('HTTP/1.0 403 Forbidden')); } ?>


<section class="section">
    <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
        <?php $this->pag(); ?>
    </nav>
</section>

<section class="section">
<div class="columns is-multiline">
    <?php
    $slide = 1;
    if ($this->img)
    {
    foreach ($this->img as $i): ?>

    <div class="column is-one-quarter-desktop is-half-tablet">
        <div class="card" style="border-radius: 1%">
            <header class="card-header">
                <p class="card-header-title"><?= htmlspecialchars($i['login'], ENT_QUOTES); ?></p>
                <time class="card-header-title" ><?= date("d/m/y H:i A", strtotime(htmlspecialchars($i['date'], ENT_QUOTES))); ?></time>
            </header>
            <div class="card-image">
                <figure class="image is-3by2">
                    <img src="<?= htmlspecialchars($i['image']) ?>" alt="photo" onclick="openModal();currentSlide('<?= htmlspecialchars($slide++, ENT_QUOTES) ?>')">
                </figure>
            </div>

            <?php if (!empty($_SESSION['logged_user'])) : ?>
            <footer class="card-footer">
                <div class="like_section card-footer-item">
                        <figure class="image like_btn is-32x32">
                            <img  id="like_<?= $i['id']?>" src="<?= URL . 'assets/icons/icon_like.png'?>" onclick="like('<?= htmlspecialchars($i['id'], ENT_QUOTES) ?>','<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>')">
                        </figure>
                    <div class="count_btn" ><?= $this->total_likes(htmlspecialchars($i['id'], ENT_QUOTES)); ?></div>
                </div>

                <div class="comm_section card-footer-item">
                    <figure class="image comm_btn is-32x32">
                        <img src="<?= URL . 'assets/icons/icon_comments.png'?>" onclick="DisplayCommModal('<?= htmlspecialchars($i['id'], ENT_QUOTES) ?>')">
                    </figure>
                    <div class="count_btn" ><?= $this->total_comm(htmlspecialchars($i['id'], ENT_QUOTES)); ?></div>
                </div>
            </footer>

            <?php endif; ?>
        </div>
    </div>
        <?php endforeach;
        }?>
</div>
</section>


<?php if (!empty($_SESSION['logged_user'])) : ?>
    <article class="media modal" id="CommentModal">
            <div class="modal-background" onclick="closeModal('CommentModal')"></div>
        <div class="media-content CommentModalContent" >
            <div class="field">
                <p class="control" id="mySlidesComm">
                    <input type="hidden" name="form" value="comment_form" id="comment_form">
                    <input type="hidden" id="hidden_id_img" name="hidden_id_img">
                    <textarea class="hover-shadow textarea" rows="8" id="id_text_area" placeholder="add a comment" REQUIRED style="width: 50vw;"></textarea></p>
            </div>
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <a class="button is-info" onclick="add_comment('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>');">Submit</a>
                    </div>
                    <a class="button is-white" onclick="closeModal('CommentModal')">close</a>

                </div>
            </nav>
        </div>
    </article>
<?php endif; ?>



<?php if ($this->img) : ?>
    <div id="GalleryModal" class="modal GalleryModal">
        <div class="modal-background" onclick="closeModal('GalleryModal')"></div>
        <?php foreach ($this->img as $i): ?>
            <div class="GalleryModalSlides card"  style="border-radius: 2%">
                <a class="close cursor button is-white" onclick="closeModal('GalleryModal')">&times;</a>
                <div class="modal-content" id="content">

                    <div class="card-image" id="card">
                        <figure class="image is-4by3" >
                            <img src="<?= htmlspecialchars($i['image'], ENT_QUOTES) ?>" style="border-radius: 1%">
                        </figure>
                    </div>
                    <div class="comment_box card-content" style="overflow: auto;">
                        <div class="media">
                            <div class=" media-content">
                                <strong class="title is-4"><?= htmlspecialchars($i['login'], ENT_QUOTES); ?></strong>
                                <span class="img_date subtitle is-6"><?= date("d/m/y H:i A", strtotime(htmlspecialchars($i['date'], ENT_QUOTES))); ?></span>
                            </div>
                        </div>
                    <?php if ($comments = $this->show_comments($i['id'])): ?>
                            <?php foreach ($comments as $comm) : ?>
                            <article class="media">
                                <div class="media-content">
                                    <div class="content">
                                        <p><strong><?= htmlspecialchars($comm['login'], ENT_QUOTES) ?></strong>
                                            <span><?= date("d/m/y H:i A", strtotime(htmlspecialchars($comm['date'], ENT_QUOTES)))?></span>
                                            <br><?= htmlspecialchars($comm['comment'], ENT_QUOTES) ?><br></p>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach;?>
                    <?php else : ?>
                        <div class="comment_box">
                            <div class="home_unlogged">
                                No comments yet.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>









