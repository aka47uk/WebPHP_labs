<?php

// Creation of interface "AccountInterface" with 3 methods
interface AccountInterface
{
    public function deposit(float $amount): void;
    public function withdraw(float $amount): void;
    public function getBalance(): float;
}

// Creation of Base class with constant and exception stuff
class BankAccount implements AccountInterface
{
    // Minimum balance const
    public const MIN_BALANCE = 0;

    // Properties
    protected float $balance;
    protected string $currency;

    public function __construct(float $initialBalance = 0, string $currency = "USD")
    {
        if ($initialBalance < self::MIN_BALANCE) {
            throw new Exception("Initial balance cannot be less than " . self::MIN_BALANCE . " {$currency}");
        }
        $this->balance = $initialBalance;
        $this->currency = $currency;
    }

    //Deposit funds
    public function deposit(float $amount): void
    {
        // Check for invalid (negative or zero) amount
        if ($amount <= 0) {
            throw new Exception("Deposit amount must be greater than 0 {$this->currency}.");
        }
        $this->balance += $amount;
    }

    // Withdraw funds method

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception("Withdrawal amount must be greater than 0 {$this->currency}.");
        }

        if (($this->balance - $amount) < self::MIN_BALANCE) {
            throw new Exception("Insufficient funds on account ({$this->balance} {$this->currency}). Attempted to withdraw: {$amount} {$this->currency}.");
        }

        $this->balance -= $amount;
    }

    // Get balance method

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}

// Inheritance and static properties

class SavingsAccount extends BankAccount
{
    // Static property for interest rate of 5%
    public static float $interestRate = 0.05;

    public function applyInterest(): void
    {
        $interest = $this->balance * self::$interestRate;
        $this->balance += $interest;
        echo "Interest applied: +{$interest} {$this->currency} (Rate: " . (self::$interestRate * 100) . "%)" . "<br>";
    }
}

echo "BANK ACCOUNT SYSTEM" . "<br><br>";

// BankAccount operations test with exception cathing
try {
    echo "Creating and operating a standard account (USD):" . "<br>";
    $acc1 = new BankAccount(500, "USD");
    echo "Initial balance: " . $acc1->getBalance() . " " . $acc1->getCurrency() . "<br>";

    $acc1->deposit(200);
    echo "After depositing 200 USD: " . $acc1->getBalance() . " USD" . "<br>";

    $acc1->withdraw(150);
    echo "After withdrawing 150 USD: " . $acc1->getBalance() . " USD" . "<br><br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br><br>";
}

// SavingsAccount operations test with exception cathing
try {
    echo "Creating and operating a savings account (UAH):" . "<br>";
    $savingsAcc = new SavingsAccount(1000, "UAH");
    echo "Initial balance: " . $savingsAcc->getBalance() . " UAH" . "<br>";

    $savingsAcc->applyInterest();
    echo "Current balance: " . $savingsAcc->getBalance() . " UAH" . "<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br><br>";
}

// "Insufficient funds" exception
try {
    echo "Attempting to withdraw more funds than available:" . "<br>";
    $acc2 = new BankAccount(100, "EUR");
    echo "Current balance: " . $acc2->getBalance() . " EUR" . "<br>";
    
    // Attempting to withdraw more than balance of (in my case) 100 eur
    $acc2->withdraw(300);
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage() . "<br><br>";
}

// Invalid transaction amount exception
try {
    echo "Attempting to deposit a negative amount:" . "<br>";
    $acc3 = new BankAccount(50, "USD");
    
    // Attempting to deposit a negative amount
    $acc3->deposit(-50);
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage() . "<br><br>";
}
