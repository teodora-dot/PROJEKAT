<?php include "./server/adminPristup.php"; ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>Pocetna strana</title>

    <link href="./assets/bootstrap.min.css" rel="stylesheet">

    <link href="cover.css" rel="stylesheet">
</head>

<body class="text-center">
    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <?php include "header.php" ?>
        <div class="row">
            <p class="lead">Zakazite novi sastanak <button class="btn btn-secondary create-button" data-toggle="modal"
                    data-target="#exampleModal" type="button">Kreiraj</button></p>
        </div>
        <p class="lead">Zakazani sastanci:</p>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tema</th>
                    <th scope="col">Datum</th>
                    <th scope="col">Tip sastanka</th>
                    <th scope="col">Organizator</th>
                    <th scope="col">Akcije</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
            </tbody>
        </table>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sastanak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="about-block content content-center" id="about">
                            <div class="container">
                                <div class="row">
                                    <div class="col">

                                        <div class="col-md-12 blackText">
                                            <form>

                                                <label for="Naslov">Tema</label>
                                                <input type="text" id="naslov" class="form-control">
                                                <label for="datum">Datum</label>
                                                <input type="date" id="datum" class="form-control">
                                                <label for="tip">Tip</label>
                                                <select class="form-control" id="tip"></select>
                                                <label for="organizator">Organizator</label>
                                                <select class="form-control" id="organizator"></select>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-12 blackText">
                                        <h3>Clanovi</h3>
                                        <label for="clan">Dodaj clana</label>
                                        <select class="form-control" id="clan"></select>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Ime</th>
                                                    <th>Prezime</th>
                                                </tr>
                                            </thead>
                                            <tbody id='clanovi'>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ponisti</button>
                        <button type="button" id="modal-save" class="btn btn-primary">Sacuvaj promenu</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="./assets/popper.min.js"></script>
        <script src="./assets/bootstrap.min.js"></script>
        <script>
            var sastanci;
            var trenutniSastanak;
            var sviZaposleni;
            var clanovi = [];

            $(document).ready(function () {
                dovuciSastanke();
                dovuciZaposlene('organizator');
                dovuciZaposlene('clan');
                dovuciTipove();
                $('#clan').change(function (e) {
                    let novi = $('#clan').val();
                    let stari = clanovi.find(element => element.id == novi);
                    if (stari !== undefined) {
                        return;
                    }
                    clanovi.push(sviZaposleni.find(element => element.id == novi));
                    postaviClanove(clanovi)
                })

                $('#modal-save').click(function (e) {
                    e.preventDefault();
                    izmeniSastanak({
                        id: trenutniSastanak ? trenutniSastanak.id : undefined,
                        tema: $('#naslov').val(),
                        zaposleni: $('#organizator').val(),
                        datum: $('#datum').val(),
                        tip: $('#tip').val(),
                        clanovi: clanovi.map(function (element) {
                            return element.id;
                        }),
                    })
                })
                $("#exampleModal").on('show.bs.modal', function (event) {
                    let button = $(event.relatedTarget)
                    let index = button.data('index');
                    $('#clan').val('');
                    if (index !== undefined && index > -1) {

                        trenutniSastanak = sastanci[index];
                        $('#naslov').val(trenutniSastanak.tema);
                        $('#tip').val(trenutniSastanak.tip_id);
                        $('#organizator').val(trenutniSastanak.zaposleni_id);
                        let datum = trenutniSastanak.datum.split('-');
                        datum = datum[1] + '/' + datum[2] + '/' + datum[0];
                        datum = new Date(datum).toISOString().substr(0, 10);
                        dovuciClanove(trenutniSastanak.id);

                        $('#datum').val(datum);
                    } else {
                        clanovi = [];
                        trenutniSastanak = [];
                        $('#naslov').val('');
                        $('#tip').val('');
                        $('#organizator').val('');
                        $('#datum').val('');
                        $('#clanovi').html('');
                    }

                })
            })





            function dovuciSastanke() {
                $.get('http://localhost:80/projekatIteh/servis/sastanak.json', function (data) {
                    sastanci = data;
                    napuniTabelu(data);
                })
            }
            function napuniTabelu(podaci) {
                $('#user-table-body').html('');
                podaci.forEach((element, index) => {
                    $('#user-table-body').append(
                        '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + element.tema + '</td>' +
                        '<td>' + element.datum + '</td>' +
                        '<td>' + element.naziv + '</td>' +
                        '<td>' + element.ime + ' ' + element.prezime + '</td>' +
                        '<td><button id="update' + element.id + '" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" data-index="' + index + '" type="button">Izmeni</button>' +
                        '<button id="delete' + element.id + '" class="btn btn-danger">Obrisi</button></td>' +
                        '/tr' +
                        '</table>');
                    $("#delete" + element.id).click(function (e) {
                        obrisiSastanak(element.id);
                    })
                });

            }

            function dovuciZaposlene(tag) {
                $.getJSON('http://localhost:80/projekatIteh/servis/zaposleni.json', function (data) {


                    if (!data) {
                        return;
                    }
                    sviZaposleni = data;
                    $('#' + tag).html('');
                    for (let element of data) {
                        $('#' + tag).append(`
                            <option value=${element.id}>
                                ${element.username}
                            </option>
                        `)
                    }
                })
            }
            function dovuciTipove() {
                $.getJSON('http://localhost:80/projekatIteh/servis/tip.json', function (data) {

                    if (!data) {
                        return;
                    }
                    $('#tip').html('');
                    for (let element of data) {
                        $('#tip').append(`
                            <option class="form-control" value=${element.id}>
                                ${element.naziv}
                            </option>
                        `)
                    }
                })
            }
            function obrisiSastanak(id) {
                $.post('./server/sastanak.php', {
                    podaci: JSON.stringify({
                        akcija: 'obrisi',
                        id: id
                    })
                }, function (response) {
                    alert(response);
                    dovuciSastanke();
                })
            }

            function dovuciClanove(id) {
                $.getJSON(`http://localhost/projekatIteh/servis/sastanak/${id}/zaposleni.json`, function (data) {

                    if (!data) {
                        return;
                    }
                    clanovi = data;
                    postaviClanove(clanovi);
                })
            }
            function izmeniSastanak(sastanak) {
                if (sastanak.id) {
                    $.post('./server/sastanak.php', {
                        podaci: JSON.stringify({
                            akcija: 'izmeni',
                            sastanak: sastanak
                        })
                    }, function (response) {
                        alert(response);
                        dovuciSastanke();
                    })
                } else {
                    $.post('./server/sastanak.php', {
                        podaci: JSON.stringify({
                            akcija: 'dodaj',
                            sastanak: sastanak
                        })
                    }, function (response) {
                        alert(response);
                        dovuciSastanke();

                    })
                }

            }
            function postaviClanove(data) {

                if (!data) {
                    return;
                }
                $('#clanovi').html('');
                for (let element of data) {
                    $('#clanovi').append(`
                            <tr>
                                <td>${element.ime + ' ' + element.prezime}</td>
                                <td>
                                    <button id="obrisiSastanak${element.id}" class='btn-danger'>X</button>
                                </td>
                            </tr>
                        `)
                    $(`#obrisiSastanak${element.id}`).click(function (e) {
                        clanovi = clanovi.filter(clan => clan.id != element.id);
                        postaviClanove(clanovi)
                    })
                }
            }

        </script>
</body>

</html>
