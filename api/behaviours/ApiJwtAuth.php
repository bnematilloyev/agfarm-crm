<?php

namespace api\behaviours;

use common\models\constants\AppConstants;
use Yii;
use yii\base\Action;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\web\User;

/**
 * ApiJwtAuth is a custom authentication method for Yii2 applications using JSON Web Tokens (JWT).
 *
 * This class extends the Yii AuthMethod class and provides authentication based on JWTs.
 *
 * @property array $exclude List of action IDs to be excluded from authentication.
 */
class ApiJwtAuth extends AuthMethod
{
    /**
     * @var array List of action IDs to be excluded from authentication.
     */
    public $exclude = [];

    /**
     * Authenticates the user based on the provided access token.
     *
     * @param User $user the user application component.
     * @param Request $request the current request.
     * @param Response $response the current response.
     * @return bool the authenticated user identity. false if authentication fails.
     * @throws UnauthorizedHttpException
     */
    public function authenticate($user, $request, $response): bool
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $accessToken = $headers->get("Authorization");
        if (!isset($accessToken)) $accessToken = $headers->get(AppConstants::CUSTOM_ACCESS_TOKEN_HEADER);
        if (!isset($accessToken)) $this->handleFailure($response);
        if (!str_starts_with($accessToken, AppConstants::BEARER_AUTH_HEADER_PREFIX)) $this->handleFailure($response);
        $accessToken = str_replace(AppConstants::BEARER_AUTH_HEADER_PREFIX, '', $accessToken);

        $service = Yii::$app->jwtService;

        if ($service->validateAccessToken($accessToken)) {
            $sub = $service->extractSubjectFromAccessToken($accessToken);
            $user = $this->getIdentity($sub);
            if (!isset($user)) {
                $this->handleFailure($response);
            }
            return Yii::$app->user->login($user);
        }
        return false;
    }

    protected function getIdentity($id): ?IdentityInterface
    {
        return \common\models\User::findOne($id);
    }

    /**
     * Performs actions before executing the requested action.
     *
     * @param Action $action the action to be executed.
     * @return bool whether the action should continue to be executed.
     * @throws UnauthorizedHttpException
     */
    public function beforeAction($action): bool
    {
        if (in_array($action->id, $this->exclude)) {
            return true;
        }

        $response = $this->response ?? Yii::$app->getResponse();
        $identity = $this->authenticate(
            $this->user ?? Yii::$app->getUser(),
            $this->request ?? Yii::$app->getRequest(),
            $response
        );

        if ($identity) {
            return true;
        } else {
            $this->challenge($response);
            $this->handleFailure($response);
        }
    }
}
