<?php
session_start();

$pseudo = $_SESSION['pseudo'];
$id     = $_SESSION['user_id'];

const VERSION = 1; // 1 OR 2

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (VERSION === 1): ?>
        <link rel="stylesheet" href="../public/css/style.css" type="text/css">
    <?php else : ?>
        <link rel="stylesheet" href="../public/style1.css" type="text/css">
    <?php endif; ?>
    <title>chatDialog</title>
</head>

<body>

    <?php if (VERSION === 1) : ?>

        <main class="flex flex-col justify-center">
            <section
                class="md:flex flex-row justify-between bg-[#734B5E] items-center text-[#F5D3C8] font-extrabold text-[40px] rounded-tl-[30px] rounded-tr-[30px]">
                <h3 >USER:</h3>
                <div class="flex flex-row justify-between gap-10">
                    <h3>Tchatche</h3>
                    <h3 class="pr-5">Application</h3>
                </div>
            </section>
            <section
                class="flex flex-row justify-around bg-[#565857] items-center text-[#F5D3C8] text-[40px] gap-0">
                <img src="../public/png/twitch-line.png" alt="twitch-line.png" />
                <h3>MiniChat</h3>
                <h3 class="hidden sm:flex">Participants</h3>
            </section>
            <section class="sm:flex flex-row justify-between items-center">
                <div class="message-user chat-dialog h-[77vh] flex-3 bg-[#D9D9D9] text-2xl overflow-scroll"></div>

                <div class="flex flex-row justify-between sm:hidden">
                    <button onclick="getMessage()" class="hover:scale-125">
                        <img class="sm:hidden" src="../public/png/send-ins-fill.png" alt="send-ins-fill.png" />
                    </button>
                    <input
                        type="text"
                        id="idmessage"
                        class="idmessage2 w-full text-[30px] bg-[#F5D3C8] sm:hidden" />
                </div>

                <h3 class=" flex sm:hidden text-[#F5D3C8] text-[40px] bg-[#565857]">
                    Participants
                </h3>
                <div
                    class="message-user chat-participant  h-[77vh] flex-1 bg-[#565857] text-2xl text-center text-amber-100 overflow-hidden"></div>
            </section>
            <div class="hidden sm:flex flex-row justify-between">

                <button onclick="getMessage()" class="hover:scale-125">
                    <img src="../public/png/send-ins-fill.png" alt="send-ins-fill.png" />
                </button>
                <input
                    type="text"
                    id="idmessage"
                    class="idmessage1 w-full text-[30px] bg-[#F5D3C8] hidden sm:flex" />
            </div>
        </main>


    <?php else : ?>
        <h1>ChatDialog</h1>
        <div class="ligne-connect">
            <a class="connectUser" href="deconnecter.php">se deconnecte</a>
            <span class="pseudo-titre"><?= $pseudo ?></span>
        </div>

        <main>
            <div id="start">
                <div id="container">
                    <div class="dialog">
                        <div class="chat-dialog"></div>
                        <div class="send">
                            <input type="button" value="message" onclick="getMessage()"> <input type="text" name="message" id="idmessage" class="idmessage1 idmessage2" size="44">
                        </div>
                    </div>
                </div>
                <div id="boiteParticipant">
                    <span class="titre">PARTICIPANT:</span>
                    <div class="chat-participant">
                    </div>
                </div>
            </div>

            <header>
                <ul>
                    <li>Date de création le 16/04/2026 </li>
                    <li>Developpeur Mr Moi </li>
                    <li>Exercice Php miniChat</li>
                    <li>Après 1 mois de formation Garage 404</li>
                </ul>
            </header>
        </main>
    <?php endif; ?>
    <!-- ----------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- ----------------------------------------------------------------------------------------------------------------------------------- -->
    <script type="text/javascript">
        const message = document.querySelector("#idmessage");
        const chatDialog = document.querySelector(".chat-dialog");
        const chatParticipant = document.querySelector(".chat-participant");
        let dateHeureSysMessagerie; // 
        let dateHeureMessageUser; //
        let runChat = 10; // au demarage affiche les dix messages avant la connection
        const tabClass = ["message-user1", "message-user2", "message-user3", "message-user4", "message-user5", "message-user6"];

        function setParticipant(users) {
            const participantUsers = users["participant"];
            chatParticipant.innerHTML = "";
            for (let x = 0; x < participantUsers.length; x++) {
                participantUsers[x].forEach((participant) => {

                    chatParticipant.innerHTML += `<div class='user-style'><span>${participant}</span></div>`
                    //   console.log(`Participant => ${participant}`);
                });
            }
            console.log(participantUsers);
        }

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
            let message;
            let mess1 = document.querySelector(".idmessage1");
            let mess2 = document.querySelector(".idmessage2");

            if (getComputedStyle(mess1).display !== "none")
                message = mess1;
            if (getComputedStyle(mess2).display !== "none")
                message = mess2;

            console.log(message.value);
            if (message.value === "")
                return;

            let heure;
            heure = formatDateTime();
            dateHeureMessageUser = heure;
            let pseudo = '<?= $pseudo ?>';
            let mes = message.value;
            console.log(mes);
            console.log(message.value);

            <?php if (VERSION == 2): ?>
                chatDialog.innerHTML += `<div class="message-user2">
                                        <span class="heure">${heure}</span>
                                        <span class="pseudo">${pseudo}:</span>
                                        <p>${mes}</p></div> `
            <?php endif; ?>
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
            console.log(result);

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

                    let classUser = "message-user" + Math.min(bddDatesMessages[i].user_id, 5);
                    chatDialog.innerHTML += `<div class="${classUser}">
                            <span class="heure">${bddDatesMessages[i].date}</span>
                            <span class="pseudo">${bddDatesMessages[i].pseudo}:</span>
                            <p class="message">${bddDatesMessages[i].message_user}</p></div> `

                }
                // const nouvelleDivArray = document.querySelectorAll(".message-user");
                // let i = nouvelleDivArray.length;
                // nouvelleDivArray[i - 1].scrollIntoView({
                //     behavior: 'smooth',
                //     block: 'end'
                // });
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
                    setParticipant(result);
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