var materialCodes = new Array();
// var sessionMaterialCode;

$(document).ready(function(){
    // console.log(sessionMaterialCode)
    pickMaterial(pickMaterialUrl, true);
})
// openModal(`http://localhost:8000/administrator/inventory/getDataMaterial`)
function openModal(url){
    let sessionMaterialCode = sessionStorage.getItem("sessionMaterialCode");
    let code = (sessionMaterialCode !== null && sessionMaterialCode !== "") ? sessionMaterialCode.split(',') : $('#btnMaterial').data('code');
    $.ajax({
        type: "GET",
        url: url,
        data:{material_code:code},
        success: function(data){
            sessionStorage.setItem("sessionMaterialCode",code);
            sessionStorage.getItem("sessionMaterialCode");
            $('.modal-body').replaceWith(data);
            $("#mediumModal").modal('show');
        },
   });
}
// function to add material 
function submitMaterial(url){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    
    var material = $("input[name=material-name]").val();
    var tipe = $("input[name=material-tipe]").val();
    var unit = $("input[name=material-unit]").val();
    let url2 = $('#btnTambahMaterial').data('url');
    console.log(url2);
    $.ajax({
        type:"POST",
        url:url,
        data:{material_name:material,material_type:tipe,material_unit:unit},
        success:function(data){
            console.log(data);
            if(data.status){
                materialCodes=[];
                $("#mediumModal").modal('hide');
                openModal(url2);
            }else{
                openModal(url2);
            }
        },
    });
}

function selectedMaterial(code){
        materialCodes.push(code);
        console.log("selected material",materialCodes);
}

// pickMaterial(`http://localhost:8000/administrator/inventory/getmaterialselected`)
function pickMaterial(url, onload = false){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    let alreadyShowed = null;
    let material = sameValue(materialCodes);
    let uniqueMaterial = Object.keys(material);
    let sessionMaterialCode = sessionStorage.getItem("sessionMaterialCode");
    sessionMaterialCode = (sessionMaterialCode !== null && sessionMaterialCode !== "" && uniqueMaterial.length > 0) ? sessionMaterialCode.concat(","+uniqueMaterial) : uniqueMaterial;
    let material_code = onload ? sessionMaterialCode : uniqueMaterial;
    if (onload) {
        alreadyShowed = $('#formAfter').find("input[id=text-input]");
        console.log(alreadyShowed);
        if(material_code.length <= 0 && sessionMaterialCode.length > 0) {
            let diff = arr_diff(alreadyShowed, sessionMaterialCode);
            if(diff.length > 0) {
                material_code = diff;
                sessionMaterialCode = materialCodes;
            }
        }
    }
    console.log(material_code)
    $.ajax({
        type:"POST",
        url:url,
        data:{material_code:material_code,data_action:"update"},
        success:function(res){
            console.log('data dari pick',res)
            materialCodes = [];
            sessionStorage.removeItem("sessionMaterialCode");
            sessionStorage.setItem("sessionMaterialCode", sessionMaterialCode);
            $('#formAfter').append(res.html);
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
    $(param).remove().fadeOut("slow");
}

function arr_diff (a1, a2) {

    var a = [], diff = [];

    for (var i = 0; i < a1.length; i++) {
        a[a1[i]] = true;
    }

    for (var i = 0; i < a2.length; i++) {
        if (a[a2[i]]) {
            delete a[a2[i]];
        } else {
            a[a2[i]] = true;
        }
    }

    for (var k in a) {
        diff.push(k);
    }

    return diff;
}