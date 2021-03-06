<?php

/**
 * AppserverIo_DummyCron_IndexController
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
 * Implements abstract controller functionality for extension.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 */

class AppserverIo_DummyCron_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Standard action for rendering layout.
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
