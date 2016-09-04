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
    const EMAIL_BCC = 'sanchezz985@gmail.com,perezatanaciod@gmail.com';
}