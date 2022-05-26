<?php
/*
 * @Author: KEEFE
 * @Email: wq2010feng@126.com
 * @Date: 2022-05-26 13:40:40
 * @LastEditors: KEEFE
 * @LastEditTime: 2022-05-26 14:39:00
 * @Description: Mail门面
 */
namespace think\keefe\facade;

use think\Facade;

class Mailer extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'think\keefe\Mailer';
    }
}