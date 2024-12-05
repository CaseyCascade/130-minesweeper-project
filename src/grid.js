import {Cell} from './cell.js'; 

export class Grid {
    constructor(rows, cols) {
        this.rows = rows;
        this.cols = cols;
        this.cells = []; // 2D array to store Cell instances
        this.container = this.createContainer(); // DOM container for the grid
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

    // Initialize the grid with Cell instances
    initializeGrid() {
        for (let r = 0; r < this.rows; r++) {
            const row = [];
            for (let c = 0; c < this.cols; c++) {
                const cell = new Cell(r, c);
                console.log(`Creating cell at (${r}, ${c})`);
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
            }
        }
    }
}
