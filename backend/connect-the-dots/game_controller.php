<?php
// backend/connect-the-dots/game_controller.php

// Disable error display for production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();
include '../config/database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Handle incoming AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'record_game':
            $grid_size = isset($_POST['grid_size']) ? $_POST['grid_size'] : '';
            $difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : '';
            $user_score = isset($_POST['user_score']) ? intval($_POST['user_score']) : 0;
            $ai_score = isset($_POST['ai_score']) ? intval($_POST['ai_score']) : 0;
            $result = isset($_POST['result']) ? $_POST['result'] : '';
            recordGame($grid_size, $difficulty, $user_score, $ai_score, $result);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            exit();
    }
}

// Function to Record Game Result
function recordGame($grid_size, $difficulty, $user_score, $ai_score, $result){
    global $link; // Access the database connection

    // Validate inputs
    $valid_grid_sizes = ['4x4', '8x8', '16x16'];
    $valid_difficulties = ['easy', 'medium', 'hard'];
    $valid_results = ['user', 'ai', 'draw'];

    if(!in_array($grid_size, $valid_grid_sizes) ||
       !in_array($difficulty, $valid_difficulties) ||
       !in_array($result, $valid_results)){
           echo json_encode(['status' => 'error', 'message' => 'Invalid input parameters']);
           exit();
    }

    $user_id = $_SESSION['user_id'];

    // Insert into game_history_connect_the_dots
    $stmt = $link->prepare("INSERT INTO game_history_connect_the_dots (user_id, grid_size, difficulty, user_score, ai_score, result) VALUES (?, ?, ?, ?, ?, ?)");
    if($stmt){
        $stmt->bind_param("issiis", $user_id, $grid_size, $difficulty, $user_score, $ai_score, $result);
        if($stmt->execute()){
            // Update scores_connect_the_dots
            updateScores($user_id, $result);
            echo json_encode(['status' => 'success']);
        }
        else{
            error_log("Failed to execute game history insert: " . $stmt->error);
            echo json_encode(['status' => 'error', 'message' => 'Failed to record game history']);
        }
        $stmt->close();
    }
    else{
        error_log("Failed to prepare game history insert statement: " . $link->error);
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare game history statement']);
    }

    exit();
}

// Function to Update Scores
function updateScores($user_id, $result){
    global $link;

    // Check if user already has a score entry
    $stmt = $link->prepare("SELECT id, total_user_score, total_ai_score, total_draws FROM scores_connect_the_dots WHERE user_id = ?");
    if($stmt){
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($id, $total_user_score, $total_ai_score, $total_draws);
        if($stmt->fetch()){
            // Update existing scores
            $stmt->close();

            if($result === 'user'){
                $total_user_score += 1;
            }
            elseif($result === 'ai'){
                $total_ai_score += 1;
            }
            elseif($result === 'draw'){
                $total_draws += 1;
            }

            $update_stmt = $link->prepare("UPDATE scores_connect_the_dots SET total_user_score = ?, total_ai_score = ?, total_draws = ?, date_updated = NOW() WHERE id = ?");
            if($update_stmt){
                $update_stmt->bind_param("iiii", $total_user_score, $total_ai_score, $total_draws, $id);
                $update_stmt->execute();
                $update_stmt->close();
            }
            else{
                error_log("Failed to prepare scores update statement: " . $link->error);
            }
        }
        else{
            // Insert new scores entry
            $stmt->close();

            $total_user_score = ($result === 'user') ? 1 : 0;
            $total_ai_score = ($result === 'ai') ? 1 : 0;
            $total_draws = ($result === 'draw') ? 1 : 0;

            $insert_stmt = $link->prepare("INSERT INTO scores_connect_the_dots (user_id, total_user_score, total_ai_score, total_draws) VALUES (?, ?, ?, ?)");
            if($insert_stmt){
                $insert_stmt->bind_param("iiii", $user_id, $total_user_score, $total_ai_score, $total_draws);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            else{
                error_log("Failed to prepare scores insert statement: " . $link->error);
            }
        }
    }
    else{
        error_log("Failed to prepare scores select statement: " . $link->error);
    }
}