const DEBUG_MODE = false;
export class Cell {
    constructor(row, col, grid) {
        this.row = row;
        this.col = col;
        this.grid = grid//Reference to parent grid 
        this.isMine = false;
        this.isRevealed = false;
        this.isFlagged = false;
        this.adjacentMines = 0;
        this.element = this.createElement();
    }

    createElement() {
        const cellElement = document.createElement('div');
        cellElement.className = 'cell';
    
        // Show mines in debug mode
        if (DEBUG_MODE && this.isMine) {
            cellElement.classList.add('debug-mine');
        }
    
        cellElement.addEventListener('click', () => this.reveal());
        cellElement.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            this.toggleFlag();
        });
    
        return cellElement;
    }
    
    gameOver() {
        this.element.classList.add('mine'); // Highlight the current cell as a mine
        this.grid.cells.forEach((row) => { // Loop through each row
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
    
    reveal() {
        if (this.isRevealed || this.isFlagged) return;

        this.isRevealed = true;
        this.element.classList.add('revealed');

        if (this.isMine) {
             this.gameOver(); 
        } else if (this.adjacentMines > 0) {
            this.element.textContent = this.adjacentMines;
        } else {
            this.element.textContent = '';
            this.grid.getNeighbors(this.row, this.col).forEach(neighbor => {
                neighbor.reveal(); 
            });
        }
    }

    toggleFlag() {
        if (this.isRevealed) return;

        if (this.isFlagged)
        {
            this.grid.flagCount--;
        } 
        else 
        {
            this.grid.flagCount++;
        }
        this.isFlagged = !this.isFlagged;
        this.element.classList.toggle('flag', this.isFlagged);

    }

    setMine() {
        this.isMine = true; 
        if (DEBUG_MODE) {
            this.element.classList.add('debug-mine');
        }
    }
    

    incrementAdjacentMines() {
        this.adjacentMines++;
    }
}
