<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Update Profile Image</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include Vue.js and jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

  <div id="app">
    <div class="modal fade in" tabindex="-1" role="dialog" id="profilemodal" v-show="isModalVisible">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="uploadProfile" enctype="multipart/form-data" id="profileform">
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
    new Vue({
      el: '#app',
      data: {
        isModalVisible: false,
        formData: {
          picfile: null
        }
      },
      methods: {
        uploadProfile() {
          let formData = new FormData(document.getElementById('profileform'));
          $.ajax({
            url: "<?php echo base_url();?>Home/upload_image",
            method: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {
              if (data.status == 200) {
                alert(data.msg);
                window.location.href = "<?php echo base_url('Home')?>";
              } else if (data.status == 400) {
                alert(data.msg);
              }
            }
          });
        },
        cancelModal() {
          this.isModalVisible = false;
        }
      }
    });

    function editProfile() {
      app.isModalVisible = true;
    }
  </script>

</body>

</html>
