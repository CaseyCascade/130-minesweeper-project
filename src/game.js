import {Grid} from './grid.js';

var numMines; 
var clearGrid;
var autoFirstMove; 
var boardSize; 
var style; 
var theme; 

function getInitParameters()
{
    alert("yuh");
    const params = new URLSearchParams(window.location.search);
    // Extract the variables
    numMines = params.get("numMines");
    clearGrid = params.get("clearGrid") === "true"; // Convert to boolean
    autoFirstMove = params.get("autoFirstMove") === "true"; // Convert to boolean
    boardSize = params.get("boardSize");
    style = params.get("style");
    theme = params.get("theme");
}

export function setInitParameters()
{
    numMines = document.getElementById("num_mines").value; 
    clearGrid = document.getElementById("win_condition").value; 
    autoFirstMove = document.getElementById("auto_first_move").checked;
    boardSize = document.getElementById("board_size").value; 
    style = document.getElementById("style").value;
    theme = document.getElementById("theme").value; 

    const queryString = `game.php?numMines=${encodeURIComponent(numMines)}&clearGrid=${encodeURIComponent(clearGrid)}&autoFirstMove=${encodeURIComponent(autoFirstMove)}&boardSize=${encodeURIComponent(boardSize)}&style=${encodeURIComponent(style)}&theme=${encodeURIComponent(theme)}`;

    window.location.href = queryString; 
}

document.addEventListener('DOMContentLoaded', () => {
    getInitParameters();
    console.log("Number of Mines:", numMines);
    console.log("Clear Grid:", clearGrid);
    console.log("Auto First Move:", autoFirstMove);
    console.log("Board Size:", boardSize);
    console.log("Style:", style);
    console.log("Theme:", theme);

    let grid; 
    if (boardSize == "small") grid = new Grid(8,8);
    else if (boardSize == "medium") grid = new Grid(16,16);
    else if (boardSize == "large") grid = new Grid(16,30);
    else console.log("Error: boardSize not set"); 
    grid.initializeGrid();        
    grid.placeMines(numMines);          
    grid.render(document.body);  
    alert("huh");
});

window.setInitParameters = setInitParameters;