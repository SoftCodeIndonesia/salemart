<?php

namespace Database\Seeders;

use App\Models\StakeholderFeat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StakeholderFeatSheed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StakeholderFeat::truncate();

        $stakeholderFeatModel = new StakeholderFeat();

        $data[0]['feature_name'] = 'Setting';
        $data[0]['feature_route'] = '/stakeholder_setting';
        $data[0]['feature_description'] = 'default feature stakeholder for developer rules';
        $data[0]['feature_icon'] = '';
        $data[0]['last_updated'] = time();
        $data[0]['created_by'] = 'system';
        $data[0]['parent_id'] = 0;

        $data[1]['feature_name'] = 'Permission';
        $data[1]['feature_route'] = '/stakeholder_permission';
        $data[1]['feature_description'] = 'default feature stakeholder for developer rules';
        $data[1]['feature_icon'] = '';
        $data[1]['last_updated'] = time();
        $data[1]['created_by'] = 'system';
        $data[1]['parent_id'] = 1;

        $data[2]['feature_name'] = 'Feature';
        $data[2]['feature_route'] = '/stakeholder_feat';
        $data[2]['feature_description'] = 'default feature stakeholder for developer rules';
        $data[2]['feature_icon'] = '';
        $data[2]['last_updated'] = time();
        $data[2]['created_by'] = 'system';
        $data[2]['parent_id'] = 1;

        foreach ($data as $key => $value) {
            $featHolder = StakeholderFeat::all()->count();

            $count = ($featHolder + 1);

            $key = 'FEAT/HOLDER' . str_pad($count, 4, "0", STR_PAD_LEFT);
            $value['feature_code'] =  $key;
            // var_dump($value);
            DB::table('stakeholder_feature')->insert($value);
            // $stakeholderFeatModel->set_data($value);
            // $stakeholderFeatModel->create();
            // StakeholderFeat::create($value);
        }
    }
}
