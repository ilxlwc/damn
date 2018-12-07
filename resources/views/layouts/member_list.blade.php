<!DOCTYPE html>
<html lang="zh-cn">
  @include('layouts.head')
  <body>  
    <!-- Left column -->
    <div class="templatemo-flex-row">
      @include('layouts.nav')      
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        @include('layouts.member_top')    
        <div class="templatemo-content-container">
          @yield('content')
        </div>
      </div>
    </div>
    
     @yield('otherModel')
    
    <!-- JS -->
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script><!-- jQuery -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script><!-- jQuery -->
    <script type="text/javascript" src="../js/templatemo-script.js"></script><!-- Templatemo Script -->
    <script type="text/javascript">     
      $(document).ready(function(){
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();        
      });      
    </script>
    @yield('javascript')
  </body>
</html>