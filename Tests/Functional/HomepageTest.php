<?php declare( strict_types=1 );


namespace Tests\Functional;


use App\Helpers\HttpClient;
use PHPUnit\Framework\TestCase;

class HomepageTest extends TestCase
{
    public function testItCanVisitHomepageAndSeeRelevantData()
    {
        $client = new HttpClient;
        $response = $client->get('http://localhost/bug-report-app/index.php');
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);
        self::assertStringContainsString('Bug Report App', $response['content']);
        self::assertStringContainsString('<h2>Manage <b>Bug Reports</b></h2>', $response['content']);
    }
}