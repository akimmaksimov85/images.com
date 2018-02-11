<?php

namespace frontend\modules\search\models;

use Yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchUser
 *
 * @author basta
 */
class SearchUser
{

    public function simpleSearch($keyword)
    {
        $sql = "SELECT * FROM user WHERE username LIKE '%$keyword%' LIMIT 20";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public static function recommendedFriends()
    {
        $sql = "SELECT * FROM user ORDER BY created_at LIMIT 4";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

}
