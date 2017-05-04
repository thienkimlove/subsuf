<?php

namespace App\Helper;

class PermissionHelper
{
    public static function permissions($modules, $functions)
    {
        $data = [];
        foreach ($modules as $module) {
            $data[$module->module_slug] = $module->toArray();
            $data[$module->module_slug]['functions'] = [];
        }

        foreach ($functions as $function) {
            $module_slug = $function->module_slug;
            if (key_exists($module_slug, $data)) {
                $data[$module_slug]['functions'][] = $function->toArray();
            }
        }

        return $data;
    }
}