$('#writeCommentBtn').click(function () {
    var formData = $('#commentForm').serializeArray();
    console.log(formData);
    $.post($("#commentForm").attr("action"), formData, function(info){
        console.log(info);
    });
    $(".comments-list").append("<div class=\"media\">"
    +"<a class=\"media-left\" href=\"#\">"
        +"<img src=\"http://lorempixel.com/40/40/people/1/\">"
    +"</a>"
    +"<div class=\"media-body\">"
        +"<h4 class=\"media-heading user_name\">"+formData[1].value+"</h4>"
        +formData[0].value+"<p><small><a href=\"#\">수정</a>  -  <a href=\"#\">삭제</a></small></p>"
    +"</div>"
    +"<p class=\"pull-right\">"
        +"<small>"+formData[3].value+"</small><br>"
        +"<small>"+formData[4].value+"</small>"
    +"</p></div>");
    clearInput();
});

$("#commentForm").submit(function(){
    return false;
});

function clearInput(){
    $("#commentContent").val('');
}



