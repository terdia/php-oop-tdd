<?php declare( strict_types=1 );


namespace Tests\Functional;


use App\Database\QueryBuilder;
use App\Entity\BugReport;
use App\Helpers\DbQueryBuilderFactory;
use App\Helpers\HttpClient;
use App\Repository\BugReportRepository;
use PHPUnit\Framework\TestCase;

class CrudTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;
    /** @var BugReportRepository $repository */
    private $repository;
    /** @var HttpClient $client */
    private $client;

    public function setUp ()
    {
        $this->queryBuilder = DbQueryBuilderFactory::make();
        $this->repository = new BugReportRepository($this->queryBuilder);
        $this->client = new HttpClient();
        parent::setUp();
    }

    public function testItCanCreateReportUsingPostRequest()
    {
        $postData = $this->getPostData(['add' => true]);
        $response = $this->client->post("http://localhost/bug-report-app/Src/add.php", $postData);
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);

        $result = $this->repository->findBy([
            ['report_type', '=', 'Audio'],
            ['link', '=', 'https://example.com'],
            ['email', '=', 'test@example.com'],
        ]);

        /** @var BugReport $bugReport */
        $bugReport = $result[0] ?? [];
        self::assertInstanceOf(BugReport::class, $bugReport);
        self::assertSame('Audio', $bugReport->getReportType());
        self::assertSame('https://example.com', $bugReport->getLink());
        self::assertSame('test@example.com', $bugReport->getEmail());

        return $bugReport;
    }

    /** @depends testItCanCreateReportUsingPostRequest */
    public function testItCanUpdateReportUsingPostRequest(BugReport $bugReport)
    {
        $postData = $this->getPostData([
            'update' => true,
            'message' => 'The video on PHP OOP has audio issues, please check and fix it',
            'link' => 'https://updated.com',
            'reportId' => $bugReport->getId(),
        ]);
        $response = $this->client->post("http://localhost/bug-report-app/Src/update.php", $postData);
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);

        /** @var BugReport $result */
        $result = $this->repository->find($bugReport->getId());

        self::assertInstanceOf(BugReport::class, $result);
        self::assertSame(
            'The video on PHP OOP has audio issues, please check and fix it',
            $result->getMessage()
        );
        self::assertSame('https://updated.com', $result->getLink());

        return $result;
    }

    /** @depends testItCanUpdateReportUsingPostRequest */
    public function testItCanDeleteReportUsingPostRequest(BugReport $bugReport)
    {
        $postData = [
            'delete' => true,
            'reportId' => $bugReport->getId(),
        ];
        $response = $this->client->post("http://localhost/bug-report-app/Src/delete.php", $postData);
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);

        /** @var BugReport $result */
        $result = $this->repository->find($bugReport->getId());
        self::assertNull($result);
    }

    private function getPostData(array $options = []): array
    {
        return array_merge([
            'reportType' => 'Audio',
            'message' => 'The video on xxx has audio issues, please check and fix it',
            'email' => 'test@example.com',
            'link' => 'https://example.com',
        ], $options);
    }
}