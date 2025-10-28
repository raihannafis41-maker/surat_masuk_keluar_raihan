/* modern-anim.js
   - animate counters
   - handle login submit overlay with envelope bounce
*/

document.addEventListener('DOMContentLoaded', function(){
  // COUNTER animation for elements with .count-to and data-count attribute
  function animateCounter(el, duration=1200){
    const target = parseInt(el.getAttribute('data-count') || '0', 10);
    let start = 0;
    const startTime = performance.now();
    function step(now){
      const progress = Math.min((now - startTime) / duration, 1);
      const value = Math.floor(progress * target);
      el.textContent = value.toLocaleString();
      if(progress < 1) requestAnimationFrame(step);
      else el.textContent = target.toLocaleString();
    }
    requestAnimationFrame(step);
  }

  // animate all counters on page load or when called
  document.querySelectorAll('.count-to').forEach(el => {
    const delay = parseInt(el.getAttribute('data-delay')||0, 10);
    setTimeout(()=> animateCounter(el), delay);
  });

  // envelope bounce when clicking submit, show overlay loader
  const form = document.querySelector('.login-form');
  const overlay = document.querySelector('.submit-overlay');
  const loaderProgress = document.querySelector('.loader-progress');
  const env = document.querySelector('.envelope');

  if(form){
    form.addEventListener('submit', function(e){
      // intercept to show animation then proceed
      e.preventDefault();
      // bounce envelope
      if(env) env.classList.add('bounce');
      // show overlay
      if(overlay) overlay.style.display='flex';
      // animate loader progress
      loaderProgress.style.width='0%';
      setTimeout(()=> loaderProgress.style.width='55%', 80);
      setTimeout(()=> loaderProgress.style.width='85%', 900);
      setTimeout(()=> {
        loaderProgress.style.width='100%';
      }, 1500);

      // after animation, submit form normally
      setTimeout(()=> {
        overlay.style.display='none';
        if(env) env.classList.remove('bounce');
        form.submit(); // submit actual form
      }, 1900); // match animation length
    });
  }

  // function to manually trigger counter (useful after AJAX)
  window.refreshCount = function(selector='.count-to'){
    document.querySelectorAll(selector).forEach(el => animateCounter(el));
  };
});
