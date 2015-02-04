<?php

/**
 * AppserverIo_DummyCron_Helper_Log
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 */

/**
 * Implements helper functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 */

class AppserverIo_DummyCron_Helper_Log
    extends Mage_Core_Helper_Abstract
{
    /**
     * @var AppserverIo_DummyCron_Helper_Config
     */
    protected $_configHelper;

    /**
     * Initialize config helper
     *
     * @param void
     * @return AppserverIo_DummyCron_Helper_Log
     */
    public function __construct()
    {
        $this->_configHelper = Mage::helper('appserverio_dummycron/config');
    }

    /**
     * Wrapper for logging only when the log functionality of the module is enabled.
     *
     * @param string $message
     * @param integer $level
     * @param string $file
     * @param bool $forceLog
     *
     * @return $this
     */
    public function log($message, $level = null, $file = '', $forceLog = false)
    {
        if ($this->_configHelper->getLoggingEnable()) {
            Mage::log($message, $level, $file, $forceLog);
        }

        return $this;
    }
}
