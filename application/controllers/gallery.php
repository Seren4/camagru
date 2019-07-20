<?php

class Gallery extends Controller
{
    public $img = null;
    public $current_page = null;

    public function index()
    {
        require APP . 'views/_templates/header.php';
        require APP . 'views/gallery/index.php';
        require APP . 'views/_templates/footer.php';
    }


    public function add_like()
    {
        $id_img = null;
        if (!empty($_POST['idImg']) AND is_numeric($_POST['idImg']))
        {
            $id_img = $_POST['idImg'];
            $this->model->add_like($id_img);
        }
    }


    public function total_likes($id_img)
    {
        if (is_numeric($id_img))
        {
            $count = $this->model->total_likes($id_img);
            return ($count);
        }
    }

    public function total_comm($id_img)
    {
        if (is_numeric($id_img))
        {
            $count = $this->model->total_comm($id_img);
            return ($count);
        }
    }

    public function show_comments($id_img)
    {
        if (is_numeric($id_img))
        {
            $array = $this->model->show_comments($id_img);
            return $array;
        }
    }


    public function pag()
    {
        $current_page = null;
        if (isset($_POST['currentpage']) && is_numeric($_POST['currentpage']))
        {
            $current_page = $_POST['currentpage'];
            $this->pagination($current_page);
        }
        else if (isset($_SESSION['currpage']) AND is_numeric($_SESSION['currpage']))
        {
            $current_page = $_SESSION['currpage'];
            $this->pagination($current_page);
        }
        else
            $this->pagination(1);
    }

    public function pagination($currentpage)
    {
        if (is_numeric($currentpage))
        {
            if ($numrows = $this->model->getImagesRows())
            {
                $rowsperpage = 8;
                $totalpages = ceil($numrows / $rowsperpage);
                $range = 3; // range of num links to show

                // if current page is greater than total pages, set current page to last page
                if ($currentpage > $totalpages)
                    $currentpage = $totalpages;
                // if current page is less than first page, set current page to first page
                if ($currentpage < 1)
                    $currentpage = 1;

                $offset = ($currentpage - 1) * $rowsperpage;
                $res = $this->model->getImages($offset, $rowsperpage);
                $this->img = $res->fetchAll(PDO::FETCH_BOTH);


                /******  build the pagination links ******/
                ?>
                <ul class="pagination" role="navigation" aria-label="pagination"><?php
                if ($currentpage > 1)// if not on page 1, don't show back links
                {
                    $prevpage = $currentpage - 1;
                    ?>
                    <li>
                        <form method="POST" action="<?= URL_WITH_INDEX_FILE . 'gallery' ?>">
                            <input type="hidden" name="currentpage" value="1">
                            <button class="pagination-link" type="submit"><<</button>

                        </form>
                    </li>
                    <li>
                        <form method="POST" action="<?= URL_WITH_INDEX_FILE . 'gallery' ?>">
                            <input type="hidden" name="currentpage" value="<?= htmlspecialchars($prevpage, ENT_QUOTES) ?>">
                            <button type="submit" class="pagination-link"> <</button>
                        </form>
                    </li>
                    <?php
                }

                if ($totalpages > 1)
                {
                    // loop to show links to range of pages around current page
                    for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++)
                    {
                        // if it's a valid page number...
                        if ($x > 0 AND $x <= $totalpages AND $x == $currentpage): ?>
                            <li>
                                <button class="pagination-link" style="background-color:seagreen!important;"><?= htmlspecialchars($x) ?></button>
                            </li>
                        <?php elseif ($x > 0 AND $x <= $totalpages AND $x != $currentpage) : ?>
                            <li>
                                <form method="POST" action="<?= URL_WITH_INDEX_FILE . 'gallery' ?>">
                                    <input type="hidden" name="currentpage" value="<?= htmlspecialchars($x, ENT_QUOTES) ?>">
                                    <button class="pagination-link" type="submit"> <?= htmlspecialchars($x, ENT_QUOTES) ?> </button>
                                </form>
                            </li>
                        <?php endif;
                    }
                }
                // if not on last page, show forward and last page links
                if ($currentpage != $totalpages)
                {
                    $nextpage = $currentpage + 1;
                    ?>
                    <li>
                        <form method="POST" action="<?= URL_WITH_INDEX_FILE . 'gallery' ?>">
                            <input type="hidden" name="currentpage" value="<?= htmlspecialchars($nextpage, ENT_QUOTES) ?>">
                            <button class="pagination-link" type="submit"> ></button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="<?= URL_WITH_INDEX_FILE . 'gallery' ?>">
                            <input type="hidden" name="currentpage" value="<?= htmlspecialchars($totalpages, ENT_QUOTES) ?>">
                            <button class="pagination-link" type="submit"> >></button>
                        </form>
                    </li>
                    <?php
                }
                ?></ul><?php
                $_SESSION['currpage'] = $currentpage;
            }
            else
            {
                ?>
                <div class="home_unlogged">
                    No images in the gallery yet.
                </div>
                <?php
            }
        }

    }
}