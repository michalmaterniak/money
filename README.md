## Introduction
PHP Money pattern's implementation, Martin Fowler [Money pattern by Martin Fowler](http://martinfowler.com/eaaCatalog/money.html).


## Usage

```bash
composer require commitm/money
```


```php
$amount = 100; // 100 = 100 cents = 1 $
$currency = 'USD';

$money = new \Money\Money(new \Money\Amount\Amount($amount), new \Money\Currency\Currency($currency));
// Money class is a value object

$money->getAmount() // return value

$code = $money->getCurrency()->getCode();

$money2 = clone $money; // values $money2 hava the same values like $money, but different objects' references

// comparing
$isEqual = $money->equals($money2); // true
$isCurrenciesTheSame = $money->identicalCurrencies($money2); // true

// math: add, sub, percentage. Value object Money class create a new object
$addMoney = $money->add($money2); // $addMoney->getAmount() === 200
$subMoney = $money->sub($money2); // $subMoney->getAmount() === 0
$sub2Money = $money->sub($money2, $money2); // $sub2Money->getAmount() === -100
// library provide possibility a negative amount
$halfMoney = $money->percent(0.5); // $halfMoney->getAmount() === 50
```
You can override Amount or Currency class with own restricts or validations, make new class and implementin AmountInterface
```php
class Amount2 implements \Money\Amount\AmountInterface {
    public function __construct(int $value) {
        // validation or something else
    }
    public function getAmount(): string{
        return ...
    }
}

$money = new \Money\Money(new Amount2(100), new \Money\Currency\Currency('USD'));
```
## License

[MIT](https://choosealicense.com/licenses/mit/)