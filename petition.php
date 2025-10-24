<?php
class Petition {
    private $conn;
    public $Titre;
    public $Description;
    public $DateAjout;
    public $DateFin;
    public $NomPorteur;
    public $Email;
    public $Pass;
    static $nbrSignatures = 0;

    // Constructor takes the PDO connection
    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouterPetition() {
        try {
            $stmt = $this->conn->prepare("INSERT INTO Petition (TitreP, DescriptionP, DateAjout, DateFin, NomPorteurP, Email, Pass) values (?,?,?,?,?,?,?)");
            return $stmt->execute([$this->Titre, $this->Description, $this->DateAjout, $this->DateFin, $this->NomPorteur, $this->Email, $this->Pass]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la pétition: " . $e->getMessage());
        }
    }

    public function getAllPetitions() {
        $stmt = $this->conn->prepare("SELECT * FROM Petition order by IDP DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastSignatures($petitionId) {
        $stmt = $this->conn->prepare("SELECT NomS, PrenomS, DateS, HeureS, EmailS FROM signature
                                    WHERE IDP = ? 
                                    ORDER BY DateS DESC, HeureS DESC 
                                    LIMIT 5");
        $stmt->execute([$petitionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPetitionDetails($petitionId) {
        $stmt = $this->conn->prepare("SELECT * FROM Petition WHERE IDP = ?");
        $stmt->execute([$petitionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopPetitionBySignatures() {
        $stmt = $this->conn->prepare("SELECT p.IDP, p.TitreP, p.DescriptionP, p.DateAjout, p.DateFin, p.NomPorteurP, p.Email, COUNT(s.IDS) AS nbrSignatures
                                FROM Petition p
                                LEFT JOIN signature s ON p.IDP = s.IDP
                                GROUP BY p.IDP
                                ORDER BY nbrSignatures DESC
                                LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($petitionId, $password) {
        $stmt = $this->conn->prepare("SELECT Pass FROM Petition WHERE IDP = ?");
        $stmt->execute([$petitionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result && $result['Pass'] === $password;
    }

    public function deletePetition($petitionId) {
        // First delete related signatures
        $stmt = $this->conn->prepare("DELETE FROM signature WHERE IDP = ?");
        $stmt->execute([$petitionId]);
        
        // Then delete the petition
        $stmt = $this->conn->prepare("DELETE FROM Petition WHERE IDP = ?");
        $stmt->execute([$petitionId]);
        
        return $stmt->rowCount() > 0;
    }

    public function updatePetition($petitionId, $titre, $description, $dateFin) {
        $stmt = $this->conn->prepare("UPDATE Petition SET TitreP = ?, DescriptionP = ?, DateFin = ? WHERE IDP = ?");
        $stmt->execute([$titre, $description, $dateFin, $petitionId]);
        
        return $stmt->rowCount() > 0;
    }
}
?>