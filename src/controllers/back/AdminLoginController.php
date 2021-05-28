<?php
namespace Controllers{
   
    use Core\Controller;
    use Core\Context;

    use Utils\Tools;

    use Model\Employee;

    class AdminLoginController extends Controller
    {
        const TEMPLATE = "login";

        public function __construct()
        {   
            $context = Context::getInstance();

            if($context->isEmployeeLogged()) {
                Tools::redirectAdmin();
            }

            if(Tools::getValue('action') === 'login') {
                $login = Tools::getValue('login');
                $password = Tools::getValue('password');

                $id_employee = Employee::getByLogin($login);
                $employee = new Employee($id_employee);

                if($employee->checkPassword($password)) {
                    $context->setEmployeeLogged($id_employee);
                    Tools::redirectAdmin();
                }
            }

            parent::__construct();
        }

        public function init()
        {
            parent::init();

            $this->template = self::TEMPLATE;
        }

        public function initVariables()
        {
            parent::initVariables();
        }
    }
}
