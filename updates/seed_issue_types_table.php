<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 20:18
 */

namespace istheweb\iscorporate\updates;

use Istheweb\IsCorporate\Models\IssueType;
use Seeder;

class SeedIssueTypesTable extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        IssueType::create([
            'name'        => 'Normal Issue',
            'description' => 'Report normal issue errors.'
        ]);

        IssueType::create([
            'name'        => 'Urgent issues',
            'description' => 'Report urgent issue errors.'
        ]);
    }

}