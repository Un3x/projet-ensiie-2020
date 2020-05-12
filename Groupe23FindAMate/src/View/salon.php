<?php
if(empty($_SESSION))
{
    header('location: login.php');
}
$messageRepository = new \src\Model\repository\MessageRepository($dbAdapter);
$searchRepository = new \src\Model\repository\SearchRepository($dbAdapter);
if(isset($_POST['message']) && !empty($_POST['message']) && isset($_SESSION['name']) && !empty($_SESSION['name']) )
{
    $messageRepository->insert($_POST['message'],$_POST['Rejoindre'],$_SESSION['name']);

}
if (isset($_POST['Rejoindre']) && isset($_SESSION['name']) && !empty($_SESSION['name']))
{

    $messages = $messageRepository->viewMessage(htmlspecialchars($_POST['Rejoindre']));
    $searchs= $searchRepository->getInfo(htmlspecialchars($_POST['Rejoindre']));
    $id=htmlspecialchars($_POST['Rejoindre']);

}
foreach($searchs as $search)
{
    $title=$search->getTitle();
    $createur=$search->getUsername();
}
if($messages=="")
{
    echo $messages;
}
else
{
    foreach($messages as $message)
    {
    $content=htmlspecialchars($message->getContent());
    $emittor=htmlspecialchars($message->getEmittor());
   /*  $content=$message->getContent(); */

    }
}

?>



<html>
    <head>
        
        <meta charset="utf-8">

    </head>
    <body>
        <h2 align="center">Salon créé par <?php echo $createur; ?></h2> <br/>
        <h3 align="center"><?php echo $title; ?></h3>
        <div class="rectangle2"><?php 
        if($messages!=""){
        foreach($messages as $message)
        {
            $content=$message->getContent();
            $emittor=$message->getEmittor();
        /*  $content=$message->getContent(); */
        echo $emittor.': '.$content.'<br/>';     

        }}?>
        


        <form action="salon.php" method="POST">
        <input type='string' autocomplete="off" placeholder="Ecrivez votre message..." name="message" style="width: 1630px;"></input>
        <button class="button" type="submit" name="Rejoindre" value="<?php echo $id ; ?>" >Envoyer</input>
        </div>
    </body>

