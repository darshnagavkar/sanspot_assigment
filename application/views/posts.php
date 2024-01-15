<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <header class="mb-4">
    <h1>Your Posts</h1>
  </header>

  <div class="card" v-for="post in posts" :key="post.id">
    <div class="card-body">
      <h5 class="card-title"> Title :{{ post.title }}</h5>
      <p class="card-text">{{ post.content }}</p>
    </div>
  </div>

  <button @click="goToAdminPanel" class="btn btn-primary mt-4">Go to Admin Panel</button>
</div>
<script>
    var serverData = <?php echo json_encode($posts); ?>;
</script>
<script>
new Vue({
  el: '#app',
  data: {
    posts:serverData
  },
  methods: {
    goToAdminPanel() {
      window.location.href = '<?php echo base_url();?>admin_panel/admin';
    }
}
});
</script>

</body>
</html>
