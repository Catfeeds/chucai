<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\queue;

/**
 * Interface RetryableJob
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
interface RetryableJob extends Job
{
    /**
     * @return int time to reserve in seconds
     */
    public function getTtr();

    /**
     * @param int $attempt number
     * @param \Exception $error from last execute of the job
     * @return bool
     */
    public function canRetry($attempt, $error);
}