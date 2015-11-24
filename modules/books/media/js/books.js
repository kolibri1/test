$('.activity-view-link').click(function() {
    $.get(
        'путь до страницы с шаблоном',
        {
            id: $(this).closest('tr').data('key')
        },
        function (data) {
            $('.modal-body').html(data);
            $('#activity-modal').modal();
        }
    );
});