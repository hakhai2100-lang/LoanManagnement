<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Employee</title>

    <style>
        body{font-family:Arial,Helvetica,sans-serif;padding:20px}
        .form-group{margin-bottom:12px}
        label{display:block;margin-bottom:4px;font-weight:600}
        input[type="text"],input[type="email"],input[type="date"],input[type="number"],select,textarea{
    a{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px}
            .error{color:#b9lclc;font-sixe:0l.95rem;margin-top:4px}
            actions{margin-top:16px}
    </style>
</head>
<body>

<h1>Create Employee</h1>

@if ($errors->any())
    <div style="border:1px solid #f5c6cb;background:#f8d7da;padding:10px;margin-bottom:16px;border-radius:4px">
        <strong>There are some problems with your input:</strong>
        <ul style="margin:8px 0 0 18px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="first_name">First name</label>
        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>

        @error('first_name')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="last_name">Last name</label>
        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>

        @error('last_name')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="">-- Select --</option>
            <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
        </select>

        @error('gender')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="date_of_birth">Date of birth</label>
        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required>

        @error('date_of_birth')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="position">Position</label>
        <input id="position" name="position" type="text" value="{{ old('position') }}">

        @error('position')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <input id="department" name="department" type="text" value="{{ old('department') }}">

        @error('department')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone') }}">

        @error('phone')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        @error('email')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3">{{ old('address') }}</textarea>

        @error('address')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="hire_date">Hire date</label>
        <input id="hire_date" name="hire_date" type="date" value="{{ old('hire_date') ?? date('Y-m-d') }}" required>

        @error('hire_date')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="salary">Salary</label>
        <input id="salary" name="salary" type="number" step="0.01" min="0" value="{{ old('salary') }}" required>

        @error('salary')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="Active" {{ old('status','Active')=='Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ old('status')=='Inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="Resigned" {{ old('status')=='Resigned' ? 'selected' : '' }}>Resigned</option>
            <option value="Terminated" {{ old('status')=='Terminated' ? 'selected' : '' }}>Terminated</option>
        </select>

        @error('status')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="photo">Photo (image)</label>
        <input id="photo" name="photo" type="file" accept="image/*">

        @error('photo')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="actions">
        <button type="submit">Create Employee</button>
        <a href="{{ route('employees.index') }}" style="margin-left:12px">Cancel</a>
    </div>

</form>

</body>
</html>