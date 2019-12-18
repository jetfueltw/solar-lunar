<?php

use Carbon\CarbonPeriod;
use GuzzleHttp\Client;
use Jetfuel\SolarLunar\Lunar;
use Jetfuel\SolarLunar\Solar;
use Jetfuel\SolarLunar\SolarLunar;
use PHPUnit\Framework\TestCase;

class ApiCheckTest extends TestCase
{
    public function testSolarToLunar()
    {
        $client = new Client();
        $period = CarbonPeriod::create('1900-01-01', '2099-12-31');

        foreach ($period as $date) {
            $solar = Solar::create($date->year, $date->month, $date->day);
            $lunar = SolarLunar::solarToLunar($solar);
            $expectLunar = $this->getExpectLunar($client, $solar);

            $this->assertEquals($expectLunar, $lunar);

            $solar = SolarLunar::lunarToSolar($lunar);
            $expectSolar = $this->getExpectSolar($client, $lunar);

            $this->assertEquals($expectSolar, $solar);
        }
    }

    /**
     * https://github.com/isee15/Lunar-Solar-Calendar-Converter
     * node check.js in javascript folder
     */
    private function getExpectLunar(Client $client, Solar $solar): Lunar
    {
        $resp = $client->request('GET', "http://localhost:1337/?src={$solar->year},{$solar->month},{$solar->day}");
        $result = explode(',', $resp->getBody()->getContents());

        return Lunar::create(
            (int) $result[0],
            (int) $result[1],
            (int) $result[2],
            (bool) $result[3]
        );
    }

    /**
     * https://github.com/isee15/Lunar-Solar-Calendar-Converter
     * node check.js in javascript folder
     */
    private function getExpectSolar(Client $client, Lunar $lunar): Solar
    {
        $resp = $client->request('GET', "http://localhost:1337/?src={$lunar->year},{$lunar->month},{$lunar->day},{$lunar->isLeap}");
        $result = explode(',', $resp->getBody()->getContents());

        return Solar::create(
            (int) $result[0],
            (int) $result[1],
            (int) $result[2]
        );
    }
}
