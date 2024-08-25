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

/* errors/404.html.twig */
class __TwigTemplate_e89e9d248b1afffebc3d688d95bbe8fa extends Template
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
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/404.css\">
</head>


<body translate=\"no\">
    <div class=\"container container-star\">
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
    </div>
    <div class=\"container container-bird\">
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"container-title\">
            <div class=\"title\">
                <div class=\"number\">4</div>
                <div class=\"moon\">
                    <div class=\"face\">
                        <div class=\"mouth\"></div>
                        <div class=\"eyes\">
                            <div class=\"eye-left\"></div>
                            <div class=\"eye-right\"></div>
                        </div>
                    </div>
                </div>
                <div class=\"number\">4</div>
            </div>
            <div class=\"subtitle\">Oops. <br><br> Request Not Found.</div>
            <a href=\"/\">Go back</a>
        </div>
    </div>



</body>

</html>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "errors/404.html.twig";
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
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Error</title>
    <!-- style -->
    <link rel=\"stylesheet\" href=\"/assets/css/404.css\">
</head>


<body translate=\"no\">
    <div class=\"container container-star\">
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-1\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
        <div class=\"star-2\"></div>
    </div>
    <div class=\"container container-bird\">
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"bird bird-anim\">
            <div class=\"bird-container\">
                <div class=\"wing wing-left\">
                    <div class=\"wing-left-top\"></div>
                </div>
                <div class=\"wing wing-right\">
                    <div class=\"wing-right-top\"></div>
                </div>
            </div>
        </div>
        <div class=\"container-title\">
            <div class=\"title\">
                <div class=\"number\">4</div>
                <div class=\"moon\">
                    <div class=\"face\">
                        <div class=\"mouth\"></div>
                        <div class=\"eyes\">
                            <div class=\"eye-left\"></div>
                            <div class=\"eye-right\"></div>
                        </div>
                    </div>
                </div>
                <div class=\"number\">4</div>
            </div>
            <div class=\"subtitle\">Oops. <br><br> Request Not Found.</div>
            <a href=\"/\">Go back</a>
        </div>
    </div>



</body>

</html>", "errors/404.html.twig", "D:\\xampp\\htdocs\\slim-skeleton\\src\\pages\\errors\\404.html.twig");
    }
}
