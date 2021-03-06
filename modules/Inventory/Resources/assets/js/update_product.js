var materialCodes = new Array();
// var alreadyShowed = null;

$(document).ready(function(){
    // console.log(sessionMaterialCode)
    pickMaterial(pickMaterialUrl, true);

})
$(document).on("change", "#formAfter", function(){
    setAlreadyShowedItem()
    setMaterialCodeItem()
})

$(document).on("change", "#input-text", function(){
    triggerChangeFormAfter()
})

function triggerChangeFormAfter() {
    $('#formAfter').trigger("change");
}

function toggleSaveResetBtn(action) {
    if(action === "hide") {
        $('button[type="submit"]').hide();
        $('button[type="reset"]').hide();
    }

    if(action === "show") {
        $('button[type="submit"]').show();
        $('button[type="reset"]').show();
    }
}

function setAlreadyShowedItem() {
    let alreadyShowed = document.querySelectorAll("#formAfter div[id^=inputMaterial]");
    let alreadyShowedArr = [];
    alreadyShowed.forEach( function(e){
        alreadyShowedArr.push(e.outerHTML);
    })
    sessionStorage.setItem("alreadyShowed", JSON.stringify(alreadyShowedArr));
}

function setMaterialCodeItem() {
    let newSessionMaterialCode = [];
    let alreadyShowed = JSON.parse(sessionStorage.getItem("alreadyShowed"));
    if(alreadyShowed !== null) {
        alreadyShowed.forEach(function(element, index) {
            let code = $(element).attr("id").substring("inputMaterial".length);
            newSessionMaterialCode.push(code);
        })
    }

    sessionStorage.setItem("sessionMaterialCode", newSessionMaterialCode);
}
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
    
    let material = sameValue(materialCodes);
    let uniqueMaterial = Object.keys(material);
    let sessionMaterialCode = sessionStorage.getItem("sessionMaterialCode");
    sessionMaterialCode = (sessionMaterialCode !== null && sessionMaterialCode !== "" && uniqueMaterial.length > 0) ? uniqueMaterial.concat(sessionMaterialCode.split(",")) : uniqueMaterial;
    let material_code = onload ? sessionMaterialCode : uniqueMaterial;
    if (onload) {
        setMaterialCodeItem();
        let alreadyShowed = JSON.parse(sessionStorage.getItem("alreadyShowed"));
        if(alreadyShowed !== null) {
            $('#formAfter').html(alreadyShowed.join(""));
        }
        triggerChangeFormAfter()
        if(alreadyShowed.length >0){
            toggleSaveResetBtn('show')
        }else{
            toggleSaveResetBtn('hide')
        }
        // console.log(["showed join", alreadyShowed.join(""), newSessionMaterialCode]);
    } else {
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
                triggerChangeFormAfter()
                toggleSaveResetBtn('show')
            },
        });
    }

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
    triggerChangeFormAfter()

    let alreadyShowed = JSON.parse(sessionStorage.getItem("alreadyShowed"));
    if(alreadyShowed === null || alreadyShowed.length <= 0) {
        toggleSaveResetBtn('hide')
    }
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
function clearSession() {
    sessionStorage.clear();
}
