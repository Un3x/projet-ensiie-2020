<div class="container">
    <?php session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["adminright"] == true){?>
    <h2>Add a book :</h2>

    <form method="post" action="borrowBook.php?add=1" enctype="multipart/form-data" >
    <label> Title </label>
    <input type="text" name="title" >

    <label> Author </label>
    <input type ="text" name="auteur">

    <label>Summary </label>
    <input type="text" name="descr">

    <label> Image </label>
    <input type="file" value="Upload Image for the book" name="imageToUpload" id="imageToUpload">

    <input type="submit" value="Add">

    </form>
    <?php }else{?>
    <p> You don't have access to this, please quit </p>
    <?php }?>

</div>
<script src="script.js"></script>