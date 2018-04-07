$(function(){
    function convert() {
        let emos = $('.emo');
        for(let emo of emos){
            let input = $(emo).text();
            let output = emojione.toImage(input);
            $(emo).html(output);
        }
    }

    function pad(e, i){
        let input = $(e.currentTarget).data('value');
        let key = $('#key').val() + input;
        $('#key').val(key);
    }
    function readpad(e, i){
        let input = $(e.currentTarget).data('value');
        let key = $('#readkey').val() + input;
        $('#readkey').val(key);
    }

    function readform(e, i){
        let uuid = $(e.currentTarget).data('uuid');
        $('#uuid').val(uuid);
        $('#read_heading')[0].scrollIntoView(true);
    }

    $('.pad').on('click', pad);
    $('.readpad').on('click', readpad);
    $('.read').on('click', readform)
    
    convert();
});
