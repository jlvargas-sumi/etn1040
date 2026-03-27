<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @page {
            margin: 3cm 1cm 1.5cm 1cm;
        }
        body{
            padding: 0;
            margin: 0;
        }
        header {
            position: fixed;
            top: -2cm;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
        }
        header, main, footer{
            /* background: red; */
            /* width: 740px; */
        }
        header table{
            width: 100%;
            border-collapse: collapse;
        }
        header table td{
            padding: 0;
            margin: 0;
        }
        header .logo{
            height: 76px;
            width: 40px;
        }
        header img{
            height: 100%;
            width: 100%;
        }
        header #titulo-encabezado{
            width: 660px;
            height: 76px;
            text-align: center;
            font-size: 10px;
        }
        #titulo-principal{
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        /* main{
            background: yellow;
        } */
        main table{
            margin-top: 20px;
            width: 100%;
            box-sizing: border-box;
            border-collapse: collapse;
            font-family:Verdana;
            font-size:10px;
        }
        main table .fondo-gris{
            background: #e0e0e0;
        }
        main td, main th{
            border: 1px solid black;
            color:#000000;
            padding: 5px;
        }
            .firma{
                height: 130px;
                width: 100%;
                text-align: center;
            }
            .firma span{
                display: inline-block;
                font-weight: bold;
                margin: 130px 50px 0px 50px;
                width: 250px;
                text-align: center;
                border-top: 2px solid black;
            }
        footer {
            position: fixed;
            bottom: -0.5cm;
            left: 0;
            right: 0;
            height: 0.5cm;
        }
        /* .sin-borde{
            width: auto;
        } */
        .sin-borde th, .sin-borde td{
            border: 5px solid white;
        }
        .nombre-celda{
            font-weight: bold;
            background: #e0e0e0;
            border-radius: 5px 0px 0px 5px;
        }

        .pagina-nueva{
            page-break-before: always !important;
        }
        .w-70{
            width: 70px;
        }
        .w-30{
            width: 30px !important;
        }
        .w-50{
            width: 50px !important;
        }
        .w-210{
            width: 210px;
        }
        .invisible{
            display: none;
        }
        .centro{
            text-align: center;
        }
        .derecha{
            text-align: right;
        }
        .izquierda{
            text-align: left;
        }        
    </style>
    <title>Lista de Inscritos</title>
</head>
<body>
    <x-usuario.auxiliar.auxiliaturas.inscritos.encabezado />
    <x-usuario.auxiliar.auxiliaturas.inscritos.pie/>
    <main>
        <x-usuario.auxiliar.auxiliaturas.inscritos.resultado-pdf :asignatura=$asignatura :auxiliar=$auxiliar :inscritos=$inscritos :periodo=$periodo :gestion=$gestion/>
    </main>
</body>
</html>