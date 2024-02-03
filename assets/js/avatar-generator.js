document.addEventListener('DOMContentLoaded', function () {
    var avatarContainers = document.querySelectorAll('.avatar-container');

    avatarContainers.forEach(function (avatarContainer) {
        var initials = avatarContainer.getAttribute('data-initials') || '';
        var width = avatarContainer.getAttribute('data-width') || '40px';
        var backgroundColor = avatarContainer.getAttribute('data-color');

        new Avatar(avatarContainer, initials, width, backgroundColor);
    });
});

class Avatar {
    constructor(container, initials, width = '40px', backgroundColor) {
        this.container = container;
        this.initials = initials;
        this.width = width;
        this.backgroundColor = backgroundColor;
        this.createAvatar();
    }

    createAvatar() {
        var avatarElement = document.createElement('span');
        avatarElement.classList.add('avatar');
        avatarElement.style.width = this.width;
        avatarElement.style.height = this.width;

        if (this.width > '38px') {
            var fontSize = Math.max(parseInt(this.width) / 2.5, 12);
        }else if(this.width > '100px'){
            var fontSize = Math.max(parseInt(this.width) / 2, 12);
        } else {
            var fontSize = Math.min(parseInt(this.width) / 2, 12);
        }

        avatarElement.style.fontSize = fontSize + 'px';

        avatarElement.textContent = this.initials.toUpperCase();

        if (this.backgroundColor) {
            avatarElement.style.backgroundColor = this.backgroundColor;
        } else {
            // Generate a random color (excluding white)
            var randomColor = getRandomColor();
            avatarElement.style.backgroundColor = randomColor;
        }

        this.container.appendChild(avatarElement);
    }
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    do {
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
    } while (color === '#FFFFFF'); // Avoid white color

    return color;
}
