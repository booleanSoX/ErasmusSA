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
                $rawState = trim($domain['domain_state']);
                $compareState = mb_strtolower($rawState);
                $stateClass = 'status-secondary'; // Gris por defecto

                $hoy = new DateTime();
                $expirationDateStr = $domain['expiration_date'] ?? null;
                $diasRestantes = null;

                if ($expirationDateStr) {
                    $fechaExp = new DateTime($expirationDateStr);
                    $diff = $hoy->diff($fechaExp);
                    $diasRestantes = (int)$diff->format("%r%a"); // %r mantiene el signo si es pasado
                }

                // Prioridad de Colores (incluyendo active/inactive en inglés y español)
                if (in_array($compareState, ['suspendido', 'inactive', 'inactivo']) || ($diasRestantes !== null && $diasRestantes < 0)) {
                    $stateClass = 'status-danger'; // Rojo
                } elseif ($diasRestantes !== null && $diasRestantes <= 30) {
                    $stateClass = 'status-warning'; // Amarillo (Quedan 30 días o menos)
                } elseif (in_array($compareState, ['activo', 'active'])) {
                    $stateClass = 'status-active'; // Verde
                }

                echo "<tr>";
                echo "<td>" . htmlspecialchars($domain['domain_name']) . "</td>";
                echo "<td><span class='status-badge $stateClass'>" . htmlspecialchars($rawState) . "</span></td>";
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
                echo "<td>" . htmlspecialchars((string)($email['size'] ?? '0')) . " KB</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='text-center'>No hay correos registrados.</td></tr>";
        }
    }

    public function displayFiles($userId) {
        // Archivos locales para Admin
        if ($userId === 1) {
            foreach (glob("uploads/*") as $file) {
                if (is_file($file)) {
                    $fileInfo = pathinfo($file);
                    
                    // Seguridad de tipos PHP 8+
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
        
        // Archivos de BD
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