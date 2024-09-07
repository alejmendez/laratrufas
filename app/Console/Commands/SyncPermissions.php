<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $entities = [
        'dog',
        'field',
        'harvest',
        'machinery',
        'plant',
        'quarter',
        'task',
        'tool',
        'user',
        'batch',
    ];

    protected $defaultActions = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    protected $permissions = [];

    protected $roles = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->create_roles();

        foreach ($this->entities as $entity) {
            foreach ($this->defaultActions as $action) {
                $this->create_permission($entity, $action);
            }
        }

        $this->create_permission('bulk', 'index');

        $this->create_permission('harvest', 'download_bulk_template');
        $this->create_permission('harvest', 'create_bulk');
        $this->create_permission('harvest', 'store_bulk');

        $this->create_permission('plant', 'download_bulk_template');
        $this->create_permission('plant', 'create_bulk');
        $this->create_permission('plant', 'store_bulk');

        $this->create_permission('planttype', 'store');

        $this->create_permission('harvestdetail', 'create');
        $this->create_permission('harvestdetail', 'store');
        $this->create_permission('harvestdetail', 'find_by_code');

        $this->permissions = collect($this->permissions);

        $allPermissions = $this->permissions->flatten();

        $this->roles['super_admin']->syncPermissions($allPermissions->toArray());
        $this->roles['administrator']->syncPermissions($allPermissions->toArray());

        $this->roles['technician']->syncPermissions([
            'field index',
            'field show',
            'quarter index',
            'quarter show',
            'plant index',
            'plant show',
            ...collect($this->permissions['harvest'])->filter(fn ($p) => ! Str::contains($p, 'destroy'))->toArray(),
            ...$this->permissions['harvestdetail'],
            ...$this->permissions['task'],
            ...$this->permissions['machinery'],
            ...$this->permissions['tool'],
        ]);

        $this->roles['farmer']->syncPermissions([
            'quarter index',
            'quarter show',
            'plant index',
            'plant show',
            ...collect($this->permissions['harvest'])->filter(fn ($p) => ! Str::contains($p, 'destroy'))->toArray(),
            ...$this->permissions['harvestdetail'],
            ...$this->permissions['task'],
        ]);
    }

    public function create_roles()
    {
        $this->roles = [
            'farmer' => 'Agricultor',
            'technician' => 'Técnico',
            'administrator' => 'Administrador',
            'super_admin' => 'Super Admin',
        ];

        foreach ($this->roles as $key => $name) {
            $rol = Role::where('name', $name)->first();
            if (! $rol) {
                $rol = Role::create(['name' => $name]);
            }
            $this->roles[$key] = $rol;
        }
    }

    public function create_permission($entity, $action)
    {
        $permission = $entity.' '.$action;

        if (! isset($this->permissions[$entity])) {
            $this->permissions[$entity] = [];
        }

        $this->permissions[$entity][] = $permission;

        if (! Permission::where('name', $permission)->exists()) {
            Permission::create(['name' => $permission]);
        }
    }
}
