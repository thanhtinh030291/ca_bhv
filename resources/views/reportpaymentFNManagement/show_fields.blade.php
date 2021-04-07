<div class="card-body table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr class="bg-info text-white">
                <th scope="col" class="noVis">STT</th>
                <th scope="col" class="noVis">Claim Type</th>
                <th scope="col" class="noVis">CL No</th>
                <th scope="col" class="noVis">INV NO</th>
                <th scope="col" class="noVis">INCUR</th>
                <th scope="col" class="noVis">TF AMT</th>
                <th scope="col" class="noVis">TF DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($CPS_PAYMENTS as $key => $item)
            <tr>
                <td>{!! $key + 1 !!}</td>
                <td>{!! $item->CL_TYPE !!}</td>
                <td>{!! $item->CL_NO !!}</td>
                <td>{!! $item->INV_NO !!}</td>
                <td>{!! $item->incur !!}</td>
                <td>{!! formatPrice($item->TF_AMT) !!}</td>
                <td>{!! $item->TF_DATE !!}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>