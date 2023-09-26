<?php

if (!function_exists('get_text_color')) {
    function get_text_color($hexColor) {
        // Convertimos el color hexadecimal a RGB
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

        // Calculamos la luminosidad
        $luminosity = ($r * 0.299 + $g * 0.587 + $b * 0.114) / 255;

        // Dependiendo de la luminosidad, retornamos blanco o negro
        return $luminosity > 0.5 ? '#363638' : '#faf8f9';
    }
}

?>