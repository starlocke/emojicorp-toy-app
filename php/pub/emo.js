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
        key_accessibility();
    }
    function readpad(e, i){
        let input = $(e.currentTarget).data('value');
        let key = $('#readkey').val() + input;
        $('#readkey').val(key);
        readkey_accessibility();
    }

    function readform(e, i){
        let uuid = $(e.currentTarget).data('uuid');
        $('#uuid').val(uuid);
        $('#read_heading')[0].scrollIntoView(true);
    }

    function readkeyconvert(e, i){
        if(e){
            e.preventDefault();
        }
        let input = $('#readkey').val();
        let output = emojione.shortnameToUnicode(input);
        $('#readkey').val(output);
        return false;
    }
    function keyconvert(e, i){
        if(e){
            e.preventDefault();
        }
        let input = $('#key').val();
        let output = emojione.shortnameToUnicode(input);
        $('#key').val(output);
        return false;

    }

    function readsubmit(e){
        readkeyconvert();
    }
    function writesubmit(e){
        keyconvert();
    }

    function readkey_accessibility(e, i){
        let input = $('#readkey').val();
        let output = emojione.toImage(input);
        $('#readkey_render').html(output);
    }
    function key_accessibility(e, i){
        let input = $('#key').val();
        let output = emojione.toImage(input);
        $('#key_render').html(output);
    }

    $('.pad').on('click', pad);
    $('.readpad').on('click', readpad);
    $('.read').on('click', readform)
    $('.read_convert').on('click', readkeyconvert); 
    $('.read_form').on('submit', readsubmit); 
    $('.write_form').on('submit', writesubmit); 
    $('.read_form').on('click', readsubmit); 
    $('.write_form').on('click', writesubmit);

    $('#readkey').on('change', readkey_accessibility);
    $('#key').on('change', key_accessibility);
    $('#readkey').on('keyup', readkey_accessibility);
    $('#key').on('keyup', key_accessibility);
    $('#readkey').on('keydown', readkey_accessibility);
    $('#key').on('keydown', key_accessibility);
    
    convert();
});
