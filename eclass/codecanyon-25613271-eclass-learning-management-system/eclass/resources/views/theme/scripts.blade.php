<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/colorbox.js') }}"></script> <!-- colorbox js -->
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<script src="{{ url('vendor/counter/waypoints.min.js') }}"></script> <!-- facts count js required for jquery.counterup.js file -->
<script src="{{ url('vendor/counter/jquery.counterup.js') }}"></script> <!-- facts count js-->
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
@if (in_array($language,$rtl))
<script src="{{ url('vendor/owl/js/owl.carouselrtl.min.js') }}"></script> <!-- owl carousel js -->  
@else
<script src="{{ url('vendor/owl/js/owl.carousel.min.js') }}"></script> <!-- owl carousel js --> 
@endif
<script src="{{ url('vendor/smoothscroll/smooth-scroll.js') }}"></script> <!-- smooth scroll js -->
<script src="{{ url('vendor/popup/jquery.magnific-popup.min.js')}}"></script> <!-- popup js-->
<script src="{{ url('vendor/navigation/menumaker.js') }}"></script> <!-- navigation js--> 
<script src="{{ url('vendor/mailchimp/jquery.ajaxchimp.js') }}"></script> <!-- mail chimp js --> 
<script src="{{ url('vendor/protip/protip.js') }}"></script> <!-- protip js -->
<script src="{{ url('js/theme.js') }}"></script> <!-- custom js -->
{{-- <script src="https://webdesign-flash.ro/p/uvp/js/main.js"></script>  --}}
<script src="{{ url('js/FWDSI.js') }}"></script> <!-- player js -->
<script src="{{ url('js/FWDUVPlayer.js') }}"></script> <!-- player js -->

<script src="{{ url('js/jquery.owl-filter.js') }}"></script> <!-- filter js --> 
<script src="{{ url('js/fontawesome-iconpicker.js')}}"></script><!-- iconpicker js -->
<script src="{{ url('js/tinymce.min.js')}}"></script>
<script src="{{ url('js/protip.js') }}"></script> <!-- protip js -->
<script src="{{ url('js/select2.min.js') }}"></script> <!-- select2 -->
<script src="{{ URL::asset('js/pace.min.js') }}"></script>
<script src="{{ url('js/custom-js.js')}}"></script>
<script src="{{ url('js/jquery.lazy.min.js') }}"></script>
<script src="{{ url('js/jquery.lazy.plugins.min.js') }}"></script>
<script src="{{ url('js/jquery-ui.js')}}"></script>
<script>var sendurl = @json(route('autocomplete.fetch'));</script>
<script src="{{ url('js/search.js')}}"></script>
<script src="{{ asset('js/share.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="{{ url('js/sweetalert2@9.js')}}"></script>
<script src="{{ asset('js/venom-button.min.js') }}"></script>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script src="{{ url('js/chart.js')}}"></script>
<script src="{{ url('js/chart.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  feather.replace()
</script>

<script>
  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
  });
</script>
<script>
  $(document).ready(function() {
  $('#list').click(function(event){
    event.preventDefault();
    $('#posts .item').addClass('col-lg-12');
    $('#posts .course-bought-block-one').addClass('col-lg-3');
    $('#posts .course-bought-block-one').removeClass('col-md-12');
    $('#posts .course-bought-block-one img').removeClass('grid-img');
    $('#posts .course-bought-block-one .img-wishlist').addClass('img-wishlist-btm');
    $('#posts .course-bought-block-one .view-user-img .user-img-one').addClass('d-none');
    $('#posts .course-bought-block-one .view-user-img .user-img-one').removeClass('d-block');
    $('#posts .categories-popularity-dtl-block').addClass('col-lg-7');
    $('#posts .categories-popularity-dtl-block').removeClass('col-md-12');
    $('#posts .categories-popularity-dtl-block').removeClass('mb-3');
    $('#posts .course-rate-block').addClass('col-lg-2');
    $('#posts .course-rate-block').removeClass('col-lg-12');
    $('#posts .rate').removeClass('text-left');
    $('#posts .rate').addClass('text-right');
    $('#grid').removeClass('active');
    $('#list').addClass('active');
  });
  $('#grid').click(function(event){
    event.preventDefault();
    $('#posts .item').removeClass('col-lg-12');
    $('#posts .item').addClass('col-lg-6');
    $('#posts .course-bought-block-one').removeClass('col-lg-3');
    $('#posts .course-bought-block-one').addClass('col-md-12');
    $('#posts .course-bought-block-one img').addClass('grid-img');
    $('#posts .course-bought-block-one .img-wishlist').removeClass('img-wishlist-btm');
    $('#posts .course-bought-block-one .view-user-img .user-img-one').removeClass('d-none');
    $('#posts .course-bought-block-one .view-user-img .user-img-one').addClass('d-block');
    $('#posts .categories-popularity-dtl-block').removeClass('col-lg-7');
    $('#posts .categories-popularity-dtl-block').addClass('col-md-12');
    $('#posts .categories-popularity-dtl-block').addClass('mb-3');
    $('#posts .course-rate-block').removeClass('col-lg-2');
    $('#posts .course-rate-block').addClass('col-lg-12');
    $('#posts .rate').addClass('text-left');
    $('#posts .rate').removeClass('text-right');
    $('#list').removeClass('active');
    $('#grid').addClass('active');
  });
});
</script>
<script>
  $(document).ready(function() {
    $('#listview').click(function(event){
      event.preventDefault();
      $('#posts .search-item').addClass('col-lg-12');
      $('#posts .item').addClass('item-list');
      $('#posts .course-bought-section').addClass('row');
      $('#posts .view-img').addClass('col-lg-3');
      $('#posts .view-dtl').addClass('col-lg-7');
      $('#posts .view-user-img').addClass('d-none');
      $('#posts .view-footer').addClass('col-lg-2');
      $('#posts .view-footer').addClass('view-footer-list');
      $('#posts .rate').removeClass('text-right');
      $('#posts .rate').addClass('text-left');
      $('#posts .advance-badge').addClass('advance-badge-list');
      $('#gridview').removeClass('active');
      $('#listview').addClass('active');
    });
    $('#gridview').click(function(event){
      event.preventDefault();
      $('#posts .search-item').removeClass('col-lg-12');
      $('#posts .item').removeClass('item-list');
      $('#posts .course-bought-section').removeClass('row');
      $('#posts .view-img').removeClass('col-lg-3');
      $('#posts .view-dtl').removeClass('col-lg-7');
      $('#posts .view-user-img').removeClass('d-none');
      $('#posts .view-footer').removeClass('col-lg-2');
      $('#posts .rate').addClass('text-right');
      $('#posts .rate').removeClass('text-left');
      $('#posts .view-footer').removeClass('view-footer-list');
      $('#posts .advance-badge').removeClass('advance-badge-list');
      $('#listview').removeClass('active');
      $('#gridview').addClass('active');
    });
  });
</script>
<script>
  $(document).ready(function () {
      // Custom function which toggles between sticky class (is-sticky)
      var stickyToggle = function (sticky, stickyWrapper, scrollElement) {
          var stickyHeight = sticky.outerHeight();
          var stickyTop = stickyWrapper.offset().top;
          if (scrollElement.scrollTop() >= stickyTop) {
              stickyWrapper.height(stickyHeight);
              sticky.addClass("is-sticky");
          }
          else {
              sticky.removeClass("is-sticky");
              stickyWrapper.height('auto');
          }
      };
      // Find all data-toggle="sticky-onscroll" elements
      $('[data-toggle="sticky-onscroll"]').each(function () {
          var sticky = $(this);
          var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
          sticky.before(stickyWrapper);
          sticky.addClass('sticky');
          // Scroll & resize events
          $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
              stickyToggle(sticky, stickyWrapper, $(this));
          });
          // On page load
          stickyToggle(sticky, stickyWrapper, $(window));
      });
  });
</script>
<script>
  $(function(){
    "use strict";
    $('.lazy').lazy({
        effect: "fadeIn",
        effectTime: 1000,
        scrollDirection: 'both',
        threshold: 0
    });
  });
</script>
@if(isset($gsetting->chat_bubble))
<script src="{{ $gsetting->chat_bubble }}" async></script>
@endif
@if($gsetting->rightclick=='1')
  <script>
    (function($) {
      "use strict";
        $(function() {
          $(document).on("contextmenu",function(e) {
             return false;
          });
      });
      })(jQuery);
  </script>
@endif
@if($gsetting->inspect=='1')
    <script>
        (function($) {
      "use strict";
           document.onkeydown = function(e) {
          if(event.keyCode == 123) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
             return false;
          }
        }
      })(jQuery);
    </script>
@endif
<script>
    $('.prime-cat').on('click',function(){
        var url = $(this).data('url');
        location.href = url;
    });
    $('.sub-cate').on('click',function(){
        var url = $(this).data('url');
        location.href = url;
    });
    $('.child-cate').on('click',function(){
        var url = $(this).data('url');
        location.href = url;
    });
</script>
@if($gsetting->wapp_enable=='1')
<script type="text/javascript">
  $('#myButton').venomButton({
      phone: '{{ $gsetting->wapp_phone }}',
      popupMessage: '{{ $gsetting->wapp_popup_msg }}',
      message: "",
      showPopup: true,
      position: "{{ $gsetting->wapp_position }}",
      linkButton: false,
      showOnIE: false,
      headerTitle: '{{ $gsetting->wapp_title }}',
      headerColor: '{{ $gsetting->wapp_color }}',
      backgroundColor: '#25d366',
      zIndex: 999999999999,
      buttonImage: '<img src="{{ asset('images/icons/whatsapp.svg') }}" />',
      size:'60px',
  });
</script>
@endif

@if(strlen( env('ONESIGNAL_APP_ID',""))>4)
<script  src="{{ url('js/OneSignalSDK.js') }}"></script>
<script>
  var ONESIGNAL_APP_ID = @json(env('ONESIGNAL_APP_ID'));
  var USER_ID = '{{  auth()->user()?auth()->user()->id:"" }}';
</script>
<script  src="{{ url('js/onesignal.js') }}"></script>
@endif


@if($gsetting->screenshot_enable=='1')
<script>
  // Function to hide content and show overlay
  function hideContent() {
      document.querySelector('#content').style.display = 'none';
  }
  // Event listener to detect PrintScreen key press
  document.addEventListener('keyup', function(e) {
      // Check if the key pressed is 'PrintScreen' or 'PrtScn'
      if (e.key === 'PrintScreen' || e.key === 'PrtScn') {
          hideContent();
          
          
      }
  });
</script>
@endif

@yield('custom-script')

