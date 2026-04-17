(function (Drupal) {
  Drupal.behaviors.templeTestimonials = {
    attach: function (context, settings) {
      const slider = once('testimonial-slider', context.querySelector('.temple-testimonials-slider')).shift();
      if (!slider) return;
 
      const items = slider.children;
      let index = 0;
 
      function showNextSlide() {
        index++;
        if (index >= items.length) {
          index = 0;
        }
 
        slider.style.transform = `translateX(-${index * 100}%)`;
      }
 
      setInterval(showNextSlide, 3000);
    }
  };
})(Drupal);;
