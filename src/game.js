import { Grid } from './grid.js';
import * as utils from './utils.js';

var resultPanel = document.getElementById("resultPanel");
var game;
var gameOverSound = document.getElementById('gameOverSound');
var youWinSound = document.getElementById('youWinSound');
var music = document.getElementById('music');

if (gameOverSound) gameOverSound.volume = 0.5;
if (youWinSound) youWinSound.volume = 0.5;
if (music) music.volume = 0.2;

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

    start() {
        resultPanel.innerHTML = "";
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
        console.log("Clear Grid: " + this.clearGrid);
        this.updateInfoPanel();
        if (this.autoFirstMove) {
            this.grid.autoFirstMove();
        }
        this.startTimer();
        music.play();

        // used to upload to the form

        // won (stored in saveResults) (0 | 1)
        // duration (stored in saveResults from this.timerInterval) ("hh:mm:ss")
        // startdatetime (initialized here) ("YYYY-MM-DD hh:mm:ss")
        // numturns (initialized here) (int)

        // YYYY-MM-DD hh-mm-ss
        this.results_startdatetime = utils.getCurrentDateTime();
        // int, number of turns
        this.results_numturns = 0;
    }

    saveResults(won) {

        let obj = {
            "won": won,
            "duration": utils.secondsToDuration(this.secondsElapsed),
            "startdatetime": this.results_startdatetime,
            "numturns": this.results_numturns
        };

        console.log("Won: " + obj.won);
        console.log("STD: " + obj.duration);
        console.log("DuS: " + obj.startdatetime);
        console.log("Trn: " + obj.numturns);

        let xhr = new XMLHttpRequest();

        xhr.open("POST", "../server/process.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("Server Response: ", xhr.responseText);
                // TODO: send you to the leaderboard page afterwards
            } else {
                console.error("Request failed. Status: ", xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error("Request failed");
        }

        let postData = new URLSearchParams({
            action: "finishgame",
            won: obj.won,
            duration: obj.duration,
            durationsec: this.secondsElapsed,
            startdatetime: obj.startdatetime,
            numturns: obj.numturns
        }).toString();

        xhr.send(postData);

    }

    checkForWinCondition() {
        for (const row of this.grid.cells) { // Loop through each row
            for (const cell of row) { // Loop through each cell in the row
                if (!this.clearGrid) { // Clear Mines Condition
                    if (cell.isMine && !cell.isFlagged) {
                        console.log("There are mines left without flags");
                        return false; // Return false if any mine is not flagged
                    }
                } else { // Clear Grid Condition
                    if (!cell.isMine && !cell.isRevealed) {
                        console.log("Clear Grid Condition not met");
                        return false; // Return false if any non-mine cell is not revealed
                    }
                }
            }
        }
        return true; // If all conditions are met, return true
    }



    endGame(win_condition_met) {
        this.saveResults(win_condition_met ? 1 : 0);
        music.pause();
        this.grid.revealGrid();
        this.stopTimer();
        let message;
        if (win_condition_met) {
            message = "YOU WIN!!!";
            youWinSound.play();
        }
        else {
            message = "GAME OVER...";
            gameOverSound.play();
        }
        const textNode = document.createTextNode(message);
        resultPanel.appendChild(textNode);

        resultPanel.style.color = win_condition_met ? "green" : "red";
    }

    update() {
        this.updateInfoPanel();
        this.results_numturns++;
        if (this.checkForWinCondition()) this.endGame(true); // Game ends here or in cell when a mine is hit
    }

    updateInfoPanel() {
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

function getInitParameters(game) {
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

export function setInitParameters() {
    let numMines = document.getElementById("num_mines").value;

    let clearGrid;
    if (document.getElementById("win_condition").value == "clear_grid") clearGrid = true;
    else clearGrid = false;

    let autoFirstMove = document.getElementById("auto_first_move").checked;
    let boardSize = document.getElementById("board_size").value;
    let style = document.getElementById("style").value;
    let theme = document.getElementById("theme").value;

    const queryString = `game.php?numMines=${encodeURIComponent(numMines)}&clearGrid=${encodeURIComponent(clearGrid)}&autoFirstMove=${encodeURIComponent(autoFirstMove)}&boardSize=${encodeURIComponent(boardSize)}&style=${encodeURIComponent(style)}&theme=${encodeURIComponent(theme)}`;

    window.location.href = queryString;
}

function initializeGame() {
    getInitParameters(game);
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname === '/130-minesweeper-project/pages/game.php') {
        initializeGame();
    } else {
        console.log("Current path:", window.location.pathname);
    }
});

function process() {
    if (game) game.updateTimerDisplay();
}

process();

window.setInitParameters = setInitParameters;