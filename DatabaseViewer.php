<?php
class DatabaseViewer {
    private $databaseManager;

    public function __construct($databaseManager) {
        $this->databaseManager = $databaseManager;
    }   

    public function displayDomains($userId) {
        $domains = $this->databaseManager->getUserDomains($userId);
        foreach ($domains as $domain) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($domain['domain_name']) . "</td>";
            echo "<td>" . htmlspecialchars($domain['domain_state']) . "</td>";
            echo "</tr>";
        }
    }

    public function displayEmails($userId) {
        $emails = $this->databaseManager->getUserEmailsPerDomain($userId);
        foreach ($emails as $email) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($email['email_address']) . "</td>";
            echo "<td>" . htmlspecialchars($email['domain_name']) . "</td>";
            echo "<td>" . htmlspecialchars((string)$email['size']) . " KB</td>";
            echo "</tr>";
        }
    }
}
?>