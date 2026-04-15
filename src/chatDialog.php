<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>chatDialog</title>

</head>

<body>
    <h1>ChatDialog</h1>
    <a href="deconnecter.php">se deconnecte</a>
    <?php
    $pseudo = $_SESSION['pseudo'];
    $id     = $_SESSION['user_id'];
    echo $_SESSION['pseudo'], "<br>";
    echo $_SESSION['user_id'], "<br>";
    ?>

    <main>
        <div id="container">
            <div class="dialog">
                <div class="chat-dialog"></div>
                <div class="send">
                    <input type="button" value="message" onclick="getMessage()"> <input type="text" name="message" id="idmessage" size="44">
                </div>
            </div>
        </div>
        <div class="chat-participant">
            <span>PARTICIPANT:</span>
        </div>
    </main>


    <!-- ----------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- ----------------------------------------------------------------------------------------------------------------------------------- -->
    <script type="text/javascript">
        const message = document.querySelector("#idmessage");
        const chatDialog = document.querySelector(".chat-dialog");
        let dateHeureSysMessagerie;
        let dateHeureMessageUser;
        const tabClass = ["message-user", "message-user1", "message-user2", "message-user3", "message-user4"];

        function formatDateTime() {
            const timeNow = new Date();
            const dateDuJour = timeNow.toLocaleDateString();
            const heureDuJour = timeNow.toLocaleTimeString();
            const dateDuJourArray = dateDuJour.split('/');
            let dateHeureDuJour = dateDuJourArray[2] + "-" + dateDuJourArray[1] + "-" + dateDuJourArray[0];
            dateHeureDuJour += " " + heureDuJour;
            return dateHeureDuJour;
        }

        /**
         * 
         * getMessage
         * 
         * Recupere le message ecris par l'utilisateur
         * 
         */
        function getMessage() {
            if (message.value == "")
                return;

            let heure;
            heure = formatDateTime();
            dateHeureMessageUser = heure;
            let pseudo = '<?= $pseudo ?>';
            let mes = message.value;
            console.log(mes);
            console.log(message.value);

/*
            chatDialog.innerHTML += `<div class="message-user2">
                            <span class="heure">${heure}</span>
                            <span class="pseudo">${pseudo}:</span>
                            <p>${mes}</p></div> `
*/
            message.value = "";
            sendMessage(mes);
        }

        /**
         * 
         * 
         * sendMessage
         * 
         * envoie le message dans la base de donnée
         * 
         */
        async function sendMessage(mes) {
            try {
                const response = await fetch("traitementMessage.php", {
                    method: 'POST',
                    headers: {
                        'content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: mes,
                        user_id: <?= $id ?>,
                        dateHeure: dateHeureMessageUser,
                        pseudo: "<?= $pseudo ?>"
                    })
                });
                if (!response.ok) {
                    throw new Error(`Erreur serveur :${response.status}`);
                }
                const result = await response.json();
                if (result.status === 'succes') {
                    console.log("Message envoyer avec succes ");
                }
                //   loadMessage();
            } catch (e) {
                console.log("Erreur d'envoi", e);
            }

        }


        /****
         * 
         * 
         * updateChate 
         * 
         * cette fonction doit metre a jour le panneau chat
         */
        function updateChat(result) {

            console.log("Bravo");
            const bddDatesMessages = result["bddMessage"];

            console.log(bddDatesMessages);

            if (bddDatesMessages.length >= 1) {

                let idx = bddDatesMessages.length;
                dateHeureSysMessagerie = bddDatesMessages[idx - 1]["date"];

                for (let i = 0; i < bddDatesMessages.length; i++) {

/*
                    if (bddDatesMessages[i].pseudo === "<?= $pseudo ?>") {

                        continue;
                    }
*/
                    chatDialog.innerHTML += `<div class="message-user">
                            <span class="heure">${bddDatesMessages[i].date}</span>
                            <span class="pseudo">${bddDatesMessages[i].pseudo}:</span>
                            <p>${bddDatesMessages[i].message_user}</p></div> `

                }
                const nouvelleDivArray = document.querySelectorAll(".message-user");
                let i = nouvelleDivArray.length;
                nouvelleDivArray[i - 1].scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }
        }

        /****
         * 
         * getMessageInDatabase
         * 
         *  interroge la base de donnée pour savoir si il y a des nouveau messages 
         * 
         */
        async function getMessageInDatabase() {
            if (dateHeureSysMessagerie == undefined)
                dateHeureSysMessagerie = formatDateTime();
            try {
                const response = await fetch("scan.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        date_message: dateHeureSysMessagerie
                    })
                });

                if (!response.ok) {
                    throw new Error("Serveur erreur");
                }
                const result = await response.json();

                if (result.status == "succes") {
                    updateChat(result);
                }
            } catch (e) {
                console.log(`une erreur c'est produite `);
            } finally {
                setTimeout(getMessageInDatabase, 2000);
            }
        }
        /******************************************************************************************************** */

        getMessageInDatabase();
    </script>
</body>

</html>