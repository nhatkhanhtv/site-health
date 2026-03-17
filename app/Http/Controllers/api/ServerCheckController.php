<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServerCheck;
use App\Models\ServerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServerCheckController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Log::debug($request->all());
        $serverInfo = ServerInfo::where('ip',$request->ip())->first();
        if($serverInfo) {
            $data = $request->only(['cpu','ram','disk']);
            
            $serverCheck = $serverInfo->serverCheck()->create([
                'ram' => $this->_formatStoreStats($data['ram'],'GB',1024),
                'cpu' => $this->_formatStoreStats($data['cpu'],'%'),
                'disk' => $this->_formatStoreStats($data['disk'],"GB",(1024*1024))
            ]);
                return response([
                    'message' => 'Received Successfully',
                    'data'=> $serverCheck,
        
                ],200);
            // }
            
        }
        return response([
            'message'=>'server not found'
        ], 404);
      

        
    }

    private function _formatStoreStats($statArray, $unit, $divide=1) {
        $used = number_format($statArray['used']/$divide,2).$unit;
        $total = number_format($statArray['total']/$divide,2). $unit;
        $usePercent = round(($statArray['used']/$statArray['total'])*100,2). "%";

        return "Used: ". $used
                . "<br> Total:".$total
                . "<br>Use Percent: ".$usePercent;
    }
}
