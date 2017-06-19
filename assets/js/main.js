 
 /**
  * Shows the preview of an image in an image tag with the id 'img-ouput'
  * @param {$event} event  
  */
 var previewImage = function(event) {
    var output = document.getElementById('img-output');
    output.src = URL.createObjectURL(event.target.files[0]);
 };

 $('form.ajax').on('submit', function(){
        var form = $(this),
            url = form.attr('action'),
            method = form.attr('method'),
            data = {};
        form.find('[name]').each(function(index, value){
            var input = $(this),
                name = input.attr('name'),
                value = $(this).val();
            data[name] = value;
        });
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response){
                var res = JSON.parse(response);
                if(res.code == 200){
                    
                }else{
                    $('#error-alert').show(); 

                }
            }
        });    
        
        return false;
 });
 
 /*
 $("form.ajax-data").submit(function() {
     var form = $(this),
            url = form.attr('action'),
            method = form.attr('method');
    var formData = new FormData($(this)[0]);
    $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response){
                var res = JSON.parse(response);
                if(res.code == 200){
                    alert(response);
                }else{
                    $('#error-alert').show(); 

                }
            }
        });    
    $.post($(this).attr("action"), formData, function(data) {
        alert(data);
    });
    return false;
});
*/