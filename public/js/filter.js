$(document).ready(function() {
    $('#busca').on('input', function() {
        setSearchValue();
    });

    $('#filter-form').submit(function(event) {
        $(this).find('select').each(function () {
            if ($(this).val() == '') {
                $(this).prop('disabled', true);
            }
        });

        if ($('#filter-search').val() == '') {
            $('#filter-search').prop('disabled', true);
        }
    });

    $('#search-form').submit(function (event) {
        if ($('#busca').val() == '') {
            $('#busca').prop('disabled', true);
        }
    });

    setSearchValue();
});

function setSearchValue() {
    $('#filter-search').val($('#busca').val());
}