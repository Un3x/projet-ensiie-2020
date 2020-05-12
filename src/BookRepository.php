<?php


namespace Book;

class BookRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $booksData = $this->dbAdapter->query('SELECT * FROM book LEFT OUTER JOIN summary on book.id = summary.id_book order by book.id');
        $books = [];
        foreach ($booksData as $booksDatum) {
            $book = new Book();
            $book
                ->setId($booksDatum['id'])
                ->setTitre($booksDatum['titre'])
                ->setAuteur($booksDatum['auteur'])
                ->setApercu($booksDatum['apercu'])
                ->setSummary($booksDatum['summ'])
                ->setLikes($this->dbAdapter->query('SELECT count(likes) from summary where id_book = $booksDatum[\'id\']'))
                ->setDislikes($this->dbAdapter->query('SELECT count(dislikes) from summary where id_book = $booksDatum[\'id\']'))
                ->setCreatedAt(new \DateTime($booksDatum['created_at']))
                ->setBorrowed($booksDatum['borrowed']);
            $books[] = $book;
        }
        return $books;
    }

    public function borrow (int $bookId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "book" SET borrowed = TRUE where id = :bookId');

        $stmt->bindParam(':bookId', $bookId);
        $stmt->execute();
    }

    public function rendre (int $bookId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "book" SET borrowed = FALSE where id = :bookId');

        $stmt->bindParam(':bookId', $bookId);
        $stmt->execute();
    }

    public function delete (int $delBookId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE from "book" WHERE id = :delBookId');

        $stmt->bindParam(':delBookId', $delBookId);
        $stmt->execute();
    }

    public function add ($bookName,$bookAuteur,$descr,$file)
    {
        $target_dir = "Images/";
        echo $file["tmp_name"];
        echo $file["size"];
        $baseName = str_replace(' ','_', $bookName);
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($file["tmp_name"]);
        if($check){
            echo "File is an image - " . $check["mime"]."<br/>" ;
        }
        else{
            echo "File is not an image<br/>";
            $uploadOk = 0;
        }

        if($file["size"] > 5000000){
            echo "Sorry, your file is too big<br/>";
            $uploadOk = 0;
        }

        if(!($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg")){
            echo "You can only upload JPG, JPEG or PNG<br/>";
            $uploadOk = 0;
        }

        $target_file = $target_dir . $baseName . ".". $imageFileType;

        if(file_exists($target_file)){
            echo "Sorry, this file is already existing<br/>";
            $uploadOk = 0;
        }

        if($uploadOk == 0){
            echo "Sorry but your file was not uploaded due to problems you can see above<br/>";
        }
        else{
            if(move_uploaded_file($file["tmp_name"],$target_file)){
                echo "The file ". $baseName . " has been uploaded<br/>";
            }
            else{
                echo "Error during moving, please contact our webmaster<br/>";
            }
        }

        $sql=
<<<SQL
        INSERT INTO "book" 
        (titre,auteur,apercu,borrowed) 
        VALUES 
        (:bookName,:bookAuteur,:pathFile,FALSE);
        
SQL;
        $sqld=
<<<SQL
        INSERT INTO "summary"
        (id_book,summ)
        VALUES
        ((SELECT id from book where titre = :bookName),:descr);
SQL;
        
        $stmt = $this
            ->dbAdapter
            ->prepare($sql);

        $stmt->bindParam(':bookName', $bookName);
        $stmt->bindParam(':bookAuteur', $bookAuteur);
        $stmt->bindParam(':pathFile', $target_file);
        $stmt->execute();

        $stmtd = $this
            ->dbAdapter
            ->prepare($sqld);

        $stmtd->bindParam(':bookName', $bookName);
        $stmtd->bindParam(':descr', $descr);
        $stmtd->execute();
    }
    
    public function getHint (string $search)
    {        
        $sql =
<<<SQL
        SELECT * from book
        WHERE (upper(titre) LIKE upper('%$search%')
        OR upper(auteur) LIKE upper('%$search%'))
        ORDER BY auteur;
SQL;
        $stmt = $this
            ->dbAdapter
            ->prepare($sql);
        $stmt->execute();
        $outp = "";

        if($stmt->rowCount()<1){
            echo "Pas de suggestion";
        }
        else{
            foreach($stmt->fetchAll() as $book){
                $outp .= $book['auteur'].",".$book['titre'].",";
            }
            $stmt = null;
            echo $outp;
        }


    }

    function findBookByName(string $search) {
        $sql = 
<<<SQL
        SELECT * from book
        LEFT JOIN summary on book.id = summary.id_book
        WHERE (upper(titre) LIKE upper('%$search%')
        OR upper(auteur) LIKE upper('%$search%'))
        ORDER BY auteur;
SQL;
        $stmt = $this
            ->dbAdapter
            ->prepare($sql);
        $stmt->execute();
        $books=[];
        foreach ($stmt->fetchAll() as $booksDatum){
            $book = new Book();
            $book
                ->setId($booksDatum['id'])
                ->setTitre($booksDatum['titre'])
                ->setAuteur($booksDatum['auteur'])
                ->setApercu($booksDatum['apercu'])
                ->setSummary($booksDatum['summ'])
                ->setCreatedAt(new \DateTime($booksDatum['created_at']))
                ->setBorrowed($booksDatum['borrowed']);
            $books[] = $book;
        }
        return $books;
    }

    function findBookById(int $search) {
        $sql = 
<<<SQL
        SELECT * from book
        LEFT JOIN summary on book.id = summary.id_book
        WHERE book.id = :search
        ORDER BY auteur;
SQL;
        $stmt = $this
            ->dbAdapter
            ->prepare($sql);
        $stmt->bindParam(':search',$search);
        $stmt->execute();
        $books=[];
        foreach ($stmt->fetchAll() as $booksDatum){
            $book = new Book();
            $book
                ->setId($booksDatum['id'])
                ->setTitre($booksDatum['titre'])
                ->setAuteur($booksDatum['auteur'])
                ->setApercu($booksDatum['apercu'])
                ->setSummary($booksDatum['summ'])
                ->setCreatedAt(new \DateTime($booksDatum['created_at']))
                ->setBorrowed($booksDatum['borrowed']);
            $books[] = $book;
        }
        return $books;
    }


    function register(string $username, $password,$confirm_password){
        $username_err = $password_err = $confirm_password_err = "";
        if(empty(trim($username))){
            $username_err = "Please enter a username !";
        }
        else{
            //Preparation d un select sql
            $sql = 
<<<SQL
            SELECT id FROM users 
            Where username = :username;
SQL;
    
            if($stmt = $this
                    ->dbAdapter
                    ->prepare($sql)){

                //Bind values
                
                $stmt->bindParam(':username',$param_username);
                $param_username = trim(htmlentities($username));
                //echo $stmt->execute();
                //if($stmt->execute()){
                    $stmt->execute();
                    if($stmt->rowCount()==1){
                        $username_err ="This username is already taken";
                    }
                    else{
                        $username = trim(htmlentities($username));
                    }
                /*}
                else{
                    echo "Oooooops! Something went wrong during username validation. Please try again later or contact our webmaster";
                }*/
                unset($stmt);
            }
        }
        
        //Validation password
        if(empty(trim($password))){
            $password_err="PLEASE enter a password";
        }
        elseif(strlen(trim($password))<6){
            $password_err = "Password must have atleast 6 characters ";
        }
        
        else{
            $password = trim(htmlentities($password));
        }
    
        //Confirmation password
        if(empty(trim($confirm_password))){
            $confirm_password_err = "Please confirm password";
        }
        else{
            $confirm_password = trim(htmlentities($confirm_password));
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match";
            }
        }
        // Check input errors before inserting into database (SQL injection ?)
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            // Prepare SQL
            $sql = "INSERT INTO users (username, passwd,adminright) VALUES (:username, :passwd,false)";
            if($stmt = $this
                        ->dbAdapter
                        ->prepare($sql)){
                //Bind parameters
                $stmt->bindParam(":username", $param_username);
                $stmt->bindParam(":passwd", $param_password);
    
                // Set parameters
                $param_username = $username;
                // Creates a password hash
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                //attempt to execute the prepared statement
                //if($stmt->execute()){
                    $stmt->execute();
                    echo "Compte bien ajouté";
                    $data=[];
                    include_once '../src/View/template.php';
                    loadView("login",$data);
                /*}
                else{
                    echo "Something went wrong during password validation. Please try again later or contact our webmaster";
                }*/
    
                unset($stmt);
            }
        }
        else{
            echo $username_err.'<br/>';
            echo $password_err.'<br/>';
            echo $confirm_password_err.'<br/>';
            echo '<button onclick="history.back();">Back </button>';
        }
    }
    function login(string $username, $password){
        session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("Location: index.php");
            exit;
        }
        $username_err = $password_err = "";

        if(empty(trim($username))){
            $username_err = "Please enter username";
        }
        else{
            $username = trim(htmlentities($username));
        }

        if(empty(trim($password))){
            $password_err = "Please enter your password";
        }
        else{
            $password = trim(htmlentities($password));
        }
        echo $password_err;
        echo $username_err;
        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT id, username, passwd,adminright from users where username = :username";
            if($stmt = $this
                        ->dbAdapter
                        ->prepare($sql)){
                $stmt->bindParam("username",$param_username);

                $param_username = trim(htmlentities($username));
                $stmt->execute();
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $adminright = $row["adminright"];
                        $hashed_passwd = $row["passwd"];
                        if(password_verify($password, $hashed_passwd)){
                            //password is correct
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["adminright"] = $adminright;

                            header("Location: index.php");
                        }
                        else{
                            $password_err = "The password you enter is not valid, try again";
                        }
                    }
                }
                else{
                    $username_err = "No account found with that username, create an account";
                }
            }
        }
        if(!empty($username_err) || !empty($password_err)){
            echo $username_err.'<br/>';
            echo $password_err.'<br/>';
            echo '<button onclick="history.back();">Back </button>';
        }
    }

    public function likes (int $userId, int $bookId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "summary"(id_book,likes) VALUES (:bookID,:userID)');

        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
    public function dislikes (int $userId, int $bookId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "summary"(id_book,dislikes) VALUES (:bookID,:userID)');

        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
?>