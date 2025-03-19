@extends('admin.layouts.master')

@section('main_section')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-3">Users</h4>
                {{--             
                <pre>{{ dd(auth()->user()->role->permissions) }}</pre> --}}
                {{-- <pre>{{ dd(auth()->user()->role, auth()->user()->role->permissions) }}</pre> --}}
                
                @if (auth()->user()->role_id == 1 || (!auth()->user()->role->permissions->isEmpty() && auth()->user()->hasPermission('add_User')))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                        <i class="fa fa-plus-circle me-2"></i> Add User
                    </button>
                @endif
            </div>

            <div class="table-responsive text-nowrap card-body">
                <table class="table table-hover" id="Datatable">
                    <thead>
                        <tr class="bg-light">
                            <th>Sno</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                <td>{{ $user->role->name ?? 'No Role Assigned' }}</td>
                                <td>+917582060792</td>
                                <td>
                                   
                                    <button class="btn btn-primary btn-sm rounded-pill edit-user"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-role="{{ $user->role_id }}"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal"><i
                                            class="fa fa-edit"></i></button>
                                    
                                    <button class="btn btn-danger btn-sm delete-user" data-id={{ $user->id }}>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="userModal" class="modal fade" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <p class="text-danger"></p>
                            </div>
                            <div class="col-md-3">
                                <div class="image-upload-container">
                                    <input type="file" name="image" class="d-none" id="imageUpload" accept="image/*"
                                        onchange="previewImage()">
                                    <label for="imageUpload" class="image-upload-label">
                                        <img id="profileImage" src="{{ asset('assets/img/user-dummy.jpg') }}"
                                            alt="Dummy Image" class="img-thumbnail">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="generatePassword()">Generate</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i id="passwordToggleIcon" class="fa fa-eye-slash"></i>
                                </button>

                            </div>
                            <p class="text-danger"></p>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="user_role" id="user_role" class="form-control"
                                onchange="updateEducationOptions();updateSpecializationOptions();">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Education</label>
                            <div id="education-checkbox-container"></div>
                            <input type="text" class="form-control mt-2" id="customEducation"
                                placeholder="Add Custom Education">
                            <button type="button" class="btn btn-sm btn-secondary mt-1"
                                onclick="addCustomEducation()">Add</button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Specialization</label>
                            <div id="specialization-checkbox-container"></div>
                            <div id="specialization-error-message" class="text-danger" style="display: none;"></div>
                            <!-- Error message -->
                            <input type="text" class="form-control mt-1" id="customSpecialization"
                                placeholder="Add Specialization">
                            <button type="button" class="btn btn-sm btn-secondary mt-1"
                                onclick="addCustomSpecialization()">Add</button>
                        </div>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Experience (years)</label>
                                <select class="form-control" name="experience" id="experience" onchange="validateDOB()">
                                    <option value="">How Many year Experience</option>
                                    <option value="5">5+ years</option>
                                    <option value="4">4+ years</option>
                                    <option value="3">3+ years</option>
                                    <option value="2">2+ years</option>
                                    <option value="1">1+ years</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob">
                                <p id="dobErrorMessage" class="text-danger" style="display: none;">Please select a valid
                                    date of birth (must be at least 22 years old based on experience).</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Joining Date</label>
                                <input type="date" class="form-control" id="joining_date" name="joining_date">
                            </div>

                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Blood Group</label>
                                <select class="form-control" id="blood_group" name="blood_group">
                                    <option value="">-- Select Blood Group --</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Dynamic Content) -->
     @include('admin.layouts.modal.edit_modal')

    <script>
        function generatePassword() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('password').value = password;
        }

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            }
        }

        $(document).ready(function() {
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: '{{ route('users.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#userModal').modal('hide');

                            // Reload the page after a short delay
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.error, 'Error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON);
                        if (xhr.status === 422) {
                            $('.text-danger').text('');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                console.log("Field:", key, "Error:", value[0])
                                let field = $("[name='" + key + "']");

                                if (field.is('select')) {
                                    field.closest('.mb-3').find('.text-danger').text(
                                        value[0]);
                                } else if (field.closest('.input-group').length) {
                                    field.closest('.input-group').parent().find(
                                            '.text-danger')
                                        .text(value[0]);
                                } else {
                                    field.next('.text-danger').text(value[0]);
                                }
                            });
                        } else {
                            toastr.error('An error occurred!', 'Error');
                        }
                    }
                });
            });
        });

        //edit user
        
        //Delete User
        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener("click", function(event) {
                if (event.target.classList.contains("delete-user") || event.target.closest(
                        ".delete-user")) {
                    let button = event.target.closest(".delete-user");
                    let userId = button.getAttribute("data-id");

                    console.log("User ID:", userId);
                    if (!confirm("Are you sure you want to delete this user?")) return;

                    fetch(`/admin/users/${userId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                                "Accept": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                toastr.success(data.message);
                                button.closest("tr").remove(); // Remove the table row
                            } else {
                                toastr.error("Error deleting user!"); // Fixed message
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            toastr.error("Something went wrong. Please try again.");
                        }); // Added missing semicolon
                }
            });
        });

        // Update Education Options with checkboxes
        function updateEducationOptions() {
            const role = document.getElementById('user_role').value;
            const educationContainer = document.getElementById('education-checkbox-container');

            // Clear existing checkboxes
            educationContainer.innerHTML = '';

            const educationOptions = {
                4: ["MBBS", "MD", "Doctorate (PhD)"],
                5: ["Diploma", "Bachelor's Degree", "Master's Degree"],
                6: ["Diploma", "Bachelor's Degree"],
                7: ["High School", "Diploma", "Bachelor's Degree", "Master's Degree"]
            };

            if (educationOptions[role]) {
                educationOptions[role].forEach((edu) => {
                    let checkboxContainer = document.createElement('div');
                    checkboxContainer.classList.add('form-check');

                    let checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.classList.add('form-check-input');
                    checkbox.name = 'education[]';
                    checkbox.value = edu;

                    let label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.textContent = edu;

                    checkboxContainer.appendChild(checkbox);
                    checkboxContainer.appendChild(label);

                    educationContainer.appendChild(checkboxContainer);
                });
            }
        }

        // Add Custom Education with Checkbox
        function addCustomEducation() {
            const educationContainer = document.getElementById('education-checkbox-container');
            const customEducationInput = document.getElementById('customEducation');

            let customEducation = customEducationInput.value.trim();
            if (customEducation) {
                let checkboxContainer = document.createElement('div');
                checkboxContainer.classList.add('form-check');

                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.classList.add('form-check-input');
                checkbox.name = 'education[]';
                checkbox.value = customEducation;
                checkbox.checked = true; // Automatically check the custom added option

                let label = document.createElement('label');
                label.classList.add('form-check-label');
                label.textContent = customEducation;

                checkboxContainer.appendChild(checkbox);
                checkboxContainer.appendChild(label);

                educationContainer.appendChild(checkboxContainer);

                customEducationInput.value = ''; // Clear input field
            }
        }

        // Update Specialization Options with checkboxes
        function updateSpecializationOptions() {
            const role = document.getElementById('user_role').value;
            const specializationContainer = document.getElementById('specialization-checkbox-container');
            //console.log('Role selected:', role); 
            specializationContainer.innerHTML = '';
            const specializationOptions = {
                4: ["Cardiologist", "Neurologist", "Orthopedic Surgeon", "Pediatrician", "Dermatologist",
                    "ENT Specialist", "Ophthalmologist", "General Physician", "Psychiatrist"
                ], // Doctors
                5: ["ICU Nurse", "Surgical Nurse", "Pediatric Nurse", "Oncology Nurse", "ER Nurse"], // Nurses
                6: ["Lab Technician", "Radiology Technician", "Anesthesia Technician",
                    "Pharmacy Technician"
                ], // Technicians
                7: ["Physiotherapist", "Speech Therapist", "Medical Transcriptionist"] // Therapists & Admin
            };

            if (specializationOptions[role]) {
                specializationOptions[role].forEach((spec) => {
                    let checkboxContainer = document.createElement('div');
                    checkboxContainer.classList.add('form-check');

                    let checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.classList.add('form-check-input');
                    checkbox.name = 'specialization[]';
                    checkbox.value = spec;

                    let label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.textContent = spec;

                    checkboxContainer.appendChild(checkbox);
                    checkboxContainer.appendChild(label);

                    specializationContainer.appendChild(checkboxContainer);
                });
            } else {
                errorMessage.style.display = 'block'; // Make the error message visible
                errorMessage.textContent = "No specialization options for this role. Please add your specialization.";
                console.log('No specialization options for this role'); // Debugging log if no options for the selected role
            }
        }

        // Trigger both education and specialization updates when role changes
        document.getElementById('user_role').addEventListener('change', function() {
            updateEducationOptions();
            updateSpecializationOptions();
        });


        // Add Custom Specialization with Checkbox
        function addCustomSpecialization() {
            const specializationContainer = document.getElementById('specialization-checkbox-container');
            const customSpecializationInput = document.getElementById('customSpecialization');

            let customSpecialization = customSpecializationInput.value.trim();
            if (customSpecialization) {
                let checkboxContainer = document.createElement('div');
                checkboxContainer.classList.add('form-check');

                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.classList.add('form-check-input');
                checkbox.name = 'specialization[]';
                checkbox.value = customSpecialization;
                checkbox.checked = true;

                let label = document.createElement('label');
                label.classList.add('form-check-label');
                label.textContent = customSpecialization;

                checkboxContainer.appendChild(checkbox);
                checkboxContainer.appendChild(label);

                specializationContainer.appendChild(checkboxContainer);

                customSpecializationInput.value = ''; // Clear input field
            }
        }

        function previewImage() {
            const file = document.getElementById('imageUpload').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                const image = document.getElementById('profileImage');
                image.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Function to validate the Date of Birth based on selected Experience
        function validateDOB() {
            const experience = document.getElementById('experience').value;
            const dobInput = document.getElementById('dob');
            const dobErrorMessage = document.getElementById('dobErrorMessage');

            if (experience && dobInput.value) {
                const currentDate = new Date();
                let minAge = 0;

                // Set the minimum age required based on selected experience
                switch (experience) {
                    case '5':
                        minAge = 30; // For 5+ years experience, the user should be at least 30 years old
                        break;
                    case '4':
                        minAge = 28; // For 4+ years experience, the user should be at least 28 years old
                        break;
                    case '3':
                        minAge = 26; // For 3+ years experience, the user should be at least 26 years old
                        break;
                    case '2':
                        minAge = 24; // For 2+ years experience, the user should be at least 24 years old
                        break;
                    case '1':
                        minAge = 22; // For 1+ years experience, the user should be at least 22 years old
                        break;
                }

                // Calculate the minimum Date of Birth based on the user's experience
                const minDOB = new Date();
                minDOB.setFullYear(currentDate.getFullYear() - minAge);

                // Check if the selected DOB is greater than the minimum required DOB
                const selectedDOB = new Date(dobInput.value);

                if (selectedDOB > minDOB || selectedDOB > currentDate) {
                    // Show the error message if the DOB is invalid (too recent)
                    dobErrorMessage.style.display = 'block';
                } else {
                    // Hide the error message if the DOB is valid
                    dobErrorMessage.style.display = 'none';
                }
            } else {
                // Hide the error message if either the experience or DOB is not selected
                dobErrorMessage.style.display = 'none';
            }
        }

        // Add event listener to ensure the DOB is validated when the user changes the date
        document.getElementById('dob').addEventListener('input', validateDOB);
    </script>
@endsection
