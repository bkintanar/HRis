<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class Navlink.
 *
 * @SWG\Definition(definition="Screen", required={"id", "employee_id"})
 * @SWG\Property(property="id", type="integer", format="int64", default=3, description="Unique identifier for the screen")
 * @SWG\Property(property="name", type="string", default="Personal Details", description="name of the screen")
 */
class Navlink extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navlinks';

    /**
     * @param $user
     *
     * @return string
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public static function sidebar($user)
    {
        $parent_links = self::where('parent_id', 0)->get();

        $parent_links->each(function ($item) {
            $item->route = str_replace('/', '-', $item->href);
        })->toArray();

        $parent_links = self::filterPermission($user, $parent_links);

        return json_encode(self::getChildren($user, $parent_links));
    }

    /**
     * @param $user
     * @param $links
     *
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private static function filterPermission($user, $links)
    {
        return $links->filter(function (Navlink $item) use ($user) {
            $permission = str_replace('/', '.', $item->href);

            return $user->hasAccess($permission.'.view');
        });
    }

    /**
     * @param $user
     * @param $children
     *
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public static function getChildren($user, $children)
    {
        foreach ($children as $k => $child) {
            $grand_children = self::where('parent_id', $child['id'])->get();

            $grand_children->each(function ($item) {
                $item->route = str_replace('/', '-', $item->href);
            })->toArray();

            $grand_children = self::filterPermission($user, $grand_children);

            $children[$k]['children'] = self::getChildren($user, $grand_children);
        }

        return $children;
    }
}
