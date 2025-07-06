<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Comment System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the comment system.
    |
    */

    // هل التعليقات تحتاج موافقة قبل النشر؟
    'auto_approve' => env('COMMENTS_AUTO_APPROVE', true),

    // الحد الأقصى لطول التعليق
    'max_length' => env('COMMENTS_MAX_LENGTH', 1000),

    // الحد الأدنى لطول التعليق
    'min_length' => env('COMMENTS_MIN_LENGTH', 5),

    // عدد التعليقات في الصفحة الواحدة
    'per_page' => env('COMMENTS_PER_PAGE', 10),

    // هل يُسمح بالروابط في التعليقات؟
    'allow_links' => env('COMMENTS_ALLOW_LINKS', true),

    // هل يُسمح بالإيموجي في التعليقات؟
    'allow_emojis' => env('COMMENTS_ALLOW_EMOJIS', true),

    // فترة انتظار بين التعليقات (بالدقائق)
    'rate_limit' => env('COMMENTS_RATE_LIMIT', 1),

    // هل يُسمح بالتعليقات للزوار غير المسجلين؟
    'allow_guests' => env('COMMENTS_ALLOW_GUESTS', true),

    // قائمة الكلمات المحظورة
    'blocked_words' => [
        // يمكن إضافة كلمات محظورة هنا
    ],

    // هل يتم حفظ عنوان IP؟
    'store_ip' => env('COMMENTS_STORE_IP', true),

    // رسائل الإشعارات
    'messages' => [
        'success' => 'تم إضافة التعليق بنجاح!',
        'pending' => 'تم إرسال التعليق وهو في انتظار الموافقة',
        'error' => 'حدث خطأ أثناء إضافة التعليق',
        'rate_limit' => 'يرجى الانتظار قليلاً قبل إضافة تعليق جديد',
        'blocked_word' => 'يحتوي التعليق على كلمات غير مسموحة',
    ],

    // إعدادات البريد الإلكتروني للإشعارات
    'email_notifications' => [
        'enabled' => env('COMMENTS_EMAIL_NOTIFICATIONS', false),
        'admin_email' => env('COMMENTS_ADMIN_EMAIL', 'admin@example.com'),
        'notify_new_comment' => true,
        'notify_comment_approved' => true,
    ],

    // إعدادات الحماية من الاعتداء
    'security' => [
        'max_attempts' => env('COMMENTS_MAX_ATTEMPTS', 5),
        'lockout_duration' => env('COMMENTS_LOCKOUT_DURATION', 15), // بالدقائق
        'honeypot' => env('COMMENTS_HONEYPOT', true),
    ],
];