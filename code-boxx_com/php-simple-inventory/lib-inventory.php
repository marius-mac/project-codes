<?php
class Inventory extends DB {
  function getAll() {
  // getAll() : get all inventory & current stock

    $sql = "SELECT * FROM `inventory_stock`";
    $stock = $this->fetch($sql);
    return count($stock)==0 ? false : $stock ;
  }

  function get($part) {
  // get() : get part
  // PARAM $part : part number

    $sql = "SELECT * FROM `inventory_stock` WHERE `part_no`=?";
    $stock = $this->fetch($sql, [$part]);
    return count($stock)==0 ? false : $stock[0] ;
  }

  function getMvt($part) {
  // getMvt() : get stock movement of part
  // PARAM $part : part number

    $sql = "SELECT * FROM `inventory_movement` WHERE `part_no`=? ORDER BY `mvt_date` DESC";
    $stock = $this->fetch($sql, [$part]);
    return count($stock)==0 ? false : $stock ;
  }

  function add($part, $name, $stock=0, $desc="") {
  // add() : add new part
  // PARAM $part : part number
  //       $name : part name
  //       $stock : initial stock level
  //       $desc : part description (optional)

    // MAIN ENTRY
    $this->start();
    $sql = "INSERT INTO `inventory_stock` (`part_no`, `part_name`, `part_desc`, `part_stock`) VALUES (?, ?, ?, ?)";
    $cond = [$part, $name, $desc, $stock];
    $pass = $this->exec($sql, $cond);

    // INITIAL STOCK MOVEMENT
    if ($pass) {
      $sql = "INSERT INTO `inventory_movement` (`part_no`, `mvt_type`, `mvt_qty`) VALUES (?, 'i', ?);";
      $cond = [$part, $stock];
      $pass = $this->exec($sql, $cond);
    }

    // FINALIZE
    $this->end($pass);
    return $pass;
  }

  function edit($part, $name, $desc="", $newPart) {
  // edit() : edit part
  // PARAM $part : part number
  //       $name : part name
  //       $desc : part description (optional)
  //       $newPart : the new part number

    // MAIN ENTRY
    $this->start();
    if ($part!=$newPart) {
      $sql = "UPDATE `inventory_stock` SET `part_no`=?, `part_name`=?, `part_desc`=? WHERE `part_no`=?;";
      $cond = [$newPart, $name, $desc, $part];
    } else {
      $sql = "UPDATE `inventory_stock` SET `part_name`=?, `part_desc`=? WHERE `part_no`=?;";
      $cond = [$name, $desc, $part];
    }
    $pass = $this->exec($sql, $cond);

    // STOCK MOVEMENT - IF PART NUMBER IS CHANGED
    if ($pass && $part!=$newPart) {
      $sql = "UPDATE `inventory_movement` SET `part_no`=? WHERE `part_no`=?;";
      $cond = [$newPart, $part];
      $pass = $this->exec($sql, $cond);
    }

    // FINALIZE
    $this->end($pass);
    return $pass;
  }

  function del($part){
  // del() : delete part
  // PARAM $part : part number

    // MAIN ENTRY
    $this->start();
    $sql = "DELETE FROM `inventory_stock` WHERE `part_no`=?;";
    $cond = [$part];
    $pass = $this->exec($sql, $cond);

    // STOCK MOVEMENT - IF PART NUMBER IS CHANGED
    if ($pass) {
      $sql = "DELETE FROM `inventory_movement` WHERE `part_no`=?;";
      $pass = $this->exec($sql, $cond);
    }

    // FINALIZE
    $this->end($pass);
    return $pass;
  }
  
  function mvt($part, $type, $qty, $comment=null) {
  // mvt() : add new stock movement, update stock count
  // PARAM $part : part number
  //       $type : movement type - 'i'n, 'o'ut, or 's'tock take.
  //       $qty : quantity
  //       $comment : comment, if any

    // CHECKS
    // Invalid movement type
    if ($type!="i" && $type!="o" && $type!="s") {
      $this->error = "Invalid movement type";
      return false;
    }

    // Invalid quantity
    if (!is_numeric($qty)) {
      $this->error = "Invalid quantity";
      return false;
    }

    // Get current stock level - Invalid part number
    $current = $this->get($part);
    if ($current==false) {
      $this->error = "Invalid part number";
      return false;
    } else {
      $current = $current['part_stock'];
    }

    // INSERT MOVEMENT ENTRY
    $this->start();
    $sql = sprintf("INSERT INTO `inventory_movement` (`part_no`, `mvt_type`, `mvt_qty`%s) VALUES (?, ?, ?%s);",
      $comment ? ", `mvt_comment`" : "", 
      $comment ? ", ?" : ""
    );
    $cond = [$part, $type, $qty];
    if ($comment) { $cond[] = $comment; }
    $pass = $this->exec($sql, $cond);

    // UPDATE STOCK COUNT
    if ($pass) {
      $sql = "UPDATE `inventory_stock` SET `part_stock`=? WHERE `part_no`=?";
      switch ($type) {
        case "i":
          $current += $qty;
          break;
        case "o":
          $current -= $qty;
          break;
        case "s":
          $current = $qty;
          break;
      }
      $cond = [$current, $part];
      $pass = $this->exec($sql, $cond);
    }

    // THE RESULT
    $this->end($pass);
    return $pass;
  }
}
?>