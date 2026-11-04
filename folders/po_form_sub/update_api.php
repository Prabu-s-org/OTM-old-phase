<?php
class Poassign {
    private $conn;

    // Properties
    public $id;
    public $unique_id;
    public $form_main_unique_id;
    public $con_unique_id;
    public $con_name;
    public $con_contact_no;
    public $con_address;
    public $unit_price;
    public $product_unique_id;
    public $item_code;
    public $product;
    public $qty;
    public $assign_qty;
    public $batch_id;
    public $po_number; // 👈 NEW

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Update method using stored procedure
    public function updatePoassign() {
        // Stored Procedure with 12 parameters
        $sqlQuery = "CALL update_po_product_assign_details(
            :form_main_unique_id,
            :batch_id,
            :item_code,
            :con_unique_id,
            :con_name,
            :con_contact_no,
            :con_address,
            :unit_price,
            :product_unique_id,
            :product,
            :qty,
            :assign_qty,
            :po_number
        )";

        $stmt = $this->conn->prepare($sqlQuery);

        // Sanitize all values
        $this->form_main_unique_id = htmlspecialchars(strip_tags($this->form_main_unique_id));
        $this->batch_id            = htmlspecialchars(strip_tags($this->batch_id));
        $this->item_code           = htmlspecialchars(strip_tags($this->item_code));
        $this->con_unique_id       = htmlspecialchars(strip_tags($this->con_unique_id));
        $this->con_name            = htmlspecialchars(strip_tags($this->con_name));
        $this->con_contact_no      = htmlspecialchars(strip_tags($this->con_contact_no));
        $this->con_address         = htmlspecialchars(strip_tags($this->con_address));
        $this->unit_price          = htmlspecialchars(strip_tags($this->unit_price));
        $this->product_unique_id   = htmlspecialchars(strip_tags($this->product_unique_id));
        $this->product             = htmlspecialchars(strip_tags($this->product));
        $this->qty                 = htmlspecialchars(strip_tags($this->qty));
        $this->assign_qty          = htmlspecialchars(strip_tags($this->assign_qty));
        $this->po_number           = htmlspecialchars(strip_tags($this->po_number)); // 👈 NEW

        // Bind parameters
        $stmt->bindParam(":form_main_unique_id", $this->form_main_unique_id);
        $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":item_code", $this->item_code);
        $stmt->bindParam(":con_unique_id", $this->con_unique_id);
        $stmt->bindParam(":con_name", $this->con_name);
        $stmt->bindParam(":con_contact_no", $this->con_contact_no);
        $stmt->bindParam(":con_address", $this->con_address);
        $stmt->bindParam(":unit_price", $this->unit_price);
        $stmt->bindParam(":product_unique_id", $this->product_unique_id);
        $stmt->bindParam(":product", $this->product);
        $stmt->bindParam(":qty", $this->qty);
        $stmt->bindParam(":assign_qty", $this->assign_qty);
        $stmt->bindParam(":po_number", $this->po_number); // 👈 NEW

        // Execute
        return $stmt->execute();
    }
}
?>

