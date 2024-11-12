<?php 
include "config.php";
$sql = "SELECT * FROM post 
        LEFT JOIN category ON post.category=category.cat_id 
        LEFT JOIN admin ON post.author_id=admin.user_id 
        ORDER BY post.publish_date DESC";
$run = mysqli_query($config, $sql);
$rows = mysqli_num_rows($run);
?>
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="style1.css">
   <link rel="stylesheet" href="card.css">
   <title>PEACHES</title>
</head>
<body>
   <nav class="navbar">
      <h1 class="logo"> PEACHES</h1>
      <ul class="nav-links">
         <li class="active"><a href="index.php">Home</a></li>
         <li class="ctn"><a href="contact.php">Contact</a></li>
         <li class="ctn"><a href="login.php"> Admin Login</a></li>
      </ul>
      <img src="./menu-btn.png" alt="" class="menu-btn">
   </nav>
   <header>
      <div class="header-content">
         <h2>Peaches</h2>
         <div class="line"></div>
         <h1>Fashion Fit, Life Fit</h1>
         <a href="#" class="ctn">Explore More</a>
      </div>
   </header>
   <section>
      <div class="title">
         <h1>Upcoming Designs</h1>
         <div class="line"></div>
      </div>
      <div class="row">
         <div class="col">
            <img src="" alt="">
         </div>
      </div>
   </section>
   <section id="destinations" class="cards-section">
      <?php
      if ($rows) {
          while ($result = mysqli_fetch_assoc($run)) {
      ?>
      <div class="card">
         <a href="single_post.php?id=<?= $result['post_id'] ?>">
         <?php $img = $result['post_image'] ?>
         <img src="admin/upload/<?= $img ?>" height="50%"> </a>
         <h3><?= ucfirst($result['post_title']) ?></h3>
         <h3><span>Rs.</span><?= ucfirst($result['price']) ?></h3>
         <h4><span><i class="fa fa-tag" aria-hidden="true"></i></span> <?= $result['cat_name'] ?></h4>
         <p><?= strip_tags(substr($result['post_body'], 0, 150)) . "..." ?></p>
         <button><a href="order.php?id=<?= $result['post_id'] ?>" class="">Order Now</a></button>
      </div>
      <?php
         }
      } ?>
   </section>
   <script>
      const menuBtn = document.querySelector('.menu-btn');
      const navlinks = document.querySelector('.nav-links');

      menuBtn.addEventListener('click', () => {
         navlinks.classList.toggle('mobile-menu');
      });
   </script>
</body>
</html>
