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
  
  <title>Registration Form</title>
  <style>
    body {
      background-color: #f8f9fa;
    }
    #app {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }
    .step {
      display: none;
    }
    .step.active {
      display: block;
    }
    button {
      margin-right: 10px;
    }
  </style>
</head>
<body>

<div id="app" class="container">
  <div class="step" :class="{ active: step === 1 }">
    <h2 class="mb-4">Step 1: Personal Information</h2>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" class="form-control" v-model="formData.name" >
    </div>
    <button @click="nextStep" class="btn btn-primary">Next</button>
    <p class="text-center">Already Have An Account!&nbsp;<a href="<?php echo base_url('user_login/user')?>">Login Here</a></p>
  </div>

  <div class="step mt-4" :class="{ active: step === 2 }">
    <h2 class="mb-4">Step 2: Contact Information</h2>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" class="form-control" v-model="formData.email" >
    </div>
    <button @click="prevStep" class="btn btn-secondary">Previous</button>
    <button @click="nextStep" class="btn btn-primary">Next</button>
  </div>

  <div class="step mt-4" :class="{ active: step === 3 }">
    <h2 class="mb-4">Step 3:Password Set</h2>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" class="form-control" v-model="formData.password" >
    </div>
    <div class="form-group">
      <label for="cpassword">Confirm Password:</label>
      <input type="password" id="cpassword" name="cpassword" class="form-control" v-model="formData.cpassword" >
    </div>
    <button @click="prevStep" class="btn btn-secondary">Previous</button>
    <button @click="nextStep" class="btn btn-primary">Next</button>
  </div>

  <div class="step mt-4" :class="{ active: step === 4 }">
    <h2 class="mb-4">Step 4: Confirmation</h2>
    <p class="mb-3">Name: {{ formData.name }}</p>
    <p class="mb-3">Email: {{ formData.email }}</p>
    <button @click="prevStep" class="btn btn-secondary">Previous</button>
    <button @click="submitForm" class="btn btn-success">Submit</button>
  </div>
</div>

<script>
  new Vue({
    el: '#app',
    data: {
      step: 1,
      formData: {
        name: '',
        email: '',
        password: '',
        cpassword: ''
      }
    },
    methods: {
      nextStep() {
        if (this.step < 4) {
          this.step++;
        }
      },
      prevStep() {
        if (this.step > 1) {
          this.step--;
        }
      },
      submitForm() {

        if (!this.validateForm()) {
          return;
        }
        var name = this.formData.name;
        var email = this.formData.email;
        var password = this.formData.password;

        $.ajax({
          url: 'personal_detail/submit_info',
          type: 'POST',
          dataType:'JSON',
          data: {name: name, email: email, password: password},
          success: function(response) {
            //alert(response);
             //console.log('Server response:', response.msg);
            
            if(response.status == 200)
            {
              console.log(response.msg);
               window.location.href="user_login/user";
            }
            else
            {
              if(response.status == 400)
              {
                if(response.data.name != ''){ alert(response.data.name);}
                if(response.data.email != '') {alert(response.data.email);}
                if(response.data.password != '') { alert(response.data.password);}
                
              }
              
            }
            
          },
          error: function(error) {
            //alert("error");
            console.error('Error:', error);
          }
        });
      },
      validateForm() {
        if (!this.formData.name || !this.formData.email || !this.formData.password || !this.formData.cpassword) {
          alert('Please fill in all fields.');
          return false;
        }

        if (this.formData.password !== this.formData.cpassword) {
          alert('Passwords do not match.');
          return false;
        }

        return true;
      }
    }
  });
</script>

</body>
</html>
