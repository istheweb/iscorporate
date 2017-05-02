<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 3/01/17
 * Time: 15:53
 */

namespace istheweb\iscorporate\updates;

use Backend\Models\User;
use Backend\Models\UserGroup;
use Carbon\Carbon;
use Istheweb\IsCorporate\Models\Employee;
use Istheweb\IsCorporate\Models\IssueStatus;
use Istheweb\IsCorporate\Models\IssueType;
use Istheweb\IsCorporate\Models\OptionValue;
use Istheweb\IsCorporate\Models\ProjectOption;
use Istheweb\IsCorporate\Models\ProjectType;
use Istheweb\IsCorporate\Models\Role;
use Istheweb\IsPdf\Models\Layout;
use Istheweb\IsPdf\Models\Template;
use October\Rain\Database\Updates\Seeder;


class SeedProjectTypeOptions extends Seeder
{
    protected  $types = [
            'Actualizaciones',
            'Diseño web',
            'Formación',
            'Diseño Gráfico',
            'Posicionamiento',
            'Tienda Online',
            'Social Media',
            'Intranet',
            'Mantenimiento',
            'Personalizado'
        ];

    protected $options = [
        ['name' =>'Diseño Gráfico', 'code' => 'graphic_design'],
        ['name' =>'Diseño Web', 'code' => 'web_design'],
        ['name' =>'Posicionamiento', 'code' => 'seo'],
        ['name' =>'Tienda online', 'code' => 'ecommerce'],
        ['name' =>'Intranet', 'code' => 'back_office'],
        ['name' =>'Social Media', 'code' => 'social_media'],
        ['name' =>'Mantenimiento', 'code' => 'maintenance'],
        ['name' =>'Personalizado', 'code' => 'personalized'],

    ];

    protected $roles = [
        ['name' => 'Diseño gráfico', 'description' => 'Encargado de los servicios de diseño gráfico'],
        ['name' => 'Diseño web', 'description' => 'Encargado de los servicios de diseño web'],
        ['name' => 'SEO Manager', 'description' => 'Encargado de los servicios SEO '],
        ['name' => 'Desarrollador', 'description' => 'Encargado de los servicios de técnicos'],
        ['name' => 'Gerente', 'description' => 'Gerente de la empresa'],
        ['name' => 'Administración', 'description' => 'Administración de la empresa'],
    ];

    protected $values = [
        ['project_option' => '1', 'code' => 'logo_graphic_design', 'value' => 'Logo', 'price' => '150'],
        ['project_option' => '1', 'code' => 'dossier_graphic_design', 'value' => 'Dossier Corporativo', 'price' => '350'],
        ['project_option' => '2', 'code' => 'page_web_design', 'value' => 'Página web', 'price' => '700'],
        ['project_option' => '2', 'code' => 'personal_web_design', 'value' => 'Página personal', 'price' => '700'],
        ['project_option' => '2', 'code' => 'corporate_web_design', 'value' => 'Página corporativa', 'price' => '1500'],
        ['project_option' => '2', 'code' => 'portal_web_design', 'value' => 'Portal', 'price' => '2500'],
        ['project_option' => '4', 'code' => 'basic_ecommerce', 'value' => 'Tienda online básica', 'price' => '900'],
        ['project_option' => '4', 'code' => 'avanced_ecommerce', 'value' => 'Tienda online avanzada', 'price' => '1500'],
        ['project_option' => '4', 'code' => 'premium_ecommerce', 'value' => 'Tienda online premium', 'price' => '2500'],
        ['project_option' => '2', 'code' => 'blog_web_design', 'value' => 'Blog', 'price' => '500'],
        ['project_option' => '3', 'code' => 'posicionamiento_seo', 'value' => 'Posicionamiento', 'price' => '200'],
        ['project_option' => '3', 'code' => 'buscadores_seo', 'value' => 'Buscadores', 'price' => '200'],
        ['project_option' => '6', 'code' => 'basico_social_media', 'value' => 'Plan Social Media Básico', 'price' => '350'],
        ['project_option' => '6', 'code' => 'medio_social_media', 'value' => 'Plan Social Media Medio', 'price' => '450'],
        ['project_option' => '6', 'code' => 'avanzado_social_media', 'value' => 'Plan Social Media Avanzado', 'price' => '650'],
        ['project_option' => '6', 'code' => 'total_social_media', 'value' => 'Plan Social Media Total', 'price' => '750'],
        ['project_option' => '6', 'code' => 'otro_social_media', 'value' => 'Otros', 'price' => '450'],
        ['project_option' => '7', 'code' => 'dominio_mantenimiento', 'value' => 'Dominio', 'price' => '10'],
        ['project_option' => '7', 'code' => 'alojamiento_mantenimiento', 'value' => 'Alojamiento', 'price' => '200'],
        ['project_option' => '7', 'code' => 'soporte_mantenimiento', 'value' => 'Soporte', 'price' => '150'],
        ['project_option' => '8', 'code' => 'project_personalized', 'value' => 'Proyecto personalizado', 'price' => '500'],
    ];

    protected $statuses = ['Nuevo', 'En progreso', 'Solucionado', 'Pregunta'];



    public function run()
    {
        $i = 1;
        foreach ($this->types as $value){
            $pt = new ProjectType();
            $pt->name = $value;
            $pt->slug = strtolower($value);
            $pt->nest_left = $i;
            $i++;
            $pt->nest_right = $i;
            $i++;
            $pt->nest_depth = 0;
            $pt->created_at = Carbon::now();
            $pt->updated_at = Carbon::now();
            $pt->save();
        }

        foreach($this->options as $option){
            $op = ProjectOption::create($option);
            $op->created_at = Carbon::now();
            $op->updated_at = Carbon::now();
            $op->save;
        }

        foreach($this->roles as $role){
            $r = Role::create($role);
            $r->setCreatedAt(Carbon::now());
            $r->setUpdatedAt(Carbon::now());
            $r->save();
        }

        foreach($this->values as $value){
            $op = OptionValue::create($value);
            $op->created_at = Carbon::now();
            $op->updated_at = Carbon::now();
            $op->save;

        }

        foreach ($this->statuses as $status) {
            IssueStatus::create([
                'name' => $status
            ]);
        }

        IssueType::create([
            'name'        => 'Normal Issue',
            'description' => 'Report normal issue errors.'
        ]);

        IssueType::create([
            'name'        => 'Urgent issues',
            'description' => 'Report urgent issue errors.'
        ]);

        $users = User::all();
        if($users->count() == 1){

            $new_users = [
                [
                    'login'                  => 'arangel',
                    'email'                 => 'soporte@istheweb.com',
                    'first_name'            => 'Andrés',
                    'last_name'             => 'Rangel Torres',
                    'password'              => '6102Espartinas',
                    'password_confirmation' => '6102Espartinas',
                    'permissions'           => [],
                    'is_superuser'          => true,
                    'is_activated'          => true
                ],
                [
                    'login'                  => 'aconnect',
                    'email'                 => 'arangeltorres@gmail.com',
                    'first_name'            => 'Andrés',
                    'last_name'             => 'Rangel Torres',
                    'password'              => '6102Espartinas',
                    'password_confirmation' => '6102Espartinas',
                    'permissions'           => [],
                    'is_superuser'          => false,
                    'is_activated'          => true
                ]
            ];

            foreach($new_users as $user){
                $user = User::create($user);
                $users->add($user);
            }

            $connectGroup = UserGroup::whereCode(Employee::USER_GROUP_CODE)->first();

            if(is_null($connectGroup)){

                $connect_permissions = [
                    "media.manage_media"                            => "1",
                    "backend.manage_preferences"                    => "1",
                    "system.access_logs"                            => "1",
                    "system.manage_mail_settings"                   => "1",
                    "system.manage_mail_templates"                  => "1",
                    "istheweb.ispdf.manage_layouts"                 => "1",
                    "istheweb.ispdf.manage_templates"               => "1",
                    "istheweb.connect.subscribers"                  => "1",
                    "istheweb.connect.events"                       => "1",
                    "istheweb.connect.contacts"                     => "1",
                    "istheweb.connect.inboxes"                      => "1",
                    "istheweb.iscorporate.access_projects"          => "1",
                    "istheweb.iscorporate.access_employees"         => "1",
                    "istheweb.iscorporate.access_clients"           => "1",
                    "istheweb.iscorporate.access_budgets"           => "1",
                    "istheweb.iscorporate.access_invoices"          => "1",
                    "istheweb.iscorporate.access_providers"         => "1",
                    "istheweb.iscorporate.create_projects"          => "1",
                    "istheweb.iscorporate.delete_projects"          => "1",
                    "istheweb.iscorporate.access_project_types"     => "1",
                    "istheweb.iscorporate.access_options"           => "1",
                    "istheweb.iscorporate.access_issues"            => "1",
                    "istheweb.iscorporate.access_other_issues"      => "1",
                    "istheweb.iscorporate.access_issue_types"       => "1",
                    "istheweb.iscorporate.access_issue_statuses"    => "1",
                    "istheweb.iscorporate.access_reports"           => "1"
                ];

                $permissions = json_encode($connect_permissions);

                $connect = new UserGroup();
                $connect->name = 'Connect Group';
                $connect->created_at = Carbon::now();
                $connect->updated_at = Carbon::now();
                $connect->code = 'connect';
                $connect->description = 'Default connect group';
                $connect->is_new_user_default = 0;
                $connect->setPermissionsAttribute($permissions);
                $connectGroup = $connect->save();

                $connect_user = User::whereLogin('aconnect')->first();
                if(!$connect_user->inGroup($connectGroup)){
                    $connect_user->addGroup($connectGroup);
                }

                foreach($users as $user) {
                    if ($user->inGroup($connectGroup)) {
                        $empleado = new Employee();
                        $empleado->user = $user;
                        $empleado->created_at = Carbon::now();
                        $empleado->updated_at = Carbon::now();
                        $empleado->save();
                    }
                }

            }

        }


        $budget_layout = Layout::whereCode('iscorporate-budgets')->first();

        if(is_null($budget_layout)){
            $pdf_layouts = [
                [
                    'code' => 'iscorporate-budgets',
                    'name' => 'IsCorporate Budgets',
                    'content_html' => '<html>\r\n    <head>\r\n        <style type="text/css" media="screen">\r\n            {{ css|raw }}\r\n        </style>\r\n    </head>\r\n    <body style="background: url({{ background_img }}) top left no-repeat;">\r\n        <div class="header">\r\n            <p class="left"></p>\r\n            <p class="right">\r\n                <strong>{{ company.name }}</strong><br>\r\n                <strong>{{ company.url}}</strong><br>\r\n            </p>\r\n        </div>\r\n        <div class="footer">\r\n        </div>\r\n        {{ content_html|raw }}\r\n    </body>\r\n</html>',
                    'content_css' => "@font-face {\r\n    font-family: \'Open Sans\';\r\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Regular.ttf\');\r\n}\r\n\r\n@font-face {\r\n    font-family: \'Open Sans\';\r\n    font-weight: bold;\r\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Bold.ttf\');\r\n}\r\n\r\n@font-face {\r\n    font-family: \'Open Sans\';\r\n    font-style: italic;\r\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Italic.ttf\');\r\n}\r\n\r\n@font-face {\r\n    font-family: \'Open Sans\';\r\n    font-style: italic;\r\n    font-weight: bold;\r\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-BoldItalic.ttf\');\r\n}\r\n\r\n@page {\r\n    margin: 0;\r\n    padding: 0;\r\n}\r\n\r\nbody {\r\n    font-family: \'Open Sans\', sans-serif;\r\n    font-size: 14px;\r\n}\r\n\r\n.header {\r\n    position: fixed;\r\n    top: 3%;\r\n    left: 30%;\r\n}\r\n\r\n.header .left {\r\n    color: #373430;\r\n    font-size: .9em;\r\n    text-transform: uppercase;\r\n    width: 60%;\r\n    display: inline-block;\r\n}\r\n\r\n.header .right {\r\n    font-size: .7em;\r\n    color: #545554;\r\n    line-height: 1em;\r\n    text-align: right;\r\n    display: inline-block;\r\n    width: 30%;\r\n    padding-top: 1%;\r\n}\r\n\r\n.footer {\r\n    position: fixed;\r\n    bottom: 0;\r\n    left: 5%;\r\n    height: 12%;\r\n    font-size: .7em;\r\n    color: #545554;\r\n    line-height: 1em;\r\n}\r\n\r\n.footer .left {\r\n    display: inline-block;\r\n    width: 25%;\r\n}\r\n\r\n.footer .right {\r\n    display: inline-block;\r\n    width: 30%;\r\n    padding-top: 7%;\r\n}\r\n\r\n.content {\r\n    margin: 12% 0 0 10%;\r\n}\r\n\r\n.small-txt {\r\n    font-size: .7em;\r\n}\r\n\r\n.company-info {\r\n    display: inline-block;\r\n    width: 55%;\r\n    line-height: 1.1em;\r\n    font-size: 1.1em;\r\n}\r\n\r\n.customer-info {\r\n    display: inline-block;\r\n    width: 45%;\r\n    font-size: .9em;\r\n    height: 10%;\r\n}\r\n\r\n.summary {\r\n    margin: 10% 0 5% 0;\r\n    border-collapse: collapse;\r\n    width: 90%;\r\n}\r\n\r\n.summary th {\r\n    background-color: #BEBEBE;\r\n    border: 1px solid #000;\r\n    padding: 5px;\r\n}\r\n\r\n.summary td {\r\n    padding: 5px 10px;\r\n    border-right: 1px solid #000;\r\n}\r\n\r\n.summary .col-1 {\r\n    width: 15%;\r\n    text-align: center;\r\n    border-left: 1px solid #000;\r\n}\r\n\r\n.summary .col-2 {\r\n    width: 50%;\r\n}\r\n\r\n.summary .col-3 {\r\n    width: 15%;\r\n    text-align: right;\r\n}\r\n\r\n.summary .col-4 {\r\n    width: 20%;\r\n    text-align: right;\r\n}\r\n\r\n.summary .bt {\r\n    border-top: 1px solid #000;\r\n}\r\n\r\n.summary .sum-price .col-4 {\r\n    border-top: 1px solid #000;\r\n    border-bottom: 1px solid #000;\r\n}",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ];

            foreach($pdf_layouts as $value){
                $opv = new Layout();
                foreach($value as $key => $value){
                    $opv->{$key} = $value;
                }
                $opv->save();
            }
        }


        $budget_template = Template::whereCode('budget-template')->first();

        if(is_null($budget_template)){
            $pdf_templates = [
                [
                    'layout_id' => 1,
                    'code' => 'budget-template',
                    'title' => 'Budget Template',
                    'description' => '',
                    'content_html' => "<div class=\"content\">\r\n    <p class=\"small-txt\">{{ address }}</p>\r\n    \r\n    <p><strong>Nº de Pedido: {{ pdfNumber }}</strong><br><strong>Fecha: {{ \'now\'|date(\'d-m-Y\') }}</strong></p>\r\n\r\n    <p class=\"company-info\">\r\n        <strong>{{ company.name }}</strong><br>\r\n        <strong>{{ company.address }} </strong><br>\r\n        <strong>{{ company.zip_code }} {{ company.city }} {{ company.country }}</strong><br>\r\n        <strong>CIF: B90270711</strong>\r\n    </p>\r\n\r\n    <p class=\"customer-info\" >\r\n            <strong>CLIENTE</strong>: {{ cif }}<br>\r\n        {{ billingAddress|raw }}<br>\r\n        <strong>Dirección de envío</strong><br>\r\n        {{ shippingAddress|raw }}\r\n\r\n    </p>\r\n    \r\n    <table class=\"summary\">\r\n        <tr>\r\n            <th>Cantidad</th>\r\n            <th>Concepto</th>\r\n            <th>Precio</th>\r\n            <th>Neto</th>\r\n        </tr>\r\n        {% for item in items %}\r\n        <tr>\r\n            <td class=\"col-1\">{{ item.qty }}</td>\r\n            <td class=\"col-2\">{{ item.name }}</td>\r\n            <td class=\"col-3\">{{ item.price }} &euro;</td>\r\n            <td class=\"col-4\">{{ item.price }} &euro;</td>\r\n        </tr>\r\n        {% endfor %}\r\n\r\n        \r\n        <tr class=\"sum-price\">\r\n            <td colspan=\"3\" class=\"col-3 bt\">Subtotal</td>\r\n            <td class=\"col-4\">{{ subtotal }} &euro;</td>\r\n        </tr>\r\n        <tr class=\"sum-price\">\r\n            <td colspan=\"3\" class=\"col-3\"><strong>Total</strong></td>\r\n            <td class=\"col-4\">{{ total }} &euro;</td>\r\n        </tr>\r\n    </table>\r\n    <p><strong>Política de devoluciones</strong></p>\r\n\r\n    <p><small>Nuestra política de devolución es muy sencilla. <br>Podrás devolver cualquier artículo comprado en www.dxbwatch.es por las siguientes causas:</small></p>\r\n        <ul>\r\n            <li>Si el artículo presenta defectos de fabricación.</li>\r\n            <li>Si existe equivocación en el artículo enviado.</li>\r\n        </ul>\r\n        <p><small>En ambos casos el producto debe ser devuelto con todos sus accesorios y en el mismo estado en el que se entregó.<br>\r\n        En la recepción de mercancía errónea o dañada se aplicará el cambio físico de la misma solo si ésta fue reportada durante las primeras 72 horas posteriores a su entrega, en ningún caso se procederá a la devolución del importe abonado por el cliente, excepto si la reposición del producto no podemos hacerla en un plazo máximo de 7 días hábiles desde la recepción del producto devuelto.<br>\r\n        Para cualquier devolución deberás contactar con nuestro departamento de atención al cliente a través de correo electrónico mandando un email a: info@dxbwatch.es</small> </p>\r\n</div>",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ];

            foreach($pdf_templates as $value){
                $opv = new Template();
                foreach($value as $key => $value){
                    $opv->{$key} = $value;
                }
                $opv->save();
            }
        }
    }
}