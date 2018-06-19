<?php

namespace CollabimApp\InternalApi;

use CollabimApp\Account\Affil\Entity\DatePickerForm;
use CollabimApp\Account\Affil\Entity\PaidAmountsList;
use CollabimApp\Account\Affil\Entity\RegisteredClientsList;
use CollabimApp\Account\Affil\Form\DatePickerFormType;
use CollabimApp\Client\Client;
use CollabimApp\Client\Discount\DiscountedPlanFacade;
use CollabimApp\Client\Discount\DiscountFacade;
use CollabimApp\Client\InvoicingPeriod\InvoicingPeriodDiscountBind;
use CollabimApp\Payment\Invoice\InvoiceListFacade;
use CollabimApp\User\CurrentPageFacade;
use KutnyLib\DateTime\Date\Date;
use KutnyLib\Security\Authorization;
use KutnyLib\Templating\LayoutFiller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DataMapper
{
    private $db;

    public function __construct(
        \Kutny_Db_Adapter_Pdo $db
    ) {
        $this->db = $db;
    }

    public function getQueries(string $method, string $securityEndpointKey)
    {
        $stmt = $this->db->prepare(
            '
            SELECT prepareDataStatement, getDataStatement
            FROM internal_api
            WHERE methodName=:method AND securityKey=:securityKey;
        '
        );
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':securityKey', $securityEndpointKey);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getData(string $prepareDataStatement, string $getDataStatement)
    {
        $this->db->query(
            $prepareDataStatement
        );
        $stmt = $this->db->query(
            $getDataStatement
        );

        return $stmt->fetchAll();
    }
}
