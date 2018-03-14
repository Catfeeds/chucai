<?php
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

class LogController extends Controller
{
    public function actionIndex() {
        $hello = Console::ansiFormat("Hello",[Console::FG_YELLOW]);
        $world = Console::ansiFormat("World",[Console::FG_GREEN]);
        Console::output("$hello $world");
    }
}