<?php

namespace App\Http\Requests\Public;

use App\Support\OpcionesConvenio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarSolicitudConvenioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'institucion' => ['required', 'string', 'max:160'],
            'tipo_institucion' => ['required', Rule::in(array_keys(OpcionesConvenio::TIPOS_INSTITUCION))],
            'pais' => ['required', 'string', 'max:80'],
            'sitio_web' => ['nullable', 'string', 'max:255'],
            'representante' => ['required', 'string', 'max:120'],
            'cargo' => ['required', 'string', 'max:120'],
            'correo' => ['required', 'email', 'max:160'],
            'telefono' => ['required', 'string', 'max:40'],
            'interes' => ['required', Rule::in(array_keys(OpcionesConvenio::INTERESES))],
            'docentes' => ['required', 'integer', 'min:1', 'max:1000000'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
            'acepta' => ['accepted'],
            // Trampa para bots: los humanos no ven este campo
            'empresa_web' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'institucion' => 'nombre de la institución',
            'tipo_institucion' => 'tipo de institución',
            'pais' => 'país',
            'sitio_web' => 'sitio web',
            'representante' => 'nombre del representante',
            'correo' => 'correo institucional',
            'telefono' => 'teléfono',
            'interes' => 'interés principal',
            'docentes' => 'número de docentes',
            'acepta' => 'declaración',
        ];
    }
}
