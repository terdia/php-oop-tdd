<?php


namespace Tests\Units;


use App\Database\QueryBuilder;
use App\Helpers\DbQueryBuilderFactory;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{

    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    public function setUp()
    {
        $this->queryBuilder = DbQueryBuilderFactory::make(
            'database', 'pdo', ['db_name' => 'bug_app_testing']
        );
        $this->queryBuilder->beginTransaction();
        parent::setUp();
    }

    public function testItCanCreateRecords()
    {
        $id = $this->insertIntoTable();
        self::assertNotNull($id);
    }

    public function testInCanPerformRawQuery()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->raw("SELECT * FROM reports;")->get();
        self::assertNotNull($result);
    }

    public function testItCanPerformSelectQuery()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $id)
            ->runQuery()
            ->first();

        self::assertNotNull($result);
        self::assertSame($id, $result->id);
    }

    public function testItCanPerformSelectQueryWithMultipleWhereClause()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $id)
            ->where('report_type', 'Report Type 1')
            ->runQuery()
            ->first();
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanFindById()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->select('*')->find($id);
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanFindOneByGivenValue()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->select('*')->findOneBy('report_type', 'Report Type 1');
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanUpdateGivenRecord()
    {
        $id = $this->insertIntoTable();
        $count = $this->queryBuilder->table('reports')->update([
            'report_type' => 'Report Type 1 updated'
        ])->where('id', $id)->runQuery()->affected();

        self::assertEquals(1, $count);
        $result = $this->queryBuilder->select('*')->find($id);
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1 updated', $result->report_type);
    }
    public function testItCanDeleteGivenId()
    {
        $id = $this->insertIntoTable();
        $count = $this->queryBuilder->table('reports')->delete()
            ->where('id', $id)->runQuery()->affected();

        self::assertEquals(1, $count);
        $result = $this->queryBuilder->select('*')->find($id);
        self::assertNull($result);
    }


    public function tearDown()
    {
        $this->queryBuilder->rollback();
        parent::tearDown();
    }

    /**
     * @return mixed
     */
    private function insertIntoTable()
    {
        $data = [
            'report_type' => 'Report Type 1',
            'message' => 'This is a dummy message',
            'email' => 'support@devscreencast',
            'link' => 'https://link.com',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $id = $this->queryBuilder->table('reports')->create($data);
        return $id;
    }
}