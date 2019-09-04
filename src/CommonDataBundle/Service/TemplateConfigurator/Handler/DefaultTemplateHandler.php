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
     * @param string $rootTwigPathAlias
     * @param string $templatePath
     * @param string $templateName
     *
     * @return string
     */
    public function getFullTemplatePath(string $rootTwigPathAlias, string $templatePath, string $templateName): string
    {
        return "$rootTwigPathAlias/$templatePath/$templateName.html.twig";
    }
}