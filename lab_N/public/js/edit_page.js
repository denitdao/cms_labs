$(document).ready(function (){
    var save_button = $('#save');
    var snackbar_container = document.querySelector('#snackbar');

    let id = document.getElementById('this_code').value;
    let input_code = document.getElementById('code');
    let input_caption_ua = document.getElementById('caption_ua');
    let input_caption_en = document.getElementById('caption_en');
    let textarea_intro_ua = document.getElementById('intro_ua');
    let textarea_intro_en = document.getElementById('intro_en');
    let editor_content_ua = document.getElementById('editor_content_ua').children[0];
    let editor_content_en = document.getElementById('editor_content_en').children[0];
    let input_parent_code = document.getElementById('parent_code');
    let input_order_num = document.getElementById('order_num');
    var page_photo_base64 = null;

    $('#page_photo').on('change', function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#image_preview_container').attr('src', e.target.result);
            page_photo_base64 = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });

    save_button.on("click", function(event){
        let page_type = $('[name = page_type]:checked');
        let view_type = $('[name = view_type]:checked');
        let order_type = $('[name = order_type]:checked');

        console.log('Updating:');
        console.log(page_type.val());
        console.log(input_code.value);
        console.log(input_parent_code.value);

        $.ajax({
            type: "PUT",
            url: '/page/' + id,
            data: {
                page_type: page_type.val(),
                view_type: view_type.val(),
                order_type: order_type.val(),
                code: input_code.value,
                caption_ua: input_caption_ua.value,
                caption_en: input_caption_en.value,
                intro_ua: textarea_intro_ua.value,
                intro_en: textarea_intro_en.value,
                content_ua: editor_content_ua.innerHTML,
                content_en: editor_content_en.innerHTML,
                parent_code: input_parent_code.value,
                order_num: input_order_num.value,
                page_photo: page_photo_base64
            }
        }).done(function (data) {
            let info;
            if (data.code !== 'error') {
                info = {
                    message: data.message,
                    timeout: 5000,
                    actionHandler: function (event) {
                        window.location.href = '/' + data.parent;
                    },
                    actionText: 'View',

                }
                snackbar_container.MaterialSnackbar.showSnackbar(info);
                setTimeout(() => window.location.href = `/page/${data.code}/edit`, 3000);
            } else {
                info = {
                    message: data.message,
                    timeout: 5000
                }
                snackbar_container.MaterialSnackbar.showSnackbar(info);
            }
        });
    });

});
