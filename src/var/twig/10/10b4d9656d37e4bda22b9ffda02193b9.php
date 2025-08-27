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

/* seeds/index.html.twig */
class __TwigTemplate_abc814e668d9bbb58a523a487ffd5c91 extends Template
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

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Seed Results</title>
    <!-- Bootstrap CSS -->

    <link href=\"./assets/css/lib/bootstrap.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"./assets/css/seeds.css\">

</head>

<body>

    <div class=\"container mt-4\">
        <div class=\"d-flex justify-content-between align-items-center\">
            <h1>Seed Results</h1>
            <button id=\"runSeedBtn\" class=\"btn btn-primary\">Run Seeds</button>
        </div>
        <!-- Loader -->
        <div id=\"loader\" class=\"loader\"></div>
        <div id=\"resultsContainer\" class=\"mt-4\">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src=\"./assets/js/lib/bootstrap.bundle.min.js\"></script>
    <script src=\"./assets/js/lib/jquery.min.js\"></script>
    <!-- Coustom js-->
    <script src=\"./assets/js/seeds.js\"></script>

</body>

</html>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "seeds/index.html.twig";
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

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Seed Results</title>
    <!-- Bootstrap CSS -->

    <link href=\"./assets/css/lib/bootstrap.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"./assets/css/seeds.css\">

</head>

<body>

    <div class=\"container mt-4\">
        <div class=\"d-flex justify-content-between align-items-center\">
            <h1>Seed Results</h1>
            <button id=\"runSeedBtn\" class=\"btn btn-primary\">Run Seeds</button>
        </div>
        <!-- Loader -->
        <div id=\"loader\" class=\"loader\"></div>
        <div id=\"resultsContainer\" class=\"mt-4\">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src=\"./assets/js/lib/bootstrap.bundle.min.js\"></script>
    <script src=\"./assets/js/lib/jquery.min.js\"></script>
    <!-- Coustom js-->
    <script src=\"./assets/js/seeds.js\"></script>

</body>

</html>", "seeds/index.html.twig", "E:\\xampp\\htdocs\\luma-new-back-end\\src\\pages\\seeds\\index.html.twig");
    }
}
