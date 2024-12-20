import {Cell} from './cell.js'; 

export class Grid {
    constructor(rows, cols, game) {
        this.rows = rows;
        this.cols = cols;
        this.cells = []; // 2D array to store Cell instances
        this.numFlags = 0; 
        this.container = this.createContainer(); // DOM container for the grid
        this.game = game; 
    }

    // Create the grid container
    createContainer() {
        const container = document.createElement('div');
        container.id = 'grid';
        container.style.display = 'grid';
        container.style.gridTemplateRows = `repeat(${this.rows}, 30px)`;
        container.style.gridTemplateColumns = `repeat(${this.cols}, 30px)`;
        container.style.gap = '2px'; // Space between cells
        return container;
    }

    autoFirstMove() 
    {
        let moveMade = false;
        while (!moveMade) {
            const r = Math.floor(Math.random() * this.rows);
            const c = Math.floor(Math.random() * this.cols);
            const cell = this.cells[r][c];
            if (!cell.isMine && cell.adjacentMines == 0) { 
                cell.reveal();
                moveMade = true; 
                console.log("Move Made at Cell[" + r +"," + c +"]")
            }
        }
    }

    // Initialize the grid with Cell instances
    initializeGrid() {
        for (let r = 0; r < this.rows; r++) {
            const row = [];
            for (let c = 0; c < this.cols; c++) {
                const cell = new Cell(r, c, this);
                this.container.appendChild(cell.element); // Add the cell to the grid container
                row.push(cell);
            }
            this.cells.push(row);
        }
        console.log("Grid initialized with cells:", this.cells);
    }
    

    // Append the grid to the DOM
    render(parentElement) {
        parentElement.appendChild(this.container);
    }

    revealGrid(){
        this.cells.forEach((row) => { // Loop through each row
            row.forEach((cell) => { // Loop through each cell in the row
                cell.isRevealed = true;
                cell.element.classList.add('revealed', 'disabled'); // Reveal and disable each cell
                if (cell.isMine) {
                    cell.element.classList.add('mine'); // Highlight all mines
                } else if (cell.adjacentMines > 0) {
                    cell.element.textContent = cell.adjacentMines; // Display adjacent mine count
                } else {
                    cell.element.textContent = ''; // Empty cell
                }
            });
        });
    }

    getNeighbors(row, col) {
        const neighbors = [];
        const directions = [
            [-1, -1], [-1, 0], [-1, 1], // Top-left, Top, Top-right
            [0, -1],         [0, 1],    // Left, Right
            [1, -1], [1, 0], [1, 1],    // Bottom-left, Bottom, Bottom-right
        ];
    
        directions.forEach(([dr, dc]) => {
            const neighborRow = row + dr;
            const neighborCol = col + dc;
    
            // Check if neighbor is within bounds
            if (
                neighborRow >= 0 && neighborRow < this.rows &&
                neighborCol >= 0 && neighborCol < this.cols
            ) {
                neighbors.push(this.cells[neighborRow][neighborCol]);
            }
        });
    
        return neighbors;
    }
    
    // Set mines randomly on the grid
    placeMines(numMines) {
        let minesPlaced = 0;
        while (minesPlaced < numMines) {
            const r = Math.floor(Math.random() * this.rows);
            const c = Math.floor(Math.random() * this.cols);
            const cell = this.cells[r][c];
            if (!cell.isMine) {
                cell.setMine();
                minesPlaced++;
                // Increment mine count for all neighbors
                this.getNeighbors(r, c).forEach(neighbor => {
                    neighbor.incrementAdjacentMines();
                });
            }
        }
    }
}
