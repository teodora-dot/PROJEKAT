<?php include "./server/vratiNaLogin.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="#">

    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    <link href="cover.css" rel="stylesheet">
    <script src="./assets/DataTables-1.10.4/extensions/AutoFill/js/dataTables.autoFill.js"></script>
    <link rel="stylesheet" href="./assets/DataTables-1.10.4/extensions/AutoFill/css/dataTables.autoFill.css" />
</head>

<body class="text-center">

    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <?php include "header.php" ?>
        <div class="row">
            <h1>Vasi sastanci</h1>
        </div>
        <table class='table' id="podaci">
            <thead>
                <tr>

                    <th scope="col">Tema</th>
                    <th scope="col">Datum</th>
                    <th scope="col">Tip sastanka</th>
                    <th scope="col">Organizator</th>
                </tr>
            </thead>

        </table>
    </div>

    <style>
        #podaci {
            color: black;
        }
    </style>


    <script>
        $(document).ready(function () {
            $.getJSON('./server/korisnikoviSastanci.php', function (data) {
                $('#podaci').DataTable({
                    "data": data.map(function (element) {
                        return [element.tema, element.datum, element.kategorija, element.username]
                    })
                })
            })
        })
    </script>
</body>

</html>