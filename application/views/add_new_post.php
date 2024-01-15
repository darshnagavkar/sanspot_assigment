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

    <title>Your Post Page</title>
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
    <!-- Post Form -->
    <div class="mb-4">
        <h2>Add New Post  <a href="<?php echo base_url();?>post/show_posts" class="btn btn-primary">View Post</a></h2> 
        <form @submit.prevent="addPost">
            <div class="form-group">
                <label for="postTitle">Title:</label>
                <input type="text" id="postTitle" v-model="newPost.title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postContent">Content:</label>
                <textarea id="postContent" v-model="newPost.content" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>

</div>

<script>
    new Vue({
        el: '#app',
        data: {
            newPost: { title: '', content: '' }
        },
        methods: {
            addPost() {
                var title = this.newPost.title;
                var content = this.newPost.content;
                $.ajax({
                url: '<?php echo base_url();?>post/submit_post',
                type: 'POST',
                data: {title: title, content: content},
                success: function(response) {
                    console.log('Server response:', response.msg);
                    window.location.href="<?php echo base_url();?>post/show_posts";
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
