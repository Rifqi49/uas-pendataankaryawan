@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<h1>Employee List</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Position</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->department->name ?? 'N/A' }}</td>
                <td>{{ $employee->position->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('employees.edit', $employee->id) }}">Edit</a> |
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No employees found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
