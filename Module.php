<?php

namespace amnah\yii2\user;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * User module
 *
 * @author amnah <amnah.dev@gmail.com>
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Module version
     */
    protected $version = "0.9.95";

    /**
     * @var string Alias for module
     */
    public $alias = "@user";

    /**
     * @var bool If true, users are required to enter an email
     */
    public $requireEmail = true;

    /**
     * @var bool If true, users are required to enter a username
     */
    public $requireUsername = false;

    /**
     * @var bool If true, users can enter an email. This is automatically set to true if $requireEmail = true
     */
    public $useEmail = true;

    /**
     * @var bool If true, users can enter a username. This is automatically set to true if $requireUsername = true
     */
    public $useUsername = true;

    /**
     * @var bool If true, users can log in using their email
     */
    public $loginEmail = true;

    /**
     * @var bool If true, users can log in using their username
     */
    public $loginUsername = true;

    /**
     * @var int Login duration
     */
    public $loginDuration = 2592000; // 1 month

    /**
     * @var array|string|null Url to redirect to after logging in. If null, will redirect to home page. Note that
     *                        AccessControl takes precedence over this (see [[yii\web\User::loginRequired()]])
     */
    public $loginRedirect = null;

    /**
     * @var array|string|null Url to redirect to after logging out. If null, will redirect to home page
     */
    public $logoutRedirect = null;

    /**
     * @var bool If true, users will have to confirm their email address after registering (= email activation)
     */
    public $emailConfirmation = true;

    /**
     * @var bool If true, users will have to confirm their email address after changing it on the account page
     */
    public $emailChangeConfirmation = true;

    /**
     * @var string Reset password token expiration (passed to strtotime())
     */
    public $resetExpireTime = "2 days";

    /**
     * @var string Login via email token expiration (passed to strtotime())
     */
    public $loginExpireTime = "15 minutes";

    /**
     * @var string Email view path
     */
    public $emailViewPath = "@user/mail";

    /**
     * @var string Force translation
     */
    public $forceTranslation = false;

    /**
     * @var array Model classes, e.g., ["User" => "amnah\yii2\user\models\User"]
     * Usage:
     *   $user = Yii::$app->getModule("user")->model("User", $config);
     *   (equivalent to)
     *   $user = new \amnah\yii2\user\models\User($config);
     *
     * The model classes here will be merged with/override the [[getDefaultModelClasses()|default ones]]
     */
    public $modelClasses = [];

    /**
     * Get module version
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // check for valid email/username properties
        $this->checkModuleProperties();

        // set up i8n
        if (empty(Yii::$app->i18n->translations['user'])) {
            Yii::$app->i18n->translations['user'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'forceTranslation' => $this->forceTranslation,
            ];
        }

        // override modelClasses
        $this->modelClasses = array_merge($this->getDefaultModelClasses(), $this->modelClasses);

        // set alias
        $this->setAliases([
            $this->alias => __DIR__,
        ]);
    }

    /**
     * Check for valid email/username properties
     */
    protected function checkModuleProperties()
    {
        // set use fields based on required fields
        if ($this->requireEmail) {
            $this->useEmail = true;
        }
        if ($this->requireUsername) {
            $this->useUsername = true;
        }

        // get class name for error messages
        $className = get_called_class();

        // check required fields
        if (!$this->requireEmail && !$this->requireUsername) {
            throw new InvalidConfigException("{$className}: \$requireEmail and/or \$requireUsername must be true");
        }
        // check login fields
        if (!$this->loginEmail && !$this->loginUsername) {
            throw new InvalidConfigException("{$className}: \$loginEmail and/or \$loginUsername must be true");
        }
        // check email fields with emailConfirmation/emailChangeConfirmation is true
        if (!$this->useEmail && ($this->emailConfirmation || $this->emailChangeConfirmation)) {
            $msg = "{$className}: \$useEmail must be true if \$email(Change)Confirmation is true";
            throw new InvalidConfigException($msg);
        }

        // ensure that the "user" component is set properly
        // this typically causes problems in the yii2-advanced app when people set it in
        // "common/config" instead of "frontend/config" and/or "backend/config"
        //   -> this results in users failing to login without any feedback/error message
        $userComponent = Yii::$app->get('user', false);
        if ($userComponent && !$userComponent instanceof \amnah\yii2\user\components\User) {
            throw new InvalidConfigException('Yii::$app->user is not set properly. It needs to extend \amnah\yii2\user\components\User');
        }
    }

    /**
     * Get default model classes
     */
    protected function getDefaultModelClasses()
    {
        // attempt to calculate user class based on user component
        //   (we do this because yii console does not have a user component)
        if (Yii::$app->get('user', false)) {
            $userClass = Yii::$app->user->identityClass;
        } elseif (class_exists('app\models\User')) {
            $userClass = 'app\models\User';
        } else {
            $userClass = 'amnah\yii2\user\models\User';
        }

        return [
            'User' => $userClass,
            'Profile' => 'amnah\yii2\user\models\Profile',
            'Role' => 'amnah\yii2\user\models\Role',
            'UserToken' => 'amnah\yii2\user\models\UserToken',
            'UserAuth' => 'amnah\yii2\user\models\UserAuth',
            'ForgotForm' => 'amnah\yii2\user\models\forms\ForgotForm',
            'AjaxLoginForm' => 'amnah\yii2\user\models\forms\AjaxLoginForm',
            'LoginForm' => 'amnah\yii2\user\models\forms\LoginForm',
            'ResendForm' => 'amnah\yii2\user\models\forms\ResendForm',
            'UserSearch' => 'amnah\yii2\user\models\search\UserSearch',
            'LoginEmailForm' => 'amnah\yii2\user\models\forms\LoginEmailForm',
            'ProdCat' => 'amnah\yii2\user\models\ProdCat',
            'Product' => 'amnah\yii2\user\models\Product',
            'Magnets' => 'amnah\yii2\user\models\Magnets',
            'Prize' => 'amnah\yii2\user\models\Prize',
            'Orders' => 'amnah\yii2\user\models\Orders',
            'Receipt' => 'amnah\yii2\user\models\Receipt',
            'LogActivity' => 'amnah\yii2\user\models\LogActivity',
            'LogApp' => 'amnah\yii2\user\models\LogApp',
            'Points' => 'amnah\yii2\user\models\Points',
            'Transaction' => 'amnah\yii2\user\models\Transaction',
            'Filemanager' => 'amnah\yii2\user\models\Filemanager',
            'ProdCatSearch' => 'amnah\yii2\user\models\search\ProdCatSearch',
            'ProductSearch' => 'amnah\yii2\user\models\search\ProductSearch',
            'MagnetsSearch' => 'amnah\yii2\user\models\search\MagnetsSearch',
            'PrizeSearch' => 'amnah\yii2\user\models\search\PrizeSearch',
            'OrdersSearch' => 'amnah\yii2\user\models\search\OrdersSearch',
            'ReceiptSearch' => 'amnah\yii2\user\models\search\ReceiptSearch',
            'LogActivitySearch' => 'amnah\yii2\user\models\search\LogActivitySearch',
            'LogAppSearch' => 'amnah\yii2\user\models\search\LogAppSearch',
            'PointsSearch' => 'amnah\yii2\user\models\search\PointsSearch',
            'TransactionSearch' => 'amnah\yii2\user\models\search\TransactionSearch'
        ];
    }

    /**
     * Get object instance of model
     * @param string $name
     * @param array  $config
     * @return ActiveRecord
     */
    public function model($name, $config = [])
    {
        $config["class"] = $this->modelClasses[ucfirst($name)];
        return Yii::createObject($config);
    }

    /**
     * Modify createController() to handle routes in the default controller
     *
     * This is needed because of the way we map actions to "user/default/<action>".
     * We can't use module bootstrapping because that doesn't work when
     * `urlManager.enablePrettyUrl` = false.
     * Additionally, this requires one less step during installation
     *
     * @link https://github.com/amnah/yii2-user/issues/94
     *
     * "user", "user/default", "user/admin", "user/copy", and "user/auth" work like normal
     * any other "user/xxx" gets changed to "user/default/xxx"
     *
     * @inheritdoc
     */
    public function createController($route)
    {
        // check valid routes
        $validRoutes  = [$this->defaultRoute, "admin", "product", "product_cat", "magnets", "prize", "orders", "receipt",
                        "log_activity", "logapp", "points", "transaction", "trigger", "filemanager", "copy", "auth"];
        $isValidRoute = false;
        foreach ($validRoutes as $validRoute) {
            if (strpos($route, $validRoute) === 0) {
                $isValidRoute = true;
                break;
            }
        }

        return (empty($route) or $isValidRoute)
            ? parent::createController($route)
            : parent::createController("{$this->defaultRoute}/{$route}");
    }

    /**
     * Get a list of actions for this module. Used for debugging/initial installations
     */
    public function getActions()
    {
        return [
            "/{$this->id}" => "This 'actions' list. Appears only when <strong>YII_DEBUG</strong>=true, otherwise redirects to /login or /account",
            "/{$this->id}/admin" => "Admin CRUD",
            "/{$this->id}/product" => "Product CRUD",
            "/{$this->id}/product_cat" => "Category of product CRUD",
            "/{$this->id}/magnets" => "Magnets CRUD",
            "/{$this->id}/prize" => "Prize CRUD",
            "/{$this->id}/orders" => "Orders CRUD",
            "/{$this->id}/receipt" => "Receipt CRUD",
            "/{$this->id}/log_activity" => "log_activity CRUD",
            "/{$this->id}/transaction" => "transaction CRUD",
            "/{$this->id}/points" => "points CRUD",
            "/{$this->id}/filemanager" => "",
            "/{$this->id}/login" => "Login page",
            "/{$this->id}/logout" => "Logout page",
            "/{$this->id}/register" => "Register page",
            "/{$this->id}/login-email" => "Login page v2 (login/register via email link)",
            "/{$this->id}/login-callback?token=zzzzz" => "Login page v2 callback (after user clicks link in email)",
            "/{$this->id}/auth/login?authclient=facebook" => "Register/login via social account",
            "/{$this->id}/auth/connect?authclient=facebook" => "Connect social account to currently logged in user",
            "/{$this->id}/account" => "User account page (email, username, password)",
            "/{$this->id}/profile" => "Profile page",
            "/{$this->id}/forgot" => "Forgot password page",
            "/{$this->id}/reset?token=zzzzz" => "Reset password page. Automatically generated from forgot password page",
            "/{$this->id}/resend" => "Resend email confirmation (for both activation and change of email)",
            "/{$this->id}/resend-change" => "Resend email change confirmation (quick link on the 'Account' page)",
            "/{$this->id}/cancel" => "Cancel email change confirmation (quick link on the 'Account' page)",
            "/{$this->id}/confirm?token=zzzzz" => "Confirm email address. Automatically generated upon registration/email change",
        ];
    }
}
