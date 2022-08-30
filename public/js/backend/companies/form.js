$(function () {
    // init: side menu for current page
    $('li#menu-companies').addClass('menu-open active');
    $('li#menu-companies').find('.treeview-menu').css('display', 'block');
    $('li#menu-companies').find('.treeview-menu').find('.add-companies a').addClass('sub-menu-active');

    $('#company-form').validationEngine('attach', {
        promptPosition : 'topLeft',
        scroll: false
    });

    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
function previewFile(){
    const preview = document.querySelector('#preview');
    const file = document.querySelector('[type=file]').files[0];
    const reader = new FileReader();
    reader.addEventListener("load", function () {
      // change image file to string
      preview.src = reader.result;
    }, false);
  
    if (file) {
      reader.readAsDataURL(file);
    }
  }