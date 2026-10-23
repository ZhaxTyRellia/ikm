const Keyboard = {
    multiMode: true,
    selectedElement: null,
    elements: {
        main: null,
        keysContainer: null,
        keys: []
    },
    properties: {
        value: "",
        capsLock: false
    },
    eventHandlers: {
        oninput: null,
        onclose: null
    },

    init() {
        this.elements.main = document.createElement("div");
        this.elements.keysContainer = document.createElement("div");

        this.elements.main.classList.add("keyboard", "keyboard--hidden");
        this.elements.keysContainer.classList.add("keyboard__keys");

        if (!this.multiMode) {
            this._setupKeyboard("alfa");
        }

        this.elements.keys = this.elements.keysContainer.querySelectorAll(".keyboard__key");
        this.elements.main.appendChild(this.elements.keysContainer);
        document.body.appendChild(this.elements.main);

        document.addEventListener("click", (event) => {
            const target = event.target;
            if (target.matches('input[type="number"]')) {
                this._bindInput(target, "numeric");
            } else if (
                target.matches('input[type="email"], input[type="text"], input[type="password"], input.p-input--bonus')
            ) {
                this._bindInput(target, "alfa");
            }
        }, true);
    },

    _bindInput(target, mode) {
        this._setupKeyboard(mode);
        this.selectedElement = target;
        this.open(target.value, (currentValue) => {
            target.value = currentValue;
        });
    },

    _setupKeyboard(type) {
        this.elements.keysContainer.innerHTML = "";
        this.elements.keysContainer.appendChild(this._createKeys(type));
        this.elements.keys = this.elements.keysContainer.querySelectorAll(".keyboard__key");
    },

    _createKeys(keyboardType) {
        const fragment = document.createDocumentFragment();
        const keyLayout = keyboardType === "numeric"
            ? ["7", "8", "9", "br", "4", "5", "6", "br", "1", "2", "3", "br", "0", "backspace", "done"]
            : [
                "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
                "q", "w", "e", "r", "t", "y", "u", "i", "o", "p",
                "caps", "a", "s", "d", "f", "g", "h", "j", "k", "l", "enter",
                "z", "x", "c", "v", "b", "n", "m", ",", ".", "?", "done",
                "space"
            ];

        const iconMap = {
            backspace: "&#9003;",
            caps: "&#8682;",
            enter: "&#8629;",
            space: "&#9251;",
            done: "&#10003;"
        };

        keyLayout.forEach((key) => {
            const keyElement = document.createElement("button");
            const insertLineBreak = ["backspace", "p", "enter", "?", "br"].includes(key);

            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard__key");

            switch (key) {
                case "backspace":
                    keyElement.classList.add("backspace-btn");
                    keyElement.innerHTML = `<span class="keyboard-icon">${iconMap.backspace}</span>`;
                    keyElement.addEventListener("click", () => {
                        this.properties.value = this.properties.value.slice(0, -1);
                        this._triggerEvent("oninput");
                    });
                    break;

                case "caps":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--activatable");
                    keyElement.innerHTML = `<span class="keyboard-icon">${iconMap.caps}</span>`;
                    keyElement.addEventListener("click", () => {
                        this._toggleCapsLock();
                        keyElement.classList.toggle("keyboard__key--active", this.properties.capsLock);
                    });
                    break;

                case "enter":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = `<span class="keyboard-icon">${iconMap.enter}</span>`;
                    keyElement.addEventListener("click", () => {
                        this.properties.value += "\n";
                        this._triggerEvent("oninput");
                    });
                    break;

                case "space":
                    keyElement.classList.add("keyboard__key--extra-wide");
                    keyElement.innerHTML = `<span class="keyboard-icon">${iconMap.space}</span>`;
                    keyElement.addEventListener("click", () => {
                        this.properties.value += " ";
                        this._triggerEvent("oninput");
                    });
                    break;

                case "done":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--dark");
                    keyElement.innerHTML = `<span class="keyboard-icon">${iconMap.done}</span>`;
                    keyElement.addEventListener("click", () => {
                        this.close();
                        this._triggerEvent("onclose");
                    });
                    break;

                case "br":
                    keyElement.classList.add("hide-me");
                    break;

                default:
                    keyElement.textContent = key.toLowerCase();
                    keyElement.addEventListener("click", () => {
                        this.properties.value += this.properties.capsLock ? key.toUpperCase() : key.toLowerCase();
                        this._triggerEvent("oninput");
                        this._fireKeyEvent();
                    });
                    break;
            }

            fragment.appendChild(keyElement);

            if (insertLineBreak) {
                fragment.appendChild(document.createElement("br"));
            }
        });

        return fragment;
    },

    _fireKeyEvent() {
        if (!this.selectedElement) return;
        this.selectedElement.dispatchEvent(new KeyboardEvent("input", {
            bubbles: true,
            cancelable: true,
            view: window
        }));
    },

    _triggerEvent(handlerName) {
        if (typeof this.eventHandlers[handlerName] === "function") {
            this.eventHandlers[handlerName](this.properties.value);
        }
    },

    _toggleCapsLock() {
        this.properties.capsLock = !this.properties.capsLock;
        for (const key of this.elements.keys) {
            if (key.childElementCount === 0) {
                key.textContent = this.properties.capsLock
                    ? key.textContent.toUpperCase()
                    : key.textContent.toLowerCase();
            }
        }
    },

    open(initialValue, oninput, onclose) {
        this.properties.value = initialValue || "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;
        this.elements.main.classList.remove("keyboard--hidden");
    },

    close() {
        this.properties.value = "";
        this.eventHandlers.oninput = null;
        this.eventHandlers.onclose = null;
        this.elements.main.classList.add("keyboard--hidden");
    }
};

window.addEventListener("DOMContentLoaded", () => Keyboard.init());
