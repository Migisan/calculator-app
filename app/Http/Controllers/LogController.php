<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
    /**
     * 1ページのアイテム数
     */
    private $per_page;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->per_page = config('const.per_page');
    }

    /**
     * 一覧
     * @return Log
     */
    public function index()
    {
        $logs = Log::orderBy('created_at', 'desc')->paginate($this->per_page);
        \Debugbar::info($logs);

        return $logs;
    }

    /**
     * 保存
     * @return Response
     */
    public function store(Request $reqeust)
    {
        $log = new Log;
        $input = $reqeust->all();
        $log->fill($input)->save();

        return response()->json([
            'res' => "success"
        ]);
    }

    /**
     * 削除
     * @param $id
     */
    public function delete($id)
    {
        Log::find($id)->delete();

        return response()->json([
            'res' => "success"
        ]);
    }
}
