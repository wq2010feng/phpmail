<?php
/*
 * @Author: KEEFE
 * @Email: wq2010feng@126.com
 * @Date: 2022-05-26 08:50:57
 * @LastEditors: KEEFE
 * @LastEditTime: 2022-05-26 15:43:38
 * @Description: Mailer类
 */
namespace think\keefe;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Mailer
{
	private $mail = null;
	public function __construct($config = []) {
		$this->init($config);
	}
  	public function init($config = []) {
		$config = array_merge([
			'SMTP_HOST'=>'',
			'SMTP_PORT'=>'465',
			'SMTP_CHARSET'=>'utf-8',
			'SMTP_DEBUG'=>'2',
			'SMTP_USER'=>'',
			'SMTP_PASS'=>'',
			'FROM_EMAIL'=>'',
			'FROM_NAME'=>'',
			'REPLY_EMAIL'=>'',
			'REPLY_NAME'=>'',
			'SMTP_SECURE' => 'ssl', // tls, ssl
			'SMTP_AUTH'=> '1',
		], config('mailsmtp'), $config);
		$this->mail = new PHPMailer(true);
		$this->mail->SMTPDebug = $config['SMTP_DEBUG']; // 设置调试级别
		$this->mail->isSMTP(); // 使用SMTP模式
		$this->mail->CharSet = $config['SMTP_CHARSET']; // 设置字符集
		$this->mail->Host = $config['SMTP_HOST']; // 设置服务器地址
		$this->mail->SMTPAuth = $config['SMTP_AUTH']; // 设置是否认证
		$this->mail->Username = $config['SMTP_USER']; // 设置用户名
		$this->mail->Password = $config['SMTP_PASS']; // 设置密码
		$this->mail->SMTPSecure = $config['SMTP_SECURE']; // 设置加密方式
		$this->mail->Port = $config['SMTP_PORT']; // 设置端口
		$this->mail->setLanguage('zh_cn'); // 设置为中文
		$this->setFrom($config['FROM_EMAIL'] ?? $config['SMTP_USER'], $config['FROM_NAME'] ?? $config['SMTP_USER']); // 设置发信人信息
		return $this;
	}
	/**
	 * @description: 添加收件人
	* @access: public
	* @param {string} $address 收件人地址
	* @param {string} $name 收件人
	* @return {Object} 本类
	*/	
	public function addAddress(string $address, string $name = '')
	{
		$this->mail->addAddress($address, $name ?? $address);
		return $this;
	}
	/**
	 * @description: 设置发件人
	* @access: public
	* @param {string} $address 发件人地址
	* @param {string} $name 发件人名称
	* @return {Object} 本类
	*/
	public function setFrom(string $address, string $name = '')
	{
		$this->mail->setFrom($address, $name ?? $address);
		return $this;
	}
	/**
	 * @description: 添加回复时接收地址
	* @access: public
	* @param {string} $address 接收地址
	* @param {string} $name 接收名称
	* @return {Object} 本类
	*/
	public function addReplyTo(string $address, string $name = '')
	{
		$this->mail->addReplyTo($address, $name ?? $address);
		return $this;
	}
	/**
	 * @description: 添加抄送人
	* @access: public
	* @param {string} $address 抄送人地址
	* @param {string} $name 抄送人
	* @return {Object} 本类
	*/
	public function addCC(string $address, string $name = '')
	{
		$this->mail->addCC($address, $name ?? $address);
		return $this;
	}
	/**
	 * @description: 添加密送人
	* @access: public
	* @param {string} $address 密送人地址
	* @param {string} $name 密送人
	* @return {Object} 本类
	*/
	public function addBCC(string $address, string $name = '')
	{
		$this->mail->addBCC($address, $name ?? $address);
		return $this;
	}
	/**
	 * @description: 设置HTML邮件内容
	* @access: public
	* @param {string} $subject 邮件标题
	* @param {string} $body 邮件正文
	* @param {string} $altbody 邮件不支持HTML时显示文本
	* @return {Object} 本类
	*/
	public function isHtml(string $subject, string $body = '', string $altbody = '') {
		$this->mail->isHTML(true);  
		$this->mail->Subject = $subject;
		$this->mail->Body    = $body;
		$this->mail->AltBody = $altbody ?? '您的邮件不支持该内容！请联系管理员！';
		return $this;
	}
	/**
	 * @description: 设置文本邮件内容
	* @access: public
	* @param {string} $subject 邮件标题
	* @param {string} $body 邮件正文
	* @return {Object} 本类
	*/
	public function isText(string $subject, string $body = '') {
		$this->mail->isHTML(false);
		$this->mail->Subject = $subject;
		$this->mail->Body    = $body;
		return $this;
	}
	/**
	 * @description: 发送邮件
	* @access: public
	* @return {bool} 发送结果
	*/
	public function send()
	{
		try {
			$this->mail->send();
			return true;
		} catch (\Exception $e) {
			return $this->mail->ErrorInfo;
		}
	}
	/**
	 * @description: 获取错误信息
	* @access: public
	* @return {string} 错误信息
	*/
	public function getErrmsg()
	{
		return $this->errmsg;
	}
	/**
	 * @description: 获取Mail类
	* @access: public
	* @return {Object} Mail类
	*/	
	public function getMail()
	{
		return $this->mail;
	}
	/**
	 * @description: 直接发送邮件
	* @access: public
	* @param {array} $params
	* @return {bool} 发送结果
	*/
	public function sendMail(array $params)
	{
		$this->init(); // 初始化Mail类
		// 添加收件人
		if (isset($params['to'])) {
			if (isset($params['to']['address'])) {
				$this->addAddress($params['to']['address'], $params['to']['name'] ?? $params['to']['address']);
			} elseif (is_array($params['to'])) {
				foreach($params['to'] as $item) {
					if (isset($item['address'])) {
						$this->addAddress($item['address'], $item['name'] ?? $item['address']);
					}
				}
			} else {
				return '收件人不能为空';
			}
		} else {
			return '收件人不能为空';
		}
		// 设置发件人
		if (isset($params['from']) && isset($params['from']['address'])) {
			$this->setFrom($params['from']['address'], $params['from']['name'] ?? $params['from']['address']);
		}
		// 设置抄送人
		if (isset($params['cc'])) {
			if (isset($params['cc']['address'])) {
				$this->addCC($params['cc']['address'], $params['cc']['name'] ?? $params['cc']['address']);
			} elseif (is_array($params['cc'])) {
				foreach($params['cc'] as $item) {
					if (isset($item['address'])) {
						$this->addCC($item['address'], $item['name'] ?? $item['address']);
					}
				}
			}
		}
		// 设置密送人
		if (isset($params['bcc']) ) {
			if (isset($params['bcc']['address'])) {
				$this->addBCC($params['bcc']['address'], $params['bcc']['name'] ?? $params['bcc']['address']);
			} elseif (is_array($params['bcc'])) {
				foreach($params['bcc'] as $item) {
					if (isset($item['address'])) {
						$this->addBCC($item['address'], $item['name'] ?? $item['address']);
					}
				}
			}
		}
		// 设置回复收信人
		if (isset($params['reply']) ) {
			if (isset($params['reply']['address'])) {
				$this->addReplyTo($params['reply']['address'], $params['reply']['name'] ?? $params['reply']['address']);
			} elseif (is_array($params['reply'])) {
				foreach($params['reply'] as $item) {
					if (isset($item['address'])) {
						$this->addReplyTo($item['address'], $item['name'] ?? $item['address']);
					}
				}
			}
		}

		// 设置邮件正文
		if (isset($params['mail']) && isset($params['mail']['title'])) {
			if (isset($params['mail']['type']) && $params['mail']['type'] == 'text') {
				$this->isText($params['mail']['title'], $params['mail']['body'] ?? '');
			} else {
				$this->isHtml($params['mail']['title'], $params['mail']['body'] ?? '', $params['mail']['AltBody'] ?? '');
			}
		} else {
			return '邮件标题不能为空';
		}
		return $this->send();
  }
}