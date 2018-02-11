<?php

namespace frontend\modules\search\models\forms;

use frontend\modules\search\models\SearchUser;
use yii\base\Model;
/**
 * Description of SearchForm
 *
 * @author basta
 */
class SearchForm extends Model
{
    public $keyword;
    
    public function rules()
    {
        return [
          ['keyword', 'trim'],  
          ['keyword', 'required'],  
          ['keyword', 'string', 'min' => 3],  
        ];
    }
    
    public function search()
    {
        if ($this->validate()) {
            $model = new SearchUser();
            return $model->advancedSearch($this->keyword);
        }
    }
}
