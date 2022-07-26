<?php

namespace Codeception\Module;

use Yii;
use Codeception\Util\Framework;
use Codeception\Exception\ModuleConfig;

/**
 * This module provides integration with [Yii framework](https://www.yiiframework.com/) (2.0).
 *
 *
 * ## Config
 *
 * * configFile *required* - the path to the application config file
 *
 * The entry script must return the application configuration array.
 *
 * You can use this module by setting params in your functional.suite.yml:
 * <pre>
 * class_name: TestGuy
 * modules:
 *     enabled: [Yii2, TestHelper]
 *     config:
 *         Yii2:
 *             configFile: '/path/to/config.php'
 * </pre>
 *
 * ## Status
 *
 * Maintainer: **qiangxue**
 * Stability: **beta**
 *
 */
class Yii2 extends Framework implements \Codeception\Util\ActiveRecordInterface
{
    /**
     * Application config file must be set.
     * @var array
     */
    protected $config = array('cleanup' => false);
    protected $requiredFields = array('configFile');
    protected $transaction;

    public $app;

    public function _initialize()
    {
        if (!is_file(\Codeception\Configuration::projectDir().$this->config['configFile'])) {
            throw new ModuleConfig(__CLASS__, "The application config file does not exist: {$this->config['configFile']}");
        }
    }

    public function _before(\Codeception\TestCase $test)
    {
        $this->client = new \Codeception\Util\Connector\Yii2();
        $this->client->configFile = \Codeception\Configuration::projectDir().$this->config['configFile'];
        $this->app = $this->client->startApp();

        if ($this->config['cleanup'] and isset($this->app->db)) {
            $this->transaction = $this->app->db->beginTransaction();
        }
    }

    public function _after(\Codeception\TestCase $test)
    {
        $_SESSION = array();
        $_FILES = array();
        $_GET = array();
        $_POST = array();
        $_COOKIE = array();
        $_REQUEST = array();
        if ($this->transaction and $this->config['cleanup']) {
            $this->transaction->rollback();
        }

        if (Yii::$app) {
            Yii::$app->session->close();
        }


        parent::_after($test);
    }

    /**
     * Inserts record into the database.
     *
     * ``` php
     * <?php
     * $user_id = $I->haveRecord('app\models\User', array('name' => 'Davert'));
     * ?>
     * ```
     *
     * @param $model
     * @param array $attributes
     * @return mixed
     */
    public function haveRecord($model, $attributes = array())
    {
        /** @var $record \yii\db\ActiveRecord  * */
        $record = $this->getModelRecord($model);
        $record->setAttributes($attributes);
        $res = $record->save(false);
        if (!$res) {
            $this->fail("Record $model was not saved");
        }

        return $record->id;
    }

    /**
     * Checks that record exists in database.
     *
     * ``` php
     * $I->seeRecord('app\models\User', array('name' => 'davert'));
     * ```
     *
     * @param $model
     * @param array $attributes
     */
    public function seeRecord($model, $attributes = array())
    {
        $record = $this->findRecord($model, $attributes);
        if (!$record) {
            $this->fail("Couldn't find $model with " . json_encode($attributes));
        }
        $this->debugSection($model, json_encode($record));
    }

    /**
     * Checks that record does not exist in database.
     *
     * ``` php
     * $I->dontSeeRecord('app\models\User', array('name' => 'davert'));
     * ```
     *
     * @param $model
     * @param array $attributes
     */
    public function dontSeeRecord($model, $attributes = array())
    {
        $record = $this->findRecord($model, $attributes);
        $this->debugSection($model, json_encode($record));
        if ($record) {
            $this->fail("Unexpectedly managed to find $model with " . json_encode($attributes));
        }
    }

    /**
     * Retrieves record from database
     *
     * ``` php
     * $category = $I->grabRecord('app\models\User', array('name' => 'davert'));
     * ```
     *
     * @param $model
     * @param array $attributes
     * @return mixed
     */
    public function grabRecord($model, $attributes = array())
    {
        return $this->findRecord($model, $attributes);
    }

    protected function findRecord($model, $attributes = array())
    {
        $this->getModelRecord($model);
        return call_user_func(array($model, 'find'))
            ->where($attributes)
            ->one();
    }

    protected function getModelRecord($model)
    {
        if (!class_exists($model)) {
            throw new \RuntimeException("Model $model does not exist");
        }
        $record = new $model;
        if (!$record instanceof \yii\db\ActiveRecord) {
            throw new \RuntimeException("Model $model is not instance of \\yii\\db\\ActiveRecord");
        }
        return $record;
    }


}
