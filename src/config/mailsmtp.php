<?php
/*
 * @Author: KEEFE
 * @Email: wq2010feng@126.com
 * @Date: 2022-05-26 10:41:09
 * @LastEditors: KEEFE
 * @LastEditTime: 2022-05-26 15:43:45
 * @Description: Mailer配置文件
 */
return [
  'SMTP_HOST'=>'smtp.163.com', // 必选
  'SMTP_PORT'=>'465', // 可选
  'SMTP_CHARSET'=>'utf-8', // 可选
  'SMTP_DEBUG'=>'2', // DEBUG_OFF：0，DEBUG_CLIENT：1，DEBUG_SERVER：2，DEBUG_CONNECTION：3，DEBUG_LOWLEVEL：4
  'SMTP_USER'=>'', // 必选
  'SMTP_PASS'=>'', // 开启认证时或不设置认证时必选
  'FROM_EMAIL'=>'', // SMTP_USER为完整地址时可选，否则必选
  'FROM_NAME'=>'', // 可选
  'REPLY_EMAIL'=>'', // 可选
  'REPLY_NAME'=>'', // 可选
  'SMTP_SECURE' => 'ssl', // tls, ssl，可选
  'SMTP_AUTH'=> true, // 可选
];