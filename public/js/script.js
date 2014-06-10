function updateGenerations (id){
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/getdata/updateg/id/' + id,
        beforeSend: function(){
            $('#update' + id).html('идет загрузка...');
        },
        success: function(data){
            $('#update' + id).html(data);
        }
    });
}

jQuery.fn.exists = function() {
    return $(this).length;
}

$(document).ready(function() {

    if($('#search').exists()) {
        var search_form = new Form('search', search_params);
        search_form.loadBrands();
        search_form.slide();
        search_form.populate();
        search_form.updateCount();

        $('.select').change(function(){
            search_form.checkInput(this);
        });
    }

    if($('#add').exists()) {
        var add_form = new AddForm('add');
        add_form.loadBrands();
        add_form.slide();
        add_form.populate();
        setTimeout(function (){add_form.updatePreview()}, 1500);

        $('.select').change(function(){
            add_form.checkInput(this);
        });
    }

    if($('.boxes').exists()) {
        $('.boxes .box').hide();
        $('#preview').hide();
        $('.boxes .box-button:first').addClass("active");
        $('.boxes .box:first').show();

        $('.boxes .box-button').unbind().click(function(){
            $('.boxes .box').slideUp("fast");
            $('.indicator').html('+');
            var box_id = this.id;
            $('#box-' + box_id).slideDown("fast");
            $('#box-button-' + box_id + '-indicator').html('-');
            $(this).toggleClass("active");
            return false;
        });
    }

    if($('#copy-form').exists()) {
        $('#result').slideUp();

        if($('#url').val().length > 0) parse();

        $('#go-copy').unbind('click').click(function(){
            parse();
            return false;
        });
    }

});

var parse = function ()
{
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/api/parse?url=' + $('#url').val(),
        beforeSend: function(){
            $('#result').html(
                'копируем информацию...'
            );
            $('#result').slideDown();
            $('#form').slideUp();
        },
        success: function(data){
            $('#result').html(data);
        }
    });
};