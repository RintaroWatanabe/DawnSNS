// 三角ボタンを押すとアコーディオンメニューを表示させる
$(function(){
  $('.menu-trigger').click(function(){
    $('.menu-list').slideToggle();
  });
});

// アコーディオンメニュー表示中は三角ボタンを反転させる
$(function () {
  $('.menu-trigger').click(function () {
    $(this).toggleClass('active');
  });
});
