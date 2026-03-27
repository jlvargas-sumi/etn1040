<footer>
    <div>
        @php
            setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain');
            $date = new DateTime('now', new DateTimeZone('America/La_Paz'));
            $fechaHora = strftime("%A, %d de %B de %Y  (%H:%M:%S)", $date->getTimestamp());
            $fechaHora = iconv('ISO-8859-1', 'UTF-8', $fechaHora);
        @endphp
        <span><strong>Fecha de emisión:</strong></span>
        <span>{{ $fechaHora }}</span>
    </div>
</footer>