<?php
$betSuit = $_POST['seme'];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inizia la corsa</title>
    
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
            margin: 0px;
            background-image: url(./IMG/bg.png);
            background-repeat: no-repeat;
            background-position: top;
            background-size: cover;
        }

        .gioco {
            margin-top: 0px;
        }

        .field{
            display: flex;
            flex-direction: column;
            width: 5%;
            height: 450px;
            padding: 10px;
            margin-left: 20%;
        }
        .field img {
            display: block;
            height: 125px;
            width: 100px;
            margin: 5px;
            border: solid 1px black;
            border-radius: 7px;
        }

        .start {
            display : flex;
            align-items : center;
            justify-content : center;
            flex-direction: row;
            width : 90vh;
            margin-left: 25%;
            margin-top : 205px;
            padding: 25px;
        }

        .start .cards {
            display: flex;
            max-width: 700px;
        }

        .start .deck {
            width: 400px;
            padding: 0 50px;
            display : flex;
            align-items : center;
            justify-content : center;
            flex-direction: row;
            
        }

        .start .cards img {
            position: relative;
            margin: 0 12px;
            border: solid 1px black;
            border-radius: 7px;
            padding : 5px;
            background-color: white;
            height: 125px;
        }

        #pesca-carta {
            cursor: pointer;

            /**QUESTI COMANDI TOLGONO LA POSSIBILITA' DI EVIDENZIARE IL TESTO */
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non prefisso */

            border: solid 2px black;
            padding: 15px;
            border-radius: 20px;
            display : flex;
            align-items : center;
            justify-content : center;
            flex-direction: column;
            background-color: #bee9e8;
        }

        #pesca-carta:hover{
            background-color: #5e9695;
        }

        .card{
            border: solid 1px black;
            border-radius: 7px;
        }
    </style>
</head>

<body>
        <header>
            <img src="./IMG/bandiera.jpg" width="100%" height="75px">
        </header>
    <main class="gioco">
        <div class="field">
            <img src="./ImmaginiCarte/dorso.JPG" alt="">
            <img src="./ImmaginiCarte/dorso.JPG" alt="">
            <img src="./ImmaginiCarte/dorso.JPG" alt="">
            <img src="./ImmaginiCarte/dorso.JPG" alt="">
            <img src="./ImmaginiCarte/dorso.JPG" alt="">
        </div>

        <div class="start">
            <div class="deck">
                <div id="pesca-carta">
                    <div>
                    GIRA
                    </div> 
                    <div>
                    UNA
                    </div>
                    <div>
                    CARTA
                    </div>
                </div>
                <img class="card" src="">
            </div>

            <div class="cards">
                <img src="./ImmaginiCarte/bg_c13.gif" alt="" data-suit="c">
                <img src="./ImmaginiCarte/bg_d13.gif" alt="" data-suit="d">
                <img src="./ImmaginiCarte/bg_h13.gif" alt="" data-suit="h">
                <img src="./ImmaginiCarte/bg_s13.gif" alt="" data-suit="s">
            </div>
        </div>
    </main>
    
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
                $('.field img').attr('src', './ImmaginiCarte/dorso.JPG')
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
                        const bet = '<?= $betSuit ?>'.trim()
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

                        if (confirm(message)) window.location.replace("./")
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
                        cards.get(cards.length - points[suit] + 1).src = './ImmaginiCarte/' + res

                        setTimeout(() => {
                            suit = res[3];
                            $(`[data-suit="${suit}"]`).css('top', `-=${$('.field img').height() + 10}px`)
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
                        $(".deck .card").attr('src', './ImmaginiCarte/' + response)
                        const suit = response[3]
                        points[suit] += 1

                        setTimeout(() => {
                            $(`[data-suit="${suit}"]`).css('top', `-=${$('.field img').height() + 10}px`)
                            checkGame(suit)
                        }, 200)
                    },
                })
            })
        })
    </script>
</body>

</html>
