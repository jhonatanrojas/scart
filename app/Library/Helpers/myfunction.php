<?php
//Your functions
 
// function demoFunction() {
//     echo "Hello world!";
// } 
use App\Events\OrderSuccess;
use App\Events\OrderCreated;
use SCart\Core\Front\Models\ShopCustomer;
use SCart\Core\Front\Models\ShopCustomField;
use SCart\Core\Front\Models\ShopCountry;
Use App\Models\Estado;
Use App\Models\Municipio;
Use App\Models\Parroquia;
Use App\Models\ShopOrder;


function sc_event_order_created(ShopOrder $order)
{
    OrderCreated::dispatch($order);
}

function sc_event_order_success(ShopOrder $order)
    {
        OrderSuccess::dispatch($order);
    }


    function sc_customer_data_insert_mapping(array $dataRaw)
    {
    

        $dataInsert = [
            'first_name' => $dataRaw['first_name'] ?? '',
            'email' => $dataRaw['email'],
            'cedula' => $dataRaw['cedula'],
            'natural_jurídica' => $dataRaw['natural_jurídica'],
            'nos_conocio' => $dataRaw['nos_conocio'] ,
            'cod_estado' => $dataRaw['cod_estado'],
            'cod_municipio' => $dataRaw['cod_municipio'],
            'cod_parroquia' => $dataRaw['cod_parroquia'],
            'password' => bcrypt($dataRaw['password']),
         
        ];

       

       

        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'email' => config('validation.customer.email', 'required|string|email|max:255').'|unique:"'.ShopCustomer::class.'",email',
            'password' => config('validation.customer.password_confirm', 'required|confirmed|string|min:6'),
        ];

        if (isset($dataRaw['status'])) {
            $dataInsert['status']  = $dataRaw['status'];
        }

        if (isset($dataRaw['rif'])) {
            $dataInsert['rif']  = $dataRaw['rif'];
        }

        if (isset($dataRaw['razon_social'])) {
            $dataInsert['razon_social']  = $dataRaw['razon_social'];
        }

        if (isset($dataRaw['estado_civil'])) {
            $dataInsert['estado_civil']  = $dataRaw['estado_civil'];
        }
        if (empty($dataRaw['nos_conocio'])) {
            $dataInsert['nos_conocio'] = $dataRaw['nos_conocio'];
        }

        if (empty($dataRaw['phone2'])) {
            $dataInsert['phone2'] = $dataRaw['phone2'];
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

     
        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = config('validation.customer.address1_required', 'required|string|max:00');
            } else {
                $validate['address1'] = config('validation.customer.address1_null', 'nullable|string|max:200');
            }
            if (!empty($dataRaw['address1'])) {
                $dataInsert['address1'] = $dataRaw['address1'];
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:240');
            } else {
                $validate['address2'] = config('validation.customer.address2_null', 'nullable|string|max:240');
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
                $validate['postcode'] = config('validation.customer.postcode_required', 'required|min:4');
            } else {
                $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:4');
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
                    $dataInsert['cedula'] = 'V '.$dataInsert['cedula'];
                }else if($dataRaw['nacionalidad'] == "E"){
                    $dataInsert['cedula'] = 'E '.$dataInsert['cedula'];
                }

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
    // if (sc_config('customer_parroquias_required')) {
    //     $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
    // } else {
    //     $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_null', 'nullable|regex:/^0[^0][0-9\-]{1,12}$/');
    // }

    // $arraycountry = (new Parroquia())->pluck('codigomunicipio')->toArray();
    // if (sc_config('customer_parroquias_required')) {
    //     $validate['cod_municipio'] = config('cod_municipio', 'required|string|min:1').'|in:'. implode(',', $arraycountry);
    // } else {
    //     $validate['cod_municipio'] = config('cod_municipio', 'nullable|string|min:1').'|in:'. implode(',', $arraycountry);
    // }
  
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



if (!function_exists('sc_customer_sendmail_reset_notification') && !in_array('sc_customer_sendmail_reset_notification', config('helper_except', []))) {
    function sc_customer_sendmail_reset_notification(string $token, string $emailReset)
    {
        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'forgot_password')->where('status', 1)->first();
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$reason_sendmail\}\}/',
                '/\{\{\$note_sendmail\}\}/',
                '/\{\{\$note_access_link\}\}/',
                '/\{\{\$reset_link\}\}/',
                '/\{\{\$reset_button\}\}/',
            ];
            $url = sc_route('password.reset', ['token' => $token]);
            $dataReplace = [
                sc_language_render('email.forgot_password.title'),
                sc_language_render('email.forgot_password.reason_sendmail'),
                sc_language_render('email.forgot_password.note_sendmail', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]),
                sc_language_render('email.forgot_password.note_access_link', ['reset_button' => sc_language_render('email.forgot_password.reset_button'), 'url' => $url]),
                $url,
                sc_language_render('email.forgot_password.reset_button'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $emailReset,
                'subject' => sc_language_render('email.forgot_password.reset_button'),
            ];

            sc_send_mail('templates.' . sc_store('template') . '.mail.forgot_password', $dataView, $config, $dataAtt = []);
        }
    }
}


/**
 * Send email verify
 */
if (!function_exists('sc_customer_sendmail_verify') && !in_array('sc_customer_sendmail_verify', config('helper_except', []))) {
    function sc_customer_sendmail_verify(string $emailVerify, string $userId)
    {
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'customer.verify_process',
            \Carbon\Carbon::now()->addMinutes(config('auth.verification', 60)),
            [
                'id' => $userId,
                'token' => sha1($emailVerify),
            ]
        );

        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'customer_verify')->where('status', 1)->first();
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$reason_sendmail\}\}/',
                '/\{\{\$note_sendmail\}\}/',
                '/\{\{\$note_access_link\}\}/',
                '/\{\{\$url_verify\}\}/',
                '/\{\{\$button\}\}/',
            ];
            $dataReplace = [
                sc_language_render('email.verification_content.title'),
                sc_language_render('email.verification_content.reason_sendmail'),
                sc_language_render('email.verification_content.note_sendmail', ['count' => config('auth.verification')]),
                sc_language_render('email.verification_content.note_access_link', ['reset_button' => sc_language_render('customer.verify_email.button_verify'), 'url' => $url]),
                $url,
                sc_language_render('customer.verify_email.button_verify'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $emailVerify,
                'subject' => sc_language_render('customer.verify_email.button_verify'),
            ];

            sc_send_mail('templates.' . sc_store('template') . '.mail.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }
}

/**
 * Send email welcome
 */
if (!function_exists('sc_customer_sendmail_welcome') && !in_array('sc_customer_sendmail_welcome', config('helper_except', []))) {
    function sc_customer_sendmail_welcome(array $data)
    {
        if (sc_config('welcome_customer')) {
            $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'welcome_customer')->where('status', 1)->first();
            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$first_name\}\}/',
                    '/\{\{\$last_name\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$password\}\}/',
                    '/\{\{\$address1\}\}/',
                    '/\{\{\$address2\}\}/',
                    '/\{\{\$address3\}\}/',
                    '/\{\{\$country\}\}/',
                    '/\{\{\$cedula\}\}/',
                ];
                $dataReplace = [
                    sc_language_render('email.welcome_customer.title'),
                    $data['first_name'] ?? '',
                    $data['last_name'] ?? '',
                    $data['email'] ?? '',
                    $data['phone'] ?? '',
                    $data['password'] ?? '',
                    $data['address1'] ?? '',
                    $data['address2'] ?? '',
                    $data['address3'] ?? '',
                    $data['country'] ?? '',
                    $data['cod_estado'] ?? '',
                    $data['cod_municipio'] ?? '',
                    $data['cod_parroquia'] ?? '',
                    $data['cedula'] ?? '',
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];

                $config = [
                    'to' => $data['email'],
                    'subject' => sc_language_render('email.welcome_customer.title'),
                ];

                sc_send_mail('templates.' . sc_store('template') . '.mail.welcome_customer', $dataView, $config, []);
            }
        }
    }
}
if (!function_exists('sc_customer_sendmail_welcome') && !in_array('sc_customer_sendmail_welcome', config('helper_except', []))) {
    function sc_customer_sendmail_welcome(array $data)
    {
        if (sc_config('welcome_customer')) {
            $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'welcome_customer')->where('status', 1)->first();
            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$first_name\}\}/',
                    '/\{\{\$last_name\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$password\}\}/',
                    '/\{\{\$address1\}\}/',
                    '/\{\{\$address2\}\}/',
                    '/\{\{\$address3\}\}/',
                    '/\{\{\$country\}\}/',
                    '/\{\{\$cedula\}\}/',
                ];
                $dataReplace = [
                    sc_language_render('email.welcome_customer.title'),
                    $data['first_name'] ?? '',
                    $data['last_name'] ?? '',
                    $data['email'] ?? '',
                    $data['phone'] ?? '',
                    $data['password'] ?? '',
                    $data['address1'] ?? '',
                    $data['address2'] ?? '',
                    $data['address3'] ?? '',
                    $data['country'] ?? '',
                    $data['cod_estado'] ?? '',
                    $data['cod_municipio'] ?? '',
                    $data['cod_parroquia'] ?? '',
                    $data['cedula'] ?? '',
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];

                $config = [
                    'to' => $data['email'],
                    'subject' => sc_language_render('email.welcome_customer.title'),
                ];

                sc_send_mail('templates.' . sc_store('template') . '.mail.welcome_customer', $dataView, $config, []);
            }
        }
    }
}
/**
 * Mapping data address of customer
 *
 * @param   [type]  $dataRaw  [$dataRaw description]
 *
 * @return  [array]              [return description]
 */
if (!function_exists('sc_customer_address_mapping') && !in_array('sc_customer_address_mapping', config('helper_except', []))) {
    function sc_customer_address_mapping(array $dataRaw)
    {


       
        $dataAddress = [
            'first_name' => $dataRaw['first_name'] ?? '',
            'address1' => $dataRaw['address1'] ?? '',
            'cedula' => $dataRaw['cedula'] ?? '',
            'cod_estado' => $dataRaw['cod_estado'] ?? '',
            'cod_municipio' => $dataRaw['cod_municipio'] ?? '',
            'cod_parroquia' => $dataRaw['cod_parroquia'] ?? '',
            'rif' => $dataRaw['rif'] ?? '',
            'razon_social' => $dataRaw['razon_social'] ?? "no aplica",
            
            
        ];
        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'address1' => config('validation.customer.address1_required', 'required|string|max:100'),
            'cedula' => config('validation.customer_cedula_required', 'required|string|min:5'),
          
        ];
        if (sc_config('customer_lastname')) {
            $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            $dataAddress['last_name'] = $dataRaw['last_name']??'';
        }
        if (sc_config('customer_address2')) {
            $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:100');
            $dataAddress['address2'] = $dataRaw['address2']??'';
        }
        if (sc_config('customer_address3')) {
            $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:100');
            $dataAddress['address3'] = $dataRaw['address3']??'';
        }
        if (sc_config('customer_phone')) {
            $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
            $dataAddress['phone'] = $dataRaw['phone']??'';
        }

        if (sc_config('customer_phone2')) {
            $validate['phone2'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,14}$/');
            $dataAddress['phone2'] = $dataRaw['phone2']??'';
        }
        // if (sc_config('customer_cedula')) {
        //     $validate['cedula'] = config('validation.customer_cedula_required', 'required|string|max:13');
        //     $dataAddress['cedula'] = $dataRaw['cedula']??'';
        // }
  
     
        if (sc_config('customer_country')) {
            $validate['country'] = config('validation.customer.country_required', 'required|string|min:2');
            $dataAddress['country'] = $dataRaw['country']??'';
        }
        if (sc_config('customer_postcode')) {
            $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:4');
            $dataAddress['postcode'] = $dataRaw['postcode']??'';
        }

        $messages = [
            'last_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required' => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'cedula.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.cedula')]),
            'cod_estado.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.estado')]),
            'country.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'cedula.regex'         => sc_language_render('customer.cedula_regex'),
            'postcode.min'        => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'country.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'      => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
        ];

        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataAddress' => $dataAddress
        ];
        return $dataMap;
    }

    
}

/**
 * Mapping data customer before edit
 *
 * @param   [array]  $dataRaw  [$dataRaw description]
 *
 * @return  [array]              [return description]
 */

    function sc_customer_data_edit_mapping(array $dataRaw)
    {



      

        $dataUpdate = [
            'first_name' => $dataRaw['first_name'],
            'cedula' => $dataRaw['cedula'],
            'estado_civil' => $dataRaw['estado_civil'],
            'natural_jurídica' => $dataRaw['natural_jurídica'],
            'rif' => $dataRaw['rif'] ?? '',
            'razon_social' => $dataRaw['razon_social'] ?? "no aplica",
            
        ];
     
        if (isset($dataRaw['status'])) {
            $dataUpdate['status']  = $dataRaw['status'];
        }

        if (isset($dataRaw['nos_conocio'])) {
            $dataUpdate['nos_conocio'] = $dataRaw['nos_conocio'];
        }


        if (isset($dataRaw['phone2'])) {

            
            $dataUpdate['phone2'] = $dataRaw['phone2'];


           
        }

        

        if (!empty($dataRaw['estado_civil'])) {
            $dataUpdate['estado_civil'] = $dataRaw['estado_civil'];
        }
        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'password' => config('validation.customer.password_null', 'nullable|string|min:6'),
            
        ];

        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'customer');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $validate['fields.'.$field->code] = 'required';
                }
            }
            $dataUpdate['fields'] = $dataRaw['fields'] ?? [];
        }

        if (!empty($dataRaw['password'])) {
            $dataUpdate['password'] = bcrypt($dataRaw['password']);
        }
        if (!empty($dataRaw['email'])) {
            $dataUpdate['email'] = $dataRaw['email'];
            $validate['email'] = config('validation.customer.email', 'required|string|email|max:255').'|unique:"'.ShopCustomer::class.'",email,'.$dataRaw['id'].',id';
        }
        //Dont update id
        unset($dataRaw['id']);

        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            } else {
                $validate['last_name'] = config('validation.customer.last_name_null', 'nullable|string|max:100');
            }
            if (sc_config('customer_cedula_required')) {
                $validate['cedula'] = config('validation.customer.cedula_required', 'required|string|max:100');
            } else {
                $validate['cedula'] = config('validation.customer.cedula', 'nullable|string|max:100');
            }
            
            if (sc_config('customer_municipio_required')) {
                $validate['cod_municipio'] = config('validation.customer.municipio_required', 'required|string|max:100');
            } else {
                $validate['cod_municipio'] = config('validation.customer.municipio', 'nullable|string|max:100');
            }
            if (sc_config('customer_parroquia_required')) {
                $validate['cod_parroquia'] = config('validation.customer.parroquia_required', 'required|string|max:100');
            } else {
                $validate['cod_parroquia'] = config('validation.customer.cod_parroquia', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['last_name'])) {
                $dataUpdate['last_name'] = $dataRaw['last_name'];
            }
        
            if (!empty($dataRaw['cod_estado'])) {
                $dataUpdate['cod_estado'] = $dataRaw['cod_estado'];
            }
            if (!empty($dataRaw['cod_municipio'])) {
                $dataUpdate['cod_municipio'] = $dataRaw['cod_municipio'];
            }
            if (!empty($dataRaw['cod_parroquia'])) {
                $dataUpdate['cod_parroquia'] = $dataRaw['cod_parroquia'];
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
                    $dataUpdate['cedula'] = 'V '.$dataRaw['cedula'];
                }else{
                    $dataUpdate['cedula'] = 'E '.$dataRaw['cedula'];
    
                }
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
                $dataUpdate['cod_estado'] = $dataRaw['cod_estado'];
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
                $dataUpdate['cod_municipio'] = $dataRaw['cod_municipio'];
            }
        }
        if (sc_config('customer_nacionalidad')) {
            if (sc_config('customer_nacionalidad_required')) {
                $validate['nacionalidad'] = config('validation.customer.nacionalidad_required', 'required|string|min:1');
            } else {
                $validate['nacionalidad'] = config('validation.customer.nacionalidad_required', 'required|string|min:1');
            }
            
        }
    
     
        if (sc_config('customer_parroquias')) {
            if (sc_config('customer_parroquias_required')) {
                // $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                // $validate['cod_parroquia'] = config('validation.customer.cod_parroquia_null', 'nullable|regex:/^0[^0][0-9\-]{1,12}$/');
            }
            if (!empty($dataRaw['cod_parroquia'])) {
                $dataUpdate['cod_parroquia'] = $dataRaw['cod_parroquia'];
            }
        }
        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = config('validation.customer.address1_required', 'required|string|max:200');
            } else {
                $validate['address1'] = config('validation.customer.address1_null', 'nullable|string|max:200');
            }
            if (!empty($dataRaw['address1'])) {
                $dataUpdate['address1'] = $dataRaw['address1'];
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:200');
            } else {
                $validate['address2'] = config('validation.customer.address2_null', 'nullable|string|max:200');
            }
            if (!empty($dataRaw['address2'])) {
                $dataUpdate['address2'] = $dataRaw['address2'];
            }
        }

        if (sc_config('customer_address3')) {
            if (sc_config('customer_address3_required')) {
                $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:200');
            } else {
                $validate['address3'] = config('validation.customer.address3_null', 'nullable|string|max:200');
            }
            if (!empty($dataRaw['address3'])) {
                $dataUpdate['address3'] = $dataRaw['address3'];
            }
        }


        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            if (!empty($dataRaw['phone'])) {
                $dataUpdate['phone'] = $dataRaw['phone'];
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
                $dataUpdate['country'] = $dataRaw['country'];
            }
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = config('validation.customer.postcode_required', 'required|min:4');
            } else {
                $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:4');
            }
            if (!empty($dataRaw['postcode'])) {
                $dataUpdate['postcode'] = $dataRaw['postcode'];
            }
        }

        if (sc_config('customer_company')) {
            if (sc_config('customer_company_required')) {
                $validate['company'] = config('validation.customer.company_required', 'required|string|max:100');
            } else {
                $validate['company'] = config('validation.customer.company_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['company'])) {
                $dataUpdate['company'] = $dataRaw['company'];
            }
        }

        if (sc_config('customer_sex')) {
            if (sc_config('customer_sex_required')) {
                $validate['sex'] = config('validation.customer.sex_required', 'required|integer|max:10');
            } else {
                $validate['sex'] = config('validation.customer.sex_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['sex'])) {
                $dataUpdate['sex'] = $dataRaw['sex'];
            }
        }

        if (sc_config('customer_birthday')) {
            if (sc_config('customer_birthday_required')) {
                $validate['birthday'] = config('validation.customer.birthday_required', 'required|date|date_format:Y-m-d');
            } else {
                $validate['birthday'] = config('validation.customer.birthday_null', 'nullable|date|date_format:Y-m-d');
            }
            if (!empty($dataRaw['birthday'])) {
                $dataUpdate['birthday'] = $dataRaw['birthday'];
            }
        }

        if (sc_config('customer_group')) {
            if (sc_config('customer_group_required')) {
                $validate['group'] = config('validation.customer.group_required', 'required|integer|max:10');
            } else {
                $validate['group'] = config('validation.customer.group_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['group'])) {
                $dataUpdate['group'] = $dataRaw['group'];
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
            $dataUpdate['first_name_kana'] = $dataRaw['first_name_kana']?? '';
            $dataUpdate['last_name_kana'] = $dataRaw['last_name_kana']?? '';
        }

        $messages = [
            'last_name.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'cedula.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.cedula')]),
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
            'cedula.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.cedula')]),
            'birthday.date'        => sc_language_render('validation.date', ['attribute'=> sc_language_render('customer.birthday')]),
            'birthday.date_format' => sc_language_render('validation.date_format', ['attribute'=> sc_language_render('customer.birthday')]),
        ];


        
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataUpdate' => $dataUpdate
        ];
        return $dataMap;
    }


function fecha_to_sql ($fecha_europea, $con_horas=true) {
		
    $fecha_europea = str_replace("/", "-", $fecha_europea);
    
    if ($con_horas) {

        $fecha_sql = date("Y-m-d H:i:s", strtotime($fecha_europea));

    }
    else {

        $fecha_sql = date("Y-m-d", strtotime($fecha_europea));

    }
    
    return $fecha_sql;

}

function fecha_europea ($fecha_sql) {

		// Por defecto
		$fecha_europea = $fecha_sql;
	
		// Obtenemos el valor time de la fecha SQL, para transformar la fecha
		$time_fecha_sql = strtotime($fecha_sql);
	
		// Si es fecha solo
		if (preg_match("/^(\d){4}(\-)(\d){2}(\-)(\d){2}$/", $fecha_sql)) {
	
			// Obtenemos la nueva fecha
			$fecha_europea = date("d/m/Y", $time_fecha_sql);
	
		}
	
		// Si es fecha y hora (con segundos)
		elseif (preg_match("/^(\d){4}(\-)(\d){2}(\-)(\d){2}(\s)(\d){2}(\:)(\d){2}(\:)(\d){2}$/", $fecha_sql)) {
	
			// Obtenemos la nueva fecha 
			$fecha_europea = date("d/m/Y", $time_fecha_sql);
	
		}
	
		// Si es fecha y hora (sin segundos)
		elseif (preg_match("/^(\d){4}(\-)(\d){2}(\-)(\d){2}(\s)(\d){2}(\:)(\d){2}$/", $fecha_sql)) {
	
			// Obtenemos la nueva fecha 
			$fecha_europea = date("d/m/Y H:i", $time_fecha_sql);
	
		}
	
		return $fecha_europea;
	
	}
function sc_order_process_after_success(string $orderID = null):array
{

    $templatePath = 'templates.' . sc_store('template');
    if ((sc_config('order_success_to_admin') || sc_config('order_success_to_customer')) && sc_config('email_action_mode')) {
        $data = \SCart\Core\Front\Models\ShopOrder::with('details')->find($orderID)->toArray();
        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'order_success_to_admin')->where('status', 1)->first();
        $checkContentCustomer = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'order_success_to_customer')->where('status', 1)->first();
        if ($checkContent || $checkContentCustomer) {
            $orderDetail = '';
            $orderDetail .= '<tr>
                                <td>' . sc_language_render('email.order.sort') . '</td>
                                <td>' . sc_language_render('email.order.sku') . '</td>
                                <td>' . sc_language_render('email.order.name') . '</td>
                                <td>' . sc_language_render('email.order.price') . '</td>
                                <td>' . sc_language_render('email.order.qty') . '</td>
                                <td>' . sc_language_render('email.order.total') . '</td>
                            </tr>';
            foreach ($data['details'] as $key => $detail) {
                $product = (new \SCart\Core\Front\Models\ShopProduct)->getDetail($detail['product_id']);
                $pathDownload = $product->downloadPath->path ?? '';
                $nameProduct = $detail['name'];
                if ($product && $pathDownload && $product->property == SC_PROPERTY_DOWNLOAD) {
                    $nameProduct .="<br><a href='".sc_path_download_render($pathDownload)."'>Download</a>";
                }

                $orderDetail .= '<tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $detail['sku'] . '</td>
                                <td>' . $nameProduct . '</td>
                                <td>' . sc_currency_render($detail['price'], '', '', '', false) . '</td>
                                <td>' . number_format($detail['qty']) . '</td>
                                <td align="right">' . sc_currency_render($detail['total_price'], '', '', '', false) . '</td>
                            </tr>';
            }
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$orderID\}\}/',
                '/\{\{\$firstName\}\}/',
                '/\{\{\$lastName\}\}/',
                '/\{\{\$toname\}\}/',
                '/\{\{\$address\}\}/',
                '/\{\{\$address1\}\}/',
                '/\{\{\$address2\}\}/',
                '/\{\{\$address3\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$phone\}\}/',
                '/\{\{\$comment\}\}/',
                '/\{\{\$orderDetail\}\}/',
                '/\{\{\$subtotal\}\}/',
                '/\{\{\$shipping\}\}/',
                '/\{\{\$discount\}\}/',
                '/\{\{\$otherFee\}\}/',
                '/\{\{\$total\}\}/',
            ];
            $dataReplace = [
                sc_language_render('email.order.email_subject_customer') . '#' . $orderID,
                $orderID,
                $data['first_name'],
                $data['last_name'],
                $data['first_name'].' '.$data['last_name'],
                $data['address1'] . ' ' . $data['address2'].' '.$data['address3'],
                $data['address1'],
                $data['address2'],
                $data['address3'],
                $data['email'],
                $data['phone'],
                $data['comment'],
                $orderDetail,
                sc_currency_render($data['subtotal'], '', '', '', false),
                sc_currency_render($data['shipping'], '', '', '', false),
                sc_currency_render($data['discount'], '', '', '', false),
                sc_currency_render($data['other_fee'], '', '', '', false),
                sc_currency_render($data['total'], '', '', '', false),
            ];

            // Send mail order success to admin
            if (sc_config('order_success_to_admin') && $checkContent) {
                $content = $checkContent->text;
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];
                $config = [
                    'to' => sc_store('email'),
                    'subject' => sc_language_render('email.order.email_subject_to_admin', ['order_id' => $orderID]),
                ];
              
                sc_send_mail($templatePath . '.mail.order_success_to_admin', $dataView, $config, []);
            }

            // Send mail order success to customer
            if (sc_config('order_success_to_customer') && $checkContentCustomer && $data['email']) {
                $contentCustomer = $checkContentCustomer->text;
                $contentCustomer = preg_replace($dataFind, $dataReplace, $contentCustomer);
                $dataView = [
                    'content' => $contentCustomer,
                ];
                $config = [
                    'to' => $data['email'],
                    'replyTo' => sc_store('email'),
                    'subject' => sc_language_render('email.order.email_subject_customer', ['order_id' => $orderID]),
                ];

                $attach = [];
                if (sc_config('order_success_to_customer_pdf')) {
                    // Invoice pdf
                    \PDF::loadView($templatePath . '.mail.order_success_to_customer_pdf', $dataView)
                        ->save(\Storage::disk('invoice')->path('order-'.$orderID.'.pdf'));
                    $attach['attachFromStorage'] = [
                        [
                            'file_storage' => 'invoice',
                            'file_path' => 'order-'.$orderID.'.pdf',
                        ]
                    ];
                }

                sc_send_mail($templatePath . '.mail.order_success_to_customer', $dataView, $config, $attach);
            }
        }
    }
    $dataResponse = [
        'orderID'        => $orderID,
    ];
    return $dataResponse;
}


function exito_biopago_email(array $data)
{

    if (sc_config('biopago_customer')) {
        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'biopago')->where('status', 1)->first();
        
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$nombre\}\}/',
                '/\{\{\$apellido\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$telefono\}\}/',
                '/\{\{\$address1\}\}/',
                '/\{\{\$cedula\}\}/',
            ];
            $dataReplace = [
                sc_language_render('email.welcome_customer.title'),
                $data['first_name'] ?? '',
                $data['last_name'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['address1'] ?? '',
                $data['cedula'] ?? '',
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $data['email'],
                'subject' => 'pago realizado con exito ',
            ];

           

            sc_send_mail('templates.' . sc_store('template') . '.mail.welcome_customer', $dataView, $config, []);
        }
    }
   
}


function estatus_del_pedido(array $data)

{
    if (sc_config('customer_estatus_del_pedido')) {
        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'estatus_del_pedido')->where('status', 1)->first();

        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$titulo\}\}/',
                '/\{\{\$nombre\}\}/',
                '/\{\{\$apellido\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$estatus\}\}/',
                '/\{\{\$estatus_mensaje\}\}/',
                '/\{\{\$numero_del_pedido\}\}/',
            ];
            $dataReplace = [
                $data['titulo'] ?? 'Estatus del pedido',
                $data['first_name'] ?? '',
                $data['last_name'] ?? '',
                $data['email'] ?? '',
                $data['estatus'] ?? '',
                $data['estatus_mensaje'] ?? '',
                $data['numero_del_pedido'] ?? '',
               
                
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
               

            ];

            $config = [
                'to' => $data['email'],
                'subject' => 'ESTATUS DEl PAGO',
            ];

           

            sc_send_mail('templates.' . sc_store('template') . '.mail.order_success_to_customer', $dataView, $config, []);
        }
    }
   
}


function estatus_de_pago(array $data)

{

   
    if (sc_config('customer_estatus_de_pago')) {
        $checkContent = (new \SCart\Core\Front\Models\ShopEmailTemplate)->where('group', 'estatus_de_pago')->where('status', 1)->first();

        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$titulo\}\}/',
                '/\{\{\$nombre\}\}/',
                '/\{\{\$apellido\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$estatus\}\}/',
                '/\{\{\$estatus_mensaje\}\}/',
                '/\{\{\$numero_del_pedido\}\}/',
                '/\{\{\$numero_referencia\}\}/',
                '/\{\{\$fecha_venciento\}\}/',
                '/\{\{\$observacion\}\}/',
                '/\{\{\$id_del_pago\}\}/',
            ];
            $dataReplace = [
                $data['titulo'] ?? 'ESTATUS DE PAGO',
                $data['first_name'] ?? '',
                $data['last_name'] ?? '',
                $data['email'] ?? '',
                $data['estatus'] ?? '',
                $data['estatus_mensaje'] ?? '', 
                $data['numero_del_pedido'] ?? '',
                $data['numero_referencia'] ?? '',
                $data['fecha_venciento'] ?? '',
                $data['observacion'] ?? '',
                $data['id_del_pago'] ?? '',
               
                
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
               

            ];

           

            $config = [
                'to' => $data['email'],
                'subject' => $data['estatus'] ?? 'ESTATUS DE PAGO',
            ];


            sc_send_mail('templates.' . sc_store('template') . '.mail.order_success_to_customer', $dataView, $config, []);
        }
    }

   
}

if (!function_exists('getBadgeHtml')) {
    function getBadgeHtml($level)
    {
        // Escribe aquí el código de tu función de ayuda
        switch ($level) {
            case 'PLATINUM':
                $color = 'rgb(115, 115, 255)'; // Color azul claro
                break;
            case 'GOLD':
                $color = 'rgb(255, 215, 0)'; // Color dorado
                break;
            case 'PLATA':
                $color = 'rgb(192, 192, 192)'; // Color plata
                break;
            case 'BRONCE':
                $color = 'rgb(205, 127, 50)'; // Color bronce
                break;
            case 'CERTIFICADO':
                $color = 'rgb(0, 128, 0)'; // Color verde
                break;
            default: // 'SIN NIVEL'
                $color = 'rgb(128, 128, 128)'; // Color gris
                break;
        }

        return "<span class='badge badge-pill  text-light    ' style='background-color: {$color};'>{$level}</span>";
    }
}




