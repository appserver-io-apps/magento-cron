<?php

/**
 * AppserverIo\Apps\Magento\Cron\SessionBeans\CronSessionBean
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

namespace AppserverIo\Apps\Magento\Cron\SessionBeans;

use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Psr\EnterpriseBeans\TimerInterface;
use AppserverIo\Psr\EnterpriseBeans\TimedObjectInterface;

/**
 * A stateless session bean that invokes the magento CRON job.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class CronSessionBean implements TimedObjectInterface
{

    /**
     * The application instance that provides the entity manager.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Example method that should be invoked after constructor.
     *
     * @return void
     * @PostConstruct
     */
    public function initialize()
    {
        $this->getInitialContext()->getSystemLogger()->info(
            sprintf('%s has successfully been invoked by @PostConstruct annotation', __METHOD__)
        );
    }

    /**
     * The application instance providing the database connection.
     *
     * @return \AppserverIo\Psr\Application\ApplicationInterface The application instance
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Returns the initial context instance.
     *
     * @return \AppserverIo\Appserver\Application\Interfaces\ContextInterface The initial context instance
     */
    public function getInitialContext()
    {
        return $this->getApplication()->getInitialContext();
    }

    /**
     * Invokes the Magento CRON implementation.
     *
     * @return void
     * @throws \Exception
     */
    public function invoke()
    {

        try {

            // backup the old working directory
            $oldDir = getcwd();

            // change current directory to the applications intallation directory
            chdir($this->getApplication()->getWebappPath());

            // initialize Mage
            require_once $this->getApplication()->getWebappPath() . '/app/Mage.php';

            // query whether Magento has been installed or not
            if (\Mage::isInstalled() === false) {
                throw new \Exception('Magento is not installed yet, please complete install wizard first.');
            }

            // configure Magento to run the CRON jobs
            \Mage::app('admin')->setUseSessionInUrl(false);
            \Mage::getConfig()->init()->loadEventObservers('crontab');
            \Mage::app()->addEventArea('crontab');

            // dispatch the events that executes the CRON jobs
            \Mage::dispatchEvent('always');
            \Mage::dispatchEvent('default');

            // restore the old working directory
            chdir($oldDir);

            // log a mesage that Magento CRON has been invoked successfully
            $this->getInitialContext()->getSystemLogger()->debug(
                sprintf('%s has successfully been invoked at %s', __METHOD__, date('Y-m-d H:i:s'))
            );

        } catch (Exception $e) {
            $this->getInitialContext()->getSystemLogger()->error($e->__toString());
        }
    }

    /**
     * Method invoked by the container upon timer schedule that will
     * invoke the Magento CRON handler.
     *
     * This method will be invoked every minute!
     *
     * @param TimerInterface $timer The timer instance
     *
     * @return void
     * @Schedule(dayOfMonth = EVERY, month = EVERY, year = EVERY, second = ZERO, minute = EVERY, hour = EVERY)
     */
    public function invokedByTimer(TimerInterface $timer)
    {

        // let the timer service invoke the CRON
        $this->invoke();

        // log a message that the CRON has been invoked by the timer service
        $this->getInitialContext()->getSystemLogger()->debug(
            sprintf('%s has successfully been invoked by @Schedule annotation', __METHOD__)
        );
    }

    /**
     * Invoked by the container upon timer expiration.
     *
     * @param \AppserverIo\Psr\EnterpriseBeans\TimerInterface $timer Timer whose expiration caused this notification
     *
     * @return void
     **/
    public function timeout(TimerInterface $timer)
    {
        $this->getInitialContext()->getSystemLogger()->info(
            sprintf('%s has successfully been by interface', __METHOD__)
        );
    }
}
