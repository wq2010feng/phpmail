# wq2010feng/thinkphp-mailer
基于phpmailer定制的邮件发送类
# 使用方法
~~~
use think\keefe\Mailer;
Mailer::init()
  ->addAddress('mail@mail.com', 'mail')
  ->addCC('mail@mail.com', 'mail')
  ->addBCC('mail@mail.com', 'mail')
  ->addReplyTo('mail@mail.com', 'mail')
  ->isHtml('标题', '内容', 'HTML不可用时显示此内容') // 或 ->isText('标题', '内容')
  ->send();
// 或
Mailer::sendMail([
  'to' => ['address'=>'mail@mail.com', 'name'=>'name'],
  'cc' => [
    ['address'=>'mail@mail.com', 'name'=>'name'],
    ['address'=>'mail2@mail.com', 'name'=>'name2']
  ],
  'bcc' => ['address'=>'mail@mail.com', 'name'=>'name'],
  'reply' => ['address'=>'mail@mail.com', 'name'=>'name'],
  'mail' => ['type'=>'text|html', 'title'=>'标题', 'body'=>'内容', 'AltBody'=>'HTML不可用时显示此内容']
]);
~~~
