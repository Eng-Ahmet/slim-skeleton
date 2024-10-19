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

/* errors/The_website_under_maintenance.html.twig */
class __TwigTemplate_43ebffe759efa3a6ff0e9282a5fc1773 extends Template
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
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/The_website_under_maintenance.css\">
    <link rel=\"stylesheet\" href=\"/assets/css/fontawesome.min.css\">

</head>

<body>

    <div class=\"maintenance\">
        <div class=\"maintenance_contain\">
            <img src=\"/assets/images/defaults/maintenance.png\" alt=\"maintenance\">
            <span class=\"pp-infobox-title-prefix\">WE ARE COMING SOON</span>
            <div class=\"pp-infobox-title-wrapper\">
                <h3 class=\"pp-infobox-title\">The website under maintenance!</h3>
            </div>
            <div class=\"pp-infobox-description\">

                <p>
                    New features will be added and modified within a maximum of 24 hours
                </p>
            </div>
            <span class=\"title-text pp-primary-title\">We are social</span>
            <div class=\"pp-social-icons pp-social-icons-center pp-responsive-center\">
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Facebook\" aria-label=\"Facebook\" role=\"button\">
                        <i class=\"fa-brands fa-facebook\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Twitter\" aria-label=\"Twitter\" role=\"button\">
                        <i class=\"fa-brands fa-twitter\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Google Plus\" aria-label=\"Google Plus\"
                        role=\"button\">
                        <i class=\"fa-brands fa-google-plus\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"LinkedIn\" aria-label=\"LinkedIn\" role=\"button\">
                        <i class=\"fa-brands fa-linkedin\"></i> </a>
                </span>
            </div>
        </div>
    </div>
</body>

</html>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "errors/The_website_under_maintenance.html.twig";
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
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/The_website_under_maintenance.css\">
    <link rel=\"stylesheet\" href=\"/assets/css/fontawesome.min.css\">

</head>

<body>

    <div class=\"maintenance\">
        <div class=\"maintenance_contain\">
            <img src=\"/assets/images/defaults/maintenance.png\" alt=\"maintenance\">
            <span class=\"pp-infobox-title-prefix\">WE ARE COMING SOON</span>
            <div class=\"pp-infobox-title-wrapper\">
                <h3 class=\"pp-infobox-title\">The website under maintenance!</h3>
            </div>
            <div class=\"pp-infobox-description\">

                <p>
                    New features will be added and modified within a maximum of 24 hours
                </p>
            </div>
            <span class=\"title-text pp-primary-title\">We are social</span>
            <div class=\"pp-social-icons pp-social-icons-center pp-responsive-center\">
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Facebook\" aria-label=\"Facebook\" role=\"button\">
                        <i class=\"fa-brands fa-facebook\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Twitter\" aria-label=\"Twitter\" role=\"button\">
                        <i class=\"fa-brands fa-twitter\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <link itemprop=\"url\" href=\"#\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"Google Plus\" aria-label=\"Google Plus\"
                        role=\"button\">
                        <i class=\"fa-brands fa-google-plus\"></i>
                    </a>
                </span>
                <span class=\"pp-social-icon\">
                    <a itemprop=\"sameAs\" href=\"#\" target=\"_blank\" title=\"LinkedIn\" aria-label=\"LinkedIn\" role=\"button\">
                        <i class=\"fa-brands fa-linkedin\"></i> </a>
                </span>
            </div>
        </div>
    </div>
</body>

</html>", "errors/The_website_under_maintenance.html.twig", "D:\\xampp\\htdocs\\hwai\\src\\pages\\errors\\The_website_under_maintenance.html.twig");
    }
}
