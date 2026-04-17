(function (Drupal) {
  Drupal.behaviors.templeTestimonials = {
    attach: function (context, settings) {
      const slider = context.querySelector('.temple-testimonials-slider');
      if (!slider) return;
 
      const items = slider.children;
      
      if(items.length <=1) return;
      let index = 0;
 
      function showNextSlide() {
        index = (index + 1) % items.length;
        slider.style.transform = `translateX(-${index * 100}%)`;
      }
 
      setInterval(showNextSlide, 3000);
    }
  };
})(Drupal);;
