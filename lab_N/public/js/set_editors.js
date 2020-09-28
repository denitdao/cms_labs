var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block', 'image', 'link'],
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'color': []}, {'background': []}],              // dropdown with defaults from theme
    [{'align': []}],
    [{'header': [3, 4, false]}],
    ['clean']                                         // remove formatting button
];

var quill_content_ua = new Quill('#editor_content_ua', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});

var quill_content_en = new Quill('#editor_content_en', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});
