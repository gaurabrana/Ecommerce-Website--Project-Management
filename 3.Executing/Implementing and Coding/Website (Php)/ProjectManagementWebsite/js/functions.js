$(document).ready(function() {
    setInterval(test, 5000);
    var i = 1;
  
    function test() {
      i = (i % 5) + 1;
      $('#slide-image-' + i).prop('checked', true);
    }
  });
$(document).ready(function(){
    $(".list1").hover(function(){
        $(".l1 i").css("visibility","visible");
        $(".l1 p").css("visibility","hidden");
        $(".l1 a").css("pointer-events","visible");
    },function(){
        $(".l1 p").css("visibility","visible");
        $(".l1 i").css("visibility","hidden");
        $(".l1 a").css("pointer-events","none");
    }); 
    
    $(".list2").hover(function(){
        $(".l2 i").css("visibility","visible");
        $(".l2 p").css("visibility","hidden");
        $(".l2 a").css("pointer-events","visible");
    },function(){
        $(".l2 p").css("visibility","visible");
        $(".l2 i").css("visibility","hidden");
        $(".l2 a").css("pointer-events","none");
    }); 

    $(".list3").hover(function(){
        $(".l3 i").css("visibility","visible");
        $(".l3 p").css("visibility","hidden");
        $(".l3 a").css("pointer-events","visible");
    },function(){
        $(".l3 p").css("visibility","visible");
        $(".l3 i").css("visibility","hidden");
        $(".l3 a").css("pointer-events","none");
    }); 

    $(".list4").hover(function(){
        $(".l4 i").css("visibility","visible");
        $(".l4 p").css("visibility","hidden");
        $(".l4 a").css("pointer-events","visible");
    },function(){
        $(".l4 p").css("visibility","visible");
        $(".l4 i").css("visibility","hidden");
        $(".l4 a").css("pointer-events","none");
    }); 

    $(".list5").hover(function(){
        $(".l5 i").css("visibility","visible");
        $(".l5 p").css("visibility","hidden");
        $(".l5 a").css("pointer-events","visible");
    },function(){
        $(".l5 p").css("visibility","visible");
        $(".l5 i").css("visibility","hidden");
        $(".l5 a").css("pointer-events","none");
    }); 
    
    $(".list6").hover(function(){
        $(".l6 i").css("visibility","visible");
        $(".l6 p").css("visibility","hidden");
        $(".l6 a").css("pointer-events","visible");
    },function(){
        $(".l6 p").css("visibility","visible");
        $(".l6 i").css("visibility","hidden");
        $(".l6 a").css("pointer-events","none");
    }); 

    $(".list7").hover(function(){
        $(".l7 i").css("visibility","visible");
        $(".l7 p").css("visibility","hidden");
        $(".l7 a").css("pointer-events","visible");
    },function(){
        $(".l7 p").css("visibility","visible");
        $(".l7 i").css("visibility","hidden");
        $(".l7 a").css("pointer-events","none");
    }); 

    $(".list8").hover(function(){
        $(".l8 i").css("visibility","visible");
        $(".l8 p").css("visibility","hidden");
        $(".l8 a").css("pointer-events","visible");
    },function(){
        $(".l8 p").css("visibility","visible");
        $(".l8 i").css("visibility","hidden");
        $(".l8 a").css("pointer-events","none");
    }); 
});
