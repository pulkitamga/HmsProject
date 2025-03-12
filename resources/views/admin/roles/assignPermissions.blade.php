@extends('admin.layouts.master')

@section('main_section')
<form id="rolePermissionsForm">
    @csrf

    <!-- Select Role -->
    <label>Select Role:</label> 
    <select name="role_id" id="roleSelect">
        @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>

    <!-- Select Model -->
    <label>Select Model:</label> 
    <select id="modelSelect">
        <option value="">-- Select Model --</option>
        @foreach ($models as $model)
            <option value="{{ $model }}">{{ ucfirst($model) }}</option>
        @endforeach
    </select>

    <!-- Permissions (Loaded via AJAX) -->
    <div id="permissions-container">
        <h4>Permissions</h4>
        <div id="permissions-list"></div>
    </div>

    <button type="submit">Assign Permissions</button>
</form>

<script>
document.getElementById('modelSelect').addEventListener('change', async function() {
    let model = this.value;
    if (!model) return;

    let response = await fetch(`/admin/get-permissions/${model}`);
    let data = await response.json();

    let permissionsList = document.getElementById('permissions-list');
    permissionsList.innerHTML = ''; // Clear previous permissions

    if (data.permissions.length === 0) {
        permissionsList.innerHTML = "<p>No permissions found for this model.</p>";
        return;
    }

    data.permissions.forEach(permission => {
        let checkbox = `<label><input type="checkbox" name="permissions[]" value="${permission.id}"> ${permission.name}</label><br>`;
        permissionsList.innerHTML += checkbox;
    });
});

document.getElementById('rolePermissionsForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    let response = await fetch('/admin/assign-permissions', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    let result = await response.json();
    alert(result.message);
});
</script>
@endsection
