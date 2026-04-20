<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/contrib/superfish/templates/superfish-menu-items.html.twig */
class __TwigTemplate_6b0d3c337716f66de2b076240129a46fb35aaec8db53e6ba637b714406f82a7d extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 22, "apply" => 23, "for" => 24, "if" => 26];
        $filters = ["escape" => 33, "spaceless" => 23];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'apply', 'for', 'if'],
                ['escape', 'spaceless'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 21
        echo "
";
        // line 22
        $context["classes"] = [];
        // line 23
        ob_start(function () { return ''; });
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menu_items"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 25
            echo "
  ";
            // line 26
            if ( !twig_test_empty($this->getAttribute($context["item"], "children", []))) {
                // line 27
                echo "    ";
                $context["item_class"] = ($this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "item_class", [])) . " menuparent");
                // line 28
                echo "    ";
                if ($this->getAttribute($context["item"], "multicolumn_column", [])) {
                    // line 29
                    echo "      ";
                    $context["item_class"] = ($this->sandbox->ensureToStringAllowed(($context["item_class"] ?? null)) . " sf-multicolumn-column");
                    // line 30
                    echo "    ";
                }
                // line 31
                echo "  ";
            }
            // line 32
            echo "
  <li";
            // line 33
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "attributes", [])), "html", null, true);
            echo ">
    ";
            // line 34
            if ($this->getAttribute($context["item"], "multicolumn_column", [])) {
                // line 35
                echo "    <div class=\"sf-multicolumn-column\">
    ";
            }
            // line 37
            echo "    ";
            if ( !twig_test_empty($this->getAttribute($context["item"], "children", []))) {
                // line 38
                echo "      ";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "link_menuparent", [])), "html", null, true);
                echo "
    ";
            } else {
                // line 40
                echo "      ";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "link", [])), "html", null, true);
                echo "
    ";
            }
            // line 42
            echo "    ";
            if ($this->getAttribute($context["item"], "multicolumn_wrapper", [])) {
                echo "<ul class=\"sf-multicolumn\">
    <li class=\"sf-multicolumn-wrapper ";
                // line 43
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "item_class", [])), "html", null, true);
                echo "\">
    ";
            }
            // line 45
            echo "    ";
            if ( !twig_test_empty($this->getAttribute($context["item"], "children", []))) {
                // line 46
                echo "      ";
                if ($this->getAttribute($context["item"], "multicolumn_content", [])) {
                    echo "<ol>";
                } else {
                    echo "<ul>";
                }
                // line 47
                echo "      ";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "children", [])), "html", null, true);
                echo "
      ";
                // line 48
                if ($this->getAttribute($context["item"], "multicolumn_content", [])) {
                    echo "</ol>";
                } else {
                    echo "</ul>";
                }
                // line 49
                echo "    ";
            }
            // line 50
            echo "    ";
            if ($this->getAttribute($context["item"], "multicolumn_wrapper", [])) {
                echo "</li></ul>";
            }
            // line 51
            echo "    ";
            if ($this->getAttribute($context["item"], "multicolumn_column", [])) {
                echo "</div>";
            }
            // line 52
            echo "  </li>

";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        $___internal_dc1ef4e136be2fc256769de11a9f2ccb88d5d29469cdf09ddc4f949c1c2bef39_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 23
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(twig_spaceless($___internal_dc1ef4e136be2fc256769de11a9f2ccb88d5d29469cdf09ddc4f949c1c2bef39_));
    }

    public function getTemplateName()
    {
        return "modules/contrib/superfish/templates/superfish-menu-items.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  167 => 23,  158 => 52,  153 => 51,  148 => 50,  145 => 49,  139 => 48,  134 => 47,  127 => 46,  124 => 45,  119 => 43,  114 => 42,  108 => 40,  102 => 38,  99 => 37,  95 => 35,  93 => 34,  89 => 33,  86 => 32,  83 => 31,  80 => 30,  77 => 29,  74 => 28,  71 => 27,  69 => 26,  66 => 25,  62 => 24,  60 => 23,  58 => 22,  55 => 21,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/superfish/templates/superfish-menu-items.html.twig", "C:\\xampp74\\htdocs\\divine-tour\\web\\modules\\contrib\\superfish\\templates\\superfish-menu-items.html.twig");
    }
}
