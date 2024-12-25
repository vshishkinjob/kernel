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

/* ComponentDiagram.puml.twig */
class __TwigTemplate_07da3981b929ae95a4e7a5fe840490ba extends Template
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
        echo "@startuml
!include <C4/C4_Container>
skinparam svgLinkTarget _self
!define DEVICONS https://raw.githubusercontent.com/tupadr3/plantuml-icon-font-sprites/master/devicons
!define FONTAWESOME https://raw.githubusercontent.com/tupadr3/plantuml-icon-font-sprites/master/font-awesome
!include DEVICONS/react.puml
!include DEVICONS/postgresql.puml
!include FONTAWESOME/cloud.puml
!include DEVICONS/php.puml
!include DEVICONS/java.puml
LAYOUT_LEFT_RIGHT()

Container(spa,\"FrontEnd APP\", \"JS + ReactJS\", \$sprite=\"react\")
Container(framework,\"API BackEnd\", \"PHP + Slim Framework\", \$sprite=\"php\")
Rel(spa,framework,\"\",\"jsonRPC\")

";
        // line 17
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["methods"] ?? null));
        foreach ($context['_seq'] as $context["methodName"] => $context["methodPath"]) {
            // line 18
            echo "Container(";
            echo twig_escape_filter($this->env, $context["methodName"], "html", null, true);
            echo ",\"";
            echo twig_escape_filter($this->env, $context["methodName"], "html", null, true);
            echo "\",,\$link=\"";
            echo twig_escape_filter($this->env, $context["methodPath"], "html", null, true);
            echo "\")
Rel(framework,";
            // line 19
            echo twig_escape_filter($this->env, $context["methodName"], "html", null, true);
            echo ",)
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['methodName'], $context['methodPath'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "
@enduml";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "ComponentDiagram.puml.twig";
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
        return array (  76 => 21,  68 => 19,  59 => 18,  55 => 17,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("@startuml
!include <C4/C4_Container>
skinparam svgLinkTarget _self
!define DEVICONS https://raw.githubusercontent.com/tupadr3/plantuml-icon-font-sprites/master/devicons
!define FONTAWESOME https://raw.githubusercontent.com/tupadr3/plantuml-icon-font-sprites/master/font-awesome
!include DEVICONS/react.puml
!include DEVICONS/postgresql.puml
!include FONTAWESOME/cloud.puml
!include DEVICONS/php.puml
!include DEVICONS/java.puml
LAYOUT_LEFT_RIGHT()

Container(spa,\"FrontEnd APP\", \"JS + ReactJS\", \$sprite=\"react\")
Container(framework,\"API BackEnd\", \"PHP + Slim Framework\", \$sprite=\"php\")
Rel(spa,framework,\"\",\"jsonRPC\")

{% for methodName, methodPath in methods %}
Container({{methodName}},\"{{ methodName }}\",,\$link=\"{{ methodPath }}\")
Rel(framework,{{methodName}},)
{% endfor %}

@enduml", "ComponentDiagram.puml.twig", "/var/www/kernel-api-framework/ArtifactsGenerator/UmlComponentsGenerator/ComponentDiagram.puml.twig");
    }
}
