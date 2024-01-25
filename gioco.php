<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inizia la corsa</title>
    <link rel="stylesheet" href="gioco.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <main class="gioco">
        <button>
            click me
        </button>
    </main>
    <?php

        //qua ricevi il seme punta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $seme = $_POST['seme']; // $seme = 'h', 'd', 'c', 's'
            
        }

    ?>
    <script>
        $(document).ready(function() {
            $('button').click(function() {
                $.ajax({
                    url: 'pesca-carta.php',
                    type: 'GET',
                    data: {},

                    success: function(response) {
                        console.log()
                    },
                })
            })
        })
    </script>
</body>

</html>