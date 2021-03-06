<div class="card-body table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr class="bg-info text-white">
                <th scope="col" class="noVis">STT</th>
                <th scope="col" class="noVis">Claim Type</th>
                <th scope="col" class="noVis">CL No</th>
                <th scope="col" class="noVis">MEMB NAME</th>
                <th scope="col" class="noVis">INV NO</th>
                <th scope="col" class="noVis">INCUR</th>
                <th scope="col" class="noVis">DIAG DESC </th>
                <th scope="col" class="noVis">PAYEE</th>
                <th scope="col" class="noVis">POCY NO</th>
                <th scope="col" class="noVis">POCYHODER Name</th>
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
                <td>{!! $item->MEMB_NAME !!}</td>
                <td>{!! $item->INV_NO !!}</td>
                <td>{!! $item->incur !!}</td>
                <td>{!! $item->diag_desc !!}</td>
                <td>{!! $item->PAYEE !!}</td>
                <td>{!! substr($item->POCY_NO,0,6) . "-" . substr($item->POCY_NO,6,3) . "-" . substr($item->POCY_NO,-5)!!}</td>
                <td>{!! $item->ph_name !!}</td>
                <td>{!! $item->TF_AMT !!}</td>
                <td>{!! $item->TF_DATE !!}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>