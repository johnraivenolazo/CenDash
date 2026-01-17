import ScrollReveal from 'scrollreveal';

const sr = ScrollReveal({
  distance: '60px',
  duration: 2000,
  delay: 200,
  reset: false,
  mobile: true,
  opacity: 0
});

// ============================================
// HERO SECTION - Staggered entrance for impact
// Why: Sequential reveal creates hierarchy and guides eye flow from title → description → CTA
// ============================================
sr.reveal('.hero-title', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 100,
  easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
});

sr.reveal('.hero-description', {
  origin: 'bottom',
  distance: '30px',
  duration: 1200,
  delay: 300
});

sr.reveal('.hero-cta', {
  origin: 'bottom',
  distance: '20px',
  duration: 1000,
  delay: 500,
  scale: 0.95
});

// Hero Stats - Stagger each stat for emphasis
// Why: Creates counting/revealing effect that draws attention to numbers
sr.reveal('.hero-stats .stat', {
  origin: 'bottom',
  distance: '30px',
  duration: 1000,
  interval: 150,
  delay: 700
});

// Hero Visual - Scale up with slight rotation
// Why: Makes the logo feel like it's "popping" into view, adding energy
sr.reveal('.hero-visual', {
  origin: 'right',
  distance: '80px',
  duration: 1400,
  delay: 400,
  scale: 0.85,
  easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)'
});

// Scroll Indicator - Gentle bounce
sr.reveal('.scroll-indicator', {
  origin: 'bottom',
  distance: '20px',
  duration: 1500,
  delay: 1200,
  opacity: 0
});

// ============================================
// SECTION HEADERS - Fade in with upward motion
// Why: Clean, professional entrance that doesn't distract from content
// ============================================
sr.reveal('.section-header', {
  origin: 'bottom',
  distance: '40px',
  duration: 1000,
  delay: 100
});

sr.reveal('.section-title', {
  origin: 'bottom',
  distance: '30px',
  duration: 1200,
  delay: 150
});

sr.reveal('.section-description', {
  origin: 'bottom',
  distance: '20px',
  duration: 1000,
  delay: 300,
  opacity: 0.8
});

// ============================================
// TRACKING SHOWCASE - Layered reveal for depth
// Why: Separating text and visual creates 3D depth effect, emphasizing the interactive nature
// ============================================
sr.reveal('.tracking-eyebrow', {
  origin: 'left',
  distance: '40px',
  duration: 1000,
  delay: 100,
  scale: 0.9
});

sr.reveal('.tracking-title', {
  origin: 'left',
  distance: '50px',
  duration: 1200,
  delay: 250
});

sr.reveal('.tracking-description', {
  origin: 'left',
  distance: '30px',
  duration: 1000,
  delay: 400
});

// Tracking Steps - Sequential reveal
// Why: Mimics reading flow, guiding users through each feature step-by-step
sr.reveal('.tracking-steps li', {
  origin: 'left',
  distance: '40px',
  duration: 1000,
  interval: 200,
  delay: 500
});

sr.reveal('.tracking-badges', {
  origin: 'left',
  distance: '30px',
  duration: 1000,
  delay: 900,
  scale: 0.9
});

// Radar Visual - Rotate and scale for tech feel
// Why: Rotation suggests motion/tracking, perfect for a real-time tracking feature
sr.reveal('.radar-card', {
  origin: 'right',
  distance: '60px',
  duration: 1400,
  delay: 300,
  scale: 0.9,
  rotate: { x: 0, y: 15, z: 0 }
});

// Map Card - Slide up for grounded feel
// Why: Bottom origin suggests it's anchoring/grounding the location concept
sr.reveal('.map-card', {
  origin: 'bottom',
  distance: '50px',
  duration: 1200,
  delay: 200,
  scale: 0.95
});

// ============================================
// REVIEWS SECTION - Alternate slide direction
// Why: Left slide for text creates visual rhythm and flow
// ============================================
sr.reveal('.reviews-eyebrow', {
  origin: 'left',
  distance: '40px',
  duration: 1000,
  delay: 100,
  scale: 0.9
});

sr.reveal('.reviews-title', {
  origin: 'left',
  distance: '50px',
  duration: 1200,
  delay: 250
});

sr.reveal('.reviews-description', {
  origin: 'left',
  distance: '30px',
  duration: 1000,
  delay: 400
});

// ============================================
// PAYMENTS SECTION - Fade in with scale
// Why: Simple fade for trust signals, marquee animation already provides motion
// ============================================
sr.reveal('.payments-eyebrow', {
  origin: 'bottom',
  distance: '30px',
  duration: 1000,
  delay: 100,
  scale: 0.9
});

sr.reveal('.payments-copy h3', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 250
});

sr.reveal('.payments-copy .section-description', {
  origin: 'bottom',
  distance: '30px',
  duration: 1000,
  delay: 400
});

sr.reveal('.payments-marquee', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 600,
  opacity: 0
});

// ============================================
// FINAL CTA SECTION - Explosive entrance
// Why: Dramatic scale + bounce creates urgency and excitement for conversion
// ============================================
sr.reveal('.final-cta-content h2', {
  origin: 'bottom',
  distance: '50px',
  duration: 1400,
  delay: 100,
  scale: 0.9,
  easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)'
});

sr.reveal('.final-cta-content > p', {
  origin: 'bottom',
  distance: '30px',
  duration: 1200,
  delay: 300
});

sr.reveal('.final-cta-buttons', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 500,
  scale: 0.95
});

sr.reveal('.final-cta-note', {
  origin: 'bottom',
  distance: '20px',
  duration: 1000,
  delay: 700,
  opacity: 0.5
});

// ============================================
// FOOTER - Stagger columns
// Why: Sequential reveal guides eye through footer sections
// ============================================
sr.reveal('.footer-column', {
  origin: 'bottom',
  distance: '40px',
  duration: 1000,
  interval: 100,
  delay: 100
});

sr.reveal('.footer-bottom', {
  origin: 'bottom',
  distance: '20px',
  duration: 1000,
  delay: 300,
  opacity: 0.5
});

// ============================================
// CONTACT FORM SECTION
// Why: Form elements reveal sequentially to guide user through input process
// ============================================
sr.reveal('.contact', {
  origin: 'bottom',
  distance: '60px',
  duration: 1400,
  delay: 100,
  scale: 0.9,
  easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)'
});

sr.reveal('.contact-content h1', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 300
});

sr.reveal('.contact-content p', {
  origin: 'bottom',
  distance: '30px',
  duration: 1000,
  delay: 450
});

sr.reveal('.contact-content form', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 600,
  scale: 0.95
});

// ============================================
// UTILITY CLASSES - Reusable animations
// ============================================
sr.reveal('.top', {
  origin: 'top',
  distance: '40px',
  duration: 1200,
  delay: 100
});

sr.reveal('.bottom', {
  origin: 'bottom',
  distance: '40px',
  duration: 1200,
  delay: 100
});

sr.reveal('.left', {
  origin: 'left',
  distance: '60px',
  duration: 1200,
  delay: 100
});

sr.reveal('.right', {
  origin: 'right',
  distance: '60px',
  duration: 1200,
  delay: 100
});

sr.reveal('.scale', {
  duration: 1200,
  scale: 0.85,
  delay: 100
});

sr.reveal('.fade', {
  duration: 1500,
  opacity: 0,
  delay: 100
});




