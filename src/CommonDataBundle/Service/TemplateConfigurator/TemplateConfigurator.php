<?php

namespace CommonDataBundle\Service\TemplateConfigurator;

use CommonDataBundle\Service\TemplateConfigurator\Exception\TemplateNotFoundException;
use CommonDataBundle\Service\TemplateConfigurator\Handler\TemplateHandlerInterface;
use Twig\Environment;

/**
 * Class TemplateConfigurator
 */
class TemplateConfigurator
{
    /**
     * @var TemplateHandlerInterface[]
     */
    private $templateHandlers = [];

    /**
     * @var TemplateHandlerInterface
     */
    private $commonHandler;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * TemplateConfigurator constructor.
     *
     * @param Environment              $templating
     * @param TemplateHandlerInterface $commonHandler
     */
    public function __construct(Environment $templating, TemplateHandlerInterface $commonHandler)
    {
        $this->templating = $templating;
        $this->commonHandler = $commonHandler;
    }

    /**
     * @param TemplateHandlerInterface $handler
     */
    public function addHandler(TemplateHandlerInterface $handler)
    {
        $this->templateHandlers[] = $handler;
    }

    /**
     * @param int $billingCarrierId
     *
     * @return TemplateHandlerInterface
     */
    private function getTemplateHandler(int $billingCarrierId): TemplateHandlerInterface
    {
        /** @var TemplateHandlerInterface $templateHandler */
        foreach ($this->templateHandlers as $templateHandler) {
            if ($templateHandler->canHandle($billingCarrierId)) {
                return $templateHandler;
            }
        }

        return $this->commonHandler;
    }

    /**
     * @param string $template
     * @param int    $billingCarrierId
     *
     * @param string $templatePath
     *
     * @return string
     *
     * @throws TemplateNotFoundException
     */
    public function getTemplate(string $template, int $billingCarrierId = 0, string $templatePath = '@App/Common')
    {
        $pathParts = explode("/", $templatePath);

        $rootTwigAlias = array_shift($pathParts);
        $relativePath = implode("/", $pathParts);

        $implTemplate = $this
            ->getTemplateHandler($billingCarrierId)
            ->getFullTemplatePath($rootTwigAlias, $relativePath, $template);

        if ($this->templating->getLoader()->exists($implTemplate)) {
            return $implTemplate;
        }

        $defaultTemplate = "$templatePath/{$template}.html.twig";

        if ($this->templating->getLoader()->exists($defaultTemplate)) {
            return $defaultTemplate;
        }

        throw new TemplateNotFoundException("Template '$template' wasn't found in implemented and default templates");
    }
}