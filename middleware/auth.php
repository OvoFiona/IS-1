<?php
function authenticateStudent() {
    session_start();
    
    if (empty($_SESSION['studentId'])) {
        // Check for API token if session not available
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            // Verify token and get studentId (implementation depends on your auth system)
            $studentId = verifyToken($token);
            
            if (!$studentId) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                exit;
            }
            
            return $studentId;
        }
        
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    
    return $_SESSION['studentId'];
}

function verifyToken($token) {
    // Implement your token verification logic
    // This is just a placeholder
    return $token ? 1 : null; // Replace with actual verification
}
?>