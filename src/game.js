var numMines; 
var clearGrid;
var autoFirstMove; 
var boardSize; 
var style; 
var theme; 

function getInitParameters()
{
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

function createGrid(rows, columns) {
    const gridDiv = document.getElementById("grid");

    // Create a table element
    const table = document.createElement("table");
    table.style.borderCollapse = "collapse"; // Optional: for better appearance

    // Create rows and cells
    for (let i = 0; i < rows; i++) {
        const row = document.createElement("tr");
        for (let j = 0; j < columns; j++) {
            const cell = document.createElement("td");
            cell.style.border = "1px solid black"; // Optional: Add borders
            cell.style.width = "30px"; // Set cell width
            cell.style.height = "30px"; // Set cell height
            cell.textContent = ""; // Optional: Add content (like row,col index)
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    // Clear any existing content and append the table to the "grid" div
    gridDiv.innerHTML = ""; // Clear previous grid (if any)
    gridDiv.appendChild(table);
}

function initGame()
{
    getInitParameters(); 
    console.log("Number of Mines:", numMines);
    console.log("Clear Grid:", clearGrid);
    console.log("Auto First Move:", autoFirstMove);
    console.log("Board Size:", boardSize);
    console.log("Style:", style);
    console.log("Theme:", theme);

    if (boardSize == "small") createGrid(8,8);
    else if (boardSize == "medium") createGrid(16,16); 
    else if (boardSize == "large") createGrid(16,30);
    else console.log("Error: boardSize not set"); 
}

document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname === "/130-minesweeper-project/pages/game.php") {
        initGame(); 
    }
});

window.setInitParameters = setInitParameters;