document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('.bubble-background');

    const createBubble = () => {
        const bubbleEl = document.createElement('span');
        bubbleEl.className = 'bubble';
        const minSize = 10;
        const maxSize = 50;
        const size = Math.random() * (maxSize + 1 - minSize) + minSize;
        bubbleEl.style.width = `${size}px`;
        bubbleEl.style.height = `${size}px`;
        bubbleEl.style.left = Math.random() * innerWidth + 'px';
        section.appendChild(bubbleEl);

        setTimeout(() => {
            bubbleEl.remove();
        }, 8000);
    }

    let activeBubble = null;

    const stopBubble = () => {
        clearInterval(activeBubble);
    };

    const cb = (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                activeBubble = setInterval(createBubble, 300);
            } else {
                stopBubble();
            }
        })
    };

    const options = {
        rootMargin: "100px 0px"
    }

    const io = new IntersectionObserver(cb, options);
    io.POLL_INTERVAL = 100;
    io.observe(section);
});