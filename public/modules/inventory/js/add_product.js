var materialCodes = new Array();

$(document).ready(function(){
    pickMaterial(pickMaterialUrl);
    // let sessionMaterial = sessionStorage.getItem('prevPickMaterial');
    // let selectedMaterial = sessionMaterial !== "" ? sessionMaterial.split(",") : null;
    // setPickedMaterialValues(selectedMaterial);
    getPickedMaterialValues();
})

function openModal(url){
    let sessionMaterial = sessionStorage.getItem('prevPickMaterial');
    let selectedMaterial = (sessionMaterial !== "" && sessionMaterial !== null) ? sessionMaterial.split(",") : null;
    getPickedMaterialValues();

    console.log(['selectedOnModalOpen', selectedMaterial]);
    $.ajax({
        type: "GET",
        url: url,
        data:{selectedMaterial : selectedMaterial},
        success: function(data){
            $('.modal-body').replaceWith(data);
            $("#mediumModal").modal('show');
        },
   });
}

function setPickedMaterialValues() {
    let inputVal = [];
    let sessionMaterial = sessionStorage.getItem('prevPickMaterial');
    let selectedMaterial = (sessionMaterial !== "" && sessionMaterial !== null) ? sessionMaterial.split(",") : null;

    if(selectedMaterial !== null) {
        selectedMaterial.forEach(function(val, i) {
            let materialElement = $(`#inputMaterial${val} input[name=${val}]`);
            // inputVal["inputMaterial"+val] = $(materialElement).val();
            inputVal.push({
                "element" : `#inputMaterial${val} input[name=${val}]`,
                "value"   : $(materialElement).val()
            })
        })
        sessionStorage.removeItem("pickedMaterialValues");
        sessionStorage.setItem("pickedMaterialValues", JSON.stringify(inputVal));
    }

    console.log(["inputVal", JSON.parse(sessionStorage.getItem("pickedMaterialValues"))]);
}

function getPickedMaterialValues() {
    let sessionPickedMaterialValues = JSON.parse(sessionStorage.getItem("pickedMaterialValues"));
    if(Array.isArray(sessionPickedMaterialValues)) {
        console.log(sessionPickedMaterialValues);
        sessionPickedMaterialValues.forEach(function(val, i) {
            let element = val.element;
            let value = val.hasOwnProperty("value") ? val.value : "";
            $(element).val(value);
            console.log([element, value]);
        })
    }
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

function clearSession() {
    sessionStorage.clear();
}

function selectedMaterial(code){
        materialCodes.push(code);
}
function pickMaterial(url){
    console.log('masuk ke pickmaterial');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    
    let material = sameValue(materialCodes);
    let uniqueMaterial = Object.keys(material);
    
    let sessionMaterial = sessionStorage.getItem('prevPickMaterial');
    let allCode = (sessionMaterial !== "" && sessionMaterial !== null) ? uniqueMaterial.concat(sessionMaterial.split(",")) : uniqueMaterial ;
    console.log(['allCode', allCode]);
    $.ajax({
        type:"post",
        url:url,
        data:{material_code:allCode},
        success:function(res){
            materialCodes = [];
            sessionStorage.removeItem('prevPickMaterial');  
            sessionStorage.setItem('prevPickMaterial',res.data);        
            $('#formAfter').replaceWith(res.html);
            console.log('isi session storage',sessionStorage.getItem('prevPickMaterial'));
            if(sessionStorage.getItem('prevPickMaterial') !== ''){
                $('#btn-reset').show();
                $('#btn-save').show();
            }
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

    let sessionMaterial = sessionStorage.getItem('prevPickMaterial');

    if(sessionMaterial !== "") {
        let newSessionMaterial = sessionMaterial.split(",");
        let index = newSessionMaterial.indexOf(id);
 
        console.log('tipe :',typeof newSessionMaterial)
        if (index > -1) {
            newSessionMaterial.splice(index, 1);
        }
        if(newSessionMaterial == ''){
            $('#btn-reset').hide(); 
            $('#btn-save').hide();
        }

        
        sessionStorage.removeItem('prevPickMaterial');
        sessionStorage.setItem('prevPickMaterial',newSessionMaterial);   
        console.log(['onRemove', newSessionMaterial]);
    }

    

}
