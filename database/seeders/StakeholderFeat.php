<?php

namespace Database\Seeders;

use App\Models\StakeholderFeat;
use Illuminate\Database\Seeder;

class StakeholderFeatSheed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stakeholderFeatModel = new StakeholderFeat();

        $data['feature_name'] = 'feature';
        $data['feature_route'] = '/stakeholder_feat';
        $data['feature_description'] = 'default feature stakeholder for developer rules';
        $data['feature_icon'] = '';
        $data['last_updated'] = time();
        $data['created_by'] = 'system';
        $data['parent_id'] = 0;

        $stakeholderFeatModel->set_data($data);
        $stakeholderFeatModel-create();
    }
}