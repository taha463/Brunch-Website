document.addEventListener('DOMContentLoaded', function () {

function fetchUserReservations() {
    fetch('../html/fetch_reservations.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Fetched Reservations:', data); // 🔍 Debugging
            const list = document.getElementById('userReservationsList');
            const noReservationMsg = document.getElementById('noReservationsMsg');
            list.innerHTML = '';

            if (data.length === 0) {
                noReservationMsg.style.display = 'block';
                return;
            }

            noReservationMsg.style.display = 'none';

            data.forEach(res => {
                const card = document.createElement('div');
                card.className = 'reservation-card';
                card.innerHTML = `
                    <div class="reservation-details">
                        <strong>Table ${res.table_id}</strong><br>
                        Date: ${res.date} • Time: ${res.time}
                    </div>
                    <div class="reservation-actions">
                        <button class="cancel-table-btn" onclick="cancelReservation(${res.id})">Cancel</button>
                    </div>
                `;
                list.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error fetching reservations:', error);
            document.getElementById('noReservationsMsg').textContent = 'Failed to load reservations.';
        });
}

// Load reservations when page loads
fetchUserReservations();
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('date');
    dateInput.min = today;
    dateInput.value = today;

    // Initial values (default to 12:00 PM and Indoor for initial display)
    let selectedDate = today;
    let selectedTime = ''; // Default time
    let selectedGuests = 1;
    let selectedAmbiance = 'indoor';
    let selectedTable = null;

    // Get elements
    const timeSelect = document.getElementById('time');
    const guestsSelect = document.getElementById('guests');
    const tableGrid = document.querySelector('.table-grid');
    const errorDiv = document.getElementById('form-error');

    // Set initial form values
    document.getElementById('selected_ambiance').value = selectedAmbiance;
    timeSelect.value = selectedTime; // Set default time

    // Ambiance cards logic
    const ambianceCards = document.querySelectorAll('.ambiance-card');
    ambianceCards.forEach(card => {
        const value = card.getAttribute('data-ambiance');
        if (value === selectedAmbiance) {
            card.classList.add('selected');
        }

        card.addEventListener('click', function () {
            ambianceCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedAmbiance = this.getAttribute('data-ambiance');
            document.getElementById('selected_ambiance').value = selectedAmbiance;
            updateTableAvailability();
        });
    });
    window.cancelReservation = function(reservationId) {
    if (!confirm("Are you sure you want to cancel this reservation?")) return;

    fetch('../html/cancel_reservation.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: reservationId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Reservation canceled successfully.");
            fetchUserReservations(); // Refresh list
            updateTableAvailability(); // Free up table for others
        } else {
            alert("Failed to cancel reservation: " + (data.message || "Unknown error"));
        }
    })
    .catch(error => {
        console.error('Error canceling reservation:', error);
        alert("An error occurred while canceling your reservation.");
    });
};

    // Tables setup (12 tables: 3 of each capacity per ambiance)
    const allTables = [];
    const capacities = [2, 4, 6, 8]; // 4 capacities
    ['indoor', 'al-fresco', 'rooftop'].forEach(amb => {
        capacities.forEach(cap => {
            for (let i = 0; i < 3; i++) { // 3 tables per capacity
                allTables.push({
                    id: allTables.length + 1, // Unique IDs from 1 to 12
                    ambiance: amb,
                    capacity: cap
                });
            }
        });
    });

    // Render tables
    function renderTables(tables) {
        tableGrid.innerHTML = '';
        tables.forEach(table => {
            const isSufficientCapacity = table.capacity >= selectedGuests;
            const div = document.createElement('div');
            div.className = `table-item ${table.available && isSufficientCapacity ? 'available' : 'unavailable'}`;
            div.setAttribute('data-id', table.id);
            div.setAttribute('data-ambiance', table.ambiance);
            div.innerHTML = `
                <div class="table-number">Table ${table.id}</div>
                <div class="table-capacity">${table.capacity} Guests</div>
                <div class="availability-status ${table.available && isSufficientCapacity ? 'available-status' : 'unavailable-status'}">
                    ${table.available && isSufficientCapacity ? 'Available' : table.available ? 'Insufficient Capacity' : 'Booked'}
                </div>
            `;

            if (table.available && isSufficientCapacity) {
                div.addEventListener('click', function () {
                    if (selectedTable) selectedTable.classList.remove('selected');
                    this.classList.add('selected');
                    selectedTable = this;
                    document.getElementById('selected_table_id').value = table.id;
                });
            } else {
                div.addEventListener('click', () => alert(table.available ? 'This table has insufficient capacity.' : 'This table is already booked.'));
            }

            tableGrid.appendChild(div);
        });
    }

    // Fetch booked tables via AJAX
    function fetchBookedTables(date, time, ambiance, callback) {
        if (!date || !time || !ambiance) {
            callback([]);
            return;
        }
        const url = `fetch_booked_tables.php?date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}&ambiance=${encodeURIComponent(ambiance)}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    callback([]);
                } else {
                    callback(data.booked_tables);
                }
            })
            .catch(error => {
                console.error('Error fetching booked tables:', error);
                callback([]);
            });
    }

    // Initial load with booked tables for default date and time
    function initializeTables() {
        fetchBookedTables(selectedDate, selectedTime, selectedAmbiance, booked => {
            const tables = allTables
                .filter(t => t.ambiance === selectedAmbiance && t.capacity >= selectedGuests)
                .map(t => ({
                    ...t,
                    available: !booked.includes(t.id)
                }));
            renderTables(tables);
        });
    }

    // Update table availability
    function updateTableAvailability() {
        if (!selectedDate || !selectedTime || !selectedAmbiance) return;
        fetchBookedTables(selectedDate, selectedTime, selectedAmbiance, booked => {
            const tables = allTables
                .filter(t => t.ambiance === selectedAmbiance && t.capacity >= selectedGuests)
                .map(t => ({
                    ...t,
                    available: !booked.includes(t.id)
                }));
            renderTables(tables);
        });
    }

    // Input listeners
    dateInput.addEventListener('change', e => {
        selectedDate = e.target.value;
        updateTableAvailability();
    });

    timeSelect.addEventListener('change', e => {
        selectedTime = e.target.value;
        updateTableAvailability();
    });

    guestsSelect.addEventListener('change', e => {
        selectedGuests = parseInt(e.target.value);
        updateTableAvailability();
    });

    // Initial dropdown values
    selectedTime = timeSelect.value;
    selectedGuests = parseInt(guestsSelect.value) || 1;

    // Initial render with booked tables
    initializeTables();

    // Form submission handler
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const tableId = document.getElementById('selected_table_id').value;
        if (!tableId) {
            errorDiv.textContent = 'Please select a table';
            errorDiv.style.display = 'block';
            return;
        }

        // Re-check table availability before submitting
        fetchBookedTables(selectedDate, selectedTime, selectedAmbiance, booked => {
            if (booked.includes(parseInt(tableId))) {
                errorDiv.textContent = 'This table was just booked by someone else. Please select another table.';
                errorDiv.style.display = 'block';
                updateTableAvailability();
                return;
            }

            // Submit form via AJAX
            const formData = new FormData(this);
            fetch('process_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorDiv.style.display = 'none';
                    alert('Booking successful! Your table is now reserved.');
                    fetchUserReservations(email); // Refresh the cancel reservation dropdown
                    
                    // Update UI to show booked table
                    const bookedTableElement = document.querySelector(`.table-item[data-id="${tableId}"]`);
                    if (bookedTableElement) {
                        bookedTableElement.classList.remove('available', 'selected');
                        bookedTableElement.classList.add('unavailable');
                        bookedTableElement.querySelector('.availability-status').textContent = 'Booked';
                        bookedTableElement.querySelector('.availability-status').className = 'availability-status unavailable-status';
                        bookedTableElement.onclick = () => alert('This table is already booked.');
                    }
                    
                    // Clear all form fields for next user
                    document.getElementById('full-name').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('date').value = '';
                    document.getElementById('time').value = '';
                    document.getElementById('guests').value = '';
                    if (selectedTable) selectedTable.classList.remove('selected');
                    selectedTable = null;
                    document.getElementById('selected_table_id').value = '';
                    selectedDate = null;
                    selectedTime = null;
                    selectedGuests = 1;
                    selectedAmbiance = 'indoor';
                    document.getElementById('selected_ambiance').value = 'indoor';
                    ambianceCards.forEach(c => c.classList.remove('selected'));
                    document.querySelector(`.ambiance-card[data-ambiance="indoor"]`).classList.add('selected');
                    
                    // Refresh table availability
                    updateTableAvailability();
                } else {
                    errorDiv.textContent = data.error || 'Unknown error';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error submitting booking:', error);
                errorDiv.textContent = 'Booking failed due to a network error.';
                errorDiv.style.display = 'block';
            });
        });
    });
});