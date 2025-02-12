<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeDTO
{
    #[Assert\NotBlank(message: "El nombre es obligatorio.")]
    public string $firstName;

    #[Assert\NotBlank(message: "El apellido es obligatorio.")]
    public string $lastName;

    #[Assert\NotBlank(message: "El puesto es obligatorio.")]
    public string $position;

    #[Assert\NotBlank(message: "La fecha de nacimiento es obligatoria.")]
    #[Assert\Date(message: "La fecha de nacimiento debe ser una fecha válida.")]
    public string $birthDate;

    #[Assert\NotBlank(message: "El correo electrónico es obligatorio.")]
    #[Assert\Email(message: "El correo electrónico no es válido.")]
    public string $email;
}
