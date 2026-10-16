<?php

/*
 * Mensajes de validación en español para los formularios públicos (opiniones, convenios, interacciones).
 * Solo están las reglas que usa el sitio; si se usa una nueva, agregar aquí su mensaje.
 */
return [
    'accepted' => 'Debes aceptar :attribute.',
    'between' => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'string' => ':attribute debe tener entre :min y :max caracteres.',
    ],
    'email' => ':attribute debe ser un correo electrónico válido.',
    'enum' => 'El valor elegido en :attribute no es válido.',
    'in' => 'El valor elegido en :attribute no es válido.',
    'integer' => ':attribute debe ser un número entero.',
    'max' => [
        'numeric' => ':attribute no puede ser mayor que :max.',
        'string' => ':attribute no puede tener más de :max caracteres.',
    ],
    'min' => [
        'numeric' => ':attribute debe ser al menos :min.',
        'string' => ':attribute debe tener al menos :min caracteres.',
    ],
    'regex' => ':attribute contiene caracteres no permitidos.',
    'required' => 'Completa :attribute.',
    'string' => ':attribute debe ser un texto.',

    'attributes' => [],
];
