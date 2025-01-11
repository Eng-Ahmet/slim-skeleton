<?php

class Autoload
{
    public static function autoload($className)
    {
        // إزالة "API" وأي شرطة مائلة قبلها
        $class = preg_replace('#' . preg_quote(DIRECTORY_SEPARATOR) . '?API#', '', $className);

        // تحويل الشرطة المائلة الخلفية إلى الشرطة المائلة القياسية
        $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);

        // فصل المسار عن اسم الكلاس
        $path = dirname($class); // المسار بدون اسم الكلاس
        $classNameOnly = basename($class); // اسم الكلاس فقط

        // تطبيق custom_lcfirst على اسم الكلاس فقط
        $classNameOnly = lcfirst($classNameOnly);

        // إعادة بناء المسار الكامل
        $classFile = APP_PATH  . $path . DIRECTORY_SEPARATOR . $classNameOnly . ".php";


        // إذا كان الملف موجودًا، قم بتحميله
        if (file_exists($classFile)) {
            require $classFile;
        } else {
            throw new Exception("Class file not found: " . $classFile);
        }
    }
}

// تسجيل الـ autoloader
spl_autoload_register(__NAMESPACE__ . "Autoload::autoload");