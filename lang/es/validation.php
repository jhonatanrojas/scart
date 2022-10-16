<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => '
    El :attribute debe ser aceptado.',
    'active_url' => '
    El :attribute no es una URL válida.',
    'after' => '
    El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => '
    El :attribute debe ser una fecha posterior o igual a :fecha.',
    'alpha' => '
    El campo :solo puede contener letras.',
    'alpha_dash' => '
    El campo :solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => '
    El campo :solo puede contener letras y números.',
    'array' => '
    El :attribute debe ser una matriz.',
    'before' => '
    El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => '
    El :attribute debe ser una fecha anterior o igual a :fecha.',
    'between' => [
        'numeric' => '
        El :attribute debe estar entre :min y :max.',
        'file' => '
        El :attribute debe estar entre :min y :max kilobytes.',
        'string' => '
        El :attribute debe tener entre :min y :max caracteres.',
        'array' => '
        El :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => '
    El campo :attribute debe ser verdadero o falso.',
    'confirmed' => '
    La confirmación de :attribute no coincide.',
    'date' => '
    El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :fecha.',
    'date_format' => '
    El :attribute no coincide con el formato :formato.',
    'different' => '
    El :attribute y :otro deben ser diferentes.',
    'digits' => '
    El :attribute debe ser :dígitos dígitos.',
    'digits_between' => '
    El :attribute debe estar entre :min y :max dígitos.',
    'dimensions' => '
    El :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => '
    El campo :attribute tiene un valor duplicado.',
    'email' => '
    El :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with' => '
    El :attribute debe terminar con uno de los siguientes: :valores.',
    'exists' => '
    El :attribute seleccionado no es válido.',
    'file' => '
    El :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor.
    ',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :valor.',
        'file' => '
        El :attribute debe ser mayor que :valor kilobytes.',
        'string' => '
        El :attribute debe ser mayor que los :valores.',
        'array' => '
        El :attribute debe tener más de :elementos de valor.',
    ],
    'gte' => [
        'numeric' => '
        El :attribute debe ser mayor o igual que :valor.',
        'file' => '
        El :attribute debe ser mayor o igual al :valor en kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual que :valor caracteres.
        ',
        'array' => '
        El :attribute debe tener :elementos de valor o más.',
    ],
    'image' => '
    El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.
    ',
    'in_array' => '
    El campo :attribute no existe en :otro.',
    'integer' => '
    El :attribute debe ser un número entero.',
    'ip' => '
    El :attribute debe ser una dirección IP válida.',
    'ipv4' => '
    El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => '
    El :attribute debe ser una dirección IPv6 válida.',
    'json' => '
    El :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => '
        El :attribute debe ser menor que :valor.',
        'file' => '
        El :attribute debe ser menor que :value kilobytes.',
        'string' => '
        Español
        The :attribute must be less than :value characters.
        El :attribute debe tener menos de :valor de caracteres.',
        'array' => '
        El :attribute debe tener menos de :elementos de valor.',
    ],
    'lte' => [
        'numeric' => '
        El :attribute debe ser menor o igual que el :valor.',
        'file' => 'El :attribute debe ser menor o igual al :valor en kilobytes.',
        'string' => '
        El :attribute debe ser menor o igual que :valor caracteres.',
        'array' => 'El :attribute no debe tener más de :elementos de valor.
        ',
    ],
    'max' => [
        'numeric' => 'El :attribute no puede ser mayor que :max.
        ',
        'file' => '
        El :attribute no puede ser mayor que :max kilobytes.',
        'string' => '
        El :attribute no puede ser mayor que :max caracteres.',
        'array' => '
        El :attribute no puede tener más de :máx elementos.',
    ],
    'mimes' => '
    El :attribute debe ser un archivo de tipo: :valores.',
    'mimetypes' => '
    El :attribute debe ser un archivo de tipo: :valores.',
    'min' => [
        'numeric' => '
        El :attribute debe ser al menos :min.',
        'file' => '
        El :attribute debe tener al menos :min kilobytes.',
        'string' => '
        El :attribute debe tener al menos :min caracteres.',
        'array' => '
        El :attribute debe tener al menos :min elementos.',
    ],
    'not_in' => '
    El :attribute seleccionado no es válido.',
    'not_regex' => 'El formato de :attribute no es válido.
    ',
    'numeric' => '
    El :attribute debe ser un número.',
    'password' => '
    La contraseña es incorrecta.',
    'present' => 'El campo :attribute debe estar presente.
    ',
    'regex' => '
    El formato de :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => '
    El campo :attribute es obligatorio cuando :otro es :valor.',
    'required_unless' => '
    El campo :attribute es obligatorio a menos que :otro esté en :valores.',
    'required_with' => '
    El campo :attribute es obligatorio cuando :valores está presente.',
    'required_with_all' => '
    El campo :attribute es obligatorio cuando los :valores están presentes.',
    'required_without' => '
    El campo :attribute es obligatorio cuando :valores no está presente.',
    'required_without_all' => '
    El campo :attribute es obligatorio cuando ninguno de los :valores está presente.',
    'same' => 'El :attribute y :otro deben coincidir.',
    'size' => [
        'numeric' => '
        El :attribute debe ser :tamaño.',
        'file' => '
        El :attribute debe ser :size kilobytes.',
        'string' => '
        El :attribute debe tener :tamaño de caracteres.',
        'array' => '
        El :attribute debe contener :elementos de tamaño.',
    ],
    'starts_with' => '
    El :attribute debe comenzar con uno de los siguientes: :valores.',
    'string' => 'El :attribute debe ser una cadena.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => '
    El :attribute ya ha sido tomado.',
    'uploaded' => 'El :attribute no se pudo cargar.',
    'url' => 'El formato de :attribute no es válido.
    ',
    'uuid' => '
    El :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '
            mensaje personalizado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];