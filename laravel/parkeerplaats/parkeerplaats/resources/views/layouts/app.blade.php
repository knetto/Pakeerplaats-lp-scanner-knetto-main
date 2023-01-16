<!DOCTYPE html>

<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200, 600" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <script src="https://kit.fontawesome.com/d4b04772d6.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/css/main.css">

    <link rel="stylesheet" href="/css/main.scss">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parkeerplaats</title>

</head>

<body>
    <x-navbar/>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield ('content')
</body>
    
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$("#myTable").DataTable()
$("#myTable2").DataTable()
</script>