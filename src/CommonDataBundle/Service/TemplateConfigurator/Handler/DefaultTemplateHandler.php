<?php

namespace CommonDataBundle\Service\TemplateConfigurator\Handler;

/**
 * Class DefaultTemplateHandler
 */
class DefaultTemplateHandler implements TemplateHandlerInterface
{
    /**
     * @param int $billingCarrierId
     *
     * @return bool
     */
    public function canHandle(int $billingCarrierId): bool
    {
        return true;
    }

    /**
     * @param string $templatePath
     * @param string $templateName
     *
     * @return string
     */
    public function getFullTemplatePath(string $templatePath, string $templateName): string
    {
        return "$templatePath/$templateName.html.twig";
    }
}