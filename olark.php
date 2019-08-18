<?php
/**
 * Copyright (C) 2019 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2019 thirty bees
 * @license   Academic Free License (AFL 3.0)
 */

if (!defined('_TB_VERSION_')) {
	exit;
}

class Olark extends Module
{
	const SITE_ID 			= 'OLARK_SITE_ID';
	const WELCOME_TITLE 	= 'OLARK_WELCOME_TITLE';
	const CHATTING_TITLE 	= 'OLARK_CHATTING_TITLE';
	const UNAVAILABLE_TITLE = 'OLARK_UNAVAILABLE_TITLE';
	const WELCOME_MESSAGE 	= 'OLARK_WELCOME_MESSAGE';
	const CHAT_INPUT_TEXT 	= 'OLARK_CHAT_INPUT_TEXT';

	protected $html;

	public function __construct() {

		$this->name = 'olark';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'thirty bees';
		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Olark');
		$this->description = $this->l('Make you business human by using live chat software for sales, marketing and customer support on your website.');

		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');
	}


	public function install() {

		return parent::install() && $this->registerHook('footer');
	}


	public function uninstall() {

		$keys = $this->getConfigurationKeys();

		/* Delete all configuration keys and uninstall the module */
		foreach ($keys as $key) {
			Configuration::deleteByName($key['key']);
		}

		return parent::uninstall();
	}


	public function getContent() {

		$this->html = '';
		$this->html .= $this->postProcess();
		$this->html .= $this->getAdminHeaderTemplate();

		$helper = $this->getHelperForm();
		$helper->fields_value = $this->getFormValues();

		$fieldsForm = [];
		$fieldsForm[] = $this->getSettingsForm();
		$fieldsForm[] = $this->getCustomizationForm();
		$this->html .= $helper->generateForm($fieldsForm);

		return $this->html;
	}


	private function getHelperForm() {

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

		$helper->title = $this->displayName;
		$helper->show_toolbar = true;
		$helper->toolbar_scroll = true;
		$helper->submit_action = '';

		return $helper;
	}


	private function postProcess() {

		$_html = '';
		if (Tools::isSubmit('submit_'.$this->name.'_settings')) {
			Configuration::updateValue(static::SITE_ID, Tools::getValue(static::SITE_ID));
			$_html .= $this->displayConfirmation($this->l('Your settings has been saved.'));
		}
		if (Tools::isSubmit('submit_'.$this->name.'_customization')) {
			Configuration::updateValue(static::WELCOME_TITLE, Tools::getValue(static::WELCOME_TITLE));
			Configuration::updateValue(static::CHATTING_TITLE, Tools::getValue(static::CHATTING_TITLE));
			Configuration::updateValue(static::UNAVAILABLE_TITLE, Tools::getValue(static::UNAVAILABLE_TITLE));
			Configuration::updateValue(static::WELCOME_MESSAGE, Tools::getValue(static::WELCOME_MESSAGE));
			Configuration::updateValue(static::CHAT_INPUT_TEXT, Tools::getValue(static::CHAT_INPUT_TEXT));
			$_html .= $this->displayConfirmation($this->l('Your settings has been saved.'));
		}
		return $_html;
	}


	private function getAdminHeaderTemplate() {

		$keys = $this->getConfigurationKeys();
		$smarty_variables = [];
		foreach ($keys as $key) {
			$smarty_variables[$key['smarty']] = Configuration::get($key['key']);
		}
		$this->context->smarty->assign($smarty_variables);

		$formUrl = './index.php?tab=AdminModules&configure=olark&token='
						.Tools::getAdminTokenLite('AdminModules')
						.'&tab_module='.$this->tab.'&module_name=olark';
		$trackingUrl = 'http://www.thirtybees.com/modules/olark.png?url_site='
						.Tools::safeOutput($_SERVER['SERVER_NAME']).
						'&amp;id_lang='.(int)$this->context->cookie->id_lang;
		$this->context->smarty->assign(
				[
					'logo' => '../modules/olark/img/olark_logo.png',
					'form' => $form,
					'tracking' => $trackingUrl,
				]
			);

		return $this->display(__FILE__, 'views/templates/front/admin_header.tpl');
	}


	private function getSettingsForm() {

		return [
			'form' => [
				'legend' => [
					'title' => $this->l('Settings'),
					'icon'  => 'icon-cogs',
				],
				'input'  => [
					[
						'type'          => 'text',
						'label'         => $this->l('Olark Site ID'),
						'name'          => static::SITE_ID,
						'desc'          => $this->l('Use the Site-ID provided to you by Olark to configure the module'),
						'size'          => 70,
						'required'      => true,
						'empty_message' => $this->l('Olark will not work without this value'),
					],
				],
				'submit' => [
					'name' => 'submit_'.$this->name.'_settings',
					'title' => $this->l('Save'),
				],
			],
		];
	}


	private function getCustomizationForm() {

		return [
			'form' => [
				'legend' => [
					'title' => $this->l('Customization'),
					'icon'  => 'icon-cogs',
				],
				'input'  => [
					[
						'type'     => 'text',
						'label'    => $this->l('Welcoming Title'),
						'name'     => static::WELCOME_TITLE,
						'desc'     => $this->l('Text on the chat button when it is collapsed.'),
						'size'     => 128,
						'required' => false,
					],
					[
						'type'     => 'text',
						'label'    => $this->l('Chatting Title'),
						'name'     => static::CHATTING_TITLE,
						'desc'     => $this->l('Title of the chatbox when it is expanded.'),
						'size'     => 128,
						'required' => false,
					],
					[
						'type'     => 'text',
						'label'    => $this->l('Unavailable Title'),
						'name'     => static::UNAVAILABLE_TITLE,
						'desc'     => $this->l('Text on the chat button when it is collapsed and you are offline or your status is set to busy.'),
						'size'     => 128,
						'required' => false,
					],
					[
						'type'     => 'text',
						'label'    => $this->l('Welcome Message'),
						'name'     => static::WELCOME_MESSAGE,
						'desc'     => $this->l('Placeholder text user sees when s/he expands the chat box.'),
						'size'     => 128,
						'required' => false,
					],
					[
						'type'     => 'text',
						'label'    => $this->l('Chat Input Text'),
						'name'     => static::CHAT_INPUT_TEXT,
						'desc'     => $this->l('Placeholder text in the text input.'),
						'size'     => 128,
						'required' => false,
					],
				],
				'submit' => [
					'name' => 'submit_'.$this->name.'_customization',
					'title' => $this->l('Save'),
				],
			],
		];
	}


	protected function getFormValues() {

		return Configuration::getMultiple(
			[
				static::SITE_ID,
				static::WELCOME_TITLE,
				static::CHATTING_TITLE,
				static::UNAVAILABLE_TITLE,
				static::WELCOME_MESSAGE,
				static::CHAT_INPUT_TEXT,
			]
		);
	}


	private function getConfigurationKeys() {

		return [
			['smarty' => 'siteId', 'key' => static::SITE_ID, 'post' => 'olarkSiteId'],
			['smarty' => 'welcomingTitle', 'key' => static::WELCOME_TITLE, 'post' => 'olarkWelcomingTitle'],
			['smarty' => 'chattingTitle', 'key' => static::CHATTING_TITLE, 'post' => 'olarkChattingTitle'],
			['smarty' => 'unavailableTitle', 'key' => static::UNAVAILABLE_TITLE, 'post' => 'olarkUnavailableTitle'],
			['smarty' => 'welcomeMessage', 'key' => static::WELCOME_MESSAGE, 'post' => 'olarkWelcomeMessage'],
			['smarty' => 'chatInputText', 'key' => static::CHAT_INPUT_TEXT, 'post' => 'olarkChatInputText'],
		];
	}


	public function hookHeader($params) {

		$this->context->controller->addJQueryPlugin('fancybox');
	}


	/* The chat box will be integrated in Javascript and displayed in the footer */
	public function hookFooter($params) {

		if (!$this->active || !Configuration::get(static::SITE_ID)) {
			return false;
		}

		/* Add customer's information in the chat box */
		if ($params['cookie']->id_customer) {
			$customer = new Customer((int)$params['cookie']->id_customer);
			if (Validate::isLoadedObject($customer)) {
				$this->context->smarty->assign(
					[
						'email' => $customer->email,
						'firstName' => $customer->firstname,
						'lastName' => $customer->lastname
					]
				);
			}
		}

		$smarty_variables = [];
		$keys = $this->getConfigurationKeys();
		foreach ($keys as $key) {
			$smarty_variables[$key['smarty']] = Configuration::get($key['key']);
		}
		$this->context->smarty->assign($smarty_variables);

		return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
	}
}