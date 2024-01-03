$(document).ready(function () {
  var action = "modal_search";

  $("#btnSearchModal").click(function () {
    var keyword = $("#keyword_modal").val();

    $.ajax({
      url: "./modules/services/modal_search.php",
      method: "POST",
      data: { action: action, keyword_modal: keyword },
      success: function (data) {
        $("#content_modal").html(data);
      },
    });
  });
});

// Lắng nghe sự kiện keydown trên cửa sổ
window.addEventListener("keydown", function (e) {
  // Kiểm tra xem phím Enter (keyCode 13) đã được nhấn hay chưa
  if (e.keyCode === 13) {
    // Ngăn chặn mở popup
    e.preventDefault();
  }
});
