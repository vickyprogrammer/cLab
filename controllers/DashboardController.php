<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * DashboardController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 05/07/2020 10:45 AM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/UsersModel.php';
require_once __DIR__ . '/../models/StatsModel.php';
require_once __DIR__ . '/../models/OrderDetailsModel.php';
require_once __DIR__ . '/../models/SupplyDetailsModel.php';

use Application\Model\OrderDetailsModel;
use Application\Model\StatsModel;
use Application\Model\SupplyDetailsModel;
use Application\Model\UsersModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * DashboardController class
 *
 * @package Application
 */
class DashboardController extends Controller
{
    private $UsersModel;
    private $StatsModel;
    private $OrdersModel;
    private $SuppliesModel;

    public function __construct()
    {
        parent::__construct();
        $this->UsersModel = new UsersModel();
        $this->StatsModel = new StatsModel();
        $this->OrdersModel = new OrderDetailsModel();
        $this->SuppliesModel = new SupplyDetailsModel();
    }

    final public function Index(): void
    {
        $this->redirectTo($this->appConfig['app_baseUrl'] . '/app/dashboard');
    }

    final public function ShowPage(RouterRequest $req): void
    {
        $this->View->assign('title', 'Dashboard');
        $this->View->assign('page', 'dashboard');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'stats' => $this->StatsModel->getStats(),
            'stockIn' => $this->SuppliesModel->getAll([], false, 30, 0, ['id DESC']),
            'stockOut' => $this->OrdersModel->getAll([], false, 30, 0, ['id DESC']),
        ]);
        $this->displayPage('app/index');
    }

    final public function getChartData(): void
    {
        $incomeChart = $this->StatsModel->getIncomeChart();
        $expensesChart = $this->StatsModel->getExpensesChart();
        $data = [
            'income' => [
                'labels' => [],
                'series' => [[], []],
            ],
            'expenses' => [
                'labels' => [],
                'series' => [[], []],
            ],
        ];
        foreach ($incomeChart as $key => $income) {
            $data['income']['labels'][$key] = $income->label;
            $data['income']['series'][0][$key] = $income->quantity;
            $data['income']['series'][1][$key] = $income->total;
        }
        foreach ($expensesChart as $key => $expense) {
            $data['expenses']['labels'][$key] = $expense->label;
            $data['expenses']['series'][0][$key] = $expense->quantity;
            $data['expenses']['series'][1][$key] = $expense->total;
        }
        $this->displayJSON([
            'success' => true,
            'data' => $data,
        ]);
    }
}
