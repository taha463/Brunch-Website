document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelector('.slides');
            const prevButton = document.querySelector('.prev');
            const nextButton = document.querySelector('.next');
            const dotContainer = document.querySelector('.nav-dots');
            const eventCounter = document.getElementById('eventCounter');
            let currentSlide = 0;
            const totalSlides = document.querySelectorAll('.slide').length;
            
            // Create navigation dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('span');
                dot.classList.add('dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    showSlide(i);
                });
                dotContainer.appendChild(dot);
            }
            
            // Show slide function
            function showSlide(index) {
                currentSlide = index;
                if (currentSlide >= totalSlides) currentSlide = 0;
                if (currentSlide < 0) currentSlide = totalSlides - 1;
                
                slides.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots
                const dots = dotContainer.querySelectorAll('.dot');
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentSlide);
                });
                
                // Update counter
                eventCounter.innerHTML = `Event <span>${currentSlide + 1}</span> of ${totalSlides}`;
            }
            
            // Button event listeners
            prevButton.addEventListener('click', function() {
                showSlide(currentSlide - 1);
            });
            
            nextButton.addEventListener('click', function() {
                showSlide(currentSlide + 1);
            });
            
            // Auto-slide every 5 seconds
            setInterval(() => {
                showSlide(currentSlide + 1);
            }, 5000);
        });