@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<h1>Edit Employee</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ old('name', $employee->name) }}" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email', $employee->email) }}" required><br>

    <label for="birth_date">Birth Date:</label>
    <input type="date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" required><br>

    <label for="address">Address:</label>
    <textarea name="address" required>{{ old('address', $employee->address) }}</textarea><br>

    <label for="department_id">Department:</label>
    <select name="department_id" required>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
        @endforeach
    </select><br>

    <label for="position_id">Position:</label>
    <select name="position_id" required>
        @foreach ($positions as $position)
            <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                {{ $position->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Update</button>
</form>
@endsection
