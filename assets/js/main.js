// We listen to the resize event
window.addEventListener('resize', () => {
    // We execute the same script as before
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
});

// Listen to tab events to enable outlines (accessibility improvement)
document.body.addEventListener('keyup', function (e) {
    if (e.which === 9) /* tab */ {
        document.documentElement.classList.remove('no-focus-outline');
    }

    document.body.addEventListener("click", function () {
        document.documentElement.classList.add('no-focus-outline');
    });
});

(function($) {

    var mailer = {
      url: "../../mailer/send.php",
    };
     
    
    function sendForm(e) {
      e.preventDefault();
  
      var form = $(this);
      console.log(form);
      var button = form.find('[type=submit]');
      var feedback = form.find('span');
  
  
  
      button.text('Enviando...').prop('disabled', true);
  
      $.ajax({
        type: "POST",
        url: mailer.url,
        data: form.serialize(),
        success: function success(res) {
          feedback.text(res.message);
          button.text('Enviar').prop('disabled', false);
          if (res.status == 'success') {
            form[0].reset();
          }
        }
      });
    }
  
    document.querySelector('[data-dom=form]').addEventListener('submit', sendForm);
  
    
  })(jQuery);
