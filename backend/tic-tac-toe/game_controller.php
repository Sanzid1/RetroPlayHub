<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

     // backend/tic-tac-toe/game_controller.php
     session_start();
     include '../config/database.php';

     header('Content-Type: application/json');

     // Check if user is logged in
     if(!isset($_SESSION['user_id'])){
         echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
         exit();
     }

     // Initialize game state if not already set
     if(!isset($_SESSION['tic_tac_toe'])){
         $_SESSION['tic_tac_toe'] = [
             'board' => ['', '', '', '', '', '', '', '', ''],
             'current_player' => 'X', // 'X' or 'O'
             'winner' => null,
             'game_over' => false,
             'difficulty' => 'easy' // Default difficulty
         ];
     }

     // Handle incoming AJAX requests
     if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $action = isset($_POST['action']) ? $_POST['action'] : '';

         switch($action){
             case 'make_move':
                 $position = isset($_POST['position']) ? intval($_POST['position']) : -1;
                 makeMove($position);
                 break;

             case 'reset_game':
                 $difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : 'easy';
                 resetGame($difficulty);
                 break;

             case 'set_difficulty':
                 $difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : 'easy';
                 setDifficulty($difficulty);
                 break;

             default:
                 echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                 break;
         }
     }

     // Function to make a move
     function makeMove($position){
         if($_SESSION['tic_tac_toe']['game_over']){
             echo json_encode(['status' => 'error', 'message' => 'Game is already over']);
             return;
         }

         if($position < 0 || $position > 8){
             echo json_encode(['status' => 'error', 'message' => 'Invalid position']);
             return;
         }

         if($_SESSION['tic_tac_toe']['board'][$position] !== ''){
             echo json_encode(['status' => 'error', 'message' => 'Position already taken']);
             return;
         }

         // Make the move
         $_SESSION['tic_tac_toe']['board'][$position] = $_SESSION['tic_tac_toe']['current_player'];

         // Check for a winner
         $winner = checkWinner();

         if($winner){
             $_SESSION['tic_tac_toe']['winner'] = $winner;
             $_SESSION['tic_tac_toe']['game_over'] = true;
             recordGame($winner);
             echo json_encode(['status' => 'win', 'winner' => $winner, 'board' => $_SESSION['tic_tac_toe']['board']]);
             return;
         }

         // Check for a draw
         if(!in_array('', $_SESSION['tic_tac_toe']['board'])){
             $_SESSION['tic_tac_toe']['game_over'] = true;
             recordGame('Draw');
             echo json_encode(['status' => 'draw', 'board' => $_SESSION['tic_tac_toe']['board']]);
             return;
         }

         // Switch player
         $_SESSION['tic_tac_toe']['current_player'] = ($_SESSION['tic_tac_toe']['current_player'] === 'X') ? 'O' : 'X';

         // If AI's turn, make AI move
         if($_SESSION['tic_tac_toe']['current_player'] === 'O'){
             aiMove($_SESSION['tic_tac_toe']['difficulty']);
         }

         echo json_encode(['status' => 'continue', 'board' => $_SESSION['tic_tac_toe']['board'], 'current_player' => $_SESSION['tic_tac_toe']['current_player']]);
     }

     // Function to reset the game
     function resetGame($difficulty){
         $_SESSION['tic_tac_toe'] = [
             'board' => ['', '', '', '', '', '', '', '', ''],
             'current_player' => 'X',
             'winner' => null,
             'game_over' => false,
             'difficulty' => $difficulty
         ];
         echo json_encode(['status' => 'reset', 'board' => $_SESSION['tic_tac_toe']['board'], 'current_player' => 'X']);
     }

     // Function to set difficulty
     function setDifficulty($difficulty){
         $allowed = ['easy', 'medium', 'hard'];
         if(in_array($difficulty, $allowed)){
             $_SESSION['tic_tac_toe']['difficulty'] = $difficulty;
             echo json_encode(['status' => 'success', 'message' => 'Difficulty set to ' . ucfirst($difficulty)]);
         } else {
             echo json_encode(['status' => 'error', 'message' => 'Invalid difficulty level']);
         }
     }

     // Function to check for a winner
     function checkWinner(){
         $board = $_SESSION['tic_tac_toe']['board'];
         $winning_combinations = [
             [0,1,2],
             [3,4,5],
             [6,7,8],
             [0,3,6],
             [1,4,7],
             [2,5,8],
             [0,4,8],
             [2,4,6]
         ];

         foreach($winning_combinations as $combo){
             if($board[$combo[0]] !== '' && $board[$combo[0]] === $board[$combo[1]] && $board[$combo[1]] === $board[$combo[2]]){
                 return $board[$combo[0]];
             }
         }

         return null;
     }

     // Function to make AI move
     function aiMove($difficulty){
         // Simple AI: Choose the first available spot
         $board = $_SESSION['tic_tac_toe']['board'];
         $available = [];
         for($i=0; $i<9; $i++){
             if($board[$i] === ''){
                 $available[] = $i;
             }
         }

         if(empty($available)){
             echo json_encode(['status' => 'draw', 'board' => $board]);
             return;
         }

         if($difficulty === 'easy'){
             // Random move
             $move = $available[array_rand($available)];
         } elseif($difficulty === 'medium'){
             // Simple strategy: block player's winning move
             $move = findBlockingMove($board);
             if($move === null){
                 $move = $available[array_rand($available)];
             }
         } elseif($difficulty === 'hard'){
             // Implement Minimax algorithm for optimal moves
             $move = findBestMove($board);
             if($move === null){
                 $move = $available[array_rand($available)];
             }
         } else {
             // Default to easy
             $move = $available[array_rand($available)];
         }

         // Make the move
         $_SESSION['tic_tac_toe']['board'][$move] = 'O';

         // Check for a winner after AI move
         $winner = checkWinner();
         if($winner){
             $_SESSION['tic_tac_toe']['winner'] = $winner;
             $_SESSION['tic_tac_toe']['game_over'] = true;
             recordGame($winner);
             echo json_encode(['status' => 'win', 'winner' => $winner, 'board' => $_SESSION['tic_tac_toe']['board']]);
             return;
         }

         // Check for a draw
         if(!in_array('', $_SESSION['tic_tac_toe']['board'])){
             $_SESSION['tic_tac_toe']['game_over'] = true;
             recordGame('Draw');
             echo json_encode(['status' => 'draw', 'board' => $_SESSION['tic_tac_toe']['board']]);
             return;
         }

         // Switch back to player
         $_SESSION['tic_tac_toe']['current_player'] = 'X';

         echo json_encode(['status' => 'continue', 'board' => $_SESSION['tic_tac_toe']['board'], 'current_player' => 'X']);
     }

     // Function to find blocking move
     function findBlockingMove($board){
         $winning_combinations = [
             [0,1,2],
             [3,4,5],
             [6,7,8],
             [0,3,6],
             [1,4,7],
             [2,5,8],
             [0,4,8],
             [2,4,6]
         ];

         foreach($winning_combinations as $combo){
             $count_X = 0;
             $count_O = 0;
             $empty = -1;
             foreach($combo as $pos){
                 if($board[$pos] === 'X') $count_X++;
                 if($board[$pos] === 'O') $count_O++;
                 if($board[$pos] === ''){
                     $empty = $pos;
                 }
             }
             if($count_X === 2 && $empty !== -1){
                 return $empty;
             }
         }

         return null;
     }

     // Function to find the best move using Minimax
     function findBestMove($board){
         $bestScore = -INF;
         $bestMove = null;

         for($i=0; $i<9; $i++){
             if($board[$i] === ''){
                 $board[$i] = 'O';
                 $score = minimax($board, 0, false);
                 $board[$i] = '';
                 if($score > $bestScore){
                     $bestScore = $score;
                     $bestMove = $i;
                 }
             }
         }

         return $bestMove;
     }

     // Minimax algorithm
     function minimax($board, $depth, $isMaximizing){
         $winner = checkWinner();
         if($winner === 'O') return 10 - $depth;
         if($winner === 'X') return $depth - 10;
         if(!in_array('', $board)) return 0;

         if($isMaximizing){
             $bestScore = -INF;
             for($i=0; $i<9; $i++){
                 if($board[$i] === ''){
                     $board[$i] = 'O';
                     $score = minimax($board, $depth + 1, false);
                     $board[$i] = '';
                     $bestScore = max($score, $bestScore);
                 }
             }
             return $bestScore;
         } else {
             $bestScore = INF;
             for($i=0; $i<9; $i++){
                 if($board[$i] === ''){
                     $board[$i] = 'X';
                     $score = minimax($board, $depth + 1, true);
                     $board[$i] = '';
                     $bestScore = min($score, $bestScore);
                 }
             }
             return $bestScore;
         }
     }

     // Function to record the game outcome in the database
     function recordGame($result){
         global $link; // Declare $link as global to access the database connection

         $user_id = $_SESSION['user_id'];
         $game_type = 'TicTacToe';
         $score = ($result === 'X') ? 1 : (($result === 'O') ? 0 : 0.5); // Example scoring
         $date = date('Y-m-d H:i:s');

         // Prepared statement for game_history
         $stmt = $link->prepare("INSERT INTO game_history (user_id, game_type, result, date) VALUES (?, ?, ?, ?)");
         if($stmt){
             $stmt->bind_param("isss", $user_id, $game_type, $result, $date);
             $stmt->execute();
             $stmt->close();
         } else {
             // Handle statement preparation error
             error_log("Failed to prepare statement for game_history: " . $link->error);
         }

         // Prepared statement for scores
         $stmt = $link->prepare("INSERT INTO scores (user_id, game_type, score, date) VALUES (?, ?, ?, ?)");
         if($stmt){
             $stmt->bind_param("isds", $user_id, $game_type, $score, $date);
             $stmt->execute();
             $stmt->close();
         } else {
             // Handle statement preparation error
             error_log("Failed to prepare statement for scores: " . $link->error);
         }
     }
     ?>