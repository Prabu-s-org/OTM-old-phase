<?php

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
    class Poassign{
        // Connection
        private $conn;
        // Table
        private $db_table = "po_product_assign_details";
        // Columns
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
        // public $rem_qty;
        // public $status;
        // public $tank_capacity;
        // public $fuel_alerts;
        // public $owner;
        // public $vehicle_group;
        // public $location;
        // public $note;
        // public $rto_location;
        // public $vehicle_model;
        // public $vehicle_brand_name;
        // public $chasis_no;
        // public $engine_no;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL


        // CREATE
        public function createPoassign(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                    unique_id  =:unique_id,
                    form_main_unique_id = :form_main_unique_id, 
                    con_unique_id = :con_unique_id, 
                    con_name = :con_name, 
                    con_contact_no = :con_contact_no,
                    unit_price = :unit_price, 
                    product_unique_id = :product_unique_id, 
                    item_code = :item_code, 
                    product = :product, 
                    qty = :qty, 
                    assign_qty = :assign_qty";
                    // status = :status";
                                     
                   
            $stmt = $this->conn->prepare($sqlQuery);
        // print_r($stmt);die();
            // sanitize
            $this->unique_id            = htmlspecialchars(strip_tags($this->unique_id));
            $this->form_main_unique_id            = htmlspecialchars(strip_tags($this->form_main_unique_id));
            $this->con_unique_id          = htmlspecialchars(strip_tags($this->con_unique_id));
            $this->con_name         = htmlspecialchars(strip_tags($this->con_name));
            $this->con_contact_no            = htmlspecialchars(strip_tags($this->con_contact_no));
            $this->unit_price            = htmlspecialchars(strip_tags($this->unit_price));
            $this->product_unique_id            = htmlspecialchars(strip_tags($this->product_unique_id));
            $this->item_code             = htmlspecialchars(strip_tags($this->item_code));
            $this->product             = htmlspecialchars(strip_tags($this->product));
            $this->qty             = htmlspecialchars(strip_tags($this->qty));
            $this->assign_qty              = htmlspecialchars(strip_tags($this->assign_qty));
            // $this->rem_qty              = htmlspecialchars(strip_tags($this->rem_qty));
            // $this->status              = htmlspecialchars(strip_tags($this->status));
          

            // bind data
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
            // $stmt->bindParam(":rem_qty", $this->rem_qty);
            // $stmt->bindParam(":status", $this->status);
           
            if($stmt->execute()){
                
               return true;
            }
            return false;
        }


        // update
        public function updatePoassign(){
            $sqlQuery = "UPDATE
                        ".$this->db_table."
                   SET
                form_main_unique_id = :form_main_unique_id, 
                con_unique_id = :con_unique_id, 
                con_name = :con_name, 
                con_contact_no = :con_contact_no,
                unit_price = :unit_price, 
                product_unique_id = :product_unique_id, 
                item_code = :item_code, 
                product = :product, 
                qty = :qty, 
                assign_qty = :assign_qty
            WHERE 
                unique_id = :unique_id";
                        // unique_id = :unique_id";
        
            $stmt = $this->conn->prepare($sqlQuery);

            $this->unique_id=htmlspecialchars(strip_tags($this->unique_id));
        
            $this->form_main_unique_id=htmlspecialchars(strip_tags($this->form_main_unique_id));
            $this->con_unique_id=htmlspecialchars(strip_tags($this->con_unique_id));
            $this->con_unique_id=htmlspecialchars(strip_tags($this->con_unique_id));
            $this->con_name=htmlspecialchars(strip_tags($this->con_name));
            $this->con_contact_no=htmlspecialchars(strip_tags($this->con_contact_no));
            $this->unit_price=htmlspecialchars(strip_tags($this->unit_price));
            $this->product_unique_id=htmlspecialchars(strip_tags($this->product_unique_id));
            $this->item_code=htmlspecialchars(strip_tags($this->item_code));
            $this->product=htmlspecialchars(strip_tags($this->product));
            $this->qty=htmlspecialchars(strip_tags($this->qty));
            $this->assign_qty=htmlspecialchars(strip_tags($this->assign_qty));
        
  // bind data
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
// print_r($stmt);

            // bind data
            // $stmt->bindParam(":name", $this->name);
            // $stmt->bindParam(":email", $this->email);
            // $stmt->bindParam(":age", $this->age);
            // $stmt->bindParam(":designation", $this->designation);
            // $stmt->bindParam(":created", $this->created);
            // $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        
        
    }
?>

