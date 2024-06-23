<?php

namespace Aselsan\Codeigniter4NikParser;

use DateTime;

class NikParser
{
    /**
     * Data result array.
     *
     * @var array
     */
    protected $data = [];
    protected $wilayah = [];

    protected $nik = '';
    protected $birthDate = '';
    protected $provinceCode = '';
    protected $regencyCode = '';
    protected $districtCode = '';

    public function __construct()
    {
        $this->wilayah = $this->getWilayah();
        $this->birthDate = $this->getBirthDate();
    }

    public function parse(string $nik = '', ?int $length = 16): array
    {
        if ($length !== strlen($nik)) {
            throw new \InvalidArgumentException(
                'The \'nik\' parameter should be ' . $length
                    . ' digit length'
            );
        }


        if (empty($nik)) {
            return [];
        }

        $this->nik = $nik;
        $this->birthDate = $nik;

        $this->data['nik'] = $nik;
        $this->data['zodiak'] = $this->getZodiac($this->birthDate);

        return $this->data;
    }

    /**
     * @return array
     */
    private function getWilayah(): array
    {
        $path = __DIR__ . '/Resource/wilayah.json';
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    /**
     * Province section
     */
    public function getProvince()
    {
        $province = substr($this->nik, 0, 2);
        if (array_key_exists($province, $this->wilayah['provinsi'])) {
            return $this->wilayah['provinsi'][$this->getProvinceCode()];
        }
        return;
    }

    public function getBirthDate()
    {
        if ($birth = substr($this->nik, 6, 6) > 0) {
            $year  = substr($birth, 0, 2);
            $month = substr($birth, 2, 2);
            $day   = substr($birth, 4, 2);
            return $year . '-' . $month . '-' . $day;
        };

        return;
    }

    public function getProvinceCode(): string
    {
        return substr($this->nik, 0, 2);
    }

    public function getBirthDateFromNik($nik)
    {
    }

    public function getZodiac($birthDate): string
    {
        $zodiac = "";

        // Buat objek DateTime dari string tanggal
        if (!$date = new DateTime($birthDate)) {
            throw new \InvalidArgumentException(
                // The valid date must be Y-m-d i.e. 1992-12-20
                'The \'birthDate\' parameter is not a valid date.'
            );
        }

        // Dapatkan bulan
        $month = $date->format('m');

        // Dapatkan tanggal
        $day = $date->format('d');

        if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
            $zodiac = "Aquarius";
        } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
            $zodiac = "Pisces";
        } elseif (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
            $zodiac = "Aries";
        } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
            $zodiac = "Taurus";
        } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
            $zodiac = "Gemini";
        } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
            $zodiac = "Cancer";
        } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
            $zodiac = "Leo";
        } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
            $zodiac = "Virgo";
        } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
            $zodiac = "Libra";
        } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
            $zodiac = "Scorpio";
        } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
            $zodiac = "Sagittarius";
        } elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
            $zodiac = "Capricorn";
        }

        return $zodiac;
    }

    public function calculateAge($birthDate): int
    {
        if (!$this->isValidDate($birthDate)) {
            throw new \InvalidArgumentException(
                // The valid date must be Y-m-d i.e. 1992-12-20
                'The \'birthDate\' parameter is not a valid date.'
            );
        }
        // Konversi tanggal lahir ke objek DateTime
        $birthDate = new DateTime($birthDate);
        // Ambil tanggal saat ini
        $currentDate = new DateTime('today');

        // Hitung selisih antara tanggal lahir dan tanggal saat ini
        $age = $birthDate->diff($currentDate)->y;

        return (int) $age;
    }

    private function isValidDate($date): bool
    {
        // Tentukan format tanggal
        $format = 'Y-m-d';

        // Buat objek DateTime dari format yang ditentukan
        $d = DateTime::createFromFormat($format, $date);

        // Periksa apakah tanggal valid dan sesuai dengan format yang diberikan
        return $d && $d->format($format) === $date;
    }
}
