# Parse Nomor Induk Kependudukan (NIK / KTP) untuk framework CodeIgniter 4
Parse indonesian identity number to get hidden information.
This repo is still being developed so there are still lots of bugs.

## Installation

	composer require aselsan/codeigniter4-nik-parser dev-dev

 ## Usage

```php
// calling
$parser = new \Aselsan\Codeigniter4NikParser\Parser();
$result = $parser->parse('3207637266300003');

// will return 
[
	'nik' => '3207637266300003',
	'zodiak' => 'Virgo',
	'gender' => 'L',
	...
]
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
