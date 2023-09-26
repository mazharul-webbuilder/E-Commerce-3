$(document).ready(function () {
    $('#dataTableCategory').DataTable({
        responsive: true
    });

    $('#dataTableLatestNews').DataTable({
        responsive: true
    });

    $('#dataTableAuthor').DataTable({
        responsive: true,
        autoWidth: false
    });

    // var table = $('#example').DataTable({
    //     responsive: true
    // })
    // .columns.adjust()
    // .responsive.recalc();


    $('#dataTableUserPersonalFav').DataTable({
        responsive: true
    });


    $('#dataTableUserCommentList').DataTable({
        responsive: true
    });

});
