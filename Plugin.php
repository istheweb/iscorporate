<?php namespace Istheweb\IsCorporate;

use App;
use Backend;
use BackendMenu;
use Event;
use Istheweb\IsCorporate\Models\Issue;
use Istheweb\IsCorporate\Models\ProjectType;
use System\Classes\PluginBase;
use Backend\Facades\BackendAuth;
use Backend\Models\User as UserModel;

/**
 * IsCorporate Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['Istheweb.IsPdf', 'Istheweb.Connect'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'istheweb.iscorporate::lang.plugin.name',
            'description' => 'istheweb.iscorporate::lang.plugin.description',
            'author'      => 'Andres Rangel',
            'icon'        => 'icon-building',
        ];
    }

    public function boot(){

        $this->extendNavigation();

        UserModel::extend(function ($model) {
            $model->hasOne['empleado'] = ['Istheweb\IsCorporate\Models\Employee'];
        });

        /*
         * Register menu items for the RainLab.Pages plugin
        */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'project-type'       => 'istheweb.iscorporate::lang.menuitem.project_type',
                'all-project-types' => 'istheweb.iscorporate::lang.menuitem.all_project_types'
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'project-type' || $type == 'all-project-types') {
                return ProjectType::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'project-type' || $type == 'all-project-types') {
                return ProjectType::resolveMenuItem($item, $url, $theme);
            }
        });


        if(!App::runningInBackend()) {
            return;
        }
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        BackendMenu::registerContextSidenavPartial('Istheweb.IsCorporate',
            'iscorporate',
            'plugins/istheweb/iscorporate/partials/_sidebar.htm');
    }

    public function registerFormWidgets()
    {
        return [
            'Istheweb\IsCorporate\FormWidgets\ProjectVariantOptions'  => [
                'label' => 'istheweb.iscorporate::lang.project.options',
                'code'  => 'project_variant_options'
            ],
            'Istheweb\IsCorporate\FormWidgets\ProjectCompany'  => [
                'label' => 'istheweb.iscorporate::lang.project.company',
                'code'  => 'project_company'
            ],
            'Istheweb\IsCorporate\FormWidgets\ProjectVariantReport'  => [
                'label' => 'istheweb.iscorporate::lang.project.report',
                'code'  => 'project_variant_report'
            ],
            'Istheweb\IsCorporate\FormWidgets\IssueToolbar'  => [
                'label' => 'istheweb.iscorporate::lang.issue.toolbar',
                'code'  => 'issue_toolbar'
            ],
            'Istheweb\IsCorporate\FormWidgets\IssueMessages' => [
                'label' => 'istheweb.iscorporate::lang.issue.messages',
                'code'  => 'issue_messages'
            ],
            'Istheweb\IsCorporate\FormWidgets\VariantEmployee' => [
                'label' => 'istheweb.iscorporate::lang.project.employees',
                'code'  => 'variant_employee'
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'istheweb.iscorporate.access_employees'    => [
                'label' => 'istheweb.iscorporate::lang.employee.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_clients'    => [
                'label' => 'istheweb.iscorporate::lang.client.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_budgets'    => [
                'label' => 'istheweb.iscorporate::lang.budget.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_invoices'    => [
                'label' => 'istheweb.iscorporate::lang.invoice.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_providers'    => [
                'label' => 'istheweb.iscorporate::lang.provider.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_projects'     => [
                'label' => 'istheweb.iscorporate::lang.project.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.create_projects'     => [
                'label' => 'istheweb.iscorporate::lang.project.create_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.delete_projects'     => [
                'label' => 'istheweb.iscorporate::lang.project.delete_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_project_types'     => [
                'label' => 'istheweb.iscorporate::lang.project_type.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_options'     => [
                'label' => 'istheweb.iscorporate::lang.option.list_title',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name',
            ],
            'istheweb.iscorporate.access_issues'         => [
                'label' => 'istheweb.iscorporate::lang.permissions.issues',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name'
            ],
            'istheweb.iscorporate.access_other_issues'   => [
                'label' => 'istheweb.iscorporate::lang.permissions.other_issues',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name'
            ],
            'istheweb.iscorporate.access_issue_types'    => [
                'label' => 'istheweb.iscorporate::lang.permissions.issue_types',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name'
            ],
            'istheweb.iscorporate.access_issue_statuses' => [
                'label' => 'istheweb.iscorporate::lang.permissions.issue_statuses',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name'
            ],
            'istheweb.iscorporate.access_reports' => [
                'label' => 'istheweb.iscorporate::lang.permissions.reports',
                'tab'   => 'istheweb.iscorporate::lang.plugin.name'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'iscorporate' => [
                'label'       => 'IsCorporate',
                'url'         => Backend::url('istheweb/iscorporate/'. $this->startPage('clients')),
                'icon'        => 'icon-building',
                'permissions' => ['istheweb.iscorporate.*'],
                'order'       => 410,

                'sideMenu'    => [
                    'issues'        => [
                        'label'       => 'istheweb.iscorporate::lang.navigation.issues',
                        'icon'        => 'icon-ticket',
                        'url'         => Backend::url('istheweb/iscorporate/issues'),
                        'group'       => 'istheweb.iscorporate::lang.sidebar.issue',
                        'permissions' => ['istheweb.iscorporate.access_issues']
                    ],
                    'issuestypes'    => [
                        'label'       => 'istheweb.iscorporate::lang.navigation.issue_types',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('istheweb/iscorporate/issuetypes'),
                        'permissions' => ['istheweb.iscorporate.access_issue_types'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.issue',
                    ],
                    'issuestatuses' => [
                        'label'       => 'istheweb.iscorporate::lang.navigation.issue_statuses',
                        'icon'        => 'icon-check-square',
                        'url'         => Backend::url('istheweb/iscorporate/issuestatuses'),
                        'group'       => 'istheweb.iscorporate::lang.sidebar.issue',
                        'permissions' => ['istheweb.iscorporate.access_issue_statuses']
                    ],
                    'clients'        => [
                        'label'       => 'istheweb.iscorporate::lang.clients.menu_label',
                        'icon'        => 'icon-university',
                        'url'         => Backend::url('istheweb/iscorporate/clients'),
                        'permissions' => ['istheweb.iscorporate.access_clients'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.clients',
                        'description' => 'istheweb.iscorporate::lang.client.description',
                    ],
                    'budgets'        => [
                        'label'       => 'istheweb.iscorporate::lang.budgets.menu_label',
                        'icon'        => 'icon-bullseye',
                        'url'         => Backend::url('istheweb/iscorporate/budgets'),
                        'permissions' => ['istheweb.iscorporate.access_budgets'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.clients',
                        'description' => 'istheweb.iscorporate::lang.budget.description',
                    ],
                    'invoices'        => [
                        'label'       => 'istheweb.iscorporate::lang.invoices.menu_label',
                        'icon'        => 'icon-sticky-note',
                        'url'         => Backend::url('istheweb/iscorporate/invoices'),
                        'permissions' => ['istheweb.iscorporate.access_invoices'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.clients',
                        'description' => 'istheweb.iscorporate::lang.invoice.description',
                    ],
                    'projects'     => [
                        'label'       => 'istheweb.iscorporate::lang.projects.menu_label',
                        'icon'        => 'icon-rocket',
                        'url'         => Backend::url('istheweb/iscorporate/projects'),
                        'permissions' => ['istheweb.iscorporate.access_projects'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.catalog',
                        'description' => 'istheweb.iscorporate::lang.project.description',
                    ],
                    'project_types'     => [
                        'label'       => 'istheweb.iscorporate::lang.project_types.menu_label',
                        'icon'        => 'icon-cubes',
                        'url'         => Backend::url('istheweb/iscorporate/projecttypes'),
                        'permissions' => ['istheweb.iscorporate.access_project_types'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.catalog',
                        'description' => 'istheweb.iscorporate::lang.project_type.description',
                    ],
                    'options'     => [
                        'label'       => 'istheweb.iscorporate::lang.options.menu_label',
                        'icon'        => 'icon-diamond',
                        'url'         => Backend::url('istheweb/iscorporate/projectoptions'),
                        'permissions' => ['istheweb.iscorporate.access_options'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.catalog',
                        'description' => 'istheweb.iscorporate::lang.option.description',
                    ],
                    'employees'    => [
                        'label'       => 'istheweb.iscorporate::lang.employees.menu_label',
                        'icon'        => 'icon-user',
                        'url'         => Backend::url('istheweb/iscorporate/employees'),
                        'permissions' => ['istheweb.iscorporate.access_employees'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.team',
                        'description' => 'istheweb.iscorporate::lang.employee.description',

                    ],
                    'roles'        => [
                        'label'       => 'istheweb.iscorporate::lang.roles.menu_label',
                        'icon'        => 'icon-briefcase',
                        'url'         => Backend::url('istheweb/iscorporate/roles'),
                        'permissions' => ['istheweb.iscorporate.access_employees'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.team',
                        'description' => 'istheweb.iscorporate::lang.role.description',
                    ],
                    'providers'        => [
                        'label'       => 'istheweb.iscorporate::lang.providers.menu_label',
                        'icon'        => 'icon-code-fork',
                        'url'         => Backend::url('istheweb/iscorporate/providers'),
                        'permissions' => ['istheweb.iscorporate.access_providers'],
                        'group'       => 'istheweb.iscorporate::lang.sidebar.providers',
                        'description' => 'istheweb.iscorporate::lang.provider.description',
                    ]
                ]
            ],
        ];
    }

    /**
     * Register mail templates
     *
     * @return array
     */
    public function registerMailTemplates()
    {
        return [
            'istheweb.iscorporate::mail.new_issue'    => 'istheweb.iscorporate::lang.mail.email_issue_to_resource',
            'istheweb.iscorporate::mail.new_reply'     => 'istheweb.iscorporate::lang.mail.email_reply_issue',
            'istheweb.iscorporate::mail.issue_closed' => 'istheweb.iscorporate::lang.mail.email_close_issue',
            'istheweb.iscorporate::mail.email_budget' => 'istheweb.iscorporate::lang.mail.email_budget'
        ];
    }

    public function startPage($page = 'clients')
    {
        $user = BackendAuth::getUser();
        $permissions = array_reverse(array_keys($this->registerPermissions()));

        if (!isset($user->permissions['superuser']) && $user->hasAccess('istheweb.iscorporate.*')) {
            foreach ($permissions as $access) {
                if ($user->hasAccess($access)) {
                    $page = explode('_', $access)[1];
                }
            }
        }
        $page = 'issues';
        return $page;
    }

    /**
     * Extend inbox navigation
     */
    protected function extendNavigation()
    {

        Event::listen('backend.menu.extendItems', function ($manager) {
            $openCount = Issue::getOpenedCount();
            if ($openCount) {
                $manager->addSideMenuItems('Istheweb.IsCorporate', 'iscorporate', [
                    'issues' => [
                        'counter' => $openCount,
                    ]
                ]);
            }
        });
    }

    public function registerListColumnTypes()
    {
        return [
            'employee_name' => [$this, 'evalEmployeeNameListColumn'],
            'comments_stripe_tags'  => [$this, 'evalCommentsListColumn'],
            'client_name'           => [$this, 'evalClientNameListColumn'],
        ];
    }

    public function evalEmployeeNameListColumn($value, $column, $record)
    {
        return strtoupper($value->user->full_name);
    }

    public function evalClientNameListColumn($value, $column, $record)
    {
        return $value->name . " (".$value->email.")";
    }

    public function evalCommentsListColumn($value, $column, $record){
        return strip_tags(trim($value));
    }

}
