<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add Bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  
  <title>Login Form</title>
  <style>
    body {
      background-color: #f8f9fa;
    }
    #app {
      max-width: 500px;
      margin: auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
      margin-top: 50px;
    }
    button {
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div id="app">
  <h2 class="mb-4">Login Form</h2>
  <form @submit.prevent="login">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" class="form-control" v-model="username" >
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" class="form-control" v-model="password" >
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <p class="text-center">Not Have An Acoount &nbsp;<a href="<?php echo base_url('personal_detail')?>">Register Here</a></p>
  </form>

  <div v-if="message" class="mt-3 alert alert-danger">
    {{message }}
  </div>
</div>

<script>
new Vue({
  el: '#app',
  data: {
      username: '',
      password: '',
      message: ''
    
  },
  methods: {
    login() {

      if (!this.username || !this.password) {
        this.message = 'Please enter both username and password.';
        return;
      }

        var username = this.username;
        var password = this.password;
       // alert(username);
        $.ajax({
          url: '<?php echo base_url();?>user_login/validate_user',
          type: 'POST',
          data: { username: username, password: password},
          success: function(response) {
           alert('Login successful!');
           window.location.href="<?php echo base_url();?>post/add_post";
          },
          error: function(error) {
            console.error('Error:', error);
          }

        });
    }
  }
});
</script>

</body>
</html>
