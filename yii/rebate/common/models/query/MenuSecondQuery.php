<?php

namespace common\models\query;

use common\models\MenuSecond;
use omgdef\multilingual\MultilingualQuery;

/**
 * MenuSecondQuery is the ActiveQuery class for [[\common\models\Menu]]
 * 
 * @see common\models\Menu
 * @package backend\modules\content\models\search
 * @author 
 * @link https://issue.molfar.net/browse/
 * @since 
 */
class MenuSecondQuery extends MultilingualQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => MenuSecond::STATUS_PUBLISHED]);
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
        $this->andWhere(['type_id' => MenuSecond::MAIN_MENU]);
        return $this;
    }

    /**
     * @return $this
     */
    public function cabinetMenu()
    {
        $this->andWhere(['type_id' => MenuSecond::CABINETS_MENU]);
        return $this;
    }

}
