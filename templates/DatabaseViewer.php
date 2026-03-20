<?php
class DatabaseViewer {
    private $databaseManager;

    public function __construct($databaseManager) {
        $this->databaseManager = $databaseManager;
    }

    public function displayDomains($userId) {
        $domains = $this->databaseManager->getUserDomains($userId);
        
        if (!$domains) {
            echo "<tr><td colspan='5' class='text-center'>No hay dominios registrados.</td></tr>";
            return;
        }

        $hoy = new DateTime();
        $hoy->setTime(0, 0, 0);

        foreach ($domains as $domain) {
            $expirationDateStr = $domain['expiration_date'] ?? null;
            $stateText = trim($domain['domain_state'] ?? 'Desconocido');
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
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($domain['domain_name']) . "</td>";
            echo "<td><span class='status-badge $stateClass'>" . htmlspecialchars($stateText) . "</span></td>";
            echo "<td>" . htmlspecialchars($domain['registration_date'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($expirationDateStr ?? 'N/A') . "</td>";
            
            echo "<td class='text-center'><i class='fa-solid fa-pen-to-square btn-edit' title='Editar Dominio'></i></td>";
            echo "</tr>";
        }
    }

    public function displayEmails($userId) {
        $emails = $this->databaseManager->getEmailsPerUser($userId);
        
        if (!$emails) {
            echo "<tr><td colspan='6' class='text-center'>No hay correos registrados.</td></tr>";
            return;
        }

        foreach ($emails as $email) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($email['email_address']) . "</td>";
            echo "<td>" . htmlspecialchars((string)($email['domain_name'] ?? '0')) . "</td>";
            echo "<td>" . htmlspecialchars((string)($email['current_size'] ?? '0')) . " KB</td>";
            echo "<td>" . htmlspecialchars((string)($email['quota_limit'] ?? '0')) . " KB</td>";
            echo "<td>" . htmlspecialchars((string)($email['last_login'] ?? 'N/A')) . "</td>";
            
            echo "<td class='text-center'><i class='fa-solid fa-pen-to-square btn-edit' title='Editar Correo'></i></td>";
            echo "</tr>";
        }
    }

    public function displayFiles($userId) {
        $files = $this->databaseManager->getUserFiles($userId) ?: [];
        
        if ($userId === 1) {
            $globalFiles = glob("uploads/*");
            foreach ($globalFiles as $filePath) {
                if (is_file($filePath)) {
                    $name = basename($filePath);
                    $this->renderFileRow([
                        'file_name' => $name,
                        'extension' => pathinfo($filePath, PATHINFO_EXTENSION),
                        'mime_type' => @mime_content_type($filePath) ?: 'application/octet-stream',
                        'file_size' => round(filesize($filePath) / 1024, 2),
                        'download_url' => $filePath 
                    ]);
                }
            }
        }

        if (empty($files) && $userId !== 1) {
            echo "<tr><td colspan='5' class='text-center'>No hay documentos registrados.</td></tr>";
            return;
        }

        foreach ($files as $file) {
            $file['download_url'] = "download.php?id=" . urlencode((string)$file['id_file']);
            $this->renderFileRow($file);
        }
    }

    private function renderFileRow($data) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($data['file_name']) . "</td>";
        echo "<td>" . htmlspecialchars($data['extension']) . "</td>";
        echo "<td>" . htmlspecialchars($data['mime_type'] ?? 'unknown') . "</td>";
        echo "<td>" . htmlspecialchars((string)$data['file_size']) . " KB</td>";
        echo "<td class='text-center'>
                <a href='" . htmlspecialchars($data['download_url']) . "' class='btn-download'>
                    <i class='fa-solid fa-download'></i>
                </a>
              </td>";
        echo "</tr>";
    }
}
?>