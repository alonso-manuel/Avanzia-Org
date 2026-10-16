<?php

namespace App\Support;

/**
 * Limpieza de texto libre enviado por visitantes (testimonios, solicitudes).
 *
 * El texto se guarda y se muestra como texto plano: Vue escapa todo lo que imprime con {{ }}
 * y nunca se usa v-html, así que no puede ejecutarse HTML ni JavaScript. Además, aquí se quita
 * lo que no tiene sentido en texto plano y se usa para engañar o romper la presentación, y se
 * ofrecen comprobaciones (HTML, enlaces) para rechazar el envío con un mensaje claro.
 */
class TextoPlano
{
    /**
     * Caracteres invisibles o de control de dirección (U+200B–U+200F, U+202A–U+202E, U+2060–U+2064,
     * U+2066–U+2069, U+FEFF): permiten ocultar texto, falsear nombres o invertir su lectura ("Trojan Source").
     */
    private const INVISIBLES = '/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{2060}-\x{2064}\x{2066}-\x{2069}\x{FEFF}]/u';

    /** Caracteres de control (excepto salto de línea y tabulación), incluido el byte nulo. */
    private const CONTROL = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u';

    /** Texto de una línea (nombres, ciudades): todo espacio en blanco se reduce a un espacio. */
    public static function linea(mixed $valor): mixed
    {
        if (! is_string($valor)) {
            return $valor;
        }

        $texto = self::base($valor);

        return trim((string) preg_replace('/\s+/u', ' ', $texto));
    }

    /** Texto de varias líneas (comentarios): conserva saltos de línea, como máximo uno en blanco seguido. */
    public static function parrafos(mixed $valor): mixed
    {
        if (! is_string($valor)) {
            return $valor;
        }

        $texto = str_replace(["\r\n", "\r"], "\n", self::base($valor));
        $texto = (string) preg_replace('/[ \t]+/u', ' ', $texto);
        $texto = (string) preg_replace('/ *\n */u', "\n", $texto);
        $texto = (string) preg_replace('/\n{3,}/u', "\n\n", $texto);

        return trim($texto);
    }

    /**
     * ¿Parece HTML? Se rechaza en vez de borrarse: strip_tags() destruiría texto legítimo como "<3" o "a < b".
     * Solo cuenta como etiqueta lo que un navegador interpretaría así: "<" pegado a una letra, "/", "?"
     * o "!" (p. ej. <script>, </b>, <?php, <!--). "<3" o "a < b" no son etiquetas.
     */
    public static function tieneHtml(string $texto): bool
    {
        return (bool) preg_match('~<(?:[/?]?[a-z]|!)~iu', $texto);
    }

    /** ¿Contiene enlaces o correos? (spam típico en formularios públicos) */
    public static function tieneEnlaces(string $texto): bool
    {
        return (bool) preg_match(
            '~(https?:|ftp:|www\.|[\w.+-]+@[\w-]+\.\w|\b[\w-]+\.(com|net|org|info|biz|xyz|top|ru|cn|io|co|pe|ly|me|link|click|site|online|shop)\b)~iu',
            $texto,
        );
    }

    private static function base(string $valor): string
    {
        // Texto no válido en UTF-8 se descarta en vez de guardarse corrupto
        if (! mb_check_encoding($valor, 'UTF-8')) {
            return '';
        }

        return (string) preg_replace([self::CONTROL, self::INVISIBLES], '', $valor);
    }
}
