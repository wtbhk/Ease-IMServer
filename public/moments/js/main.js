function createPost() {
  $("#post-modal").modal();
}
function getUrlParam(name) {
  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg);  //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
var token = getUrlParam('access_token');

$(document).ready(function () {
  $.get("../profile", {'access_token': token}, function (result) {
    $("#user-name").html(result['name']);
    $("#avt").attr('src', result['avatar']);
    $(".access-token").val(token);
  });

  $.get("../post", {'access_token': token}, function (posts) {
    var html = template('template', {'posts': posts});
    $("#list ul").html(html);

    $(".heart").on('click', function () {
      post_id = $(this).parents("li").attr('data-id');
      if ($(this).hasClass('empty')) {
        $(this).removeClass('empty');
        $.post("../post/" + post_id + "/like", {'access_token': token});
      } else {
        $(this).addClass('empty');
        $.ajax({
          url: '../post/' + post_id + '/like',
          type: 'DELETE',
          data: {'access_token': token}
        });
      }
    });

    $("#comment-modal-submit").on("click", function (event) {
      event.preventDefault();
      post_id = $("#comment-modal").attr('data-id');
      $("#comment-modal .close-modal").click();
      content = $("#comment-modal-content").val()
      $.post("../post/" + post_id + "/comment", {
        "access_token": token,
        "content": content
      }, function () {
        html = "<p><span>" + $("#user-name").html() + "：</span>" + content + "</p>";
        $("#list li[data-id=" + post_id + "] .cmt-list").append(html);
      });
    });

    $(".comment").on("click", function () {
      $("#comment-modal").attr("data-id", $(this).parents("li").attr('data-id'))
      $("#comment-modal").modal();
    });
  });

  $("#post-modal-image").on("click", function (event) {
    $("#post-modal-file").click();
  });

  $("#post-modal-file").on("change", function (event) {
    if (this.files && this.files[0]) {
      reader = new FileReader();
      reader.onload = function (e) {
        $("#post-modal-image").attr("src", e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    }
  });
});
