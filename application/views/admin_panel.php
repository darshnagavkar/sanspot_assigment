<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    
    <title>Admin Panel</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        #app {
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div id="app">
    <header class="mb-4">
        <h1>Admin Panel</h1> <a href="<?php echo base_url();?>personal_detail" class="btn btn-primary mt-4">Add User</a>
    </header>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Profile Image</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td><a href="#" @click="editProfile(user.id)"><img src = "<?php echo base_url();?>frontend/image/default.png" alt="profile Image"  style = "border-radius:60%" height ="50" width = "50"></a></td>
            <td>{{ user.email }}</td>
            <td>
                <button class="btn btn-warning" @click="editUser(user)">Edit</button>
                <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit User</h5>
            <form @submit.prevent="editing ? updateUser() : addUser()">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" v-model="formData.name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="formData.email" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>

    <div class="modal fade in" tabindex="-1" role="dialog" id="profilemodal" v-show="isModalVisible">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="() => uploadProfile()" enctype="multipart/form-data" id="profileform">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Upload Profile Picture</h5>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label> Choose Profile Picture:</label>
                <input type="file" name="picfile" v-model="formData.picfile" />
              </div>
              <br>
              <div class="modal-footer">
                <input type="submit" value="Upload file" name="upload" class="btn btn-primary"> <button type="button" class="btn btn-danger" @click="cancelModal">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
<script>
    var serverData = <?php echo json_encode($users); ?>;
</script>
<script>
new Vue({
    el: '#app',
    data: {
        users:serverData,
        formData: { name: '', email: ''},
        editing: false,
        editingUserId: null,
        isModalVisible: false,
        picData: {
          picfile: null
        },
        currentUserId: null,
    },
    
    methods: {
        
        editUser(user) {
            this.formData = { id:user.id,name: user.name, email: user.email };
            this.editing = true;
            this.editingUserId = user.id;
            this.currentUserId = user.id;
        },
        updateUser() {
            $.ajax({
                url: `<?php echo base_url();?>admin_panel/edit_user/${this.editingUserId}`,
                type: 'POST',
                dataType: 'json',
                data: this.formData,
                success: (response) => {
                    if(response.status == 200)
                    {
                        alert(response.msg);
                        location.reload();
                    }
                    else{
                        alert(response.msg);
                    }
                },
                error: (error) => {
                    console.error('Error updating user:', error);
                }
            });
        },
        deleteUser(userId) {
            $.ajax({
                url: `<?php echo base_url();?>admin_panel/delete_user/${userId}`,
                type: 'DELETE',
                success: () => {
                    this.users = this.users.filter(user => user.id !== userId);
                },
                error: (error) => {
                    console.error('Error deleting user:', error);
                }
            });
        },
        uploadProfile() {
          let picData = new FormData(document.getElementById('profileform'));
          $.ajax({
            url: `<?php echo base_url();?>admin_panel/upload_image/${this.currentUserId}`,
            method: "POST",
            data: picData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {
              if (data.status == 200) {
                alert(data.msg);
                window.location.href = "<?php echo base_url('admin_panel/admin')?>";
              } else if (data.status == 400) {
                alert(data.msg);
              }
            }
          });
        },
        cancelModal() {
          this.isModalVisible = false;
        },
        resetForm() {
            this.formData = { name: '', email: '' };
            this.editing = false;
            this.editingUserId = null;
        }
    }
});

function editProfile(userId) {
    this.currentUserId = userId;
    $('#profilemodal').modal('show');
    }
</script>

</body>
</html>
