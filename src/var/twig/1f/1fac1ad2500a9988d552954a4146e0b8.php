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

/* errors/403.html.twig */
class __TwigTemplate_058a7014667cacc144c5083224e6ec9a extends Template
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
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "errors/403.html.twig";
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

</html>", "errors/403.html.twig", "D:\\xampp\\htdocs\\hwai\\src\\pages\\errors\\403.html.twig");
    }
}
