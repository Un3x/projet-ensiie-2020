<?php require_once("header.php"); ?>
<?php
$dbAdaper = (new DbAdaperFactory())->createService();
$MessageRepository = new \Message\MessageRepository($dbAdaper);
$userRepository = new \User\UserRepository($dbAdaper);

$id=$_SESSION['id'];
$messages_r = $MessageRepository->select_recep($id);
$messages_e = $MessageRepository->select_emet($id);
$user_cnt = $userRepository->select($id);

?>
<?php require_once("menuConnect.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Messages reçus</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>message</th>
                    <th>date</th>
                    <th>emetteur</th>
                    <th>recepteur</th>
                </tr>
                <?php foreach($messages_r as $message): ?>
                    <tr>
                        <td><?= $message->getContent() ?></td>
                        <td><?= $message->getDate() ?></td>
                        <td><?= $message->getEmetteur() ?></td>
                        <td><?= $message->getRecepteur() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Messages envoyés</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>message</th>
                    <th>date</th>
                    <th>emetteur</th>
                    <th>recepteur</th>
                </tr>
                <?php foreach($messages_e as $message): ?>
                    <tr>
                        <td><?= $message->getContent() ?></td>
                        <td><?= $message->getDate() ?></td>
                        <td><?= $message->getEmetteur() ?></td>
                        <td><?= $message->getRecepteur() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</br>
<button type="button" onclick="sendMsg('<?= $user_cnt->getRole() ?>')">Envoyer un message</button></br>
<form id="sndm" method="POST" action="sendMsg.php" style="display:none">
    <input name="id" type="hidden" value="<?= $user_cnt->getId() ?>">
    <label for="d">Destinataire : </label>
    <input type="text" id="d" name="dest" required="required"></br>
    <label for="m">Message : </label>
    <input type="text" id="m" name="msg" required="required"></br>
    <button type="button" onclick="document.getElementById('sndm').style.display='none'">Annuler</button>
    <button type="submit">Envoyer</button>
</form>
<form id="sndmA" method="POST" action="sendMsg.php" style="display:none">
    <input name="id" type="hidden" value="<?= $user_cnt->getId() ?>">
    <label for="d">Destinataire : </label>
    <input type="text" id="d" name="dest">
    <label for="sendAll">Envoyer à tous : </label>
    <input type="checkbox" name="sendAll"></br>
    <label for="m">Message : </label>
    <input type="text" id="m" name="msg" required="required"></br>
    <button type="button" onclick="document.getElementById('sndmA').style.display='none'">Annuler</button>
    <button type="submit">Envoyer</button>
</form>


<script type="text/javascript"> 
    function sendMsg(status){
        if (status=="Membre"){
           document.getElementById('sndm').style.display='block' 
           document.getElementById('sndmA').style.display='none'           
        }
        else if (status=="Administrateur"){
           document.getElementById('sndm').style.display='none'
           document.getElementById('sndmA').style.display='block'    
        }
    }
</script>

<?php require_once("footer.php"); ?>

