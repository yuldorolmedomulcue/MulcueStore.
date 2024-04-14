<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{ /*conexion con mysqli*/
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';  /*hace conexion con los valores y cantodad dde productos en mysqli*/
   } 

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MulcueStore</title>

   <link rel="icon" id="png" href="images/icon2.png">

<!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
    <link rel="stylesheet" href="http://localhost/bookstore/assets/css/style.css">

</head>
<body>

<?php include 'header.php';?> <!-- text sobre la tienda  -->

<section class="home">
    <div class="content">
      <h3>SHIPPING TO THE DOOR OF YOUR HOUSE.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">discover more</a>  <!-- btn ms info  -->
   </div>
</section>

<section class="products">     <!-- llamo las peliculas a home.php -->
   <h1 class="title">letest products</h1> <!--titulo ecnima de los productos-->
   <div class="box-container">

      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM  `products` LIMIT 6 ") or die ('query failed'); /*limite pelis*/
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>

     <form action="" method="post" class="box"> <!-- box- clase pra cuadro de imagen pa la peli -->
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""> <!-- imagenes de las pelis -->
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?>K</div> <!-- simbolos de precios-->
         <input type="number" min="1" name="product_quatity" value="1" class="qty" ><!-- cuadro # de productos a escoger-->
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>"><!-- valores debajo de los products -->
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn"> <!--btn de add_to_cart-->
     </form>

      <?php
       }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

<!--btn sobre mas info-->
   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a> <!--redirecciona a shop.php-->
   </div>


</section>

<section class="about">
   <div class="flex">
      <div class="image">
        <img src="images/about-img.jpg" alt=""> <!--imgen y texto debajo de los productos-->
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis ratione ex odit deserunt veniam quidem necessitatibus accusamus? Veniam, magnam cum?</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>
</section>

<section class="home-contact">
   <div class="content">
   <h3>have any questions?</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo doloremque reprehenderit ducimus consectetur incidunt architecto sequi modi in vero voluptatem.</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>


<?php include 'footer.php'?>
<!-- custom  js file link  -->
<script src="js/script.js"></script>
</body>
</html>
