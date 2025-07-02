<?php
// Start session
session_start();
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/food.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Food Chain</title>
</head>
<style>
  </style>
  
<body>




  <section id="Home">
     <Header class="header">
    <nav class="navbar">
    
      <div class="nav-left">
        <a href="#Home">Home</a>
        <a href="#blog">Blog</a>
        <a href="#Menu">Menu</a>
        <a href="#Branch">Branch</a>
      </div>
  
     <a href="#Home"><img class="img1" src="../image/Place Your Logo Here (Double Click to Edit).png" alt="Logo"></a>
  
     <div class="nav-right">
        <a href="#About">About</a>
        <a href="#Contact">Contact</a>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'user'): ?>

         
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


  <div class="container300">
<div class="img2">
<img src="../image/Shape (3).png" alt="">
</div>
<div class="image3">
<img class="img3" src="../image/Place Your Image Here (Double Click to Edit).png" alt="">
</div>
<img class="img4" src ="-../image/Shape (2).png" alt="">
<img class="img5" src ="../image/Shape 1.png" alt="">

<div class="image-container">
<img class="img6" src="../image/shape orange.png" alt="">
</div>

<img class="img7" src="../image/Shape.png" alt="">

<div class="good">
<h1 class="meal">Have a <br>Nice Meal</h1></br>
</div>
<div class="good1">
<p class="food">Enjoy every bite, made with love and fresh ingredients.<br> From wholesome breakfasts to delightful desserts, your<br> perfect meal is just a click away-crafted to comfort,<br> nourish, and bring a little joy to your day.</p></br>
</div>
<div class="good2">
<button onclick="window.location.href='../html/Readmore.php'" class="button1">Read More</button>
</div>
<img class="img8" src="../image/lines.png" alt="">
<br><br>

</div>


  
<section id="blog" class="blog">


    <div class="text">Blog</div>
    <br>
    <br>
    <img class="img9" src="../image/Layer 1.png" alt="">
    <img class="img10" src="../image/Layer 2.png" alt="">
    <img class="img11" src="../image/Layer 3.png" alt="">

    <a class="first" href="Toast with Cheese and Veggies">Toast with Cheese and Veggies<br></a>
    <h5 class="desp">Crispy toast with cheese slices</h5></br>
    <div class="second">
    <a class="a1" href="Coffee and Pastry">Coffee and Pastry<br></a>
    <h5 class="des">Freshly brewed coffee with croissant</h5></br></div>
   
    <a class="third" href="Muesli with Strawberries">Muesli with Strawberries</p><br></a>
    <h5 class="dep">Healthy muesli topped with strawberries</h5></br><br>

    <img class="img12" src="../image/primary_image.jpg">
    <img class="img13" src="../image/Shape (3).png" alt="">
    <h1 class="bloghading"> Best Meal <br> Brunch in NYC</h1>
    <img class="img14" src="../image/Shape (2).png" alt="">
    <img class="img15" src="../image/lines.png" alt="">
    <img class="img16"src=  "../image/Shape.png" alt="">
    <p class="food1">When it comes to brunch in New York City, nothing beats<br> the combination of fresh ingredients, cozy ambiance and <br>exceptional flavors.Whether you're a local or just visiting,<br>NYC’s brunch scene offers something.For everyone
    Discover <br>the hidden gems where locals gather for their weekend <br>brunch.From artisan pastries to perfectly brewed coffee,<br>each bite tells a story of culinary passion and tradition.</p>
   <div class="link">
    <a class="a2" href="../html/Blog.php">Read Story</a></div>
    <br>
    <br><br><br>
</section>


<section id="Menu" class="Menu">
  <div class="text1">Menu</div>
    <div class="crip">Explore our menu featuring a selection of premium coffee options like Americano <br>and Long Black, paired with delicious brunch favorites including pancakes and fresh salads.</div>
   
    <div class="container2">
     
      <span class="container200">
        <span class="picture200">
            <img src="../image/photo-1504674900247-0877df9cc836.jpeg" alt="">
        </span>
               <span class="side200">
               <h2>Salmon Benedict</h2>
               <p>Classic Salmon Benedict<br> Poached eggs,smoked <br> salmon,and creamy<br> hollandaise sauce.</p>
               <button class="button200" onclick="window.location.href='../html/Booking.php'">Book Now</button>
               </span>
      </span>
  
      <span class="container201">
        <span class="picture201">
            <img src="../image/photo-1567620905732-2d1ec7ab7445.jpeg" alt="">
        </span>
               <span class="side201">
               <h2>Pancake Stack</h2>
               <p>Fluffy pancakes<br> layered with fresh<br> berries and drizzled<br> with maple syrup.</p>
               <<button class="button201" onclick="window.location.href='../html/Booking.php'">Book Now</button>
               </span>
      </span>

      <span class="container202">
        <span class="picture202">
            <img src="../image/photo-1608039829572-78524f79c4c7.jpeg" alt="">
        </span>
               <span class="side202">
               <h2>Eggs Benedict</h2>
               <p>Poached eggs, and<br> rich hollandaise <br>sauce on a toasted <br>English muffin.</p>
               <button class="button202" onclick="window.location.href='../html/Booking.php'">Book Now</button>
               </span>
      </span>

      <span class="container3">
        <span class="picture2">
            <img src="../image/coeffe 3.png" alt="">
        </span>
               <span class="side2">
               <h2>Cafe Latte</h2>
               <p>A smooth and creamy <br>blend of rich espresso <br>and steamed milk, topped <br>with a delicate layer of froth.<br></p>
               <button class="button4" onclick="window.location.href='../html/Booking.php'">Book Now</button>
               </span>
      </span>
    
     </div>

    <button onclick="window.location.href='../html/menu.php'" class="button100">See All</button>             
      
</section>

<br>
<br>
<br>

<section id="Branch" class="Shop">

<div class="fext">Branch</div>
<div class="mood">the perfect blend of comfort and taste at our store. Experience a warm atmosphere,delicious treats, <br>
    and exceptional service designed to make every visit memorable.</div>
    <span class="container4">
    <span class="container5">
        <span class="picture5">
            <img src="../image/photo-1559925393-8be0ec4767c8.jpg" alt="">
        </span>
       <button class="button5">Florida</button>

        <p class="text4">A lively spot in Florida with fresh, local <br>ingredients
            Great for a laid-back meal <br>near the beach.It's known for its fresh,<br> locally sourced ingredients.</p>
       <button type="button" class="button8">Visit Now</button>
       </span>

       <span class="container6">
        <span class="picture6">
            <img src="../image/32618a5b085aa8c76826e77c13c95724.webp" alt="">
        </span>
        <button class="button6">New York</button>
        <p class="text5">A lively spot in Florida with fresh, local <br>ingredients
            Great for a laid-back meal <br>near the beach.It's known for its fresh,<br> locally sourced ingredients.</p>
       <button type="button" class="button9">Visit Now</button>
       </span>

        <span class="container7">
        <span class="picture7">
            <img src="../image/photo-1555396273-367ea4eb4db5.jpg" alt="">
        </span>
        <button class="button7">Washington DC</button>

        <p class="text6">A lively spot in Florida with fresh, local <br>ingredients
            Great for a laid-back meal <br>near the beach.It's known for its fresh,<br> locally sourced ingredients.</p>
       <button type="button" class="button10">Visit Now</button>
       </span>
    </span>
      </section>


    <br>
     <br>
     <br>
     <br><br>

   <div class="container">
        <section class="events-section">
            <h2 class="section-title">Upcoming Events</h2>
            
            <div class="slider-container">
                <div class="slider">
                    <div class="slides">
                        <div class="slide">
                            <div class="slide-image">
                                <img src="../image/glenov-brankovic-e4B5AvA7Jqo-unsplash.jpg">
                            </div>
                            <div class="slide-content">
                                <h3 class="slide-title">Mother's Day Special Brunch</h3>
                                <p class="slide-subtitle">Celebrate the most important woman in your life with our gourmet brunch experience</p>
                                <div class="slide-details">
                                    <div class="detail">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>July 10, 2025</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-clock"></i>
                                        <span>10:00 AM - 2:00 PM</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>The Brunch Restaurant</span>
                                    </div>
                                </div>
                                <a href="../html/Booking.php" class="cta-button">Reserve Your Table</a>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="slide-image">
                                <img src="../image/siyuan-g_V2rt6iG7A-unsplash.jpg">
                            </div>
                            <div class="slide-content">
                                <h3 class="slide-title">Mother's Day 20% Off Brunch</h3>
                                <p class="slide-subtitle">Special discount for all mothers on their special day</p>
                                <div class="slide-details">
                                    <div class="detail">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>July 10, 2025</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-clock"></i>
                                        <span>10:00 AM - 2:00 PM</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-tag"></i>
                                        <span>20% Discount for Mothers</span>
                                    </div>
                                </div>
                                <a href="../html/Booking.php" class="cta-button">Book Now</a>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="slide-image">
                                <img src="../image/elevandos-medya-5roXmTjPA-s-unsplash.jpg">
                            </div>
                            <div class="slide-content">
                                <h3 class="slide-title">New Brunch Menu Launch</h3>
                                <p class="slide-subtitle">Introducing our seasonal menu with fresh, locally-sourced ingredients</p>
                                <div class="slide-details">
                                    <div class="detail">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>July 10 - August 31, 2025</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-clock"></i>
                                        <span>Every Weekend</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-tag"></i>
                                        <span>15% Off Opening Week</span>
                                    </div>
                                </div>
                                <a href="../html/menu.php" class="cta-button">View Menu</a>
                            </div>
                        </div>
                    </div>
                    <div class="slider-controls">
                        <button class="prev"><i class="fas fa-chevron-left"></i></button>
                        <button class="next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="nav-dots"></div>
            </div>
            
            
        </section>
    </div>


     <br>
     <br><br> <br><br>
     <section id="About" class="about">

       <div class="us">About us</div>
         <span class="container10">
            <video class="video1" autoplay loop playsinline controls muted>
           <source src="../image/untitled (Original) (1).mp4">
            </video>
            <span class="side6"> 
           <div class="company">Company Profile</div>
           <p class="profile">At Brunch, we create meals that delight your<br> senses Our passion for fresh,wholesome<br> ingredients ensures that every bite is a<br> moment of pure enjoyment.</p>
           <img class="fit" src="../image/facebook-instagram-twitter-logo-png-transparent-images-thumbnail-1697953629.png">          
         </span>
        </span>
        <img class="img88" src="../image/Untitled_design-removebg-preview.png" alt="">
    </section>
    <br>
    <br><br>
    <br><br>
    <br><br>
    <section id="Contact" class="contact">
           <div class="get">Contact</div>
              <span class="container11">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55641.2469667715!2d-74.00259718690833!3d40.
                710471967235144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62
                !2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1723800149999!5m2!1sen!2s" 
                width="600" height="450" style="border:0;" allowfullscreen="" 
                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                <form class="side15">
                 <div class="back">Contact us</div>

                 <input type="text" placeholder="Your Name">
                 <select name="Gender">
                    <option value="Gender">Gender</option>
                    <option value="Male">Male</option>
                   <option value="Female">Female</option> 
                 </select>
                 <textarea name="Message" placeholder="Messages"></textarea>
                 <button class="button15" type="submit">Send Message</button>
                </form>
            </span>
        </section>
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
            <a href="#About">About</a>
            <a href="#blog">Blog</a>
            <a href="#Menu">Menu</a>
          
      
            
           </div>

           <div class="link2">
            <h3>Sitelink</h3>
            <a href="#Shop">Shop</a>
            <a href="#Contact">Contact</a>
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
        
        <script src="../js/dropdown.js"></script>
        <script src="../js/node.js"></script>
         <script src="../js/slider.js"></script>
         <script>
        </body>
     </html>