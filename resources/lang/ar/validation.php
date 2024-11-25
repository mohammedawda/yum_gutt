<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |
      | اسطر التحقق والتصديق للغة العربية
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class.
      |
      | الاسطر ادناه تحتوي علي رسائل الخطأ الافتراضية المستخدمة في فئة التحقق.
      |
      | Some of these rules have multiple versions such as the size rules.
      |
      | بعض هذه القواعد تحتوي علي عدة نسخ مثل قاعدة الحجم.
      |
      | Feel free to tweak each of these messages.
      |
      | لا تتردد في تعديل اي منها.
      |
     */

    "accepted" => ":attribute يجب أن يتم قبول.",
    "active_url" => ":attribute ليس عنوان إنترنت صالحًا.",
    "before" => ":attribute يجب أن يكون تاريخ قبل :date.",
    "after" => ":attribute يجب أن يكون تاريخًا بعد :date.",
    "after_or_equal" => ":attribute يجب أن يكون تاريخا بعد أو يساوي :date.",
    "alpha" => ":attribute يجب أن يحتوي  على أحرفاً فقط.",
    "alpha_dash" => ":attribute يجب أن يحتوي  على أحرف وأرقام وإشارة ناقص.",
    "alpha_num" => ":attribute يجب أن يحتوي  على أحرف وأرقام.",
    "array" => ":attribute يجب ان تكون مصفوفة.",
    "between" => array(
        "numeric" => ":attribute يجب أن يكون رقم بين :min - :max.",
        "file" => ":attribute يجب أن يكون بين :min - :max كيلو بايت.",
        "string" => ":attribute يجب أن يكون طوله بين :min - :max من الأحرف.",
        "array" => ":attribute يجب ان يحتوي علي :min - :max بنود."
    ),
    "boolean" => "The :attribute field must be true or false",
    "confirmed" => "تأكيد :attribute لا يتطابق.",
    "date" => ":attribute ليس تاريخ صحيح.",
    "date_format" => ":attribute لا يطابق اليصغة :format.",
    "different" => ":attribute و :other يجب أن يكونا مختلفين.",
    "digits" => ":attribute يجب أن يتكون من :digits أرقام.",
    "digits_between" => ":attribute يجب أن يكون بين :min و :max أرقام.",
    "email" => ":attribute بصيغة خاطئة.",
    "exists" => ":attribute المختار غير صالح.",
    "image" => ":attribute يجب أن يكون صورة",
    "in" => "قيمة :attribute المختارة غير صالح.",
    "integer" => ":attribute يجب أن يكون رقماً صحيحاً.",
    "ip" => ":attribute يجب أن يكون عنوان أنترنت (IP) صحيحاً.",
    "max" => array(
        "numeric" => ":attribute يجب ألا يكون أكبر من :max.",
        "file" => ":attribute يجب ألا يكون أكبر من :max كيلو بايت.",
        "string" => ":attribute يجب ألا يكون أكبر من :max حرف.",
        "array" => ":attribute يجب ان لا يزيد علي :max بنود."
    ),
    "mimes" => ":attribute يجب أن يكون ملف من نوع: :values.",
    "min" => array(
        "numeric" => ":attribute يجب أن يكون على الأقل :min.",
        "file" => ":attribute يجب أن يكون على الأقل :min كيلو بايت.",
        "string" => ":attribute يجب أن يكون طوله على الأقل :min أحرف.",
        "array" => ":attribute يجب ان يحتوي علي الاقل :min بنود."
    ),
    "not_in" => ":attribute المختار غير صالح.",
    "numeric" => ":attribute يجب أن يكون رقم.",
    "regex" => ":attribute صيغته غير صالحة.",
    "required" => ":attribute مطلوب.",
    "required_if" => ":attribute مطلوب عندما يكون :other يساوي :value.",
    "required_with" => ":attribute مطلوب عندما يكون :values موجوداً.",
    "required_with_all" => ":attribute مطلوب عندما يكون :values is موجوداً.",
    "required_without" => ":attribute مطلوب عندما لا يكون :values موجوداً.",
    "required_without_all" => " :attribute مطلوب عندما لا يكون :values موجوداً.",
    "same" => ":attribute و :other يجب أن يتطابقا",
    "size" => array(
        "numeric" => ":attribute يجب أن يكون :size.",
        "file" => ":attribute يجب أن يكون :size كيلو بايت.",
        "string" => ":attribute يجب أن يتكون من :size أحرف.",
        "array" => ":attribute يجب ان يحتوي على :size بنود."
    ),
    "timezone" => "The :attribute must be a valid zone.",
    "unique" => "قيمة :attribute تم استخدامها مسبقاً.",
    "url" => ":attribute صيغته غير صحيحة.",
    'lte' => [
        'numeric' => 'الحقل :attribute يجب أن يكون أقل من أو يساوي :value.',
    ],
    'lt' => [
        'numeric' => 'الحقل :attribute يجب أن يكون أقل من  :value.',
    ],
    'gte' => [
        'numeric' => 'الحقل :attribute يجب أن يكون أكبر من أو يساوي :value.',
    ],
    'gt' => [
        'numeric' => 'الحقل :attribute يجب أن يكون أكبر من :value.',
    ],
    'stage_created_successfully'=>' تم انشاء المحل بنجاح',
    'stage_updated_successfully'=>' تم تعديل المحل بنجاح',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |
      | اسطر التحقق المخصصه للغة العربية
      |
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines.
      |
      | من هنا يمكنك تحديد رسائل تحقق مخصصه للسمات باستخدام مجمع "attribute.rule"
      | لتسمية السطر.
      |
      | his makes it quick to specify a specific custom language line for a given
      | attribute rule.
      |
      | يكون التحديد سريعا عند استخدام سمه معينة للغة المخصصة
      |
     */
    'custom' => array(
        'page_title' => array(
            'required' => 'custom-message'
        ),'user_phone' => [
            'required_unless' => 'رقم الهاتف مطلوب إلا إذا كانت طريقة الدفع غير فيزا أو تقسيط.',
        ],'reference_number' => [
            'required_unless' => 'رقم التحويل إلا إذا كانت طريقة الدفع غير فيزا أو تقسيط.',
        ],'transfer_photo' => [
            'required_unless' => 'صورة التحويل إلا إذا كانت طريقة الدفع غير فيزا أو تقسيط.',
        ],'answers' => [
            'required_unless' => 'لابد من اختيار قيم الاجابة عند اختيار نوع السؤال اى شئ غير الفروع.',
        ],'national_id' => [
        'required_if' => 'رقم الهوية مطلوب عندما يكون الصلاحية صاحب مطعم.',
        ], 'national_id_photo_type' => [
        'required_if' => 'نوع صورة الهوية القومية مطلوب عندما يكون الصلاحية صاحب مطعم.',
        ], 'national_id_photo' => [
            'required_if' => 'صورة الهوية القومية مطلوب عندما يكون الصلاحية صاحب مطعم.',
        ]
    ),
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |
      | سمات التحقق المخصصه
      |
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
      | الاسطر ادناه تستخدم لتبديل السمات بشكل مقروء اكثر مثل "البريد الالكتروني"
      | بدلا عن "الايميل". هذه سيساعد في جعل الرسائل اوضح.
      |
     */
    'attributes' => array(
        "page_title"  => "عنوان الصفحة",
        "name"        => "الاسم",
        "username"    => "اسم المستخدم",
        "email"       => "البريد الالكتروني",
        "first_name"  => "الاسم الأول",
        "last_name"   => "اسم العائلة",
        "password"    => "كلمة المرور",
        "city"        => "المدينة",
        "country"     => "الدولة",
        "address"     => "العنوان",
        "phone"       => "الهاتف",
        "mobile"      => "الجوال",
        "age"         => "العمر",
        "sex"         => "الجنس",
        "gender"      => "الجنس",
        "day"         => "اليوم",
        "month"       => "الشهر",
        "year"        => "السنة",
        "hour"        => "ساعة",
        "minute"      => "دقيقة",
        "second"      => "ثانية",
        "title"       => "العنوان",
        "content"     => "المحتوى",
        "description" => "الوصف",
        "object"      => "الأهداف",
        "objects"     => "الأهداف",
        "excerpt"     => "الملخص",
        "date"        => "التاريخ",
        "time"        => "الوقت",
        "school"      => "المدرسة",
        "available"   => "متاح",
        "size"        => "الحجم",
        'code'        => 'رقم التاكيدى',
        "type"        => "النوع",
        'city_id'     => 'المدينة',
        'cost'        => 'التكلفة',
        'from'        => 'من',
        'to'          => 'إلى',
        'my_code'     => 'الكود الخاص بي',
        'image'       => 'الملف',
        'status'      => 'الحالة',
        'active'      => 'مفعل',
        'id_number'   => 'رقم الهوية الشخصية',
        'excel'       => 'ملف الاكسيل',
        'link'        => 'الرابط',
        'message'     => 'الرسالة',
        'subject'     => 'الموضوع',
        'answer'      => 'الإجابة',
        'notes'       => 'الملاحظات',
        'banks'       => 'بنك الأسئلة',
        'grade'       => 'الدرجة',
        'answers'     => 'الإجابة',
        'receiver_id' => 'مستلم الرسالة',
        'comment'     => 'التعليق',
        'project_id'  => 'رقم المشروع',

        'fail_message'  => 'رسالة الفشل',
        'start_date'    => 'تاريخ البداية',
        'end_date'      => 'تاريخ النهاية',
        'vision_ar'     => 'الرؤية بالعربي',
        'vision_en'     => 'الرؤية بالانجليزي',
        'mission_ar'    => 'الأهداف بالعربي',
        'mission_en'    => 'الأهداف بالانجليزي',
        'vision_photo'  => 'صورة الرؤية',
        'mission_photo' => 'صورة الأهداف',
        'discussion_id' => 'رقم المناقشة',
        'country_code'  => 'كود الدولة',

        'password_confirmation' => 'تأكيد كلمة المرور',
        'current_password'      =>'كلمة المرور الحالى',
        'discount_code'         => 'كود الخصم',
        'iqama_saudi_id'        => 'رقم الإقامة',
        'job_card'              => 'البطاقة الوظيفية',
        'profile_pic'           => 'صورة البروفايل',
        'package_id'            => 'الباقة',
        'category_id'           => 'القسم',
        'birth_date'            => 'تاريخ الميلاد',
        'time_minutes'          => 'الوقت بالدقائق',
        'success_average'       => 'نسبة النجاح',
        'try_no'                => 'عدد المحاولات',
        'question_no'           => 'عدد الأسئلة',
        'success_message'       => 'رسالة النجاح',
        'user_id'       => 'كود المستخدم',
        'arabic_name'       => 'الإسم باللغة العربية',
        'price'       => 'المبلغ',
        'arabic_description'       => 'الوصف باللغة العربية',
        'sub_category_id'       => 'كود القسم الفرعى',
        'longi'       => 'الخريطة',
        'lati'       => 'الخريطة',
        'period'       => 'الفترة',
        'tags'       => 'تاج',
        'images'       => 'صور المنتج',
        'rating'       => 'التقيم',
        'product_id'       => 'المنتج',
        'review'       => 'نص التقيم',
        'offer'       => 'العرض',
        'main_category_id'       => 'كود القسم الرئيسى',
        'national_id_photo'       => 'صورة الهوية القومية',
        'national_id_photo_type'       => 'نوع صورة الهوية القومية',
        'profile_photo' => 'صورة الصفحة الشخصية',
        'national_id'       => 'رقم الهوية',
        'role_id'         => 'الصلاحية',
        'country_id'       => 'الدولة',
        'terms_and_condition'       => 'الموافقة على الشروط والاحكام',
        'question_ar'       => 'السؤال بالعربية',
        'question_en'       => 'السؤال بالانجليزية',
        'answers.*.question_id' => 'السؤال',
        'answers.*.answer' => 'الإجابة',
        'payment_method_id'       => 'طريقة الدفع',
        'reason'       => 'السبب',
        'transaction_id'       => 'كود التحويل',
        'permissions.*'       => 'الصلاحية',
        'name_ar'       => 'الإسم باللغة العربية',
        'name_en'       => 'الإسم باللغة الإنجليزية',
        'address_id'       => 'العنوان',
        'addressable_type'       => 'مكان الاستلام',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',
        ''       => '',


    ),
);
