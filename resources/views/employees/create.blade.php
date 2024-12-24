@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<h1>Add New Employee</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('employees.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ old('name') }}" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br>

    <label for="birth_date">Birth Date:</label>
    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required><br>

    <label for="address">Address:</label>
    <textarea name="address" required>{{ old('address') }}</textarea><br>

    <label for="department_id">Department:</label>
    <select name="department_id" required>
        <option value="">Select Department</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
    </select><br>

    <label for="position_id">Position:</label>
    <select name="position_id" required>
        <option value="">Select Position</option>
        @foreach ($positions as $position)
            <option value="{{ $position->id }}">{{ $position->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Save</button>
</form>
@endsection
