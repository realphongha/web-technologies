<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Trang chủ</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../../../public/css/style.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/banner.php';
        require_once __DIR__ . '/../fragments/menu.php';
        ?>
        
        <div id="content">            
            <div class="section-content">
                <h1>SÁCH HAY</h1>
            </div>
            <div class="row-center">
            <?php
                foreach ($variables as $book){
                    echo "<div class='row'>";
                    ?>      
                
                <div class="row-img">
                    <a href="/book/view?id=<?php echo $book->getBookId()?>">
                    <img src="<?php echo $book->getImage(); ?>"
                         style="height: 250px; width: 250px"/>
                    </a>
                </div>
                        
                    <?php                           
                        echo "<a href='/book/view?id={$book->getBookId()}' style='font-size:20px'>"
                            .$book->getTitle() ."</a>"; 
                        echo "<p>" .$book->getPrice() . " (VND)</p>";                                   
                    ?>      
                                       
                    <?php
                        echo "</div>";
                    }               
                    ?>                       
            </div>
        </div>
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>
