<?php

namespace CommonDataBundle\Entity\Interfaces;

interface CarrierInterface
{
    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @return string|null
     */
    public function getIsp(): ?string;

    /**
     * @return int
     */
    public function getBillingCarrierId(): int;

    /**
     * @return string
     */
    public function getCountryCode(): string;

    /**
     * @return int
     */
    public function getOperatorId(): int;

    /**
     * @return int
     */
    public function getSubscriptionPeriod(): int;

    /**
     * @return int
     */
    public function getTrialPeriod(): int;

    /**
     * @return int|null
     */
    public function getNumberOfAllowedSubscriptionsByConstraint(): ?int;

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string;

    /**
     * @param bool $isCapAlertDispatch
     *
     * @return CarrierInterface
     */
    public function setIsCapAlertDispatch(bool $isCapAlertDispatch): self;

    /**
     * @return bool
     */
    public function getIsCapAlertDispatch(): bool;

    /**
     * @param \DateTime $flushDate
     *
     * @return CarrierInterface
     */
    public function setFlushDate(\DateTime $flushDate): self;

    /**
     * Set defaultLanguage
     *
     * @param LanguageInterface $defaultLanguage
     *
     * @return CarrierInterface
     */
    public function setDefaultLanguage(LanguageInterface $defaultLanguage = null): self;

    /**
     * Get defaultLanguage
     *
     * @return LanguageInterface
     */
    public function getDefaultLanguage(): ?LanguageInterface;


    /**
     * @return bool
     */
    public function getIsCampaignsOnPause(): bool;

    public function getSubscribeAttempts();

    /**
     * @return bool
     */
    public function isOneClickFlow(): bool;
}