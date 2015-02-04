<?php

/**
 * AppserverIo\Apps\Magento\Cron\Servlets\InvokeCronServlet
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

namespace AppserverIo\Apps\Magento\Cron\Servlets;

use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Annotated servlet handling GET/POST requests.
 *
 * The GET requests only append the servlet name, defined in the @Route annotation,
 * to the response, whereas the POST requests send a message to the MQ, defined in
 * the queueSender property of the servlet.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/magento-cron
 * @link      http://www.appserver.io
 *
 * @Route(name="invokeCron",
 *        displayName="InvokeCron",
 *        description="Invoke the Magento CRON job.",
 *        urlPattern={"/invokeCron.do", "/invokeCron.do*"})
 */
class InvokeCronServlet extends HttpServlet
{

    /**
     * The CRON SSB instance.
     *
     * @var \AppserverIo\Apps\Magento\Cron\SessionBeans\UserProcessor
     * @EnterpriseBean(name="CronSessionBean")
     */
    protected $cron;

    /**
     * Handles a HTTP GET request and invokes the Magento CRON job.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @throws \AppserverIo\Psr\Servlet\ServletException Is thrown if the request method is not implemented
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
        $this->cron->invoke();
        $servletResponse->appendBodyStream('Successfully invoked Magento CRON job!');
    }
}
