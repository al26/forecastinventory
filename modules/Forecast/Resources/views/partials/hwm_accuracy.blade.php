<div class="col-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">X(t)</th>
                <th scope="col">S(t)</th>
                <th scope="col">A(t)</th>
                <th scope="col">B(t)</th>
                <th scope="col">F(t)</th>
                <th scope="col">Error</th>
                <th scope="col">Abs. Error</th>
                <th scope="col">Error^2</th>
                <th scope="col">PE</th>
                <th scope="col">Abs. PE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($multiplicative as $key => $item)
                <tr>
                    <td>{{$key+=1}}</td>
                    <td>{{$item->xt}}</td>
                    <td>{{$item->st}}</td>
                    <td>{{$item->at}}</td>
                    <td>{{$item->bt}}</td>
                    <td>{{$item->ft}}</td>
                    <td>{{$item->error}}</td>
                    <td>{{$item->error_abs}}</td>
                    <td>{{$item->error_square}}</td>
                    <td>{{$item->error_percentage}}</td>
                    <td>{{$item->error_abs_percent}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>