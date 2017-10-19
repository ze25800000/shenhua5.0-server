<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27 0027
 * Time: 16:33
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
use app\model\OilStandard;
use app\model\OilUsed;
use app\service\BaseController;
use app\model\WorkHour;
use think\Db;
use think\Exception;
use think\Request;

class Admin extends BaseController {
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'delAll,deleteRecentUploadData']
    ];

    public function delAll() {
        try {
            Equipment::query('TRUNCATE equipment');
            InfoWarning::query('TRUNCATE info_warning');
            OilAnalysis::query('TRUNCATE oil_analysis');
            OilDetail::query('TRUNCATE oil_detail');
            OilStandard::query('TRUNCATE oil_standard');
            WorkHour::query('TRUNCATE work_hour');
            OilUsed::query('TRUNCATE oil_used');
        } catch (Exception $e) {
            $this->error('执行失败');
        }
        $this->success('执行成功', '/');
    }

    public function deleteRecentUploadData() {
        $url = Request::instance()->url();
        preg_match('/oiling\/(\w*)\/delrecent/', $url, $matches);
        $type = $matches[1];
        switch ($type) {
            case 'info':
                $ids        = InfoWarning::getRecentInfoWarningIds();
                $oilUsedIds = OilUsed::getRecentOilUsedIds();
                Db::table('oil_used')->delete($oilUsedIds);
                $result = Db::table('info_warning')->delete($ids);
                break;
            case 'workhour':
                $ids    = WorkHour::getRecentWorkHourIds();
                $result = Db::table('work_hour')->delete($ids);
                break;
            case 'analysis':
                $ids    = OilAnalysis::getRecentOilAnalysisIds();
                $result = Db::table('oil_analysis')->delete($ids);
                break;
            default :
                $result = null;
                break;
        }

        if (!$result) {
            $this->error('删除最近一次上传数据失败');
        }
        $this->success('删除最近一次上传数据成功', '/');
    }
}