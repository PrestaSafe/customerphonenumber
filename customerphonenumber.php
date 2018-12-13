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

        return parent::install() && $this->registerHook('additionalCustomerFormFields'); 
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->unregisterHook('additionalCustomerFormFields');
    }
    
    public function hookadditionalCustomerFormFields($params)
    {
        
        return [
            (new FormField)
            ->setName('professionnal_id')
            ->setType('text')
            //->setRequired(true) Décommenter pour rendre obligatoire
            ->setLabel($this->l('Professionnal id')),
            // (new FormField)
            // ->setName('justificatif_upload')
            // ->setType('file')
            // ->setLabel($this->l('document ID'))
        ];
    }

}