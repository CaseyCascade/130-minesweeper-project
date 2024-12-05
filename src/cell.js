export class Cell {
    constructor(row, col) {
        this.row = row;
        this.col = col;
        this.isMine = false;
        this.isRevealed = false;
        this.isFlagged = false;
        this.adjacentMines = 0;
        this.element = this.createElement();
    }

    createElement() {
        const cellElement = document.createElement('div');
        cellElement.className = 'cell';
        cellElement.addEventListener('click', () => this.reveal());
        cellElement.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            this.toggleFlag();
        });
        return cellElement;
    }

    reveal() {
        if (this.isRevealed || this.isFlagged) return;

        this.isRevealed = true;
        this.element.classList.add('revealed');

        if (this.isMine) {
            this.element.classList.add('mine');
            alert("Game Over!");
        } else if (this.adjacentMines > 0) {
            this.element.textContent = this.adjacentMines;
        } else {
            this.element.textContent = '';
        }
    }

    toggleFlag() {
        if (this.isRevealed) return;

        this.isFlagged = !this.isFlagged;
        this.element.classList.toggle('flag', this.isFlagged);
    }

    setMine() {
        this.isMine = true; 
    }

    incrementAdjacentMines() {
        this.adjacentMines++;
    }
}
