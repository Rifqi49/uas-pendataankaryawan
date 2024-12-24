<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll(): Collection
    {
        return Employee::with(['department', 'position'])->get();
    }

    public function getById(int $id): ?object
    {
        return Employee::with(['department', 'position'])->find($id);
    }

    public function create(array $data): object
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $employee = Employee::find($id);
        if ($employee) {
            return $employee->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $employee = Employee::find($id);
        if ($employee) {
            return $employee->delete();
        }
        return false;
    }
}