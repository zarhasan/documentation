class Toast {
    constructor() {
        this.message = '';
        this.duration = 3000;
        this.position = 'bottom-right';
        this.hasDismissButton = false; // Default to false
        this.dismissCallback = null;
        this.toastElement = null;
        this.timer = null;
    }

    setMessage(message) {
        if (typeof message !== 'string') {
            console.error('Toast message must be a string.');
            return this;
        }
        this.message = message;
        return this;
    }

    setDuration(duration) {
        if (typeof duration !== 'number' || duration < 0) {
            console.error('Toast duration must be a non-negative number.');
            return this;
        }
        this.duration = duration;
        return this;
    }

    setPosition(position) {
        const validPositions = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
        if (!validPositions.includes(position)) {
            console.error('Invalid toast position.');
            return this;
        }
        this.position = position;
        return this;
    }

    setDismissButton(hasDismissButton) {
        if (typeof hasDismissButton !== 'boolean') {
            console.error('Invalid value for hasDismissButton.');
            return this;
        }
        this.hasDismissButton = hasDismissButton;
        return this;
    }

    setDismissCallback(callback) {
        if (typeof callback !== 'function') {
            console.error('Dismiss callback must be a function.');
            return this;
        }
        this.dismissCallback = callback;
        return this;
    }

    show() {
        if (!this.message) {
            console.error('Toast message is missing.');
            return;
        }

        if (this.timer) {
            clearTimeout(this.timer);
        }

        if (this.toastElement) {
            document.body.removeChild(this.toastElement);
        }

        this.toastElement = document.createElement('div');
        this.toastElement.classList.add('toast', this.position);
        this.toastElement.setAttribute('role', 'alert');
        this.toastElement.setAttribute('aria-live', 'polite');

        const messageElement = document.createElement('span');
        messageElement.textContent = this.message;
        this.toastElement.appendChild(messageElement);

        if (this.hasDismissButton) {
            const dismissButton = document.createElement('button');
            dismissButton.textContent = 'Dismiss';
            dismissButton.addEventListener('click', () => {
                this.dismiss();
            });
            this.toastElement.appendChild(dismissButton);
            dismissButton.tabIndex = 0; // Allow focus on the dismiss button
        }

        document.body.appendChild(this.toastElement);

        if (this.duration > 0) {
            this.timer = setTimeout(() => {
                this.dismiss();
            }, this.duration);
        }

        if (this.hasDismissButton) {
            this.toastElement.focus(); // Move focus to the toast if it has a dismiss button
        }
    }

    dismiss() {
        if (this.timer) {
            clearTimeout(this.timer);
        }

        if (this.toastElement) {
            document.body.removeChild(this.toastElement);
            this.toastElement = null;
        }

        if (this.dismissCallback) {
            this.dismissCallback();
        }
    }
}
