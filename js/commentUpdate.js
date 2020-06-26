function updateCommentList(reviewNum){
    var url = "commentUpdate.php";
    $.ajax({
        type: 'POST',
        url: url,
        data: reviewNum,
        dataType: 'json',
        success: function(result) {
            console.log("업데이트"+result);
            var htmls = "";
            if(result.length > 1){
                $(result).each(function(){
                    // htmls += '<div class="media">';
                    // htmls += '<a class="media-left" href="#">';
                    // htmls += '<img src="http://lorempixel.com/40/40/people/1/">';
                    // htmls += '</a>';
                    // htmls += '<div class="media-body">';
                    // htmls += '<h4 class="media-heading user_name"><?=$id?></h4>';
                    // htmls += '<div id="commentContent"><?=$commentContent?></div>';
                    // htmls += '<input type="hidden" id="reviewNum" value="<?=$reviewNum?>"/>';
                    // htmls += '<p><small><a href="#" id="editComment">수정</a> - <a href="#" id="deleteComment">삭제</a></small></p>';
                    // htmls += '</div>';
                    // htmls += '<p class="pull-right">';
                    // htmls += '<small><?= $commentDate ?></small><br>';
                    // htmls += '<small><?= $commentTime ?></small>';
                    // htmls += '</p>';
                    // htmls += '</div>';
                });	
            }
            // $("#comments-list").html(htmls);
        }	 
    });	
}
