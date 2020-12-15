<?php

namespace App\Http\Controllers;

use App\Jobs\SalesCsvProcess;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload-file');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => ['file']
        ]);

        $data   =   file($request->file);

        // Chunking file
        $chunks = array_chunk($data, 1000);

        $header = [];
        $batch  = Bus::batch([])->dispatch();

        foreach ($chunks as $key => $chunk) {

            $data = array_map('str_getcsv', $chunk);

            if ($key === 0)
            {
                $header = $data[0];
                unset($data[0]);
            }

            $batch->add(new SalesCsvProcess($data, $header));
        }

        return $batch;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    public function batchInProgress()
    {
        $batches = DB::table('job_batches')->where('pending_jobs', '>', 0)->get();
        if (count($batches) > 0) {
            return Bus::findBatch($batches[0]->id);
        }

        return [];
    }
}
