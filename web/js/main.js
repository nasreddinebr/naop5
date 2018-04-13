//Flash message display time (3s)
setTimeout(function (){
    $('#flash-message').remove();
}, 3000);

function callAjax(url, termSearch) {
    if (termSearch === "" || termSearch.length < 3) {
        $('li').remove();
    }else if (termSearch.length >= 3) {
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                search: 1,
                q: termSearch
            },
            success: function (data) {
                $("#listResult").html(data);
            },
            dataType: 'text'
        });
    }

    //setTimeout(function (){ $('#messagesuccess').remove();}, 3000);

    // Position the list of results
    var elem = document.getElementById('termsearch');
    var resultWidth = $('#zoneSearch').width();
    var serachTop = $('#zoneSearch').height();
    $('#result').css('width', resultWidth);
    $('#result').css('top', serachTop+'px');
}

// Retrieving the modification form and inject it into the modal box in ajax.
function runEditModal($id) {
    let uri = 'http://127.0.0.1:8000/observation/edit/' + $id;
    $.ajax({
        url: uri,
        data: {
            format: 'json'
        },

        success: function(data) {

            $("#formEdit").html(data);
        },
        type: 'GET'
    });
}

