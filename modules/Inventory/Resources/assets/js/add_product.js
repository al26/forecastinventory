var materialCodes = new Array();
function openModal(url){
    $.ajax({
        type: "GET",
        url: url,
        success: function(data){
            $('.modal-body').replaceWith(data);
            $("#mediumModal").modal('show');
        },
   });
}

function submitMaterial(url){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    console.log(url);
    var material = $("input[name=material-name]").val();
    var tipe = $("input[name=material-tipe]").val();
    var unit = $("input[name=material-unit]").val();
    $.ajax({
        type:"POST",
        url:url,
        data:{material_name:material,material_type:tipe,material_unit:unit},
        success:function(data){
            console.log(data)
            if(data.status){
                materialCodes=[];
                $("#mediumModal").modal('hide');
                openModal("getDataMaterial");
            }else{
                openModal("getDataMaterial");
            }
        },
    });
}

function selectedMaterial(code){
        materialCodes.push(code);
}
function pickMaterial(url){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    // let material = materialCodes.filter(unique);
    let material = sameValue(materialCodes);
    let uniqueMaterial = Object.keys(material);
    $.ajax({
        type:"post",
        url:url,
        data:{material_code:uniqueMaterial},
        success:function(data){
            materialCodes = [];          
            $('#formAfter').replaceWith(data);
            $('button[type="submit"]').removeAttr("hidden");
            $('button[type="reset"]').removeAttr("hidden");
        },
    });
    $("#mediumModal").modal('hide');
}
function removeMaterial(){
    materialCodes=[];
}

function sameValue(element){
    let counts = {};
    element.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
    remove(2,counts);
    return counts;
}

function remove(num, obj){
    for (let property in obj) {
            if (obj[property] % num == 0) {
                delete obj[property];
            }
        }
}

function removeInputMaterial(id){
    let param = '#inputMaterial'+id; 
    $(param).remove();
}