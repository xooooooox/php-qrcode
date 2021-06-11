## Installation
```bash
composer require xooooooox/qrcode
``` 

## For example
```php
<?php

use xooooooox\qrcode\QrCode;

$qn = QrCode::Newer('/var/static/image/','/qrcode');
$RelativePath = $qn->Create('https://www.example.com/example','testing');
$AbsolutePath = $qn->VerifyDirectory($qn->QrCodePrefixDirectory.$RelativePath);
var_dump($RelativePath);
var_dump($AbsolutePath);
```
