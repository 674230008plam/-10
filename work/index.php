<?php
declare(strict_types=1);

final class Product
{
    public private(set) float $price;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        float $price,
    ) {
        $this->price = $this->validatePrice($price);
    }

    public function applyDiscount(float $percent): void
    {
        // ต้องใส่วงเล็บรอบเงื่อนไข if
        if ($percent < 0.0 || $percent > 100.0) {
            throw new InvalidArgumentException('Discount must be between 0 and 100.');
        }

        $this->price = round($this->price * (100.0 - $percent) / 100.0, 2);
    }

    public function displayPrice(): string
    {
        return sprintf('%s (#%d) ราคา: %.2f บาท', $this->name, $this->id, $this->price);
    }

    private function validatePrice(float $price): float
    {
        if ($price < 0.0) {
            throw new InvalidArgumentException('Price cannot be negative.');
        }

        return round($price, 2);
    }
}

// ================= ตัวอย่างการเรียกใช้งานเพื่อทดสอบ =================
try {
    // 1. สร้าง Object สินค้า
    $item = new Product(1, 'สมุดโน้ต', 45.00);
    echo "เริ่มต้น: " . $item->displayPrice() . PHP_EOL;

    // 2. ทดลองลดราคา 10%
    $item->applyDiscount(10);
    echo "หลังลด 10%: " . $item->displayPrice() . PHP_EOL;

    // 3. ทดลองใส่ส่วนลดที่ผิดเงื่อนไข (จะโดน Exception ดักไว้)
    // $item->applyDiscount(150);

} catch (InvalidArgumentException $e) {
    echo "ข้อผิดพลาด: " . $e->getMessage() . PHP_EOL;
}