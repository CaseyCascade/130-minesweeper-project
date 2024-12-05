const DEBUG_MODE = true;
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
    
        cellElement.addEventListener('click', () => {
            this.reveal();
            this.grid.game.update();
        });
        cellElement.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            this.toggleFlag();
            this.grid.game.update();
        });
    
        return cellElement;
    }
    
    reveal() {
        if (this.isRevealed || this.isFlagged) return;

        console.log("Cell [" + this.row + "," + this.col + "] Revealed");  
        this.isRevealed = true;
        this.element.classList.add('revealed');

        if (this.isMine) {
             this.grid.game.endGame(false); //Game Over   
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
            this.grid.numFlags--;
        } 
        else 
        {
            console.log("numFlags: " + this.grid.numFlags);
            console.log("numMines: " + this.grid.game.numMines);
            if (this.grid.numFlags >= this.grid.game.numMines) return; 
            this.grid.numFlags++;
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
