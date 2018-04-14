<?php

namespace matrozov\wacAuth;

use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\filters\auth\CompositeAuth;

class WacAuth extends CompositeAuth
{
    /**
     * @inheritdoc
     */
    protected function isOptional($action)
    {
        // Run default isOptional check
        if (parent::isOptional($action)) {
            return true;
        }

        // Find AccessControl behavior
        /* @var AccessControl $behavior */
        foreach ($action->controller->behaviors as $behavior) {
            if (!($behavior instanceof AccessControl)) {
                continue;
            }

            /* @var AccessRule $rule */
            foreach ($behavior->rules as $rule) {
                // Check, if rule allow access for guest user
                if ($rule->allows($action, $this->user ?: Yii::$app->getUser(), $this->request ?: Yii::$app->getRequest())) {
                    return true;
                }
            }
        }

        return false;
    }
}