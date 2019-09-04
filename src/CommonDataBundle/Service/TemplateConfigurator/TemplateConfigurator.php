<?php

namespace CommonDataBundle\Service\TemplateConfigurator;

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
     * @var string
     */
    private $rootTwigPathName;

    /**
     * TemplateConfigurator constructor.
     *
     * @param Environment              $templating
     * @param TemplateHandlerInterface $commonHandler
     * @param string                   $rootTwigPathName
     */
    public function __construct(
        Environment $templating,
        TemplateHandlerInterface $commonHandler,
        string $rootTwigPathName
    ) {
        $this->templating = $templating;
        $this->commonHandler = $commonHandler;
        $this->rootTwigPathName = "@$rootTwigPathName";
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
     * @param string $templatePath
     * @param string $template
     * @param int    $billingCarrierId
     *
     * @return string
     */
    public function getTemplate(string $templatePath, string $template, int $billingCarrierId = 0)
    {
        $implTemplate = $this
            ->getTemplateHandler($billingCarrierId)
            ->getFullTemplatePath($this->rootTwigPathName, $templatePath, $template);

        if ($this->templating->getLoader()->exists($implTemplate)) {
            return $implTemplate;
        }

        return "$this->rootTwigPathName/Common/{$template}.html.twig";
    }
}