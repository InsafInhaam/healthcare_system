<?php
class DiagnosisReport
{
    private $conn;
    private $table_name = "diagnosis_reports";

    public $id;
    public $image_id;
    public $staff_id;
    public $report;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new diagnosis report
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (image_id, staff_id, report) VALUES (:image_id, :staff_id, :report)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":image_id", $this->image_id);
        $stmt->bindParam(":staff_id", $this->staff_id);
        $stmt->bindParam(":report", $this->report);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
