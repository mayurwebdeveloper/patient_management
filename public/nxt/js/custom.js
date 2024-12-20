jQuery(document).ready(function(){


  jQuery(".nav-btn").click(function(){
     jQuery(this).parent().toggleClass("open-menu");
  })

    jQuery('.banner-section').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
      });
      jQuery('.movie-list').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows:false,
        asNavFor: '.slider-nav',
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: false
            }
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          
        ]
      });
      jQuery('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.movie-list',
        dots: false,
          
      });


})