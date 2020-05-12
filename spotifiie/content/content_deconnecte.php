<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <img id="imageAccueil" src="images/ado.jpg">
        </div>
        <div id="content" class="col-sm-6 col-sm-6">
            <?php
            echo "<h1 style='margin-top: 3%'>$pageTitle</h1>";
            if ($authorized) {
                require("content/content_$askedPage.php");
            } else {
                echo "<p>Page inaccessible</p>";
            }
            ?>
            <footer style="position:fixed;bottom: 0px">
                <p>Site réalisé par Rachid Krita, Yasmine Ouyahya, Roxane Douc et Marie Hyvernaud</p>
            </footer>
        </div>
    </div>
</div>  
