<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* admin/login.html.twig */
class __TwigTemplate_24c2aebbdf23406303f3ee24963fb1b0 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">

\t<head>
\t\t<meta charset=\"UTF-8\"/>
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
\t\t<title>Login</title>
\t\t<link
\t\trel=\"icon\" type=\"image/png\" href=\"image/icon.png\"/>
\t\t<!-- Bootstrap CSS -->
\t\t<link
\t\thref=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css\" rel=\"stylesheet\"/>
\t\t<!-- FontAwesome CSS -->
\t\t<link
\t\trel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css\" crossorigin=\"anonymous\"/>
\t\t<!-- Toastr CSS -->
\t\t<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\"/>
\t\t<link rel=\"stylesheet\" href=\"/assets/css/login.css\"/>
\t</head>

\t<body>
\t\t<div class=\"container\">
\t\t\t<div class=\"row justify-content-center\">
\t\t\t\t<div class=\"col-md-6 col-lg-4\">
\t\t\t\t\t<div class=\" mt-5\">
\t\t\t\t\t\t<div
\t\t\t\t\t\t\tclass=\"card-body\">
\t\t\t\t\t\t\t<!-- Company Logo -->
\t\t\t\t\t\t\t<div style=\"display: flex; justify-content: center\">
\t\t\t\t\t\t\t\t<img src=\"/assets/images/defaults/logo.png\" alt=\"Company Logo\" class=\"img-fluid mb-4\" style=\"max-width: 200px; text-align: center\"/>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<h3 class=\"card-title text-center\">Login</h3>
\t\t\t\t\t\t\t<form method=\"post\" id=\"loginForm\">
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label for=\"email\">Email address</label>
\t\t\t\t\t\t\t\t\t<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\"/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label for=\"password\">Password</label>
\t\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t\t\t<input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\"/>
\t\t\t\t\t\t\t\t\t\t<div class=\"input-group-append\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\">
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-eye\" id=\"togglePassword\"></i>
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary btn-block\">
\t\t\t\t\t\t\t\t\tLogin
\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"card-footer text-center d-flex\" style=\"justify-content: space-around\">
\t\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t\t<a href=\"#\">Forgot Password?</a>
\t\t\t\t\t\t\t</small>
\t\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t\t<a href=\"/register\">Don't have an account?</a>
\t\t\t\t\t\t\t</small>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Footer with Privacy Policy -->
\t\t\t\t\t<div class=\"text-center mt-3\">
\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t<a href=\"#\">Privacy Policy</a>
\t\t\t\t\t\t</small>
\t\t\t\t\t\t|
\t\t\t\t\t\t<small>All rights reserved &copy; 2024</small>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>

\t\t<!-- Bootstrap JS and dependencies -->
\t <script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\"></script>
\t\t <script src=\"https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js\"></script>
\t\t <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\"></script>
\t\t <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js\"
\t\t    integrity=\"sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==\"
\t\t    crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>
\t\t<!-- Toastr JS -->
\t\t <script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>
\t\t<!-- Custom JS -->
\t\t <script type=\"module\" src=\"/assets/js/login.js\"></script>
\t</body>

</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/login.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">

\t<head>
\t\t<meta charset=\"UTF-8\"/>
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
\t\t<title>Login</title>
\t\t<link
\t\trel=\"icon\" type=\"image/png\" href=\"image/icon.png\"/>
\t\t<!-- Bootstrap CSS -->
\t\t<link
\t\thref=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css\" rel=\"stylesheet\"/>
\t\t<!-- FontAwesome CSS -->
\t\t<link
\t\trel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css\" crossorigin=\"anonymous\"/>
\t\t<!-- Toastr CSS -->
\t\t<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\"/>
\t\t<link rel=\"stylesheet\" href=\"/assets/css/login.css\"/>
\t</head>

\t<body>
\t\t<div class=\"container\">
\t\t\t<div class=\"row justify-content-center\">
\t\t\t\t<div class=\"col-md-6 col-lg-4\">
\t\t\t\t\t<div class=\" mt-5\">
\t\t\t\t\t\t<div
\t\t\t\t\t\t\tclass=\"card-body\">
\t\t\t\t\t\t\t<!-- Company Logo -->
\t\t\t\t\t\t\t<div style=\"display: flex; justify-content: center\">
\t\t\t\t\t\t\t\t<img src=\"/assets/images/defaults/logo.png\" alt=\"Company Logo\" class=\"img-fluid mb-4\" style=\"max-width: 200px; text-align: center\"/>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<h3 class=\"card-title text-center\">Login</h3>
\t\t\t\t\t\t\t<form method=\"post\" id=\"loginForm\">
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label for=\"email\">Email address</label>
\t\t\t\t\t\t\t\t\t<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\"/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label for=\"password\">Password</label>
\t\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t\t\t<input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\"/>
\t\t\t\t\t\t\t\t\t\t<div class=\"input-group-append\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\">
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-eye\" id=\"togglePassword\"></i>
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary btn-block\">
\t\t\t\t\t\t\t\t\tLogin
\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"card-footer text-center d-flex\" style=\"justify-content: space-around\">
\t\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t\t<a href=\"#\">Forgot Password?</a>
\t\t\t\t\t\t\t</small>
\t\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t\t<a href=\"/register\">Don't have an account?</a>
\t\t\t\t\t\t\t</small>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Footer with Privacy Policy -->
\t\t\t\t\t<div class=\"text-center mt-3\">
\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t<a href=\"#\">Privacy Policy</a>
\t\t\t\t\t\t</small>
\t\t\t\t\t\t|
\t\t\t\t\t\t<small>All rights reserved &copy; 2024</small>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>

\t\t<!-- Bootstrap JS and dependencies -->
\t <script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\"></script>
\t\t <script src=\"https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js\"></script>
\t\t <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\"></script>
\t\t <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js\"
\t\t    integrity=\"sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==\"
\t\t    crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>
\t\t<!-- Toastr JS -->
\t\t <script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>
\t\t<!-- Custom JS -->
\t\t <script type=\"module\" src=\"/assets/js/login.js\"></script>
\t</body>

</html>
", "admin/login.html.twig", "D:\\xampp\\htdocs\\hwai\\src\\pages\\admin\\login.html.twig");
    }
}
