$(document).ready(function(){
      let hash = window.location.hash;
    if (hash) {
        $('#myTab .nav-item .nav-link').removeClass('active');
        $(hash+'-tab').addClass('active');
    }

    if ( $.fn.dataTable.isDataTable( '#comparison-table' ) ) {
        comparison_table = $('#comparison-table').DataTable();
        comparison_table.destroy();
    }

})