<?php

namespace frontend\components;

use common\models\MenuMain;
use Yii;
use yii\helpers\Url;

class MenuMainF
{
    /**
     * @return array
     */
    public static function getMenu()
    {
        $role_id = 1;
        $result = static::getMenuRecrusive($role_id);
        return $result;
    }

    /**
     * @return array
     */
    public static function getCabinetMenu($active_item = '')
    {
        $items = MenuMain::find()
            ->noParents()
            ->cabinetMenu()
            ->active()
            ->orderBy('order')
            ->all();

        $active_item = $active_item ? : $items[0]->id;
        $result= static ::showTreeCabinetMenu($items, $active_item);
        return $result;
    }

    private static function showTreeCabinetMenu($tree, $active_item)
    {
        $res = [];
        foreach ($tree as $item) {
            $url = count($item->children) > 0 ? Url::toRoute(['/cabinet/', 'slug' => $item->slug]) : [ Yii::getAlias('@web/'.$item->url)];
            array_push($res, [
                'label' => $item->title,
                'url' => $url,
                'active' => $item->id === $active_item,
            ]);
        }
        return $res;
    }

    /**
     * @return array
     */
    public static function getMenuPart()
    {
        $items = MenuMain::find()->noParents()->active()->orderBy('order')->all();

        $result = static::showTreeMenu2($items);
        return $result;
    }

    private static function showTreeMenu($tree, $active_item = '')
    {
        $res=[];
        foreach ($tree as $item) {
            if (count($item->children) > 0) {
                array_push($res, [
                        'label' =>$item->title,
                        'url' => [ Yii::getAlias('@web/'.$item->fullSlug)],
                        'items' => static ::showTreeMenu($item->children)
                    ]
                );
            }else{
                array_push($res, [
                        'label' =>$item->title,
                        'url' =>  Yii::getAlias('@web/'.$item->fullSlug),
                        'active' =>$item->id === $active_item
                    ]
                );
            }
        }
        return $res;
    }

    private static function showTreeMenu2($tree)
    {
        $res = [];
        foreach ($tree as $item) {
            $onclick = !$item->url ? 'onclick="return false;"' : '';
            if (count($item->children) > 0) {
                array_push($res, [
                        'label' =>$item->title? $item->title : 'label',
                        'url' => [ Yii::getAlias('@web/'.$item->url)],
                        'items' => static ::showTreeMenu2($item->children),
                        'template' => '<a href="{url}"' . $onclick . '>{label}<span></span></a>'
                    ]);
            }else{
                array_push($res, [
                        'label' =>$item->title,
                        'url' => [ Yii::getAlias('@web/'.$item->url)],
                        'template' => '<a href="{url}"' . $onclick . '>{label}</a>'
                    ]);
            }
        }
        return $res;
    }


    private static function getMenuRecrusive($parent = null)
    {

        $items = MenuMain::find()
            ->noParents()
            ->mainMenu()
            ->active()
            ->orderBy('order')
            ->all();

        $result= static ::showTreeMenu2($items);

        return $result;
    }


}