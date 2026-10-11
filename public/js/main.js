/**
 * ══════════════════════════════════════════════════════════════════
 * ROHIT VERMA - PORTFOLIO INTERACTION ENGINE
 * Vanilla JavaScript (Theme management, Typing, Counters, Filters)
 * ══════════════════════════════════════════════════════════════════
 */

document.addEventListener('DOMContentLoaded', () => {

    /* === 1. AOS (ANIMATE ON SCROLL) INITIALIZATION === */
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            disable: 'mobile',
        });
    }

    /* === 2. NAVBAR BLUR ON SCROLL === */
    const navbar = document.querySelector('.navbar-glass');
    const handleNavbarScroll = () => {
        if (!navbar) return;
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };
    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll();

    /* === 3. THEME TOGGLE (BOOTSTRAP 5.3 data-bs-theme: DARK / LIGHT) === */
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const savedTheme = localStorage.getItem('portfolio-theme') || 'dark';

    const applyTheme = (theme) => {
        const activeTheme = (theme === 'light') ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', activeTheme);
        document.documentElement.setAttribute('data-theme', activeTheme);

        if (themeToggleBtn) {
            if (activeTheme === 'light') {
                themeToggleBtn.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
                themeToggleBtn.setAttribute('title', 'Switch to Dark Mode');
            } else {
                themeToggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
                themeToggleBtn.setAttribute('title', 'Switch to Light Mode');
            }
        }
        localStorage.setItem('portfolio-theme', activeTheme);
    };

    // Apply immediately
    applyTheme(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
            applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });
    }

    /* === 4. HERO SECTION TYPING ANIMATION === */
    const typingElement = document.getElementById('typingText');
    if (typingElement) {
        const phrases = [
            'Laravel Developer',
            'PHP Specialist',
            'Full Stack Web Artisan',
            'Database & API Architect'
        ];
        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;

        const type = () => {
            const currentPhrase = phrases[phraseIndex];

            if (isDeleting) {
                typingElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                typingSpeed = 50;
            } else {
                typingElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                typingSpeed = 110;
            }

            if (!isDeleting && charIndex === currentPhrase.length) {
                typingSpeed = 1800;
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                typingSpeed = 400;
            }

            setTimeout(type, typingSpeed);
        };

        type();
    }

    /* === 5. STATS COUNTER ANIMATION === */
    const counters = document.querySelectorAll('.stat-counter');
    if (counters.length > 0) {
        let hasAnimated = false;

        const animateCounters = () => {
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
                const duration = 1600;
                const stepTime = 20;
                const totalSteps = duration / stepTime;
                const increment = target / totalSteps;
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target + '+';
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current) + '+';
                    }
                }, stepTime);
            });
        };

        const statsSection = document.getElementById('statsSection') || document.querySelector('.stat-box');
        if (statsSection) {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && !hasAnimated) {
                    hasAnimated = true;
                    animateCounters();
                }
            }, { threshold: 0.3 });

            observer.observe(statsSection);
        } else {
            animateCounters();
        }
    }

    /* === 6. SCROLL TO TOP BUTTON === */
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 350) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        }, { passive: true });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /* === 7. CONTACT FORM SUBMIT LOADING STATE === */
    const contactForm = document.getElementById('portfolioContactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', () => {
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>Transmitting Message...</span>
                `;
            }
        });
    }

    /* === 8. PROJECT CATEGORY FILTER TABS === */
    const filterButtons = document.querySelectorAll('.project-filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    if (filterButtons.length > 0 && projectItems.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active', 'btn-glass-primary'));
                this.classList.add('active', 'btn-glass-primary');

                const filterValue = this.getAttribute('data-filter');

                projectItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filterValue === 'all' || category === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 250);
                    }
                });
            });
        });
    }

    /* === 9. AUTOMATIC CLICK EVENT TRACKING (data-track) === */
    document.addEventListener('click', (e) => {
        const trackEl = e.target.closest('[data-track]');
        if (!trackEl) return;

        const event = trackEl.getAttribute('data-track');
        const label = trackEl.getAttribute('data-label') || trackEl.getAttribute('title') || trackEl.innerText.trim();
        const currentPath = window.location.pathname;

        const payload = JSON.stringify({
            event: event,
            label: label ? label.substring(0, 250) : null,
            path: currentPath
        });

        // Use sendBeacon if available, fallback to fetch with keepalive
        const trackUrl = '/track';
        if (navigator.sendBeacon) {
            const blob = new Blob([payload], { type: 'application/json' });
            navigator.sendBeacon(trackUrl, blob);
        } else {
            fetch(trackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: payload,
                keepalive: true
            }).catch(() => {});
        }
    });

    /* === 10. PRIVACY / COOKIE NOTICE BANNER === */
    const cookieBanner = document.getElementById('cookiePrivacyBanner');
    const acceptCookiesBtn = document.getElementById('acceptCookiesBtn');

    if (cookieBanner && acceptCookiesBtn) {
        if (!localStorage.getItem('portfolio_cookie_consent')) {
            setTimeout(() => {
                cookieBanner.classList.remove('d-none');
                cookieBanner.classList.add('d-flex');
            }, 800);
        }

        acceptCookiesBtn.addEventListener('click', () => {
            localStorage.setItem('portfolio_cookie_consent', 'true');
            cookieBanner.classList.remove('d-flex');
            cookieBanner.classList.add('d-none');
        });
    }

});
