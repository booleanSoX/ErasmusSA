<?php
class DatabaseViewer {
    private $databaseManager;

    public function __construct($databaseManager) {
        $this->databaseManager = $databaseManager;
    }   

    public function displayDomains($userId) {
        $domains = $this->databaseManager->getUserDomains($userId);
        if ($domains) {
            foreach ($domains as $domain) {
                $hoy = new DateTime();
                $hoy->setTime(0, 0, 0); 
                $expirationDateStr = $domain['expiration_date'] ?? null;
                
                $stateText = 'Desconocido';
                $stateClass = 'status-secondary'; 
                if ($expirationDateStr) {
                    $fechaExp = new DateTime($expirationDateStr);
                    $fechaExp->setTime(0, 0, 0);
                    
                    $diff = $hoy->diff($fechaExp);
                    $diasRestantes = (int)$diff->format("%r%a"); 

                    if ($diasRestantes < 0) {
                        $stateText = 'Suspendido';
                        $stateClass = 'status-danger';  
                    } elseif ($diasRestantes <= 30) {
                        $stateText = 'Activo';
                        $stateClass = 'status-warning';
                    } else {
                        $stateText = 'Activo';
                        $stateClass = 'status-active';  
                    }
                } else {
                    $stateText = trim($domain['domain_state'] ?? 'N/A');
                }

                echo "<tr>";
                echo "<td>" . htmlspecialchars($domain['domain_name']) . "</td>";
                echo "<td><span class='status-badge $stateClass'>" . htmlspecialchars($stateText) . "</span></td>";
                echo "<td>" . htmlspecialchars($domain['registration_date'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($domain['expiration_date'] ?? 'N/A') . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No hay dominios registrados.</td></tr>";
        }
    }

    public function displayEmails($userId) {
        $emails = $this->databaseManager->getUserEmailsPerDomain($userId);
        if ($emails) {
            foreach ($emails as $email) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($email['email_address']) . "</td>";
                echo "<td>" . htmlspecialchars((string)($email['id_domain'] ?? '0')) . "  </td>";
                echo "<td>" . htmlspecialchars((string)($email['current_size'] ?? '0')) . " KB</td>";
                echo "<td>" . htmlspecialchars((string)($email['quota_limit'] ?? '0')) . " KB</td>";
                echo "<td>" . htmlspecialchars((string)($email['last_login'] ?? 'N/A')) . "</td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='text-center'>No hay correos registrados.</td></tr>";
        }
    }

    public function displayFiles($userId) {
        if ($userId === 1) {
            foreach (glob("uploads/*") as $file) {
                if (is_file($file)) {
                    $fileInfo = pathinfo($file);
                    
                    $mime = @mime_content_type($file) ?: 'application/octet-stream';
                    $size = @filesize($file) ?: 0;

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fileInfo['basename']) . "</td>";
                    echo "<td>" . htmlspecialchars($fileInfo['extension'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars((string)$mime) . "</td>";
                    echo "<td>" . round($size / 1024, 2) . " KB</td>";
                    echo "<td class='text-center'>
                            <a href='" . htmlspecialchars($file) . "' class='btn-download' download><i class='fa-solid fa-download'></i></a>
                          </td>";
                    echo "</tr>";
                }
            }
        }
        
        $files = $this->databaseManager->getUserFiles($userId); 
        if ($files) {
            foreach ($files as $file) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($file['file_name']) . "</td>";
                echo "<td>" . htmlspecialchars($file['extension']) . "</td>";
                echo "<td>" . htmlspecialchars($file['mime_type'] ?? 'unknown') . "</td>";
                echo "<td>" . htmlspecialchars((string)$file['file_size']) . " KB</td>";
                echo "<td class='text-center'>
                        <a href='download.php?id=" . urlencode((string)$file['id_file']) . "' class='btn-download'><i class='fa-solid fa-download'></i></a>
                      </td>";
                echo "</tr>";
            }
        } elseif ($userId !== 1) {
            echo "<tr><td colspan='5' class='text-center'>No hay documentos registrados.</td></tr>";
        }
    }
}
?>