import {Grid} from './grid.js';

export class Game {
    constructor(numMines, clearGrid, autoFirstMove, boardSize, style, theme) {
        this.numMines = numMines; 
        this.clearGrid = clearGrid;
        this.autoFirstMove = autoFirstMove;
        this.boardSize = boardSize; 
        this.style = style; 
        this.theme = theme;
        this.grid;
        this.timerInterval;
        this.secondsElapsed = 0;
        this.start(); 
    }

    start()
    {
        if (this.boardSize == "small") this.grid = new Grid(8, 8, this);
        else if (this.boardSize == "medium") this.grid = new Grid(16, 16, this);
        else if (this.boardSize == "large") this.grid = new Grid(16, 30, this);
        else {
            console.error("Error: Invalid boardSize value");
            return;
        }
        console.log("Grid created with size:", this.grid.rows, "x", this.grid.cols);
        this.grid.initializeGrid();        
        console.log("Grid initialized");
        this.grid.placeMines(this.numMines);
        console.log("Mines placed");
        const gameContainer = document.getElementById("gameContainer");
        if (!gameContainer) {
            console.error("Error: #gameContainer element not found");
            return;
        }
        this.grid.render(gameContainer);  
        console.log("Grid rendered to #gameContainer");
        this.updateInfoPanel();
        if (this.autoFirstMove)
        {
            this.grid.autoFirstMove(); 
        }
        this.startTimer();
    }

    checkForWinCondition()
    {
        this.grid.cells.forEach((row) => { // Loop through each row
            row.forEach((cell) => { // Loop through each cell in the row
                if (cell.isMine) {
                    if (!cell.isFlagged) return false; 
                }
                else {
                    if (this.clearGrid){
                        if (!cell.isRevealed) return false;
                    }
                }
                return true; 
            });
        });
    }
    
    gameOver()
    {
        this.grid.revealGrid();
        this.stopTimer(); 
        // TODO Needs additional gameover logic later 
    }
    update()
    {
        this.updateInfoPanel(); 
        if (this.checkForWinCondition()) this.stopTimer(); //TODO Additional victory screen logic
    }

    updateInfoPanel()
    {
        let infoPanel = document.getElementById("infoPanel"); 
        infoPanel.textContent = `Mines: ${this.numMines - this.grid.numFlags}`;
    }

    updateTimerDisplay() {
        const minutes = Math.floor(this.secondsElapsed / 60);
        const seconds = this.secondsElapsed % 60;
        const timerElement = document.getElementById("timer");
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    startTimer() {
        if (!this.timerInterval) {
            this.timerInterval = setInterval(() => {
                this.secondsElapsed++;
                this.updateTimerDisplay();
            }, 1000);
        }
    }

    // Function to stop the timer
    stopTimer() {
        clearInterval(this.timerInterval);
        this.timerInterval = null;
    }
}
    
// Globals
var game; 

function getInitParameters(game)
{
    const params = new URLSearchParams(window.location.search);
    // Extract the variables
    let numMines = parseInt(params.get("numMines"));
    let clearGrid = params.get("clearGrid") === "true"; // Convert to boolean
    let autoFirstMove = params.get("autoFirstMove") === "true"; // Convert to boolean
    let boardSize = params.get("boardSize");
    let style = params.get("style");
    let theme = params.get("theme");
    game = new Game(numMines, clearGrid, autoFirstMove, boardSize, style, theme); 
}

export function setInitParameters()
{
    let numMines = document.getElementById("num_mines").value; 
    let clearGrid = document.getElementById("win_condition").value; 
    let autoFirstMove = document.getElementById("auto_first_move").checked;
    let boardSize = document.getElementById("board_size").value; 
    let style = document.getElementById("style").value;
    let theme = document.getElementById("theme").value; 

    const queryString = `game.php?numMines=${encodeURIComponent(numMines)}&clearGrid=${encodeURIComponent(clearGrid)}&autoFirstMove=${encodeURIComponent(autoFirstMove)}&boardSize=${encodeURIComponent(boardSize)}&style=${encodeURIComponent(style)}&theme=${encodeURIComponent(theme)}`;

    window.location.href = queryString; 
}

function initializeGame()
{
    getInitParameters(game);
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname === '/130-minesweeper-project/pages/game.php') {
        initializeGame(); 
    } else {
        console.log("Current path:", window.location.pathname);
    }
});

function process()
{
    if (game) game.updateTimerDisplay(); 
}

process(); 

window.setInitParameters = setInitParameters;