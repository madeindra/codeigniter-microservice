#!/bin/bash

if curl rabbitmq:15672
then apache2ctl -D FOREGROUND & php -r "require 'application/helpers/invoice_helper.php'; processInvoice();"
else exit
fi
