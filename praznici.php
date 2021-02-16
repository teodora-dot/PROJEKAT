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

    <title>Neradni dani</title>
</head>

<body class="text-center">
    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <?php include "header.php";?>
        <table class='table display ' id='praznici_tabela'>
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Datum</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php include "footer.php" ?>
    <style>
        #praznici_tabela{
            color:black;
        }
    </style>
    <script>
        $(document).ready(function () {
            $.getJSON('./server/praznici.php', function (data) {
                console.log({ data: data });
                $('#praznici_tabela').DataTable({
                    "data": data.map(function (element) {
                        return [element.localName, element.date]
                    })
                });
            })
        })
    </script>
</body>

</html>
