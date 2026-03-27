<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin: 3cm 1cm 1cm 1cm;
        }
        .nacional{
            background: #FD8A8A;
        }
        .rollout{
            background: #F1F7B5 ;
        }
        .corporativo{
            background: #A8D1D1;
        }
        .light-blue-darken-4{
            background: #01579b;
        }
        .purple{
            background: #9c27b0;
        }
        .amber-accent-4{
            background: #ffab00;
        }
        .blue{
            background: #2196f3;
        }
        .green{
            background: #4caf50;
        }
        .grey{
            background: #9e9e9e;
        }
        .red{
            background: #f44336;
        }
        body{
            padding: 0;
            margin: 0;
        }
        header {
            font-size: 12px;
            position: fixed;
            top: -2cm;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
        }

        header, main, footer{
            /* width: 1040px; */
            width: 725px;
        }
        header table{
            width: 100%;
        }
        
        header table td{
            padding: 0;
            margin: 0;
        }
        header .logo-acta{
            width: 80px;
            height: 40px;
        }
        header img{
            width: 100%;
        }
        header .titulo-acta{
            text-align: center;
            width: 500px;
            font-size: 10px !important;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .tabla-cronogramas{
            width: 100%;
            box-sizing: border-box;
        }
        .pagina-nueva{
            page-break-before: always !important;
        }
        main table{
            width: 100% !important;
            box-sizing: border-box;
            border-collapse: collapse;
            font-family:Verdana;
            font-size:6px;
        }
        main td, main th{
            border: 1px solid black;
            color:#000000;
            padding: 1px;
        }
        main th.dia, main td.dia{
            min-width: 8px !important;
            min-height: 8px !important;
        }
        main .referencia, main .conteo, main > span{
            width: auto !important;
            font-size: 10px !important;
            margin: 20px;
        }
        .w-70{
            width: 70px;
        }
        .w-15{
            width: 15px !important;
        }
        .w-30{
            width: 30px !important;
        }
        .w-50{
            width: 50px !important;
        }
        .w-120{
            width: 120px !important;
        }
        .w-150{
            width: 150px !important;
        }
        .w-210{
            width: 210px;
        }
        .invisible{
            display: none;
        }
        .centro{
            text-align: center !important;
        }
        .derecha{
            text-align: right;
        }
        .izquierda{
            text-align: left;
        }

        footer {
            font-size: 10px;
            /* position: fixed; */
            bottom: -2cm;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
        }
        .firma{
            width: 100%;
            height: 100%;
            text-align: center
        }
        .firma span{
            display: inline-block;
            font-weight: bold;
            margin: 120px 50px -5px 50px;
            width: 250px;
            text-align: center;
            border-top: 2px solid black;
        }
    </style>
</head>
<body>
    
    <header class="encabezado-repetido">
        <table>
            <tbody>
                {{-- <td class="logo-acta"><img src="{{public_path('/imagenes/log_sts.png')}}"></td> --}}
                <td class="titulo-acta">
                    TITULO
                    
                </td>
                {{-- <td class="logo-acta"><img src="{{public_path('/imagenes/tigo-logo-header.jpg')}}"></td> --}}
            </tbody>
        </table>
    </header>
    <footer>
        <div class="firma">
            <span>
                FIRMA: TELECEL S.A. <br>
                <br><br>
            </span>
            <span>
                FIRMA: STS BOLIVIA LTDA. <br>
                {{-- {{mb_strtoupper($jefeGrupo->persona_nombres, "UTF-8")}} {{mb_strtoupper($jefeGrupo->persona_primer_apellido, "UTF-8")}} {{mb_strtoupper($jefeGrupo->persona_segundo_apellido, "UTF-8")}} <br> --}}
                {{-- RESP. {{$grupo}} --}}
            </span>
        </div>
    </footer>
    <main>
        {!! $datos->test_texto !!}
        {{-- {{$datos->test_texto}} --}}
    </main>
</body>
</html>