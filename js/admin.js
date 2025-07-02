document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing dashboard');

    // Check if CSS is applied
    const testSection = document.querySelector('.content-section');
    if (testSection && window.getComputedStyle(testSection).display !== 'none') {
        console.error('CSS rule .content-section { display: none; } is not applied!');
    }

    // Initialize dashboard
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    const dashboardSection = document.getElementById('dashboard');
    if (dashboardSection) {
        dashboardSection.classList.add('active');
        console.log('Dashboard section activated');
    } else {
        console.error('Dashboard section not found');
    }

    // Set active nav link
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    const dashboardLink = document.querySelector('.nav-links a[data-target="dashboard"]');
    if (dashboardLink) {
        dashboardLink.classList.add('active');
        console.log('Dashboard nav link activated');
    } else {
        console.error('Dashboard nav link not found');
    }

    // Navigation click handler
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            console.log(`Nav link clicked: ${this.getAttribute('data-target')}`);

            navLinks.forEach(a => a.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            this.classList.add('active');
            const targetId = this.getAttribute('data-target');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
                console.log(`Activated section: ${targetId}`);
            } else {
                console.error(`Section not found: ${targetId}`);
            }
        });
    });

    // Menu day filtering
    window.showMenu = function(day) {
        document.querySelectorAll('.menu-card').forEach(card => {
            card.classList.add('hidden');
        });
        document.getElementById(`${day}-menu`).classList.remove('hidden');

        // Update active button
        document.querySelectorAll('.filter-buttons button').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`.filter-buttons button[onclick="showMenu('${day}')"]`).classList.add('active');
    };
});