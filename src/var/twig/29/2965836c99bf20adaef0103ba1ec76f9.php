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

/* errors/403.html.twig */
class __TwigTemplate_8fb21ccf6faa1ff45d489349bce5a6a0 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<!DOCTYPE html>
<html>

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/403.css\">


</head>

<body>
    <div class=\"container\">
        <h1>4<div class=\"lock\">
                <div class=\"top\"></div>
                <div class=\"bottom\"></div>
            </div>3</h1>
        <p>Access denied</p>
    </div>
    <script src=\"/assets/js/403.js\"></script>
</body>

</html>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "errors/403.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array ();
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/403.css\">


</head>

<body>
    <div class=\"container\">
        <h1>4<div class=\"lock\">
                <div class=\"top\"></div>
                <div class=\"bottom\"></div>
            </div>3</h1>
        <p>Access denied</p>
    </div>
    <script src=\"/assets/js/403.js\"></script>
</body>

</html>", "errors/403.html.twig", "D:\\xampp\\htdocs\\slim-skeleton\\src\\pages\\errors\\403.html.twig");
    }
}
