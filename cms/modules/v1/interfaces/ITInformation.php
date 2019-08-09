<?php 

namespace cms\modules\v1\interfaces;

interface ITInformation
{
    public function getUserInformation();

    public function getInvoices();

    public function concatDataAndReturn();

    public function getActiveRequest();
}