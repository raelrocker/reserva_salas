
$(function () {
    $('.input-group.date').datetimepicker({locale:'pt', format: 'DD/MM/YYYY'});


});

function getDate(dateString) {
    if (dateString == '')
    {
        return '';
    }
    var arr = dateString.split('/');
    return arr[2] + '-' + arr[1] + '-' + arr[0];
}