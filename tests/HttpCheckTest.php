<?php

use Carbon\CarbonPeriod;
use GuzzleHttp\Client;
use Jetfuel\SolarLunar\Lunar;
use Jetfuel\SolarLunar\Solar;
use Jetfuel\SolarLunar\SolarLunar;
use PHPUnit\Framework\TestCase;

class HttpCheckTest extends TestCase
{
    public function testSolarToLunar()
    {
        $client = new Client();
        $period = CarbonPeriod::create('1900-01-01', '2100-01-01');

        foreach ($period as $date) {
            $year = $date->year;
            $month = $date->month;
            $day = $date->day;

            $solar = Solar::create($year, $month, $day);
            $lunar = SolarLunar::solarToLunar($solar);
            $res = $this->getSolarToLunar($client, $solar);

            $isValid = $lunar->year === $res[0] &&
                $lunar->month === $res[1] &&
                $lunar->day === $res[2] &&
                $lunar->isLeap === $res[3];

            $this->assertTrue($isValid);

            $solar = SolarLunar::lunarToSolar($lunar);
            $res = $this->getLunarToSolar($client, $lunar);

            $isValid = $solar->year === $res[0] &&
                $solar->month === $res[1] &&
                $solar->day === $res[2];

            $this->assertTrue($isValid);
        }
    }

    /**
     * https://github.com/isee15/Lunar-Solar-Calendar-Converter
     * node check.js in javascript folder
     */
    private function getSolarToLunar(Client $client, Solar $solar): array
    {
        $resp = $client->request('GET', "http://localhost:1337/?src={$solar->year},{$solar->month},{$solar->day}");
        $result = explode(',', $resp->getBody()->getContents());

        return [
            (int) $result[0],
            (int) $result[1],
            (int) $result[2],
            (bool) $result[3],
        ];
    }

    /**
     * https://github.com/isee15/Lunar-Solar-Calendar-Converter
     * node check.js in javascript folder
     */
    private function getLunarToSolar(Client $client, Lunar $lunar): array
    {
        $resp = $client->request('GET', "http://localhost:1337/?src={$lunar->year},{$lunar->month},{$lunar->day},{$lunar->isLeap}");
        $result = explode(',', $resp->getBody()->getContents());

        return [
            (int) $result[0],
            (int) $result[1],
            (int) $result[2],
        ];
    }
}
