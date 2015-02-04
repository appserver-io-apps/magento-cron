<?php

/**
 * AppserverIo_DummyCron_Model_Cron
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
 * Implements a dummy CRON functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 */

class AppserverIo_DummyCron_Model_Cron extends AppserverIo_DummyCron_Model_Abstract
{

    /**
     * A dummy method invoked by the appserver.io CRON SLSB.
     *
     * @return AppserverIo_DummyCron_Model_Cron
     */
    public function doSomething()
    {
        Mage::log(__METHOD__);
        return $this;
    }
}
