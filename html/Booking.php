<?php  
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header('Location:../html/Login.php');
    exit;
}
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brunch Booking</title>
    <link rel="stylesheet" href="../css/Booking.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@300;500&display=swap" rel="stylesheet">
</head>
<body>

 
    <section class="form-container">
      <!-- Cancellation Dropdown -->

<div class="cancel-reservation-dropdown">
    <button class="cancel-icon-btn" title="Cancel Reservation">
        <!-- Modern X Icon using SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>

    <div class="dropdown-content" id="cancelDropdown">
        <h4>Your Reservations</h4>
        <div id="userReservationsList">
            <!-- Will be populated by JS -->
        </div>
        <p id="noReservationsMsg">No active reservations.</p>
    </div>
</div>
        <div class="form-header">
            <h2>Reserve Your Table</h2>
            <p>We can't wait to host you for a memorable brunch!</p>
        </div>
        
        <div id="form-error" class="error" style="display: none;"></div>
        
        <form class="reservation-form" id="bookingForm" method="POST">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" name="full_name" placeholder="e.g. Muhammad Taha" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="e.g. taha@example.com" required>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="time">Time</label>
                        <select id="time" name="time" required>
                            <option value="" disabled selected>Select time</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="12:30">12:30 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="13:30">1:30 PM</option>
                            <option value="14:00">2:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="guests">Number of Guests</label>
                        <select id="guests" name="guests" required>
                            <option value="" disabled selected>Select guests</option>
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5 Guests</option>
                            <option value="6">6 Guests</option>
                            <option value="7">7 Guests</option>
                            <option value="8">8 Guests</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Ambiance Selection -->
            <div class="ambiance-section">
                <h3 class="section-title">Choose Your Ambiance</h3>
                <div class="ambiance-options">
                    <div class="ambiance-card selected" data-ambiance="indoor">
                        <div class="card-header">
                            <h3>Indoor Comfort</h3>
                        </div>
                        <div class="table-visual indoor"></div>
                        <div class="card-body">
                            <p>Cozy and elegant indoor seating.</p>
                        </div>
                    </div>
                    <div class="ambiance-card" data-ambiance="al-fresco">
                        <div class="card-header">
                            <h3>Outdoor Comfort</h3>
                        </div>
                        <div class="table-visual al-fresco"></div>
                        <div class="card-body">
                            <p>Enjoy the fresh air on our charming patio.</p>
                        </div>
                    </div>
                    <div class="ambiance-card" data-ambiance="rooftop">
                        <div class="card-header">
                            <h3>Rooftop Views</h3>
                        </div>
                        <div class="table-visual rooftop"></div>
                        <div class="card-body">
                            <p>Stunning city views from our rooftop oasis.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Table Selection -->
            <div class="table-selection">
                <h3 class="section-title">Select Your Table</h3>
                <p>Available tables are highlighted below. Please select one to reserve.</p>
                <div class="table-grid" id="tableGrid"></div>
            </div>
            
            <!-- Hidden fields -->
            <input type="hidden" id="selected_ambiance" name="ambiance" value="indoor">
            <input type="hidden" id="selected_table_id" name="table_id" value="">
            
            <button type="submit" class="submit-btn">Book My Brunch</button>
        </form>
    </section>
<script>
    document.querySelector('.cancel-icon-btn').addEventListener('click', function () {
        const dropdown = document.getElementById('cancelDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('cancelDropdown');
        const btn = document.querySelector('.cancel-icon-btn');
        if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });

</script>
    <script src="../js/Booking.js"></script>
</body>
</html>