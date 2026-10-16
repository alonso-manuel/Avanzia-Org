<?php

namespace App\Http\Requests\Public;

use App\Support\OpcionesOpinion;
use App\Support\Paises;
use App\Support\TextoPlano;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Testimonio público: cualquiera puede enviarlo, así que todo campo de texto se trata como hostil.
 * Se limpia (TextoPlano) y luego se valida con listas cerradas, patrones estrictos y límites de longitud.
 */
class GuardarOpinionRequest extends FormRequest
{
    // Letras (con tildes y ñ), marcas, espacios y . ' ’ - ; debe empezar con letra
    private const PATRON_NOMBRE = "/^[\p{L}\p{M}][\p{L}\p{M} .'’-]*$/u";

    // Lo anterior más dígitos y algunos signos habituales en nombres de colegios: , & ( ) / °
    private const PATRON_INSTITUCION = "/^[\p{L}\p{M}\p{N}][\p{L}\p{M}\p{N} .,'’&()\/°\"-]*$/u";

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => TextoPlano::linea($this->input('nombre')),
            'ciudad' => TextoPlano::linea($this->input('ciudad')),
            'institucion' => TextoPlano::linea($this->input('institucion')) ?: null,
            'comentario' => TextoPlano::parrafos($this->input('comentario')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:80', 'regex:'.self::PATRON_NOMBRE],
            'pais' => ['required', 'string', Rule::in(array_keys(Paises::OPINION))],
            'ciudad' => ['required', 'string', 'min:2', 'max:60', 'regex:'.self::PATRON_NOMBRE],
            'institucion' => ['nullable', 'string', 'max:100', 'regex:'.self::PATRON_INSTITUCION],
            'curso' => ['required', 'string', Rule::in(OpcionesOpinion::cursos())],
            'estrellas' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['required', 'string', 'min:15', 'max:600', $this->comentarioValido(...)],
            'acepta_publicacion' => ['accepted'],
            // Trampa para bots: los humanos no ven este campo
            'sitio_web' => ['nullable', 'string'],
        ];
    }

    /** Reglas propias del comentario libre (el único campo realmente abierto). */
    private function comentarioValido(string $atributo, mixed $valor, Closure $fallo): void
    {
        if (! is_string($valor)) {
            return;
        }

        if (TextoPlano::tieneHtml($valor)) {
            $fallo('El comentario no puede contener código ni etiquetas HTML.');
        } elseif (TextoPlano::tieneEnlaces($valor)) {
            $fallo('El comentario no puede incluir enlaces ni correos.');
        } elseif (preg_match('/(.)\1{7,}/u', $valor)) {
            $fallo('El comentario tiene demasiados caracteres repetidos.');
        } elseif (count(preg_split('/\s+/u', $valor) ?: []) < 3) {
            $fallo('Cuéntanos un poco más sobre tu experiencia (al menos 3 palabras).');
        }
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'tu nombre',
            'pais' => 'el país',
            'ciudad' => 'la ciudad',
            'institucion' => 'la institución',
            'curso' => 'el curso',
            'estrellas' => 'la calificación',
            'comentario' => 'el comentario',
            'acepta_publicacion' => 'la autorización de publicación',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.regex' => 'Tu nombre solo puede tener letras, espacios, puntos, apóstrofos y guiones.',
            'ciudad.regex' => 'La ciudad solo puede tener letras, espacios, puntos, apóstrofos y guiones.',
            'institucion.regex' => 'El nombre de la institución contiene caracteres no permitidos.',
        ];
    }
}
