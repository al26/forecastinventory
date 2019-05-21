<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mediumModalLabel">Bahan baku</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                @php
                    $url = route('getmaterialselected',Auth::user()->getRoleNames()[0]);
                @endphp
                {{-- <button type="button" onclick="openFormAdd()" class="btn btn-info" >Tambah baru</button> --}}
                <button type="button" onclick="removeMaterial()" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" onclick="pickMaterial(`{{$url}}`)" class="btn btn-primary">Pilih</button>
            </div>
        </div>
    </div>
</div>

<script>
    var pickMaterialUrl = "{{$url}}";
</script>