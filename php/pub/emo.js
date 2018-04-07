$(function(){
    function convert() {
        let emos = $('.emo');
        console.log(emos);
        for(let emo of emos){
            console.log(emo);
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

    $('.pad').on('click', pad);
    
    convert();
});
