# slim-skeleton Project

## Introduction

Welcome to the Slim HWAI Project! This project provides a boilerplate setup using the Slim Framework, a PHP micro-framework designed for creating simple yet powerful web applications. This setup is intended to streamline the process of starting a new PHP project with Slim by providing a ready-to-use skeleton.

## Installation

To install the Slim HWAI project, you will need Composer, a dependency management tool for PHP. Follow these steps to create a new project:

1. Ensure Composer is Installed: Make sure you have Composer installed on your system. You can download it from [getcomposer.org](https://getcomposer.org).

2. Create a New Project: Run the following command in your terminal to create a new project based on the Slim HWAI boilerplate:

    ```bash
    composer create-project hwai/slim-skeleton
    ```

    This command will create a new directory with the Slim HWAI project structure and install all necessary dependencies.

## Project Structure

After installation, you will have a project with the following structure:

-   `src/`: Contains the source code for your application. This is where you'll place your routes, controllers, and any other business logic.
-   `public/`: This is the web root directory. It contains publicly accessible files like HTML, CSS, JavaScript, and the entry point for your application (`index.php`).
-   `config/`: Contains configuration files for your application. This might include settings for database connections, middleware, and other configuration parameters.
-   `vendor/`: Contains Composer-managed libraries and dependencies. You generally won't need to modify anything here.
-   `tests/`: (Optional) If you include testing in your project, this directory will hold your test cases and test-related configuration.

## Running the Application

To start the application and view it in your web browser, you can use the built-in PHP web server. Navigate to the root directory of your project and run:

```bash
rr.exe serve
```

This will start a local server at [http://localhost:8080](http://localhost:8080). Open this URL in your browser to view your application.

## Configuration

Configuration files are located in the `config/` directory. Here, you can adjust settings specific to your environment, such as database credentials, environment variables, and other configuration parameters.

## Development and Contribution

If you wish to contribute to the development of this project, follow these steps:

1. Fork the Repository: Click on the "Fork" button at the top-right of the repository page on GitHub.

2. Create a Feature Branch: Create a new branch for your feature or bug fix:

    ```bash
    git checkout -b feature/YourFeature
    ```

3. Make Changes: Implement your changes and test them locally.

4. Submit a Pull Request: Push your changes to your forked repository and open a Pull Request (PR) on the original repository, providing a clear description of the changes you made.

## Issues and Support

If you encounter any issues or have questions about the project, please:

1. Open an Issue on GitHub with a detailed description of the problem or question.
2. Contact us via email at support@hwai.com for additional support.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

# luma-new-back

# Routing

## Register

## 📍 Endpoint

`POST /register`

## 📝 Description

تُستخدم هذه النقطة لتسجيل مستخدم جديد في النظام. يجب إرسال جميع البيانات المطلوبة في جسم الطلب بصيغة JSON.

---

## 📤 Request Headers

| Header       | Value              |
| ------------ | ------------------ |
| Content-Type | `application/json` |
| Accept       | `application/json` |

---

## 📦 Request Body (JSON)

```json
{
    "first_name": "Ahmed",
    "last_name": "Al-Mutairi",
    "email": "ahmed@example.com",
    "phone": "+966501234567",
    "age": 25,
    "gender": "Male",
    "privacy_policy": 1,
    "country_code": "SA",
    "country_name": "Saudi Arabia",
    "password": "StrongPassword123",
    "password_confirmation": "StrongPassword123",
    "user_type": "Student"
}
```

> 🔒 **ملاحظات:**
>
> -   `privacy_policy` يجب أن تكون `1` لتأكيد الموافقة على الشروط.
> -   يجب أن تطابق `password_confirmation` كلمة المرور.
> -   `user_type` يمكن أن تكون `Student`, `Teacher`, أو نوع آخر حسب النظام.

---

## ✅ Successful Response (201 Created)

```json
{
    "status": 201,
    "message": "OK",
    "data": {
        "message": "Registration successful. Please check your email to activate your account."
    },
    "error": null,
    "timestamp": "2025-06-15T23:51:57+00:00",
    "version": "1.0.0",
    "path": "/register",
    "user_agent": "PostmanRuntime/7.44.0",
    "ip": "127.0.0.1",
    "request_method": "POST",
    "referer": "",
    "content_type": "application/json",
    "accept_language": "",
    "host": "localhost",
    "protocol": "http",
    "original_url": "http://localhost:8000/register",
    "query_string": "",
    "trace_id": "c8e210a40bedc432",
    "signature": "bb8bb838ac9aa1d36415858cf512c5e92906cf8fe9a536a39bec5cb871b66ec8"
}
```

---

## ❌ Error Response Example

```json
{
    "status": 500,
    "message": "Database settings array is missing or incomplete.",
    "data": null,
    "error": "Database settings array is missing or incomplete.",
    "timestamp": "2025-06-15T23:55:22+00:00",
    "version": "1.0.0",
    "path": "/register",
    "user_agent": "PostmanRuntime/7.44.0",
    "ip": "127.0.0.1",
    "request_method": "POST",
    "referer": "",
    "content_type": "application/json",
    "accept_language": "",
    "host": "localhost",
    "protocol": "http",
    "original_url": "http://localhost:8000/register",
    "query_string": "",
    "trace_id": "c583102a5254c78a",
    "signature": "bb8bb838ac9aa1d36415858cf512c5e92906cf8fe9a536a39bec5cb871b66ec8"
}
```

---

## 📌 Notes

-   يُرسل الرابط إلى البريد الإلكتروني لتفعيل الحساب بعد التسجيل.
-   يجب أن يكون البريد الإلكتروني صالحًا ونشطًا لتلقّي رسالة التفعيل.
-   يتم حفظ عنوان الـ IP والمعلومات الخاصة بالطلب لأغراض التتبع والأمان.

---

## 🧪 Example using cURL

```bash
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Ahmed",
    "last_name": "Al-Mutairi",
    "email": "ahmed@example.com",
    "phone": "+966501234567",
    "age": 25,
    "gender": "Male",
    "privacy_policy": 1,
    "country_code": "SA",
    "country_name": "Saudi Arabia",
    "password": "StrongPassword123",
    "password_confirmation": "StrongPassword123",
    "user_type": "Student"
  }'
```

## Login

## 📍 Endpoint

`POST /login`

## الوصف

نقطة النهاية `/login` تُستخدم لتسجيل دخول المستخدمين عبر إرسال بيانات البريد الإلكتروني وكلمة المرور.  
تقوم الخدمة بالتحقق من صحة البيانات، التحقق من حالة المستخدم، تسجيل المحاولات، وإنشاء توكن JWT في حالة النجاح.

---

## طلب تسجيل الدخول (Request)

-   **الطريقة:** POST
-   **الرابط:** `/login`
-   **نوع المحتوى:** `application/json`

### جسم الطلب (Body)

```json
{
    "email": "user@example.com",
    "password": "yourPassword123"
}
```

-   **email**: البريد الإلكتروني للمستخدم (يجب أن يكون بصيغة صحيحة).
-   **password**: كلمة المرور (بين 8 و 20 حرفًا).

---

## استجابة ناجحة (Success Response)

-   **الحالة:** 200 OK
-   **نوع المحتوى:** `application/json`

### مثال على الاستجابة

```json
{
    "status": 200,
    "message": "OK",
    "data": {
        "message": "Login successful.",
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "expires_in": 600
    },
    "error": null,
    "timestamp": "2025-06-17T13:41:52+00:00",
    "version": "1.0.0",
    "path": "/login",
    "user_agent": "PostmanRuntime/7.44.0",
    "ip": "127.0.0.1",
    "request_method": "POST",
    "referer": "",
    "content_type": "application/json",
    "accept_language": "",
    "host": "localhost",
    "protocol": "http",
    "original_url": "http://localhost:8000/login",
    "query_string": "",
    "trace_id": "8b3b9c91f90df5d7",
    "signature": "2db4f2843cacec2ee01ae425e0d129683446443290b7face4d5a8a51bd0b493f"
}
```

-   **token**: رمز JWT الذي يتم استخدامه للمصادقة في الطلبات المستقبلية.
-   **expires_in**: مدة صلاحية التوكن بالثواني (600 ثانية = 10 دقائق).

---

## استجابة في حالة الخطأ (Error Response)

### مثال على استجابة خطأ في حالة بيانات غير صحيحة أو فشل تسجيل الدخول

-   **الحالة:** 401 Unauthorized
-   **نوع المحتوى:** `application/json`

```json
{
    "status": 401,
    "message": "Invalid email or password.",
    "data": null,
    "error": "Invalid email or password.",
    "timestamp": "2025-06-17T13:42:54+00:00",
    "version": "1.0.0",
    "path": "/login",
    "user_agent": "PostmanRuntime/7.44.0",
    "ip": "127.0.0.1",
    "request_method": "POST",
    "referer": "",
    "content_type": "application/json",
    "accept_language": "",
    "host": "localhost",
    "protocol": "http",
    "original_url": "http://localhost:8000/login",
    "query_string": ""
}
```
