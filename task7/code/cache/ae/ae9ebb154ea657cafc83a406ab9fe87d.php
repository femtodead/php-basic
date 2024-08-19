<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* main.tpl */
class __TwigTemplate_e0abd865af2a73441ea0e85d1722adc1 extends Template
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
        echo "<!DOCTYPE html>
<html>
    <head>
        <title>";
        // line 4
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
    </head>
    <body>
    <p>CSRF Token: ";
        // line 7
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? null), "html", null, true);
        echo "</p>
        ";
        // line 8
        if (($context["user_authorized"] ?? null)) {
            // line 9
            echo "        <p><a href=\"/user/logout\">Выход</a></p>

        ";
        }
        // line 12
        echo "        <div id=\"header\">
            ";
        // line 13
        $this->loadTemplate("auth-template.tpl", "main.tpl", 13)->display($context);
        // line 14
        echo "        </div>

        ";
        // line 16
        $this->loadTemplate(($context["content_template_name"] ?? null), "main.tpl", 16)->display($context);
        // line 17
        echo "    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "main.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 17,  68 => 16,  64 => 14,  62 => 13,  59 => 12,  54 => 9,  52 => 8,  48 => 7,  42 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "main.tpl", "/data/mysite.local/src/Domain/Views/main.tpl");
    }
}
