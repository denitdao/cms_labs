$(document).ready(function (){
    var create_button = $('#create');
    var snackbar_container = document.querySelector('#snackbar');

    let input_code = document.getElementById('code');
    let input_caption_ua = document.getElementById('caption_ua');
    let input_caption_en = document.getElementById('caption_en');
    let textarea_intro_ua = document.getElementById('intro_ua');
    let textarea_intro_en = document.getElementById('intro_en');
    let editor_content_ua = document.getElementById('editor_content_ua').children[0];
    let editor_content_en = document.getElementById('editor_content_en').children[0];
    let input_parent_code = document.getElementById('parent_code');
    let input_order_num = document.getElementById('order_num');

    create_button.on("click", function(event){
        console.log('Creating:');
        console.log(input_code.value);
        console.log(input_caption_ua.value);
        console.log(input_caption_en.value);
        console.log(textarea_intro_ua.value);
        console.log(textarea_intro_en.value);
        console.log(editor_content_ua.innerHTML);
        console.log(editor_content_en.innerHTML);
        console.log(input_parent_code.value);
        console.log(input_order_num.value);

        $.ajax({
            type: "POST",
            url: '/page',
            data: {
                code: input_code.value,
                caption_ua: input_caption_ua.value,
                caption_en: input_caption_en.value,
                intro_ua: textarea_intro_ua.value,
                intro_en: textarea_intro_en.value,
                content_ua: editor_content_ua.innerHTML,
                content_en: editor_content_en.innerHTML,
                parent_code: input_parent_code.value,
                order_num: input_order_num.value
            }
        }).done(function (data) {
            let info;
            if (data.code !== 'error') {
                info = {
                    message: data.message,
                    timeout: 5000,
                    actionHandler: function (event) {
                        window.location.href = '/' + data.code;
                    },
                    actionText: 'View',
                }
            } else {
                info = {
                    message: data.message,
                    timeout: 5000
                }
            }
            snackbar_container.MaterialSnackbar.showSnackbar(info);
        });
    });

    autosize($('textarea'));
});
