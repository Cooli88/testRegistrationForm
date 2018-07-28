<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{

    public $email;
    public $fullName;
    public $individualEntrepreneur = false;
    public $legalEntity = false;
    public $organizationTitle;
    public $inn;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['fullName', 'email'], 'required'],
            [['individualEntrepreneur', 'legalEntity'], 'safe'],
            ['email', 'email'],
            ['inn', 'validateInnRequired', 'skipOnEmpty' => false, 'skipOnError' => false, ],
            ['inn', 'integer', 'min' => 100000000000000, 'max' => 999999999999999],
            ['organizationTitle', 'validateOrganizationTitleRequired', 'skipOnEmpty' => false, 'skipOnError' => false,],
            ['organizationTitle', 'string', 'length' => [3, 255]],
        ];
    }

    /**
     * Validates the inn.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateInnRequired($attribute, $params)
    {
        $mustBe = $this->individualEntrepreneur || $this->legalEntity;
        if ($mustBe && ($this->inn === '' || $this->inn === null) ) {
            $this->addError($attribute, 'ИНН должно быть заполнено.');
        }
    }

    /**
     * Validates the inn.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateOrganizationTitleRequired($attribute, $params)
    {
        if ($this->legalEntity && ($this->organizationTitle === '' || $this->organizationTitle === null) ) {
            $this->addError($attribute, 'Название организации должно быть заполнено.');
        }
    }
}
