// connect-the-dots.js

document.addEventListener('DOMContentLoaded', function(){
    const startBtn = document.getElementById('start-btn');
    const resetBtn = document.getElementById('reset-btn');
    const difficultySelect = document.getElementById('difficulty');
    const gridSizeSelect = document.getElementById('grid-size');
    const gameBoard = document.getElementById('game-board');
    const statusDiv = document.getElementById('status');

    let gridSize = '4x4';
    let difficulty = 'easy';
    let userTurn = true;
    let gameActive = false;
    let userScore = 0;
    let aiScore = 0;
    let totalBoxes = 0;

    // Store lines and boxes
    let lines = [];
    let boxes = [];

    // Event Listeners
    startBtn.addEventListener('click', startGame);
    resetBtn.addEventListener('click', resetGame);

    // Function to Start Game
    function startGame(){
        if(gameActive){
            alert('Game is already in progress. Please reset to start a new game.');
            return;
        }

        difficulty = difficultySelect.value;
        gridSize = gridSizeSelect.value;
        userScore = 0;
        aiScore = 0;
        statusDiv.textContent = "Your turn";
        gameActive = true;

        renderBoard(gridSize);
    }

    // Function to Reset Game
    function resetGame(){
        gameActive = false;
        userTurn = true;
        userScore = 0;
        aiScore = 0;
        statusDiv.textContent = "Select difficulty and grid size to start the game.";
        gameBoard.innerHTML = '';
        lines = [];
        boxes = [];
        totalBoxes = 0;
    }

    // Function to Render Game Board
    function renderBoard(size){
        gameBoard.innerHTML = '';
        lines = [];
        boxes = [];
        userScore = 0;
        aiScore = 0;

        const [rows, cols] = size.split('x').map(Number);
        const boardSize = 400; // in pixels
        const dotSpacing = boardSize / (rows + 1);
        const lineThickness = 5; // in pixels
        const boxSize = dotSpacing;

        // Set game board size
        gameBoard.style.width = `${boardSize}px`;
        gameBoard.style.height = `${boardSize}px`;

        // Create Dots
        for(let r = 1; r <= rows; r++){
            for(let c = 1; c <= cols; c++){
                const dot = document.createElement('div');
                dot.classList.add('dot');
                dot.style.top = `${r * dotSpacing - (dot.offsetHeight / 2)}px`;
                dot.style.left = `${c * dotSpacing - (dot.offsetWidth / 2)}px`;
                gameBoard.appendChild(dot);
            }
        }

        // Create Lines (Horizontal and Vertical)
        for(let r = 1; r <= rows; r++){
            for(let c = 1; c <= cols; c++){
                // Horizontal Line
                if(c < cols){
                    const hLine = document.createElement('div');
                    hLine.classList.add('line', 'horizontal');
                    hLine.dataset.row = r;
                    hLine.dataset.col = c;
                    hLine.style.top = `${r * dotSpacing}px`;
                    hLine.style.left = `${c * dotSpacing}px`;
                    hLine.style.width = `${dotSpacing - lineThickness}px`;
                    hLine.style.height = `${lineThickness}px`;
                    hLine.addEventListener('click', () => claimLine(hLine, 'horizontal'));
                    gameBoard.appendChild(hLine);
                    lines.push(hLine);
                }

                // Vertical Line
                if(r < rows){
                    const vLine = document.createElement('div');
                    vLine.classList.add('line', 'vertical');
                    vLine.dataset.row = r;
                    vLine.dataset.col = c;
                    vLine.style.top = `${r * dotSpacing}px`;
                    vLine.style.left = `${c * dotSpacing}px`;
                    vLine.style.width = `${lineThickness}px`;
                    vLine.style.height = `${dotSpacing - lineThickness}px`;
                    vLine.addEventListener('click', () => claimLine(vLine, 'vertical'));
                    gameBoard.appendChild(vLine);
                    lines.push(vLine);
                }
            }
        }

        // Create Boxes
        for(let r = 1; r < rows; r++){
            for(let c = 1; c < cols; c++){
                const box = document.createElement('div');
                box.classList.add('box');
                box.dataset.row = r;
                box.dataset.col = c;
                box.style.top = `${r * dotSpacing}px`;
                box.style.left = `${c * dotSpacing}px`;
                box.style.width = `${boxSize}px`;
                box.style.height = `${boxSize}px`;
                gameBoard.appendChild(box);
                boxes.push(box);
                totalBoxes++;
            }
        }
    }

    // Function to Claim a Line
    function claimLine(lineElement, type){
        if(!gameActive){
            alert('Please start a new game first.');
            return;
        }

        if(lineElement.classList.contains('active')){
            alert('This line has already been taken.');
            return;
        }

        if(!userTurn){
            alert("It's not your turn.");
            return;
        }

        // User claims the line
        lineElement.classList.add('active', 'user');
        lineElement.removeEventListener('click', () => claimLine(lineElement, type));

        // Check if any box is completed
        const completedBoxes = checkCompletedBoxes(lineElement, 'user');

        if(completedBoxes.length > 0){
            userScore += completedBoxes.length;
            statusDiv.textContent = `You completed ${completedBoxes.length} box(es)! Your turn.`;
        }
        else{
            userTurn = false;
            statusDiv.textContent = "AI's turn.";
            // AI makes a move after a short delay
            setTimeout(aiMove, 500);
        }

        // Check for Game Over
        if(checkGameOver()){
            return;
        }
    }

    // Function to AI Make a Move
    function aiMove(){
        if(!gameActive){
            return;
        }

        // Simple AI Logic based on difficulty
        let aiMoveLine;

        if(difficulty === 'easy'){
            aiMoveLine = getRandomAvailableLine();
        }
        else if(difficulty === 'medium'){
            // Medium AI tries to block user's potential box completion
            aiMoveLine = getBlockingLine();
            if(!aiMoveLine){
                aiMoveLine = getRandomAvailableLine();
            }
        }
        else if(difficulty === 'hard'){
            // Hard AI uses a more strategic approach
            aiMoveLine = getBestMove();
            if(!aiMoveLine){
                aiMoveLine = getRandomAvailableLine();
            }
        }

        if(aiMoveLine){
            aiMoveLine.classList.add('active', 'ai');
            aiMoveLine.removeEventListener('click', () => claimLine(aiMoveLine, aiMoveLine.classList.contains('horizontal') ? 'horizontal' : 'vertical'));

            // Check if any box is completed
            const completedBoxes = checkCompletedBoxes(aiMoveLine, 'ai');

            if(completedBoxes.length > 0){
                aiScore += completedBoxes.length;
                statusDiv.textContent = `AI completed ${completedBoxes.length} box(es)! AI's turn.`;
            }
            else{
                userTurn = true;
                statusDiv.textContent = "Your turn.";
            }

            // Check for Game Over
            checkGameOver();
        }
    }

    // Function to Get a Random Available Line (Easy AI)
    function getRandomAvailableLine(){
        const availableLines = lines.filter(line => !line.classList.contains('active'));
        if(availableLines.length === 0){
            return null;
        }
        const randomIndex = Math.floor(Math.random() * availableLines.length);
        return availableLines[randomIndex];
    }

    // Function to Get Blocking Line (Medium AI)
    function getBlockingLine(){
        // AI checks for any user lines that could lead to box completion and blocks them
        for(let box of boxes){
            if(box.classList.contains('user') || box.classList.contains('ai')){
                continue;
            }
            const [r, c] = [parseInt(box.dataset.row), parseInt(box.dataset.col)];
            const surroundingLines = getSurroundingLines(r, c);
            const activeUserLines = surroundingLines.filter(line => line.classList.contains('active', 'user'));
            const availableLines = surroundingLines.filter(line => !line.classList.contains('active'));

            if(activeUserLines.length === 2 && availableLines.length === 1){
                return availableLines[0];
            }
        }
        return null;
    }

    // Function to Get Surrounding Lines for a Box
    function getSurroundingLines(r, c){
        const horizontal1 = lines.find(line => line.classList.contains('horizontal') && parseInt(line.dataset.row) === r && parseInt(line.dataset.col) === c);
        const horizontal2 = lines.find(line => line.classList.contains('horizontal') && parseInt(line.dataset.row) === r+1 && parseInt(line.dataset.col) === c);
        const vertical1 = lines.find(line => line.classList.contains('vertical') && parseInt(line.dataset.row) === r && parseInt(line.dataset.col) === c);
        const vertical2 = lines.find(line => line.classList.contains('vertical') && parseInt(line.dataset.row) === r && parseInt(line.dataset.col) === c+1);
        return [horizontal1, horizontal2, vertical1, vertical2];
    }

    // Function to Find Best Move (Hard AI)
    function getBestMove(){
        // Implement advanced AI strategies like threat detection, move prioritization, etc.
        // For simplicity, we'll use the same blocking strategy as medium
        return getBlockingLine();
    }

    // Function to Check Completed Boxes
    function checkCompletedBoxes(lineElement, player){
        const [r, c] = [parseInt(lineElement.dataset.row), parseInt(lineElement.dataset.col)];
        let completedBoxes = [];

        if(lineElement.classList.contains('horizontal')){
            // Check top box
            if(r > 1){
                const box = boxes.find(b => parseInt(b.dataset.row) === r-1 && parseInt(b.dataset.col) === c);
                if(box && !box.classList.contains('user') && !box.classList.contains('ai')){
                    const surroundingLines = getSurroundingLines(r-1, c);
                    const isCompleted = surroundingLines.every(line => line.classList.contains('active'));
                    if(isCompleted){
                        box.classList.add(player === 'user' ? 'user' : 'ai');
                        completedBoxes.push(box);
                    }
                }
            }
            // Check bottom box
            if(r < parseInt(gridSize.split('x')[0])){
                const box = boxes.find(b => parseInt(b.dataset.row) === r && parseInt(b.dataset.col) === c);
                if(box && !box.classList.contains('user') && !box.classList.contains('ai')){
                    const surroundingLines = getSurroundingLines(r, c);
                    const isCompleted = surroundingLines.every(line => line.classList.contains('active'));
                    if(isCompleted){
                        box.classList.add(player === 'user' ? 'user' : 'ai');
                        completedBoxes.push(box);
                    }
                }
            }
        }
        else if(lineElement.classList.contains('vertical')){
            // Check left box
            if(c > 1){
                const box = boxes.find(b => parseInt(b.dataset.row) === r && parseInt(b.dataset.col) === c-1);
                if(box && !box.classList.contains('user') && !box.classList.contains('ai')){
                    const surroundingLines = getSurroundingLines(r, c-1);
                    const isCompleted = surroundingLines.every(line => line.classList.contains('active'));
                    if(isCompleted){
                        box.classList.add(player === 'user' ? 'user' : 'ai');
                        completedBoxes.push(box);
                    }
                }
            }
            // Check right box
            if(c < parseInt(gridSize.split('x')[1])){
                const box = boxes.find(b => parseInt(b.dataset.row) === r && parseInt(b.dataset.col) === c);
                if(box && !box.classList.contains('user') && !box.classList.contains('ai')){
                    const surroundingLines = getSurroundingLines(r, c);
                    const isCompleted = surroundingLines.every(line => line.classList.contains('active'));
                    if(isCompleted){
                        box.classList.add(player === 'user' ? 'user' : 'ai');
                        completedBoxes.push(box);
                    }
                }
            }
        }

        return completedBoxes;
    }

    // Function to Check if Game is Over
    function checkGameOver(){
        const availableLines = lines.filter(line => !line.classList.contains('active'));
        if(availableLines.length === 0 && gameActive){
            gameActive = false;
            let resultText = '';

            if(userScore > aiScore){
                resultText = `You win! Your Score: ${userScore} | AI Score: ${aiScore}`;
            }
            else if(aiScore > userScore){
                resultText = `AI wins! Your Score: ${userScore} | AI Score: ${aiScore}`;
            }
            else{
                resultText = `It's a draw! Your Score: ${userScore} | AI Score: ${aiScore}`;
            }

            statusDiv.textContent = resultText;
            sendGameResultToBackend(resultText);
            return true;
        }
        return false;
    }

    // Function to Send Game Result to Backend
    function sendGameResultToBackend(result){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/connect-the-dots/game_controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status === 200){
                try {
                    const response = JSON.parse(this.responseText);
                    if(response.status === 'success'){
                        console.log('Game result recorded successfully.');
                    }
                    else{
                        console.error('Error recording game result:', response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            }
            else{
                console.error('Failed to send game result. Status:', this.status);
            }
        }
        xhr.onerror = function(){
            console.error('Request error while sending game result.');
        }
        // Send grid size, difficulty, user score, ai score, and result
        xhr.send(`action=record_game&grid_size=${gridSize}&difficulty=${difficulty}&user_score=${userScore}&ai_score=${aiScore}&result=${getResultType()}`);
    }

    // Helper Function to Determine Result Type
    function getResultType(){
        if(userScore > aiScore){
            return 'user';
        }
        else if(aiScore > userScore){
            return 'ai';
        }
        else{
            return 'draw';
        }
    }

});