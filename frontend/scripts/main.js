document.addEventListener('DOMContentLoaded', () => {


    // =========================================
    // 1. ENDLOS-CAROUSELS
    // =========================================

    document.querySelectorAll('[data-project-carousel]').forEach((carousel) => {

        const track = carousel.querySelector('[data-carousel-track]');
        const prevButton = carousel.querySelector('[data-carousel-prev]');
        const nextButton = carousel.querySelector('[data-carousel-next]');

        if (!track) return;

        const originalCards = Array.from(
            track.querySelectorAll(':scope > .project-card')
        );

        if (originalCards.length <= 1) return;

        let setWidth = 0;
        let isReady = false;

        const getGap = () => {
            const styles = window.getComputedStyle(track);
            return parseFloat(styles.columnGap) || 0;
        };

        const calculateSetWidth = () => {

            const gap = getGap();

            const cardsWidth = originalCards.reduce((total, card) => {
                return total + card.getBoundingClientRect().width;
            }, 0);

            return cardsWidth + gap * originalCards.length;

        };


        // Zwei zusätzliche Kopien vor und nach den Originalkarten

        const addClones = () => {

            const firstCard = originalCards[0];

            const beforeFragment = document.createDocumentFragment();

            for (let copy = 0; copy < 2; copy++) {

                originalCards.forEach((card) => {

                    const clone = card.cloneNode(true);
                    clone.setAttribute('data-carousel-clone', 'true');

                    beforeFragment.appendChild(clone);

                });

            }

            track.insertBefore(beforeFragment, firstCard);


            const afterFragment = document.createDocumentFragment();

            for (let copy = 0; copy < 2; copy++) {

                originalCards.forEach((card) => {

                    const clone = card.cloneNode(true);
                    clone.setAttribute('data-carousel-clone', 'true');

                    afterFragment.appendChild(clone);

                });

            }

            track.appendChild(afterFragment);

        };


        // Carousel in der mittleren Kopie starten

        const initialiseCarousel = () => {

            setWidth = calculateSetWidth();

            if (!setWidth) return;

            track.style.scrollBehavior = 'auto';
            track.scrollLeft = setWidth * 2;
            track.style.scrollBehavior = '';

            isReady = true;

        };


        addClones();


        // Warten, bis die Bilder geladen und die Karten vermessen sind

        if (document.fonts && document.fonts.ready) {

            document.fonts.ready.then(() => {
                initialiseCarousel();
            });

        } else {

            initialiseCarousel();

        }


        // Bei Scrollbewegungen unauffällig zurücksetzen

        let scrollLocked = false;

        track.addEventListener('scroll', () => {

            if (!isReady || scrollLocked) return;

            const currentPosition = track.scrollLeft;

            if (currentPosition < setWidth) {

                scrollLocked = true;

                track.style.scrollBehavior = 'auto';
                track.scrollLeft = currentPosition + setWidth;
                track.style.scrollBehavior = '';

                scrollLocked = false;

            } else if (currentPosition > setWidth * 3) {

                scrollLocked = true;

                track.style.scrollBehavior = 'auto';
                track.scrollLeft = currentPosition - setWidth;
                track.style.scrollBehavior = '';

                scrollLocked = false;

            }

        });


        // Kartenabstand für die Pfeile berechnen

        const getScrollAmount = () => {

            const card = originalCards[0];

            if (!card) return 300;

            return card.getBoundingClientRect().width + getGap();

        };


        // Nach links scrollen

        if (prevButton) {

            prevButton.addEventListener('click', () => {

                track.scrollBy({
                    left: -getScrollAmount(),
                    behavior: 'smooth'
                });

            });

        }


        // Nach rechts scrollen

        if (nextButton) {

            nextButton.addEventListener('click', () => {

                track.scrollBy({
                    left: getScrollAmount(),
                    behavior: 'smooth'
                });

            });

        }


        // Bei einer Fenstergrössenänderung neu positionieren

        let resizeTimeout;

        window.addEventListener('resize', () => {

            clearTimeout(resizeTimeout);

            resizeTimeout = setTimeout(() => {

                const oldWidth = setWidth;

                setWidth = calculateSetWidth();

                if (oldWidth && setWidth) {

                    track.style.scrollBehavior = 'auto';
                    track.scrollLeft = setWidth * 2;
                    track.style.scrollBehavior = '';

                }

            }, 150);

        });

    });



    // =========================================
    // 2. YOUTUBE-VIDEO-ID ERMITTELN
    // =========================================

    const getYouTubeId = (url) => {

        try {

            const parsedUrl = new URL(url);

            const hostname = parsedUrl.hostname.replace(/^www\./, '');

            if (hostname === 'youtu.be') {

                return parsedUrl.pathname.split('/').filter(Boolean)[0] || null;

            }

            if (
                hostname === 'youtube.com' ||
                hostname === 'm.youtube.com' ||
                hostname === 'youtube-nocookie.com'
            ) {

                if (parsedUrl.pathname === '/watch') {
                    return parsedUrl.searchParams.get('v');
                }

                const pathParts = parsedUrl.pathname.split('/').filter(Boolean);

                if (
                    ['embed', 'shorts', 'live'].includes(pathParts[0]) &&
                    pathParts[1]
                ) {
                    return pathParts[1];
                }

            }

        } catch (error) {

            console.error('Ungültiger YouTube-Link:', error);

        }

        return null;

    };



    // =========================================
    // 3. VIDEO ERST BEIM KLICK LADEN
    // =========================================

    document.addEventListener('click', (event) => {

        const playButton = event.target.closest('[data-project-video-play]');

        if (!playButton) return;

        const placeholder = playButton.closest(
            '.project-modal-video-placeholder'
        );

        if (!placeholder) return;

        // Verhindern, dass das Video mehrfach geladen wird

        if (placeholder.querySelector('iframe')) return;

        const youtubeUrl = playButton.dataset.youtubeUrl;
        const videoId = getYouTubeId(youtubeUrl);

        if (!videoId) {

            console.error('Die YouTube-URL konnte nicht erkannt werden.');
            return;

        }

        const iframe = document.createElement('iframe');

        iframe.src =
            'https://www.youtube-nocookie.com/embed/' +
            encodeURIComponent(videoId) +
            '?autoplay=1&rel=0&playsinline=1';

        iframe.title = 'YouTube-Video';

        iframe.allow =
            'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';

        iframe.allowFullscreen = true;

        iframe.referrerPolicy = 'strict-origin-when-cross-origin';

        iframe.className = 'project-video-iframe';

        placeholder.appendChild(iframe);

        playButton.hidden = true;

    });



    // =========================================
    // 4. PROJEKT-POP-UPS ÖFFNEN
    // =========================================

    document.addEventListener('click', (event) => {

        const button = event.target.closest('[data-project-modal-open]');

        if (!button) return;

        const modalId = button.dataset.projectModalOpen;
        const modal = document.getElementById(modalId);

        if (!modal) return;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');

        document.body.classList.add('project-modal-open');

        const closeButton = modal.querySelector('.project-modal-close');

        if (closeButton) {
            closeButton.focus();
        }

    });



    // =========================================
    // 5. VIDEO STOPPEN
    // =========================================

    const stopProjectVideo = (modal) => {

        const placeholders = modal.querySelectorAll(
            '.project-modal-video-placeholder'
        );

        placeholders.forEach((placeholder) => {

            const iframe = placeholder.querySelector('iframe');
            const playButton = placeholder.querySelector(
                '[data-project-video-play]'
            );

            if (iframe) {
                iframe.remove();
            }

            if (playButton) {
                playButton.hidden = false;
            }

        });

    };



    // =========================================
    // 6. PROJEKT-POP-UPS SCHLIESSEN
    // =========================================

    const closeProjectModal = (modal) => {

        if (!modal) return;

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');

        document.body.classList.remove('project-modal-open');

        // Laufendes Video stoppen

        stopProjectVideo(modal);

    };


    document.addEventListener('click', (event) => {

        const closeButton = event.target.closest(
            '[data-project-modal-close]'
        );

        if (!closeButton) return;

        const modal = closeButton.closest('[data-project-modal]');

        closeProjectModal(modal);

    });



    // =========================================
    // 7. POP-UP MIT ESCAPE SCHLIESSEN
    // =========================================

    document.addEventListener('keydown', (event) => {

        if (event.key !== 'Escape') return;

        const openModal = document.querySelector('.project-modal.is-open');

        if (!openModal) return;

        closeProjectModal(openModal);

    });

});