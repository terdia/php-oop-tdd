<?php declare( strict_types=1 );
require_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\BugReport;
use App\Repository\BugReportRepository;
use App\Helpers\DbQueryBuilderFactory;
use App\Database\QueryBuilder;
use App\Logger\Logger;
use App\Exception\BadRequestException;

if(isset($_POST, $_POST['delete'])){
    $reportId = $_POST['reportId'];
    $logger = new Logger;

    try{
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = DbQueryBuilderFactory::make();
        /** @var BugReportRepository $repository */
        $repository = new BugReportRepository($queryBuilder);
        /** @var BugReport $bugReport */
        $bugReport = $repository->find((int) $reportId);
        $repository->delete($bugReport);

    }catch (Throwable $exception){
        $logger->critical($exception->getMessage(), $_POST);
        throw new BadRequestException($exception->getMessage(), [$exception], 400);
    }

    $logger->info(
        'bug report deleted',
        ['id' => $bugReport->getId(), 'type' => $bugReport->getReportType(),]
    );
    $bugReports = $repository->findAll();
}
