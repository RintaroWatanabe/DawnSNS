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

// 編集画面のモーダル
$(function () {
  $('.modal-open').each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var modal = document.getElementById(target);
      console.log(modal);
      $(modal).fadeIn();
      return false;
    });
  });

  //
  // $('.modalClose').on('click', function () {
  //   $('.js-modal').fadeOut();
  //   return false;
  // });

  // モーダルの背景をクリックした時にモーダルを閉じる
  $('.modal-inner').on('click', function (e) {
    if (e.target === this) {
      $('.js-modal').fadeOut();
      return false;
    }
  });
});
