<?php declare( strict_types=1 );

use App\Repository\BugReportRepository;
use App\Helpers\DbQueryBuilderFactory;
use App\Database\QueryBuilder;

/** @var QueryBuilder $queryBuilder */
$queryBuilder = DbQueryBuilderFactory::make();
$repository = new BugReportRepository($queryBuilder);

$bugReports = $repository->findAll();