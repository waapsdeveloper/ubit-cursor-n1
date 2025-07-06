/**
 * Hero Section Component JavaScript
 * This file contains all the JavaScript functionality for the hero section
 */

class HeroSection {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupAnimations();
        this.setupScrollEffects();
    }

    setupEventListeners() {
        // Smooth scroll for CTA buttons
        const ctaButtons = document.querySelectorAll('#hero-section a[href^="#"]');
        ctaButtons.forEach(button => {
            button.addEventListener('click', this.handleSmoothScroll.bind(this));
        });

        // Parallax effect for background
        window.addEventListener('scroll', this.handleParallax.bind(this));
    }

    handleSmoothScroll(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    handleParallax() {
        const heroSection = document.getElementById('hero-section');
        if (!heroSection) return;

        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        heroSection.style.transform = `translateY(${rate}px)`;
    }

    setupAnimations() {
        // Add entrance animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        });

        // Observe hero elements
        const heroElements = document.querySelectorAll('#hero-section .animate-on-scroll');
        heroElements.forEach(el => observer.observe(el));
    }

    setupScrollEffects() {
        // Fade out scroll indicator on scroll
        const scrollIndicator = document.querySelector('#hero-section .animate-bounce');
        if (scrollIndicator) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                if (scrolled > 100) {
                    scrollIndicator.style.opacity = '0';
                } else {
                    scrollIndicator.style.opacity = '1';
                }
            });
        }
    }

    // Method to update hero content dynamically
    updateContent(newData) {
        const titleElement = document.querySelector('#hero-section h1');
        const subtitleElement = document.querySelector('#hero-section p');
        
        if (titleElement && newData.title) {
            titleElement.innerHTML = newData.title;
        }
        
        if (subtitleElement && newData.subtitle) {
            subtitleElement.innerHTML = newData.subtitle;
        }
    }

    // Method to add custom animations
    addCustomAnimation(element, animationClass) {
        if (element) {
            element.classList.add(animationClass);
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize hero section
    const heroSection = new HeroSection();
    
    // Make it globally available for customization
    window.HeroSection = heroSection;
    
    console.log('Hero section initialized');
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = HeroSection;
} 