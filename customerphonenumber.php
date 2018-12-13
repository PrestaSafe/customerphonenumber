<?php


if (!defined('_CAN_LOAD_FILES_')) {
    exit;
}


class CustomerPhoneNumber extends Module
{

    public function __construct()
    {
        $this->name = 'customerphonenumber';
        $this->author = 'ISDD Nîmes';
        $this->version = '1.0.1';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Customer phone number', array(), 'Modules.CustomerPhoneNumber.Admin');
        $this->description = $this->trans('Add a phone number to a customer.', array(), 'Modules.CustomerPhoneNumber.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.2.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:customerphonenumber/views/templates/hook/additionalCustomerFormFields.tpl';
    }


    public function install()
    {

        return parent::install() 
        && $this->registerHook('additionalCustomerFormFields')
        && $this->registerHook('actionObjectCustomerAddAfter')
        && $this->registerHook('actionObjectCustomerUpdateBefore')
        && $this->installDB(); 
    }

    private function installDB()
    {
        $row = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'customer');
        if(!isset($row['phone'])){
            $sql = 'ALTER TABLE `'._DB_PREFIX_.'customer` ADD `phone` VARCHAR(255) NOT NULL AFTER `ape`';
            return Db::getInstance()->execute($sql);    
        }
        return true;
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->unregisterHook('additionalCustomerFormFields');
    }
    
    public function hookadditionalCustomerFormFields($params)
    {
        
        return [
            (new FormField)
            ->setName('customer_phone')
            ->setType('text')
            ->setValue($this->context->customer->phone)
            ->setLabel($this->l('Customer phone')
            ),
        ];
    }

    public function hookactionObjectCustomerAddAfter($params)
    {
        
    }
    public function hookactionObjectCustomerUpdateBefore($params)
    {
        $customer = $params['object'];
        $phone_number = pSQL(Tools::getValue('customer_phone'));
        $customer->phone = $phone_number;
    }

}