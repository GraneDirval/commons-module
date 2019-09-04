<?php

namespace CommonDataBundle\Service\TemplateConfigurator\Handler;

/**
 * Interface TemplateHandlerInterface
 */
interface TemplateHandlerInterface
{
    /**
     * @param int $billingCarrierId
     *
     * @return bool
     */
    public function canHandle(int $billingCarrierId): bool;

    /**
     * @param string $templatePath
     * @param string $templateName
     *
     * @return string
     */
    public function getFullTemplatePath(string $templatePath, string $templateName): string;
}