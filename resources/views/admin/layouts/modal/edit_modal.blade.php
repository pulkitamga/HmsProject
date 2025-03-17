<div id="editUserModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    @method('Put')
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" id="edit_user_name" name="name">
                        <p class="text-danger"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User Email</label>
                        <input type="email" class="form-control" id="edit_user_email" name="email" readonly>
                        <p class="text-danger"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select name="user_role" class="form-control" id="edit_user_role">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger"></p>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".edit-user").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.getAttribute('data-id');
                    let userName = this.getAttribute('data-name');
                    let userEmail = this.getAttribute('data-email');
                    let userRole = this.getAttribute('data-role');
                    document.getElementById("edit_user_id").value = userId;
                    document.getElementById("edit_user_name").value = userName;
                    document.getElementById("edit_user_email").value = userEmail;
                    document.getElementById("edit_user_role").value = userRole;
                    new bootstrap.Modal(document.getElementById("editRoleModal")).show();
                })


            })
            document.getElementById("editUserForm").addEventListener("submit", function(e) {
                e.preventDefault();

                let userId = document.getElementById("edit_user_id").value;
                let userName = document.getElementById("edit_user_name").value;
                let userRole = document.getElementById("edit_user_role").value;

                fetch(`/admin/users/${userId}`, {
                        method: "POST", // Change to POST
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            _method: "PUT", // Laravel requires this for PUT requests via fetch
                            name: userName,
                            role: userRole
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        toastr.success(data.message);
                        location.reload();
                    })
                    .catch(error => console.error("Error:", error));
            });

        });

</script>