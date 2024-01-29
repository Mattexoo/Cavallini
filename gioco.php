<?php
// $betSuit = $_POST['seme'];
$betSuit = "c";
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inizia la corsa</title>
    <link rel="stylesheet" href="gioco.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
        }

        .gioco {
            margin-top: 150px;
        }

        .field img {
            display: block;
        }

        .start {
            display: flex;
        }

        .start .deck {
            width: 300px;
            padding: 0 50px;
        }

        .start .cards img {
            position: relative;
            margin: 0 12px;
        }

        #pesca-carta {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <main class="gioco">
        <div class="field">
            <img src="./Immagini Carte/dorso.JPG" alt="">
            <img src="./Immagini Carte/dorso.JPG" alt="">
            <img src="./Immagini Carte/dorso.JPG" alt="">
            <img src="./Immagini Carte/dorso.JPG" alt="">
            <img src="./Immagini Carte/dorso.JPG" alt="">
        </div>

        <div class="start">
            <div class="deck">
                <img src="./Immagini Carte/dorso.JPG" alt="" id="pesca-carta">
                <img class="card" src="" alt="<-- clicca qui">
            </div>

            <div class="cards">
                <img src="./Immagini Carte/bg_c13.gif" alt="" data-suit="c">
                <img src="./Immagini Carte/bg_d13.gif" alt="" data-suit="d">
                <img src="./Immagini Carte/bg_h13.gif" alt="" data-suit="h">
                <img src="./Immagini Carte/bg_s13.gif" alt="" data-suit="s">
            </div>
        </div>
    </main>
    <?php
        //qua ricevi il seme punta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $seme = $_POST['seme']; // $seme = 'h', 'd', 'c', 's'

        }

    ?>
    <script>
        const START_POINTS = {
            c: 0,
            d: 0,
            h: 0,
            s: 0,
        }

        $(document).ready(function() {
            let points = {
                ...START_POINTS
            }

            function restartGame() {
                $(`[data-suit]`).css('top', '0')
                $(".deck .card").attr('src', '')
                $('.field img').attr('src', './Immagini Carte/dorso.JPG')
                points = {
                    ...START_POINTS
                }
                $.ajax({
                    url: 'pesca-carta.php',
                    type: 'GET',
                    cache: false,
                    data: {
                        restart: 1
                    },
                })
            }

            function checkGame(suit) {
                if (points[suit] === 6) {
                    setTimeout(() => {
                        const bet = '<?= $betSuit ?>'
                        const SUITS = {
                            c: 'fiori',
                            h: 'cuori',
                            s: 'picche',
                            d: 'quadri'
                        }

                        let message = ''
                        if (bet == suit) message = 'Complimenti, ha vinto il seme: ' + SUITS[suit]
                        else message = 'Hai perso, ha vinto il seme: ' + SUITS[suit]
                        message += "\nVuoi cambiare il seme scommesso?"

                        if (confirm(message)) window.location.replace("/")
                        else restartGame()

                    }, 200)
                    return
                }

                let showCard = points[suit] != 1
                for (const point of Object.values(points)) showCard &= point >= points[suit]
                if (!showCard) return

                $.ajax({
                    url: 'pesca-carta.php',
                    type: 'GET',
                    data: {
                        restart: 0
                    },
                    cache: false,

                    success: function(res) {
                        const cards = $('.field img')
                        cards.get(cards.length - points[suit] + 1).src = './Immagini Carte/' + res

                        setTimeout(() => {
                            suit = res[3];
                            $(`[data-suit="${suit}"]`).css('top', "-=" + $('.field img').height())
                            points[suit] += 1
                            checkGame(suit)
                        }, 200)
                    }
                })
            }

            $('#pesca-carta').click(function() {
                $.ajax({
                    url: 'pesca-carta.php',
                    type: 'GET',
                    data: {
                        restart: 0
                    },
                    cache: false,

                    success: function(response) {
                        $(".deck .card").attr('src', './Immagini Carte/' + response)
                        const suit = response[3]
                        points[suit] += 1

                        setTimeout(() => {
                            $(`[data-suit="${suit}"]`).css('top', "-=" + $('.field img').height())
                            checkGame(suit)
                        }, 200)
                    },
                })
            })
        })
    </script>
</body>

</html>