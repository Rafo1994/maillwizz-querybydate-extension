<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * QuerybydateExt
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2015 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 */

class QuerybydateExt extends ExtensionInit
{
    // name of the extension as shown in the backend panel
    public $name = 'Query By Date';

    // description of the extension as shown in backend panel
    public $description = 'This extension enables querying between dates ';

    // current version of this extension
    public $version = '1.0';

    // minimum app version
    public $minAppVersion = '1.3.6.2';

    // the author name
    public $author = 'Rafael Vidas';

    // author website
    public $website = '';

    // contact email address
    public $email = 'rafael.vidas1@gmail.com';

    /**
     * in which apps this extension is allowed to run
     * '*' means all apps
     * available apps: customer, backend, frontend, api, console
     * so you can use any variation,
     * like: array('backend', 'customer'); or array('frontend');
     */
    public $allowedApps = array('*');

    /**
     * This is the reverse of the above
     * Instead of writing:
     * public $allowedApps = array('frontend', 'customer', 'api', 'console');
     * you could say:
     * public $notAllowedApps = array('backend');
     */
    public $notAllowedApps = array();

    // cli enabled
    // since cli is a special case, we need to explicitly enable it
    // do it only if you need to hook inside console hooks
    public $cliEnabled = true;

    // can this extension be deleted? this only applies to core extensions.
    protected $_canBeDeleted = true;

    // can this extension be disabled? this only applies to core extensions.
    protected $_canBeDisabled = true;

    /**
     * The run method is the entry point of the extension.
     * This method is called by mailwizz at the right time to run the extension.
     */
    public function run()
    {
        /**
         * The path alias: ext-example
         * refers to the path of this folder on the server
         * so if you to echo Yii::getPathOfAlias('ext-example'); you get something like:
         * /var/www/html/apps/common/extensions/example
         * the ext- prefix is automatically added to the extension folder name in order to avoid
         * name clashes with other mailwizz internals
         */
        Yii::import('ext-querybydate.common.models.*');

        /**
         * Please note that
         * Yii::getPathOfAlias('ext-example')
         * is the same thing as
         * $this->getPathAlias();
         *
         * So if you want to require something from the extension, you can do:
         * require $this->getPathAlias('vendor/library/something/something') . '.php';
         * where vendor is a folder in this extension.
         */


        /**
         * We can detect in which application we currently are
         * By using $this->isAppName('appName') mailwizz tels us if we are in that app
         * or not.
         * We say we are in certain application, when it is loaded by a user in the url.
         * For example accessing http://mailwizzapp.com/customer means we are in the customer app
         *
         * Knowing the above, we will hook inside the backend app as follows:
         */

	    if ( $this->isAppName( 'frontend' ) ) {
		    Yii::app()->controllerMap['querybydate'] = [
			    'class'     => 'ext-querybydate.frontend.controllers.QuerybydateController',
			    'extension' => $this,
		    ];
		    Yii::app()->urlManager->addRules( [
			    [ 'querybydate/index', 'pattern' => 'getsubscribersbydate/*' ],
		    ] );
	    }

        /**
         * Now we can continue only if the extension is enabled from its settings:
         */
        if ($this->getOption('enabled', 'no') != 'yes') {
            return;
        }

    }

    /**
     * This is an inherit method where we define the url to our settings page in backed.
     * Remember that we can click on an extension title to view the extension settings.
     * This method generates that link.
     */
    public function getPageUrl()
    {
        return Yii::app()->createUrl('ext_querybydate_settings/index');
    }

    /**
     * Code to run before enabling the extension.
     * Make sure to call the parent implementation
     *
     * Please note that if you return false here
     * the extension will not be enabled.
     */
    public function beforeEnable()
    {
        // your code here

        // call parent
        return parent::beforeEnable();
    }

    /**
     * Code to run after enabling the extension.
     * Make sure to call the parent implementation
     */
    public function afterEnable()
    {

        // call parent
        parent::afterEnable();
    }

    /**
     * Code to run before disable the extension.
     * Make sure to call the parent implementation
     *
     * Please note that if you return false here
     * the extension will not be disabled.
     */
    public function beforeDisable()
    {
        // your code here

        // call parent
        return parent::beforeDisable();
    }

    /**
     * Code to run after disable the extension.
     * Make sure to call the parent implementation
     */
    public function afterDisable()
    {
        // your code here

        // call parent
        parent::afterDisable();
    }

    /**
     * Code to run before delete the extension.
     * Make sure to call the parent implementation
     *
     * Please note that if you return false here
     * the extension will not be deleted.
     */
    public function beforeDelete()
    {
        // your code here

        // call parent
        return parent::beforeDelete();
    }

    /**
     * Code to run after delete the extension.
     * Make sure to call the parent implementation
     */
    public function afterDelete()
    {

        // call parent
        parent::afterDelete();
    }

    /**
     * This method is called to check if an extension needs update
     */
    public function checkUpdate()
    {

    }

    /**
     * This is called when the extension is actually updated
     * So update logic goes here.
     */
    public function update()
    {

    }
}
