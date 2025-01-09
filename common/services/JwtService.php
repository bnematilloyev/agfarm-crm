<?php

namespace common\services;

use common\models\constants\AppConstants;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use Yii;
use yii\base\Component;

/**
 * Class JwtBearerFilter
 *
 * Yii2 component for handling JWT (JSON Web Token) authentication.
 *
 * @package common\services
 */
class JwtService extends Component
{
    /**
     * @var string The secret key used for signing JWT tokens.
     */
    private $accessSecretKey;

    /**
     * @var int The expiration time for access tokens in seconds.
     */
    private $accessTokenExpiration;

    /**
     * @var Key The key used for signing and verifying JWT tokens.
     */
    private $accessKey;

    /**
     * @var string The secret key used for signing JWT tokens.
     */
    private $refreshSecretKey;

    /**
     * @var int The expiration time for access tokens in seconds.
     */
    private $refreshTokenExpiration;

    /**
     * @var Key The key used for signing and verifying JWT tokens.
     */
    private $refreshKey;

    public function getTokenResult(bool $withRefreshToken = false): array
    {
        $user = Yii::$app->user->identity ?? null;
        if (!isset($user)) {
            return [];
        }
        $result = [
            'access_token' => $this->generateAccessToken($user->id),
            'expires_in' => Yii::$app->params['user.jwt.token.access.expiration'],
            'token_type' => rtrim(AppConstants::BEARER_AUTH_HEADER_PREFIX),
        ];
        if ($withRefreshToken) {
            $result['refresh_token'] = $this->generateRefreshToken($user->id);
        }
        return $result;
    }

    /**
     * JwtBearerFilter constructor.
     *
     * @param array $config The configuration array.
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        // Assign values from Yii application parameters.
        $this->accessSecretKey = Yii::$app->params['user.jwt.token.access.key'];
        $this->accessTokenExpiration = Yii::$app->params['user.jwt.token.access.expiration'];
        $this->accessKey = $this->getSignInKey($this->accessSecretKey);
        $this->refreshSecretKey = Yii::$app->params['user.jwt.token.refresh.key'];
        $this->refreshTokenExpiration = Yii::$app->params['user.jwt.token.refresh.expiration'];
        $this->refreshKey = $this->getSignInKey($this->refreshSecretKey);
    }

    /**
     * Validates an access JWT token.
     *
     * @param string $token The JWT token to validate.
     *
     * @return bool Whether the token is valid.
     */
    public function validateAccessToken(string $token): bool
    {
        return $this->validateToken($token, $this->accessKey);
    }

    /**
     * Validates a refresh JWT token.
     *
     * @param string $token The JWT token to validate.
     *
     * @return bool Whether the token is valid.
     */
    public function validateRefreshToken(string $token): bool
    {
        return $this->validateToken($token, $this->refreshKey);
    }

    /**
     * Validates a JWT token.
     *
     * @param string $token The JWT token to validate.
     *
     * @return bool Whether the token is valid.
     */
    private function validateToken(string $token, Key $key): bool
    {
        if (!$token) {
            return false;
        }
        if ($this->isTokenExpired($token, $key)) {
            return false;
        }
        $sub = $this->extractClaim($token, "sub", $key);
        if (!isset($sub)) {
            return false;
        }
        return true;
    }

    /**
     * Generates an access token for a user.
     *
     * @param string $subject The token's subject, such as user's id.
     * @param array $extraClaims Additional claims to include in the token.
     *
     * @return string The generated access token.
     */
    public function generateAccessToken(string $subject, array $extraClaims = []): string
    {
        return $this->generateToken($subject, $this->accessKey, $this->accessTokenExpiration, $extraClaims);
    }

    /**
     * Generates a access token for a user.
     *
     * @param string $subject The token's subject, such as user's id.
     * @param array $extraClaims Additional claims to include in the token.
     *
     * @return string The generated refresh token.
     */
    public function generateRefreshToken(string $subject, array $extraClaims = []): string
    {
        return $this->generateToken($subject, $this->refreshKey, $this->refreshTokenExpiration, $extraClaims);
    }

    /**
     * Generates a token
     *
     * @param string $subject The token's subject, such as user's id.
     * @param array $extraClaims Additional claims to include in the token.
     *
     * @return string The generated token.
     */
    private function generateToken(string $subject, Key $key, int $tokenExpiration, array $extraClaims = []): string
    {
        return JWT::encode([
            'sub' => $subject,
            'iat' => time(),
            'exp' => time() + $tokenExpiration,
            'data' => $extraClaims,
        ], $key->getKeyMaterial(), 'HS256');
    }

    /**
     * @param string $token The JWT token.
     *
     * @return string|null The user ID or null if not found.
     */
    public function extractSubjectFromAccessToken(string $token): ?string
    {
        return $this->loadUserFromToken($token, $this->accessKey);
    }

    /**
     * @param string $token The JWT token.
     *
     * @return string|null The user ID or null if not found.
     */
    public function extractSubjectFromRefreshToken(string $token): ?string
    {
        return $this->loadUserFromToken($token, $this->refreshKey);
    }

    /**
     * Extracts the subject from a JWT token and load user from this subject
     *
     * @param string $token The JWT token.
     *
     * @return string|null The user ID or null if not found.
     */
    private function loadUserFromToken(string $token, Key $key): ?string
    {
        $subject = $this->extractClaim($token, 'sub', $key);
        if (!isset($subject)) {
            return null;
        }
        return $subject;
    }

    /**
     * Checks if a token is expired.
     *
     * @param string $token The JWT token.
     *
     * @return bool Whether the token is expired.
     */
    private function isTokenExpired(string $token, Key $key): bool
    {
        return $this->extractExpiration($token, $key) < time();
    }

    /**
     * Extracts the expiration time from a JWT token.
     *
     * @param string $token The JWT token.
     *
     * @return int The expiration time.
     */
    private function extractExpiration(string $token, Key $key): ?int
    {
        return $this->extractClaim($token, 'exp', $key);
    }

    /**
     * Extracts a specific claim from a JWT token.
     *
     * @param string $token The JWT token.
     * @param string $claim The claim to extract.
     *
     * @return mixed The value of the claim or null if not found.
     */
    public function extractClaim(string $token, string $claim, Key $key)
    {
        $data = $this->extractAllClaims($token, $key);
        return $data->$claim ?? null;
    }

    /**
     * Extracts all claims from a JWT token.
     *
     * @param string $token The JWT token.
     *
     * @return false|stdClass The decoded claims or false if decoding fails.
     */
    public function extractAllClaims(string $token, Key $key)
    {
        try {
            return JWT::decode($token, $key);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieves the key used for signing and verifying JWT tokens.
     *
     * @return Key The key instance.
     */
    private function getSignInKey(string $secretKey): Key
    {
        $keyBytes = JWT::urlsafeB64Decode($secretKey);
        return new Key($keyBytes, 'HS256');
    }
}
