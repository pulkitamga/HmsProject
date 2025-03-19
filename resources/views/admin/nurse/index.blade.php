@extends('admin.layouts.master')

@section('main_section')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-3">Doctors List</h4>
            </div>

            <div class="table-responsive text-nowrap card-body">
                <table class="table table-hover" id="Datatable">
                    <thead>
                        <tr class="bg-light">
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nurses as $nurse)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nurse->user->name }}</td>
                                <td>{{ $nurse->user->email }}</td>
                                <td>
                                    @if (
                                        $nurse->userDetails &&
                                            $nurse->userDetails->specialization &&
                                            is_array(json_decode($nurse->userDetails->specialization)))
                                        @foreach (json_decode($nurse->userDetails->specialization) as $specialization)
                                            <li>{{ $specialization }}</li>
                                        @endforeach
                                    @else
                                        <li>No Specializations available</li>
                                    @endif

                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm viewDoctor" data-id="{{ $nurse->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="btn btn-primary btn-sm rounded-pill edit-user"
                                        data-id="{{ $nurse->id }}" data-name="{{ $nurse->name }}"
                                        data-email="{{ $nurse->email }}" data-role="{{ $nurse->role_id }}"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal"><i
                                            class="fa fa-edit"></i></button>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- View Doctor Modal -->
            <div id="viewDoctorModal" class="modal fade" tabindex="-1" aria-labelledby="viewDoctorLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Doctor Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID:</strong> <span id="viewDoctorId"></span></p>
                            <p><strong>Name:</strong> <span id="viewDoctorName"></span></p>
                            <p><strong>Email:</strong> <span id="viewDoctorEmail"></span></p>
                            <p><strong>Role:</strong><span id="viewDoctorRole"></span></p>
                            <p><strong>Specialization<span id="viewDoctorSpecialization"></span></strong></p>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.layouts.modal.edit_modal')

        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add or Edit Doctor
            $('#doctorForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();

                let method = $('#doctorId').val() ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                        errorMessage += '</ul></div>';
                        $('#messageBox').html(errorMessage);
                    }
                });
            });

            // View Doctor Details
            $('.viewDoctor').click(function() {
                let id = $(this).data('id');
                $.get('{{ url('admin/doctors') }}/' + id, function(response) {
                    if (response.success) {
                        $('#viewDoctorId').text(response.data.id);
                        $('#viewDoctorName').text(response.data.user.name);
                        $('#viewDoctorEmail').text(response.data.user.email);
                        $('#viewDoctorRole').text(response.data.user.role.name);
                        // Display Specialization
                        if (response.data.user.user_details) {
                            let specialization = response.data.user.user_details.specialization;

                            try {
                               
                                specialization = JSON.parse(specialization);
                            } catch (e) {
                                console.error("Error parsing specialization:", e);
                            }

                            if (Array.isArray(specialization)) {
                                $('#viewDoctorSpecialization').text(specialization.join(', '));
                            } else {
                                $('#viewDoctorSpecialization').text(
                                'N/A'); 
                            }
                        } else {
                            $('#viewDoctorSpecialization').text(
                            'N/A'); 
                        }

                        $('#viewDoctorModal').modal('show');

                    } else {
                        alert(response.message);
                    }
                });
            });

            // Delete Doctor
            function deleteDoctor(id) {
                if (confirm('Are you sure you want to delete this doctor?')) {
                    $.ajax({
                        url: '{{ url('admin/doctors') }}/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload();
                        }
                    });
                }
            }
        });
    </script>
@endsection
