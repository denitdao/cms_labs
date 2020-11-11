$(document).ready(function () {
    if($('[name = page_type]:checked').val() !== 'container') $('#container_settings').hide();
    if($('[name = page_type]:checked').val() == 'alias') $('#container_content').hide();

    $('#container').on('change', function () {
        $('#container_settings').show();
        $('#container_content').show();
    });
    $('#publication').on('change', function () {
        $('#container_settings').hide();
        $('#container_content').show();
    });
    $('#alias').on('change', function () {
        $('#container_settings').hide();
        $('#container_content').hide();
    });

    autosize($('textarea'));
});
