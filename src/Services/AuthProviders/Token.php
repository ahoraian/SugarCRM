<?php declare(strict_types=1);

namespace App\Services\AuthProviders;

class Token
{
    /**
     * Token constructor.
     * @param string $accessToken
     * @param int $expiresIn
     * @param string $tokenType
     * @param string|null $scope
     * @param string|null $refreshToken
     * @param int|null $refreshExpiresIn
     * @param string|null $downloadToken
     */
    public function __construct(private string $accessToken,
                                private int $expiresIn,
                                private string $tokenType,
                                private ?string $scope,
                                private ?string $refreshToken,
                                private ?int $refreshExpiresIn,
                                private ?string $downloadToken)
    {
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     */
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * @param string|null $refreshToken
     */
    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return int|null
     */
    public function getRefreshExpiresIn(): ?int
    {
        return $this->refreshExpiresIn;
    }

    /**
     * @param int|null $refreshExpiresIn
     */
    public function setRefreshExpiresIn(?int $refreshExpiresIn): void
    {
        $this->refreshExpiresIn = $refreshExpiresIn;
    }

    /**
     * @return string|null
     */
    public function getDownloadToken(): ?string
    {
        return $this->downloadToken;
    }

    /**
     * @param string|null $downloadToken
     */
    public function setDownloadToken(?string $downloadToken): void
    {
        $this->downloadToken = $downloadToken;
    }

}