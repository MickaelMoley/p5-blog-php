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

/* post/form/_form.html.twig */
class __TwigTemplate_5d6355be4ec39fec97cb6d7406055554405a1802e117acd596df3492f00806bf extends Template
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
        echo "<form action=\"\">

    <div>
        <label for=\"form[title]\">
            Titre de l'article
        </label>
        <input type=\"text\" name=\"form[title]\" value=\"";
        // line 7
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "title", [], "any", false, false, false, 7), "html", null, true);
        echo "\">
    </div>
    <div>
        Crée le ";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "created_at", [], "any", false, false, false, 10), "html", null, true);
        echo " - Modifié le ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "updated_at", [], "any", false, false, false, 10), "html", null, true);
        echo "
    </div>
    <div>
        <label for=\"form[excerpt]\">
           Extrait de l'article
        </label>
        <textarea name=\"form[excerpt]\" id=\"\" cols=\"30\" rows=\"10\">";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "excerpt", [], "any", false, false, false, 16), "html", null, true);
        echo "</textarea>
    </div>
    <div>
        <label for=\"form[content]\">
            Contenu de l'article
        </label>
        <textarea name=\"form[content]\" id=\"\" cols=\"30\" rows=\"10\">";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "content", [], "any", false, false, false, 22), "html", null, true);
        echo "</textarea>
    </div>
    <button type=\"submit\" name=\"btn_submit\">Enregistrer les modifications</button>
    <a href=\"/post/";
        // line 25
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "id", [], "any", false, false, false, 25), "html", null, true);
        echo "/delete\" name=\"btn_delete\">Supprimer cette article </a>

</form>";
    }

    public function getTemplateName()
    {
        return "post/form/_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 25,  71 => 22,  62 => 16,  51 => 10,  45 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<form action=\"\">

    <div>
        <label for=\"form[title]\">
            Titre de l'article
        </label>
        <input type=\"text\" name=\"form[title]\" value=\"{{ form.title }}\">
    </div>
    <div>
        Crée le {{ form.created_at }} - Modifié le {{  form.updated_at }}
    </div>
    <div>
        <label for=\"form[excerpt]\">
           Extrait de l'article
        </label>
        <textarea name=\"form[excerpt]\" id=\"\" cols=\"30\" rows=\"10\">{{ form.excerpt }}</textarea>
    </div>
    <div>
        <label for=\"form[content]\">
            Contenu de l'article
        </label>
        <textarea name=\"form[content]\" id=\"\" cols=\"30\" rows=\"10\">{{ form.content }}</textarea>
    </div>
    <button type=\"submit\" name=\"btn_submit\">Enregistrer les modifications</button>
    <a href=\"/post/{{ form.id }}/delete\" name=\"btn_delete\">Supprimer cette article </a>

</form>", "post/form/_form.html.twig", "/mnt/6AF0C09AF0C06E3F/xampp/htdocs/projets/P5_Blog_Mickael_Moley/src/BlogBundle/View/post/form/_form.html.twig");
    }
}
