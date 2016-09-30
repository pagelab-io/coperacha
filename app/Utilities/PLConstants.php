<?php

namespace App\Utilities;

class PLConstants {

    // owners constants
    const OWNER_MONEYBOX = "moneybox";
    const OWNER_PARTICIPANT = "participant";

    // payment constants
    const PAYMENT_OXXO = 'O';
    const PAYMENT_SPEI = 'S';
    const PAYMENT_PAYPAL = 'P';
    const PAYMENT_PENDING = 'PENDING';
    const PAYMENT_CANCELED = 'CANCELED';
    const PAYMENT_PAYED = 'PAYED';
    const PAYMENT_OXXO_STRING = 'Oxxo';
    const PAYMENT_SPEI_STRING = 'Spei';
    const PAYMENT_PAYPAL_STRING = 'PayPal';
    const PAYMENT_COMMISSION = 5;

    // email's constants
    const EMAIL_CONTACT = 'emails.contact';
    const EMAIL_DEADLINE = 'emails.deadline';
    const EMAIL_GOAL_FINISHED = 'emails.goalfinished';
    const EMAIL_MONEYBOX_INVITATION = 'emails.invitation';
    const EMAIL_NEW_COPERACHA = 'emails.newcoperacha';
    const EMAIL_NEW_MONEYBOX = 'emails.newmoneybox';
    const EMAIL_PASSWORD_RECOVERY = 'emails.passwordrecovery';
    const EMAIL_PAYMENT_CONFIRMATION = 'emails.paymentconfirmation';
    const EMAIL_PENDING_INVITATION = 'emails.pendinginvitation';
    const EMAIL_CONFIRM_TRANSFER = 'emails.transferconfirm';
    const EMAIL_REGISTER = 'emails.welcome';
    //const EMAIL_BCC = 'perezatanaciod@gmail.com,sanchezz985@gmail.com,coperachamexico@gmail.com';
    const EMAIL_BCC = 'perezatanaciod@gmail.com,sanchezz985@gmail.com';

    // person constants
    const PERSON_GENDER_H = "Hombre";
    const PERSON_GENDER_M = "Mujer";

    // moneybox constants
    const MONEYBOX_STATUS_ACTIVE = "Activa";
    const MONEYBOX_STATUS_INACTIVE = "Completada";
}