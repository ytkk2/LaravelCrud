$(function(){
    
    /* Start using Ajax */
    $('#search').on('click', function(){
        var postcode = $('#postcode').val();
         request = $.ajax({
            type: 'POST',
            url: '/postcode/{postcode}/address',
            cache: false,
            dataType: 'json',
            data: {
                // set the value
                id:$("#postcode").val()
            }
        });

    /* Success */
        request.done(function(data){
            var prefecture = data[0]["prefecture"];
            var city = data[0]["city"];
            var local = data[0]["local"]
        /* Output */
            //$("#prefecture").append('<option value="'+prefecture.display_name+'">'+prefecture.display_name+'</option>');
            $("#prefecture").val(prefecture);
            $("#city").val(city);
            $("#local").val(local);
            
        });

    /* Fail */
        request.fail(function(){
            alert("通信に失敗しました");
        });

    });
});