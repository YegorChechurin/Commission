<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

abstract class AbstractSettingsManager
{
    protected $settings;

    public function __construct(SettingsFetcher $settingsFetcher)
    {
        $this->settings = $settingsFetcher->fetchSettings($this);
    }
}
