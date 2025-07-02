  <?php
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="../css/readmore.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
</style>
<body>
  
   <section id="Home">
     <Header class="header">
    <nav class="navbar">
    
      <div class="nav-left">
        <a href="../html/indexhome.php">Home</a>
        <a href="../html/Blog.php">Blog</a>
        <a href="../html/menu.php">Menu</a>
        <a href="../html/indexhome.php#Branch">Branch</a>
      </div>
  
   
     <a href="../html/indexhome.php"><img class="img1" src="../image/Place Your Logo Here (Double Click to Edit).png" alt="Logo"></a>
  
     <div class="nav-right">
        <a href="../html/indexhome.php#About">About</a>
        <a href="../html/indexhome.php#Contact">Contact</a>
         <?php if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'user'):?>
          
          <button class="book-btn22" onclick="window.location.href='../html/Booking.php'">Book Table</button>
            <div class="user-dropdown" id="userDropdown">
                    <div class="user-icon" id="userIcon">
                        <i class="fas fa-user"></i>
                    </div>
                    
                    <div class="dropdown-content">
                        <div class="dropdown-menu">

                             <div class="divider"></div>
                            
                            <a href="../html/logout.php" class="logout-btn"> 
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>                                               
                       </div>
                    </div>
                </div>
            </div>
         <?php else: ?>
          <!-- Show when not logged in -->
          <button class="Login" onclick="window.location.href='../html/Login.php'">Sign in</button>
        <?php endif; ?>
        <img class="btn1" src="../image/sun.svg" alt="Toggle Theme">

      </div>
    </nav>
  </Header>
   </section>

   <section id="more">
    <div class="container10">

    <div class="container11">
     <h1 class="heading">👋 Hi, we’re Brunch.</h1>
     <p class="para1">We started Brunch with one simple goal: to create a cozy space<br> where food feels like a hug. What began as a passion for great
        <br>meals and better company has grown into a place
        loved by foodies,<br> families, and friends alike.  
        At Brunch, we don’t just serve food — <br>we serve moments. The kind where laughter is loud, coffee is strong,<br> and pancakes come with a side of memories.
        Welcome to our table.<br> We’re glad you’re here.
    </p>
    </div>
    <div class="container12">
     <img src="../image/pexels-czapp-arpad-3647289-11010067.jpg">  
    </div>

    </div>
   </section>
   <div class="container300">
<div class="img2">
<img src="../image/Shape (3).png" alt="">
</div>

<img class="img4" src ="../image/Shape (2).png" alt="">


<div class="image-container">
<img class="img6" src="../image/shape orange.png" alt="">
</div>

<img class="img7" src="../image/Shape.png" alt="">


<img class="img8" src="../image/lines.png" alt="">
<br><br>

</div>
 <br><br>
 <br><br><br>


 <section id="Branch" class="Shop">

<div class="fext">Meet Our Culinary Experts</div>
<div class="mood">Discover the talented chefs behind our kitchen. Their passion turns every dish into a masterpiece.<br>Experience an
     exceptional service designed to make every visit memorable.</div>
    
   
     <span class="container4">
    <span class="container5">
        <span class="picture5">
            <img src="../image/young-bearded-man-his-work-place-cooking-vegetables.jpg" alt="">
        </span>
       <button class="button5">Stive Larson</button>
              <p class="button8">Master Chef</p>
        <div class="text4">Chef Stive Larson Known for his modern <br>techniques,Chef Stive turns simple<br> ingredients into culinary art.</div>

       </span>

       <span class="container6">
        <span class="picture6">
            <img src="../image/happy-young-cook-uniform-holding-salad.jpg" alt="">
        </span>
        <button class="button6">Alex Richmond</button>
         <p class="button9">Master Chef</p>
        <div class="text5">With 15+ years of experience, Chef Alex  <br> blends creativity with bold, flavorful dishes.</div>
       
       </span>

        <span class="container7">
        <span class="picture7">
            <img src="../image/studio-portrait-cook-man-with-fresh-vegetables-table.jpg" alt="">
        </span>
        <button class="button7">Alex Greenfield</button>
           <p class="button10">Head Chef</p>
        <div class="text6">Chef Alex Greenfieldbrings warmth and<br> elegance to every dish, inspired by her <br>Mediterranean roots.</div>
       </span>
    </span>
      </section>   

    <div class="reviews-container">
        <div class="section-header">
            <h2 class="section-title">Customer Reviews</h2>
            <p class="section-subtitle">What our guests say about their brunch experience</p>
        </div>
        
        <div class="reviews-row">
            <!-- Review 1 -->
            <div class="review-card">
                <div class="quote-icon">"</div>
                <div class="review-content">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">BrunchBoost has the most amazing avocado toast I've ever had! The atmosphere is so inviting and chic.</p>
                    <div class="reviewer-info">
                        <div class="reviewer-name">Sarah L.</div>
                        <div class="review-date">October 15, 2023</div>
                    </div>
                </div>
            </div>
            
            <!-- Review 2 -->
            <div class="review-card">
                <div class="quote-icon">"</div>
                <div class="review-content">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">The AI recommender is genius! It helped me discover my new favorite dish: the Berry Bliss Pancakes. Highly recommend!</p>
                    <div class="reviewer-info">
                        <div class="reviewer-name">Mike P.</div>
                        <div class="review-date">November 2, 2023</div>
                    </div>
                </div>
            </div>
            
            <!-- Review 3 -->
            <div class="review-card">
                <div class="quote-icon">"</div>
              
                <div class="review-content">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-text">A truly delightful brunch spot. The service was excellent and the food was fresh and flavorful. I'll be back!</p>
                    <div class="reviewer-info">
                        <div class="reviewer-name">Jessica Chen</div>
                        <div class="review-date">September 28, 2023</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<br>
<br><br>
      <section class="footer">
         <span class="container15">
            <img class="img20" src="../image/Place Your Logo Here (Double Click to Edit).png">
           <span class="text29" >
             <h3>Your Company</h3>
            <p>President street 25<br> New York, USA<br>12850</p>
            <a href="www.Brunch.com">www.Brunch.com</a>
            </span>    

            <div class="link1">
            <h3>Quick Links</h3>
            <a href="indexhome.php">Home</a>
            <a href="../html/indexhome.php #About">About</a>
            <a href="../html/indexhome.php #blog">Blog</a>
            <a href="../html/indexhome.php #Menu">Menu</a>
          
      
            
           </div>

           <div class="link2">
            <h3>Sitelink</h3>
            <a href="../html/indexhome.php #Shop">Shop</a>
            <a href="../html/indexhome.php #Contact">Contact</a>
            <a href="../html/Login.php">Sign in</a>
            <a href="../html/Signup.php">Sign up</a>
           </div>
           <div class="link3">
            <h3>Sitemap</h3>
            <a href="../html/readmore.php">Read More</a>
            <a href="../html/menu.php">Full Menu</a>
            <a href="../html/Booking.php">Booking Now</a>
            <a href="../html/Blog.php"> Full Blog</a>
           </div>
           <img class="img21" src="../image/Place Your Logo Here (Double Click to Edit).png">
           <p class="text20">Copyright c 2020 Freepik<br> Company S.L. All rights reserved.
           </p>
           <span class="img27">
           <img src="../image/facebook.png">
           <img src="../image/instagram.png">
           <img src="../image/twitter.png">
           </span>
         </span>
        </section>

    <script src="../js/node.js"></script>
      <script src="../js/dropdown.js"></script>
</body>
</html>