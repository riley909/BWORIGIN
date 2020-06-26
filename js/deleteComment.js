function deleteComment() {
    console.log("!!");
    var commentContent = $("#commentContent");
    var reviewNum = $("#reviewNum");
    $.confirm({
        icon: 'fas fa-exclamation-triangle',
        title: '',
        content: '댓글을 삭제할까요?',
        buttons: {
            삭제: function () {
                // TODO: Uncaught RangeError: Maximum call stack size exceeded 수정
                // $.ajax({
                //     type: 'POST',
                //     url: "deleteComment.php",
                //     data: {'review_num': reviewNum, 'comment_content': commentContent},
                //     dataType: 'json',
                //     success: function(result) {
                //         console.log("삭제"+result);
                //     }
                // });	
                $.alert('삭제되었습니다.');
                // updateCommentList(reviewNum);
            },
            취소: function () {
                $.alert('취소되었습니다.');
            }
        }
    });
};