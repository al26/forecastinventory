var materialCodes = new Array();
function openModal(url){
    $.ajax({
        type: "GET",
        url: url,
        success: function(data){
            
            $('.modal-body').fadeIn('slow').replaceWith(data);
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
    var material = $("input[name=material-input]").val();
    $.ajax({
        type:"POST",
        url:url,
        data:{material_name:material},
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

function selectedMaterial(code){
        materialCodes.push(code);
        console.log(materialCodes);
        
}
function pickMaterial(url){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    // let material = materialCodes.filter(unique);
    let material = sameValue(materialCodes);
    // console.log(material);
    // console.log(Object.keys(material));
    let uniqueMaterial = Object.keys(material);
    $.ajax({
        type:"post",
        url:url,
        data:{material_code:uniqueMaterial},
        success:function(data){
            materialCodes = [];          
            console.log(data)
            $('#formMaterial').replaceWith(data);
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
    $(param).fadeOut( "slow");
    console.log(id)
    
}