$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// 审核文章能不能通过
$(".post-audit").click(function(event){
    var target = $(event.target);
    var post_id = target.attr("post-id");
    var status = target.attr("post-action-status");

    $.ajax({
        url: "/admin/posts/" + post_id + "/status",
        type: "POST",
        data: { "status": status },
        dataType: "json",
        success: function success(data) {
            if (data.error != 0) {
                alert(data.msg);
                return;
            }
            target.parent().parent().remove();
        }
    });
});

//删除专题的js
$(".resource-delete").click(function (event) {
    if(confirm("确定要执行删除操作吗？") == false){
        return;
    }
    var target = $(event.target);
    event.preventDefault();
    var url= target.attr("delete-url");
    $.ajax({
        url: url,
        method: "POST",
        data: {"_method":'DELETE'},
        dataType: "json",
        success: function (data) {
            if(data.error != 0){
                alert('data.msg');
                return;
            }
            window.location.reload();
        }
    });
});