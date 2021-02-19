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

/* post/edit.html.twig */
class __TwigTemplate_1ffc8bab87cdc452119d9858828cc861302ac2ddac14bd4a740516953e0decca extends Template
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
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <title>dazdazdaz</title>
</head>
<body>
    <h1>Modification d'un article</h1>
    ";
        // line 9
        $this->loadTemplate("post/form/_form.html.twig", "post/edit.html.twig", 9)->display($context);
        // line 10
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "post/edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 10,  47 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <title>dazdazdaz</title>
</head>
<body>
    <h1>Modification d'un article</h1>
    {% include 'post/form/_form.html.twig' %}
</body>
</html>", "post/edit.html.twig", "/mnt/6AF0C09AF0C06E3F/xampp/htdocs/projets/P5_Blog_Mickael_Moley/src/BlogBundle/View/post/edit.html.twig");
    }
}
