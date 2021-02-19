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

/* index.html.twig */
class __TwigTemplate_0a9c910cc944c6974c2af5375aea97d9a372e72f09ca1450b3d9f914b366d2a1 extends Template
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
        echo "<html>
    <head>
        <meta charset=\"utf-8\">
    </head>
<body>
<h1>Hello world with ";
        // line 6
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "</h1>
<pre>";
        // line 7
        echo twig_escape_filter($this->env, ($context["params"] ?? null), "html", null, true);
        echo "</pre>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 7,  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<html>
    <head>
        <meta charset=\"utf-8\">
    </head>
<body>
<h1>Hello world with {{ name }}</h1>
<pre>{{ params }}</pre>
</body>
</html>", "index.html.twig", "/mnt/6AF0C09AF0C06E3F/xampp/htdocs/projets/P5_Blog_Mickael_Moley/src/BlogBundle/View/index.html.twig");
    }
}
