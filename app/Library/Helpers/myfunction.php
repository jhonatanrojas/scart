<?php
//Your functions
 
// function demoFunction() {
//     echo "Hello world!";
// } 
use SCart\Core\Front\Models\ShopCustomer;
use SCart\Core\Front\Models\ShopCustomField;
use SCart\Core\Front\Models\ShopCountry;
Use App\Models\Estado;
Use App\Models\Municipio;
Use App\Models\Parroquia;

if (!function_exists('sc_customer_data_insert_mapping')) {
    function sc_customer_data_insert_mapping(array $dataRaw)
    {
        $dataInsert = [
            'first_name' => $dataRaw['first_name'] ?? '',
            'email' => $dataRaw['email'],
            'cedula' => $dataRaw['cedula'],
            'cod_estado' => $dataRaw['cod_estado'],
            'cod_municipio' => $dataRaw['cod_municipio'],
            'cod_parroquia' => $dataRaw['cod_parroquia'],
            'password' => bcrypt($dataRaw['password']),
        ];

        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'cedula' => config('validation.customer.cedula', 'required|string|max:100'),
            'email' => config('validation.customer.email', 'required|string|email|max:255').'|unique:"'.ShopCustomer::class.'",email',
            'password' => config('validation.customer.password_confirm', 'required|confirmed|string|min:6'),
        ];

        if (isset($dataRaw['status'])) {
            $dataInsert['status']  = $dataRaw['status'];
        }

        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'customer');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $validate['fields.'.$field->code] = 'required';
                }
            }
        }

        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            } else {
                $validate['last_name'] = config('validation.customer.last_name_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['last_name'])) {
                $dataInsert['last_name'] = $dataRaw['last_name'];
            }
        }

        if (sc_config('customer_estado')) {
            $validate['cod_estado'] = config('validation.customer.estado_required', 'required|min:1');
            $dataInsert['cod_estado'] = $dataRaw['cod_estado']??'';
        }
        if (sc_config('customer_municipio')) {
            $validate['cod_municipio'] = config('validation.customer.municipio_required', 'required|min:1');
            $dataInsert['cod_municipio'] = $dataRaw['cod_municipio']??'';
        }
        if (sc_config('customer_parroquias')) {
            $validate['cod_parroquia'] = config('validation.customer.parroquia_required', 'required|min:1');
            $dataInsert['cod_parroquia'] = $dataRaw['cod_municipio']??'';
        }
        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = config('validation.customer.address1_required', 'required|string|max:100');
            } else {
                $validate['address1'] = config('validation.customer.address1_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address1'])) {
                $dataInsert['address1'] = $dataRaw['address1'];
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:100');
            } else {
                $validate['address2'] = config('validation.customer.address2_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address2'])) {
                $dataInsert['address2'] = $dataRaw['address2'];
            }
        }

        if (sc_config('customer_address3')) {
            if (sc_config('customer_address3_required')) {
                $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:100');
            } else {
                $validate['address3'] = config('validation.customer.address3_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address3'])) {
                $dataInsert['address3'] = $dataRaw['address3'];
            }
        }


        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            if (!empty($dataRaw['phone'])) {
                $dataInsert['phone'] = $dataRaw['phone'];
            }
        }

        if (sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config('customer_country_required')) {
                $validate['country'] = config('validation.customer.country_required', 'required|string|min:2').'|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = config('validation.customer.country_null', 'nullable|string|min:2').'|in:'. implode(',', $arraycountry);
            }
            if (!empty($dataRaw['country'])) {
                $dataInsert['country'] = $dataRaw['country'];
            }
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = config('validation.customer.postcode_required', 'required|min:5');
            } else {
                $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:5');
            }
            if (!empty($dataRaw['postcode'])) {
                $dataInsert['postcode'] = $dataRaw['postcode'];
            }
        }

        if (sc_config('customer_company')) {
            if (sc_config('customer_company_required')) {
                $validate['company'] = config('validation.customer.company_required', 'required|string|max:100');
            } else {
                $validate['company'] = config('validation.customer.company_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['company'])) {
                $dataInsert['company'] = $dataRaw['company'];
            }
        }

        if (sc_config('customer_sex')) {
            if (sc_config('customer_sex_required')) {
                $validate['sex'] = config('validation.customer.sex_required', 'required|integer|max:10');
            } else {
                $validate['sex'] = config('validation.customer.sex_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['sex'])) {
                $dataInsert['sex'] = $dataRaw['sex'];
            }
        }

        if (sc_config('customer_birthday')) {
            if (sc_config('customer_birthday_required')) {
                $validate['birthday'] = config('validation.customer.birthday_required', 'required|date|date_format:Y-m-d');
            } else {
                $validate['birthday'] = config('validation.customer.birthday_null', 'nullable|date|date_format:Y-m-d');
            }
            if (!empty($dataRaw['birthday'])) {
                $dataInsert['birthday'] = $dataRaw['birthday'];
            }
        }

        if (sc_config('customer_group')) {
            if (sc_config('customer_group_required')) {
                $validate['group'] = config('validation.customer.group_required', 'required|integer|max:10');
            } else {
                $validate['group'] = config('validation.customer.group_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['group'])) {
                $dataInsert['group'] = $dataRaw['group'];
            }
        }

        if (sc_config('customer_name_kana')) {
            if (sc_config('customer_name_kana_required')) {
                $validate['first_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
            } else {
                $validate['first_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['first_name_kana'])) {
                $dataInsert['first_name_kana'] = $dataRaw['first_name_kana'];
            }
            if (!empty($dataRaw['last_name_kana'])) {
                $dataInsert['last_name_kana'] = $dataRaw['last_name_kana'];
            }
        }


        if (sc_config('customer_cedula')) {
            if (sc_config('customer_cedula_required')) {
                $validate['cedula'] = config('validation.customer.cedula_required', 'required|string|min:3');
            } else {
                $validate['cedula'] = config('validation.customer.cedula_required', 'required|string|min:3');
            }
            if (!empty($dataRaw['cedula'])) {
                if($dataRaw['nacionalidad'] == "V"){
                    $dataInsert['cedula'] = 'V:'.$dataInsert['cedula'];
                }
            }else{
                $dataInsert['cedula'] = 'E:'.$dataInsert['cedula'];

            }
        }

if (sc_config('customer_estado')) {
    $arraycountry = (new Estado)->pluck('codigoestado')->toArray();
    if (sc_config('customer_estado_required')) {
        $validate['cod_estado'] = config('cod_estado', 'required|string|min:1').'|in:'. implode(',', $arraycountry);
    } else {
        $validate['cod_estado'] = config('cod_estado', 'nullable|string|min:1').'|in:'. implode(',', $arraycountry);
    }
    if (!empty($dataRaw['cod_estado'])) {
        $dataInsert['cod_estado'] = $dataRaw['cod_estado'];
    }
}
if (sc_config('customer_municipio')) {
    $arraycountry = (new Municipio)->pluck('codigomunicipio')->toArray();
    if (sc_config('customer_municipio_required')) {
        $validate['cod_municipio'] = config('cod_municipio', 'required|string|min:1').'|in:'. implode(',', $arraycountry);
    } else {
        $validate['cod_municipio'] = config('cod_municipio', 'nullable|string|min:1').'|in:'. implode(',', $arraycountry);
    }
    if (!empty($dataRaw['cod_municipio'])) {
        $dataInsert['cod_municipio'] = $dataRaw['cod_municipio'];
    }
}

if (sc_config('customer_parroquias')) {
    if (sc_config('customer_phone_required')) {
        $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
    } else {
        $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_null', 'nullable|regex:/^0[^0][0-9\-]{1,12}$/');
    }
    if (!empty($dataRaw['cod_parroquia'])) {
        $dataInsert['cod_parroquia'] = $dataRaw['cod_parroquia'];
    }
}
        if (!empty($dataRaw['fields'])) {
            $dataInsert['fields'] = $dataRaw['fields'];
        }

        $messages = [
            'last_name.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.email')]),
            'password.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.password')]),
            'address1.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'company.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.company')]),
            'sex.required'         => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.sex')]),
            'birthday.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.birthday')]),
            'email.email'          => sc_language_render('validation.email', ['attribute'=> sc_language_render('customer.email')]),
            'phone.regex'          => sc_language_render('customer.phone_regex'),
            'password.confirmed'   => sc_language_render('validation.confirmed', ['attribute'=> sc_language_render('customer.password')]),
            'postcode.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'password.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.password')]),
            'country.min'          => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.max'            => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.email')]),
            'address1.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
            'birthday.date'        => sc_language_render('validation.date', ['attribute'=> sc_language_render('customer.birthday')]),
            'birthday.date_format' => sc_language_render('validation.date_format', ['attribute'=> sc_language_render('customer.birthday')]),
        
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataInsert' => $dataInsert
        ];
        return $dataMap;
    }

}




