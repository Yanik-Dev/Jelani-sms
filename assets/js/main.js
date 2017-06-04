
 jQuery().ready(function(){
     $('#success-alert').fadeIn('8000', function(){
         $('#success-alert').fadeOut('4000');
     });
     
 });

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