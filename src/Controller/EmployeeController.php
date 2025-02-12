<?php

namespace App\Controller;

use App\DTO\EmployeeDTO;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/employee', name: 'employee_')]
final class EmployeeController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(EmployeeRepository $employeeRepository): JsonResponse
    {
        $employees = $employeeRepository->findAll();
        $allEmployees = array_map(fn(Employee $employee) => $this->serializeEmployee($employee), $employees);

        return $this->json($allEmployees);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function getEmployee(int $id, EmployeeRepository $employeeRepository): JsonResponse
    {
        $employee = $employeeRepository->find($id);

        if (!$employee) {
            return new JsonResponse(['error' => 'Empleado no encontrado'], 404);
        }

        return $this->json($this->serializeEmployee($employee));
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $createEmployeeDTO = new EmployeeDTO();
        $createEmployeeDTO->firstName = $data['firstName'];
        $createEmployeeDTO->lastName = $data['lastName'];
        $createEmployeeDTO->position = $data['position'];
        $createEmployeeDTO->birthDate = $data['birthDate'];
        $createEmployeeDTO->email = $data['email'];

        $errors = $validator->validate($createEmployeeDTO);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $employee = new Employee();
        $employee->setFirstName($createEmployeeDTO->firstName);
        $employee->setLastName($createEmployeeDTO->lastName);
        $employee->setPosition($createEmployeeDTO->position);
        $employee->setBirthDate(new \DateTime($createEmployeeDTO->birthDate));
        $employee->setEmail($createEmployeeDTO->email);

        $em->persist($employee);
        $em->flush();

        return new JsonResponse(['message' => 'Empleado creado correctamente', 'employee' => $this->serializeEmployee($employee)], 201);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, Employee $employee, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $updateEmployeeDTO = new EmployeeDTO();
        $updateEmployeeDTO->firstName = $data['firstName'];
        $updateEmployeeDTO->lastName = $data['lastName'];
        $updateEmployeeDTO->position = $data['position'];
        $updateEmployeeDTO->birthDate = $data['birthDate'];
        $updateEmployeeDTO->email = $data['email'];

        $errors = $validator->validate($updateEmployeeDTO);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $employee->setFirstName($updateEmployeeDTO->firstName);
        $employee->setLastName($updateEmployeeDTO->lastName);
        $employee->setPosition($updateEmployeeDTO->position);
        $employee->setBirthDate(new \DateTime($updateEmployeeDTO->birthDate));
        $employee->setEmail($updateEmployeeDTO->email);

        $em->flush();

        return new JsonResponse(['message' => 'Empleado actualizado correctamente']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Employee $employee, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($employee);
        $em->flush();

        return new JsonResponse(['message' => 'Empleado eliminado correctamente']);
    }

    private function serializeEmployee(Employee $employee): array
    {
        return [
            'id' => $employee->getId(),
            'firstName' => $employee->getFirstName(),
            'lastName' => $employee->getLastName(),
            'position' => $employee->getPosition(),
            'birthDate' => $employee->getBirthDate()->format('d-m-Y'),
            'email' => $employee->getEmail()
        ];
    }
}
