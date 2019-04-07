$("#collapseExample3 ").on("shown.bs.collapse", function () {
    getProductionData();
});

$(document).ready(function () {
    var table = $("#production-table").DataTable();
    $("#production-table tbody").on("click", ".buttonProduction", function () {
        var tr = $(this).closest("tr");
        var row = table.row(tr);
        // console.log($(this).attr("href"));
        let url = $(this).attr("href");

        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                console.log(response);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass("shown");
                } else {
                    // Open this row
                    row.child(format(response)).show();
                    tr.addClass("shown");
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
});

function format(d) {
    // `d` is the original data object for the row
    let element = '<div class="table-responsive table-hover"><table class="table table-bordered">' +
        '<thead class="thead-light">' +
        "<tr>" +
        "<th>Nama Bahan Baku</td>" +
        "<th>Kebutuhan Material </th>" +
        "<th>Satuan</th>" +
        "<th>Stock Material</th>" +
        "<th>Status Material</th>" +
        "</tr>" +
        "</thead>" +
        "<tbody>";

    $.each(d, function (index, value) {
        let totalMaterial = value.kebutuhan_material * value.jumlah_production;
        element += `<tr>
            <td> ${value.material_name}</td>
            <td> ${totalMaterial}</td>
            <td> ${value.unit} </td>
            <td> ${value.stock_material} </td>
            <td>${totalMaterial > value.stock_material ? "<span class='badge badge-warning'>restock</span>" : "<span class='badge badge-info'>Cukup</span>"}</td>
        </tr>`;

    });

    element += `</tbody></table></div>`;

    return (
        element
    );
}
