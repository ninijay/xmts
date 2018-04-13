//animation trigger on click
$(".download-btn").click(function() {
    $(".download").toggleClass("download--animate");
    $(".bar").toggleClass("bar--animate");
    $(".btn__arrow").toggleClass("btn__arrow--animate");
    $(".btn__stop").toggleClass("btn__stop--animate");
    $(".btn__done").toggleClass("btn__done--animate");
  });
  