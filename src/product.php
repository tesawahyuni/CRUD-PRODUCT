<?php
class Product {
    public $id;
    public $name;
    public $category;
    public $price;
    public $stock;
    public $image_path;
    public $status;

    public function __construct($name, $category, $price, $stock, $image_path, $status, $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->image_path = $image_path;
        $this->status = $status;
    }
}
?>
