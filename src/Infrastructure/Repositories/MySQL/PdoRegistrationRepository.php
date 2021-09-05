<?php declare(strict_types=1);

namespace App\Infrastructure\Repositories\MySQL;

use App\Domain\Entities\Registration;
use App\Domain\Exceptions\RegistrationNotFoundException;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\CPF;
use App\Domain\ValueObjects\Email;
use DateTimeImmutable;
use PDO;

final class PdoRegistrationRepository implements LoadRegistrationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param CPF $cpf
     * @return Registration
     * @throws RegistrationNotFoundException
     */
    public function loadByRegistrationNumber(CPF $cpf): Registration
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM `registrations` WHERE registration_number = :cpf"
        );
        $statement->execute([':cpf' => $cpf]);
        $record = $statement->fetch();

        if (!$record) {
            throw new RegistrationNotFoundException($cpf);
        }

        $registration = new Registration();
        $registration
            ->setName($record['name'])
            ->setEmail(new Email($record['email']))
            ->setRegistrationNumber(new CPF($record['registration_number']))
            ->setBirthDate(new DateTimeImmutable($record['birth_date']))
            ->setRegistrationAt(new DateTimeImmutable($record['created_at']));

        return $registration;
    }
}
