<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use Doctrine\DBAL\Connection;


final class UserService
{
    /** @var Connection */
    private $databaseConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function cleartoken(User $authenticatedUser): void
    {

        if (null === $authenticatedUser) {
            return;
        }

        /* @var User $authenticatedUser */
        /* @noinspection PhpUnhandledExceptionInspection */
        // Possible exception should not be caught, as we need to become aware that something broke here
        $this->databaseConnection->executeStatement(sprintf('
            DELETE FROM apicompare_refresh_tokens
            WHERE username = "%s"
        ', $authenticatedUser->getUserIdentifier()));
    }
}
