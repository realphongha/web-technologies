<h1>Book lists</h1>
<div class="row">

    <div class="col-md-8">

        <?php
        $escapeHtml = 'htmlspecialchars';
        $books = isset($variables) ? $variables : [];
        foreach ($books as $book){
            ?>
            <h3>
                <?php
                    echo $escapeHtml($book->getTitle()) . ": " 
                            . $escapeHtml($book->getPrice()) . " (VND)";
                ?>
            </h3>
            <?php
        }
        ?>

    </div>
</div>