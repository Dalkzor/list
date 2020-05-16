<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ErrorCode
{
    const NO_AUTHENTICATION = 1;
    const NO_PERMISSIONS = 2;
    const INVALID_INPUT_PARAMETERS = 3;
    const WRONG_LOGIN_OR_PASSWORD = 4;
    const DUPLICATE_RECORD = 5;
    const INCOMPLETE_STRING = 6;
    const FORM_NOT_FIND = 7;
    const ENTITY_NOT_FOUND = 8;

    //add or edit operator
    const INVALID_LOGIN = 9;
    const INVALID_PASSWORD = 10;
    const PASSWORDS_DID_NOT_MATCH = 11;
    const LOGIN_BUSY = 12;





    /*
     * @param int $code
     * @return string
     */
    /*static function getMessage($code){
        switch ($code) {
            case self::NO_AUTHENTICATION:
                return 'Необходима аутентификация.';
            case self::NO_PERMISSIONS:
                return 'Недостаточно прав';
            case self::INVALID_INPUT_PARAMETERS:
                return 'Ошибка во входных параметрах:';

            default:
                return '';
        }
    }*/
}