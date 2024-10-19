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

/* tests/show_tests_result.html.twig */
class __TwigTemplate_f2f5d7f32554915fa8ce4457892aa95f extends Template
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
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Test Results</title>
    <link href=\"/assets/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"/assets/css/phpunit.css\">
</head>

<body>
    <div class=\"container mt-4\">
        <div class=\"d-flex justify-content-between align-items-center\">
            <h1>Test Results</h1>
            <a href=\"/run-tests\" class=\"btn btn-primary btn-custom\">Run Tests</a>
        </div>
        <div class=\"mt-4\">
            ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["testsuites"]) || array_key_exists("testsuites", $context) ? $context["testsuites"] : (function () { throw new RuntimeError('Variable "testsuites" does not exist.', 19, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["suite"]) {
            // line 20
            yield "            ";
            $context["cardClass"] = ((((CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "errors", [], "any", false, false, false, 20) > 0) || (CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "failures", [], "any", false, false, false, 20) > 0))) ? ("card-errors") : ("card-no-errors"));
            // line 21
            yield "            <div class=\"card mb-3 ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["cardClass"]) || array_key_exists("cardClass", $context) ? $context["cardClass"] : (function () { throw new RuntimeError('Variable "cardClass" does not exist.', 21, $this->source); })()), "html", null, true);
            yield "\">
                <div class=\"card-header\">
                    Test Suite: ";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "name", [], "any", false, false, false, 23));
            yield "
                </div>
                <div class=\"card-body\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>File</td>
                                <td>";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "file", [], "any", false, false, false, 36));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Tests</td>
                                <td>";
            // line 40
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "tests", [], "any", false, false, false, 40));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Assertions</td>
                                <td>";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "assertions", [], "any", false, false, false, 44));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Errors</td>
                                <td>";
            // line 48
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "errors", [], "any", false, false, false, 48));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Failures</td>
                                <td>";
            // line 52
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "failures", [], "any", false, false, false, 52));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Skipped</td>
                                <td>";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "skipped", [], "any", false, false, false, 56));
            yield "</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>";
            // line 60
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "time", [], "any", false, false, false, 60));
            yield " seconds</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Test Cases:</h5>
                    ";
            // line 66
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["suite"], "testcases", [], "any", false, false, false, 66));
            foreach ($context['_seq'] as $context["_key"] => $context["case"]) {
                // line 67
                yield "                    ";
                $context["caseCardClass"] = (((CoreExtension::getAttribute($this->env, $this->source, $context["case"], "failure", [], "any", true, true, false, 67) || CoreExtension::getAttribute($this->env, $this->source, $context["case"], "error", [], "any", true, true, false, 67))) ? ("card-errors") : ("card-no-errors"));
                // line 68
                yield "                    <div class=\"card mb-2 ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["caseCardClass"]) || array_key_exists("caseCardClass", $context) ? $context["caseCardClass"] : (function () { throw new RuntimeError('Variable "caseCardClass" does not exist.', 68, $this->source); })()), "html", null, true);
                yield "\">
                        <div class=\"card-header\">
                            Test Case: ";
                // line 70
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "name", [], "any", false, false, false, 70));
                yield "
                        </div>
                        <div class=\"card-body\">
                            <table class=\"table table-bordered\">
                                <thead>
                                    <tr>
                                        <th>Attribute</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>File</td>
                                        <td>";
                // line 83
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "file", [], "any", false, false, false, 83));
                yield "</td>
                                    </tr>
                                    <tr>
                                        <td>Line</td>
                                        <td>";
                // line 87
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "line", [], "any", false, false, false, 87));
                yield "</td>
                                    </tr>
                                    <tr>
                                        <td>Class</td>
                                        <td>";
                // line 91
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "class", [], "any", false, false, false, 91));
                yield "</td>
                                    </tr>
                                    <tr>
                                        <td>Assertions</td>
                                        <td>";
                // line 95
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "assertions", [], "any", false, false, false, 95));
                yield "</td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td>";
                // line 99
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "time", [], "any", false, false, false, 99));
                yield " seconds</td>
                                    </tr>
                                    ";
                // line 101
                if (CoreExtension::getAttribute($this->env, $this->source, $context["case"], "failure", [], "any", true, true, false, 101)) {
                    // line 102
                    yield "                                    <tr>
                                        <td>Failure</td>
                                        <td>";
                    // line 104
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "failure", [], "any", false, false, false, 104), "html", null, true)));
                    yield "</td>
                                    </tr>
                                    ";
                }
                // line 107
                yield "                                    ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["case"], "error", [], "any", true, true, false, 107)) {
                    // line 108
                    yield "                                    <tr>
                                        <td>Error</td>
                                        <td>";
                    // line 110
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["case"], "error", [], "any", false, false, false, 110), "html", null, true)));
                    yield "</td>
                                    </tr>
                                    ";
                }
                // line 113
                yield "                                </tbody>
                            </table>
                        </div>
                    </div>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['case'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 118
            yield "                </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['suite'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 121
        yield "        </div>
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
        return "tests/show_tests_result.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  243 => 121,  235 => 118,  225 => 113,  219 => 110,  215 => 108,  212 => 107,  206 => 104,  202 => 102,  200 => 101,  195 => 99,  188 => 95,  181 => 91,  174 => 87,  167 => 83,  151 => 70,  145 => 68,  142 => 67,  138 => 66,  129 => 60,  122 => 56,  115 => 52,  108 => 48,  101 => 44,  94 => 40,  87 => 36,  71 => 23,  65 => 21,  62 => 20,  58 => 19,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Test Results</title>
    <link href=\"/assets/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"/assets/css/phpunit.css\">
</head>

<body>
    <div class=\"container mt-4\">
        <div class=\"d-flex justify-content-between align-items-center\">
            <h1>Test Results</h1>
            <a href=\"/run-tests\" class=\"btn btn-primary btn-custom\">Run Tests</a>
        </div>
        <div class=\"mt-4\">
            {% for suite in testsuites %}
            {% set cardClass = (suite.errors > 0 or suite.failures > 0) ? 'card-errors' : 'card-no-errors' %}
            <div class=\"card mb-3 {{ cardClass }}\">
                <div class=\"card-header\">
                    Test Suite: {{ suite.name|e }}
                </div>
                <div class=\"card-body\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>File</td>
                                <td>{{ suite.file|e }}</td>
                            </tr>
                            <tr>
                                <td>Tests</td>
                                <td>{{ suite.tests|e }}</td>
                            </tr>
                            <tr>
                                <td>Assertions</td>
                                <td>{{ suite.assertions|e }}</td>
                            </tr>
                            <tr>
                                <td>Errors</td>
                                <td>{{ suite.errors|e }}</td>
                            </tr>
                            <tr>
                                <td>Failures</td>
                                <td>{{ suite.failures|e }}</td>
                            </tr>
                            <tr>
                                <td>Skipped</td>
                                <td>{{ suite.skipped|e }}</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>{{ suite.time|e }} seconds</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Test Cases:</h5>
                    {% for case in suite.testcases %}
                    {% set caseCardClass = (case.failure is defined or case.error is defined) ? 'card-errors' : 'card-no-errors' %}
                    <div class=\"card mb-2 {{ caseCardClass }}\">
                        <div class=\"card-header\">
                            Test Case: {{ case.name|e }}
                        </div>
                        <div class=\"card-body\">
                            <table class=\"table table-bordered\">
                                <thead>
                                    <tr>
                                        <th>Attribute</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>File</td>
                                        <td>{{ case.file|e }}</td>
                                    </tr>
                                    <tr>
                                        <td>Line</td>
                                        <td>{{ case.line|e }}</td>
                                    </tr>
                                    <tr>
                                        <td>Class</td>
                                        <td>{{ case.class|e }}</td>
                                    </tr>
                                    <tr>
                                        <td>Assertions</td>
                                        <td>{{ case.assertions|e }}</td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td>{{ case.time|e }} seconds</td>
                                    </tr>
                                    {% if case.failure is defined %}
                                    <tr>
                                        <td>Failure</td>
                                        <td>{{ case.failure|nl2br|e }}</td>
                                    </tr>
                                    {% endif %}
                                    {% if case.error is defined %}
                                    <tr>
                                        <td>Error</td>
                                        <td>{{ case.error|nl2br|e }}</td>
                                    </tr>
                                    {% endif %}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>
            {% endfor %}
        </div>
    </div>
</body>

</html>", "tests/show_tests_result.html.twig", "D:\\xampp\\htdocs\\hwai\\src\\pages\\tests\\show_tests_result.html.twig");
    }
}
