<?php

namespace common\models\query;

use common\models\MenuMain;
use omgdef\multilingual\MultilingualQuery;

/**
 * MenuMainQuery is the ActiveQuery class for [[\common\models\Menu]]
 * 
 * @see common\models\Menu
 * @package backend\modules\content\models\search
 * @author 
 * @link https://issue.molfar.net/browse/
 * @since 
 */
class MenuMainQuery extends MultilingualQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => MenuMain::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere(['parent_id' => null]);
        return $this;
    }

    /**
     * @return $this
     */
    public function mainMenu()
    {
        $this->andWhere(['type_id' => MenuMain::MAIN_MENU]);
        return $this;
    }

    /**
     * @return $this
     */
    public function cabinetMenu()
    {
        $this->andWhere(['type_id' => MenuMain::CABINETS_MENU]);
        return $this;
    }

}
