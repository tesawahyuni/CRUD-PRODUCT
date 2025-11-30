<?php
require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/Product.php";

class ProductRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Database())->connect();
    }

    // CREATE
    public function create(Product $product) {
        $query = "INSERT INTO products (name, category, price, stock, image_path, status)
                  VALUES (:name, :category, :price, :stock, :image_path, :status)";

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'name' => $product->name,
            'category' => $product->category,
            'price' => $product->price,
            'stock' => $product->stock,
            'image_path' => $product->image_path,
            'status' => $product->status
        ]);
    }

    // READ ALL
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ by ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update(Product $product) {
        $query = "UPDATE products SET 
                    name=:name, category=:category, price=:price, stock=:stock, 
                    image_path=:image_path, status=:status 
                  WHERE id=:id";

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'name' => $product->name,
            'category' => $product->category,
            'price' => $product->price,
            'stock' => $product->stock,
            'image_path' => $product->image_path,
            'status' => $product->status,
            'id' => $product->id
        ]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
