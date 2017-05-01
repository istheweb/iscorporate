<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 20:16
 */

namespace istheweb\iscorporate\updates;

use Istheweb\IsCorporate\Models\IssueStatus;
use Seeder;

class SeedIssueStatusesTable extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        $statuses = ['Nuevo', 'En progreso', 'Solucionado', 'Pregunta'];

        foreach ($statuses as $status) {
            IssueStatus::create([
                'name' => $status
            ]);
        }
    }

}
