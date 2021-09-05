<?php declare(strict_types=1);

namespace App\Domain\Exceptions;

use App\Domain\ValueObjects\CPF;
use Exception;
use Throwable;

final class RegistrationNotFoundException extends Exception
{
    public function __construct(CPF $cpf, $code = 404, Throwable $previous = null)
    {
        $message = "Inscrição com cpf: {$cpf} não encontrado";

        parent::__construct($message, $code, $previous);
    }
}
