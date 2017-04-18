function CommentReply(parent){

    $('.show-back').each( function () {
        $( this ).show();
    });

    document.getElementById("reply-"+parent).appendChild(document.getElementById("comment-form"));
    document.getElementById("text-reply").value = '';
    document.getElementById("parent-id").value = parent;
}


function CommentEdit(id, text){

    $('.show-back').each( function () {
        $( this ).show();
    });

    document.getElementById("post-remove-"+id).style.display='none';
    document.getElementById("post-"+id).appendChild(document.getElementById("comment-form"));
    document.getElementById("text-reply").value = text;
    document.getElementById("comment-id").value = id;
}


function deleteComment(e) {

     $.ajax({
         type: 'POST',
         url:  '/comment/delete',
         dataType: 'json',
         data: $(e).serialize(),

         success: function(data) {

             $('#conversation').html(data.comments);
             $('#comments-quantity').html('<strong>' + data.quantity + '</strong>');
         }
     });
}


function addComment(e) {

    $.ajax({
        type: 'POST',
        url:  '/comment/add',
        dataType: 'json',
        data: $(e).serialize(),

        success: function(data) {

            if(data.error){

                $('#error-div').show();
                $('#error-span').html(data.error);

            } else {
                document.getElementById("comment-form-wrap").appendChild(document.getElementById("comment-form"));
                document.getElementById("text-reply").value = '';
                document.getElementById("comment-id").value = '';
                document.getElementById("parent-id").value  = '';
                $('#error-div').hide();
                $('#conversation').html(data.comments);
                $('#comments-quantity').html('<strong>' + data.quantity + '</strong>');
                $('#comment-text').val('');
            }
        }
    });
}

function closeError(id) {
    document.getElementById(id).style.display = 'none';
}


function changeCategory(id) {

    $.ajax({
        type: 'POST',
        url:  '/home/tab',
        data: { 'cat_id' : id },
        dataType: 'json',

        success: function(data) {
            $('#conversation').html(data.comments);
            $('#comments-quantity').html('<strong>' + data.quantity + '</strong>');
            $('.tab').each( function () {
                $( this ).removeClass('active');
            });
            $('#tab-' + id).addClass('active');
            $('#cat-id-form').val(data.category);
            $('#cat-id').val(data.category);
        }
    });
}

function vote(e, id) {
    var type = e.className;
    var vote = document.getElementById('vote-' + id);

    $.ajax({
        type: 'POST',
        url:  '/comment/vote',
        data: { 'data' : [ vote.dataset.user, id, vote.dataset.author, type ] },
        dataType: 'json',

        success: function(data) {

            if(data.error){

                $('#error-div').show();
                $('#error-span').html(data.error);

            } else {

                $('#rating-' + id).html(data.rating);
                $('#rating-' + id).removeClass();
                if(data.rating >= 0 ) {
                    $('#rating-' + id).addClass('text-success');
                } else {
                    $('#rating-' + id).addClass('text-danger');
                }

               // $(':first-child', e).toggleClass("btn-danger");
            }
        }
    });
}

$( '.close-form-reply' ).click(function (event) {

    event.preventDefault();
    document.getElementById("text-reply").value='';
    document.getElementById("comment-form-wrap").appendChild(document.getElementById("comment-form"));

    $('.show-back').each( function () {
        $( this ).show();
    });
});


$( '.show-login-form' ).click( function (event) {
    event.preventDefault();
    $( '.login-form' ).toggle();
});

$( '.close-form' ).click(function (event) {
    event.preventDefault();
    $('.login-form').hide();
    $('.registration-form').hide();
});

$( '.go-to-registration' ).click(function (event) {
    event.preventDefault();
    $('.login-form').hide();
    $('.registration-form').show();
});

$( '.go-to-login' ).click(function (event) {
    event.preventDefault();
    $('.registration-form').hide();
    $('.login-form').show();
});