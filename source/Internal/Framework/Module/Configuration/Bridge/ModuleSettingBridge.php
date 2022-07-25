<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Event\SettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\SettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @deprecated will be removed in v7.0, we won't store module settings in the database.
 */
class ModuleSettingBridge implements ModuleSettingBridgeInterface
{
    /**
     * @var ModuleConfigurationDaoInterface
     */
    private $moduleConfigurationDao;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var SettingDaoInterface
     */
    private $settingDao;

    public function __construct(
        ContextInterface $context,
        ModuleConfigurationDaoInterface $moduleConfigurationDao,
        SettingDaoInterface $settingDao
    ) {
        $this->context = $context;
        $this->moduleConfigurationDao = $moduleConfigurationDao;
        $this->settingDao = $settingDao;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string $moduleId
     */
    public function save(string $name, $value, string $moduleId): void
    {
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $this->context->getCurrentShopId());
        $setting = $moduleConfiguration->getModuleSetting($name);
        $setting->setValue($value);
        $this->settingDao->save($setting, $moduleId, $this->context->getCurrentShopId());
        $this->moduleConfigurationDao->save($moduleConfiguration, $this->context->getCurrentShopId());
    }

    /**
     * @param string $name
     * @param string $moduleId
     * @return mixed
     */
    public function get(string $name, string $moduleId)
    {
        $configuration = $this->moduleConfigurationDao->get($moduleId, $this->context->getCurrentShopId());
        return $configuration->getModuleSetting($name)->getValue();
    }
}
