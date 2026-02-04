// Mobile Menu Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
    });
}

// Close menu when a link is clicked
const navLinks = document.querySelectorAll('.nav-menu a');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (navMenu) {
            navMenu.style.display = 'none';
        }
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Form submission
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);
        
        // Show success message (in production, this would send to a server)
        alert('Thank you for your message! We will get back to you soon.');
        contactForm.reset();
    });
}

// Scroll animation for elements
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe cards for animation
const cards = document.querySelectorAll('.feature-card, .service-item, .blog-card, .pricing-card');
cards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.3s ease';
    observer.observe(card);
});

// Responsive mobile menu styles
if (window.innerWidth <= 768) {
    if (navMenu) {
        navMenu.style.position = 'absolute';
        navMenu.style.top = '100%';
        navMenu.style.left = '0';
        navMenu.style.right = '0';
        navMenu.style.background = 'white';
        navMenu.style.flexDirection = 'column';
        navMenu.style.gap = '0';
        navMenu.style.display = 'none';
        navMenu.style.zIndex = '99';
        navMenu.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
    }
}

// Redirect CTA buttons to contact form
const ctaButtons = document.querySelectorAll('.cta-button, .view-all-btn');
ctaButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        // If button is a link, it will work naturally
        // If it's a button, we redirect to contact page
        if (button.tagName === 'BUTTON' && !button.form) {
            window.location.href = 'contact.html';
        }
    });
});

// Pricing card click handler
const pricingButtons = document.querySelectorAll('.pricing-card .cta-button');
pricingButtons.forEach(button => {
    button.addEventListener('click', () => {
        window.location.href = 'contact.html?package=' + button.closest('.pricing-card').querySelector('h2').textContent;
    });
});

// Newsletter subscription
const newsletterButtons = document.querySelectorAll('footer .footer-section button');
newsletterButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const input = button.previousElementSibling;
        if (input && input.type === 'email') {
            if (input.value) {
                alert('Thank you for subscribing! Check your email for confirmation.');
                input.value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        }
    });
});

// Counter animation for stats
const stats = document.querySelectorAll('.stat-item h3');
const animateCounter = (element) => {
    const finalValue = parseInt(element.textContent);
    let currentValue = 0;
    const increment = finalValue / 30;
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= finalValue) {
            element.textContent = finalValue + (element.textContent.includes('%') ? '%' : element.textContent.includes('+') ? '+' : '');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(currentValue) + (element.textContent.includes('%') ? '%' : element.textContent.includes('+') ? '+' : '');
        }
    }, 50);
};

// Observe stats section
if (stats.length > 0) {
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                stats.forEach(stat => {
                    animateCounter(stat);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    });
    
    stats.forEach(stat => {
        statsObserver.observe(stat.closest('.stat-item') || stat);
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Press 'C' to go to contact page
    if (e.key === 'c' && !e.ctrlKey && !e.metaKey) {
        window.location.href = 'contact.html';
    }
});

// Handle window resize for mobile menu
window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && navMenu) {
        navMenu.style.display = 'flex';
    }
});

console.log('The Wedding Company - Website loaded successfully!');
