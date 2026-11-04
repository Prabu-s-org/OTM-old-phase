<?php
class Poassign {
    private $conn;

    public $unique_id;
    public $form_main_unique_id;
    public $con_unique_id;
    public $con_name;
    public $con_contact_no;
    public $unit_price;
    public $product_unique_id;
    public $item_code;
    public $product;
    public $qty;
    public $assign_qty;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createPoassign() {
        $sqlQuery = "CALL insert_po_product_assign_details(
            :unique_id,
            :form_main_unique_id,
            :con_unique_id,
            :con_name,
            :con_contact_no,
            :unit_price,
            :product_unique_id,
            :item_code,
            :product,
            :qty,
            :assign_qty
        )";

        $stmt = $this->conn->prepare($sqlQuery);

        // Sanitize
        $this->unique_id = htmlspecialchars(strip_tags($this->unique_id));
        $this->form_main_unique_id = htmlspecialchars(strip_tags($this->form_main_unique_id));
        $this->con_unique_id       = htmlspecialchars(strip_tags($this->con_unique_id));
        $this->con_name            = htmlspecialchars(strip_tags($this->con_name));
        $this->con_contact_no      = htmlspecialchars(strip_tags($this->con_contact_no));
        $this->unit_price          = htmlspecialchars(strip_tags($this->unit_price));
        $this->product_unique_id   = htmlspecialchars(strip_tags($this->product_unique_id));
        $this->item_code           = htmlspecialchars(strip_tags($this->item_code));
        $this->product             = htmlspecialchars(strip_tags($this->product));
        $this->qty                 = htmlspecialchars(strip_tags($this->qty));
        $this->assign_qty          = htmlspecialchars(strip_tags($this->assign_qty));

        // Bind
        $stmt->bindParam(":unique_id", $this->unique_id);
        $stmt->bindParam(":form_main_unique_id", $this->form_main_unique_id);
        $stmt->bindParam(":con_unique_id", $this->con_unique_id);
        $stmt->bindParam(":con_name", $this->con_name);
        $stmt->bindParam(":con_contact_no", $this->con_contact_no);
        $stmt->bindParam(":unit_price", $this->unit_price);
        $stmt->bindParam(":product_unique_id", $this->product_unique_id);
        $stmt->bindParam(":item_code", $this->item_code);
        $stmt->bindParam(":product", $this->product);
        $stmt->bindParam(":qty", $this->qty);
        $stmt->bindParam(":assign_qty", $this->assign_qty);

        return $stmt->execute();
    }
}



?>
