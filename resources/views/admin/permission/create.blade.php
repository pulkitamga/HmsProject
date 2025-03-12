@extends('admin.layouts.master')

@section('main_section')
    <div class="container">
        <h2 class="mb-4">Add Permissions</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
        
            <!-- Model Selection -->
            <div class="mb-3">
                <label for="model_name" class="form-label">Select Model:</label>
                <select name="model_name" id="model_name" class="form-control" required>
                    @foreach ($models as $model)
                        <option value="{{ $model }}">{{ ucfirst($model) }}</option>
                    @endforeach
                </select>
            </div>
        
            <!-- Permission Selection -->
            <div class="mb-3">
                <label for="permissions" class="form-label">Select Permissions:</label>
                <select name="permissions[]" id="permissions" class="form-control" multiple required>
                    @foreach (['add', 'view', 'edit', 'delete'] as $action)
                        <option value="{{ $action }}"> {{ ucfirst($action) }} </option>
                    @endforeach
                </select>
            </div>
        
            <button type="submit" class="btn btn-primary">Save Permissions</button>
        </form>
        

    </div>
@endsection
