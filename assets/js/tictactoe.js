document.addEventListener('DOMContentLoaded', function(){
    const cells = document.querySelectorAll('.cell');
    const statusDiv = document.getElementById('status');
    const resetBtn = document.getElementById('reset-btn');
    const startBtn = document.getElementById('start-btn');
    const difficultySelect = document.getElementById('difficulty');

    let gameStarted = false;

    // Disable cells until game starts
    disableAllCells();

    // Start Game Button Event Listener
    startBtn.addEventListener('click', function(){
        const difficulty = difficultySelect.value;
        console.log(`Starting game with difficulty: ${difficulty}`);
        startGame(difficulty);
    });

    // Cell Click Event Listeners
    cells.forEach(cell => {
        cell.addEventListener('click', function(){
            if(this.textContent !== '' || this.classList.contains('disabled') || !gameStarted){
                console.log('Cell is already taken or game not started.');
                return;
            }
            const position = this.getAttribute('data-position');
            console.log(`Player clicked on position: ${position}`);
            makeMove(position);
        });
    });

    // Reset Game Button Event Listener
    resetBtn.addEventListener('click', function(){
        console.log('Resetting game.');
        resetGame();
    });

    // Function to Start Game
    function startGame(difficulty){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/tic-tac-toe/game_controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status === 200){
                console.log('Received response from reset_game:', this.responseText);
                try {
                    const response = JSON.parse(this.responseText);
                    console.log('Parsed response:', response);
                    if(response.status === 'reset'){
                        updateBoard(response.board);
                        statusDiv.textContent = `Player ${response.current_player}'s turn`;
                        gameStarted = true;
                        enableAllCells();
                    } else {
                        console.error('Unexpected response status:', response.status);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('Failed to reset game. Status:', this.status);
            }
        }
        xhr.onerror = function(){
            console.error('Request error during reset_game.');
        }
        xhr.send(`action=reset_game&difficulty=${difficulty}`);
    }

    // Function to Make a Move
    function makeMove(position){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/tic-tac-toe/game_controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status === 200){
                console.log('Received response from make_move:', this.responseText);
                try {
                    const response = JSON.parse(this.responseText);
                    console.log('Parsed response:', response);
                    if(response.status === 'error'){
                        alert(response.message);
                    } else {
                        updateBoard(response.board);
                        if(response.status === 'win'){
                            statusDiv.textContent = `Player ${response.winner} wins!`;
                            gameStarted = false;
                            disableAllCells();
                        } else if(response.status === 'draw'){
                            statusDiv.textContent = `It's a draw!`;
                            gameStarted = false;
                            disableAllCells();
                        } else if(response.status === 'continue'){
                            statusDiv.textContent = `Player ${response.current_player}'s turn`;
                        } else {
                            console.error('Unexpected response status:', response.status);
                        }
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('Failed to make move. Status:', this.status);
            }
        }
        xhr.onerror = function(){
            console.error('Request error during make_move.');
        }
        xhr.send(`action=make_move&position=${position}`);
    }

    // Function to Reset Game
    function resetGame(){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/tic-tac-toe/game_controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status === 200){
                console.log('Received response from reset_game (reset):', this.responseText);
                try {
                    const response = JSON.parse(this.responseText);
                    console.log('Parsed response:', response);
                    if(response.status === 'reset'){
                        updateBoard(response.board);
                        statusDiv.textContent = `Player ${response.current_player}'s turn`;
                        gameStarted = false;
                        disableAllCells();
                    } else {
                        console.error('Unexpected response status:', response.status);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('Failed to reset game. Status:', this.status);
            }
        }
        xhr.onerror = function(){
            console.error('Request error during reset_game.');
        }
        xhr.send(`action=reset_game`);
    }

    // Function to Update the Board UI
    function updateBoard(board){
        console.log('Updating board with:', board);
        cells.forEach(cell => {
            const pos = cell.getAttribute('data-position');
            cell.textContent = board[pos];
            if(board[pos] !== ''){
                cell.classList.add('disabled');
            } else {
                cell.classList.remove('disabled');
            }
        });
    }

    // Function to Disable All Cells
    function disableAllCells(){
        cells.forEach(cell => {
            cell.classList.add('disabled');
            cell.textContent = '';
        });
        console.log('All cells disabled.');
    }

    // Function to Enable All Cells
    function enableAllCells(){
        cells.forEach(cell => {
            if(cell.textContent === ''){
                cell.classList.remove('disabled');
            }
        });
        console.log('All cells enabled.');
    }
});

console.log("RetroPlay Hub Scripts Loaded");