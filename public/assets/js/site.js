var loaderHtml = `
	<div id="scifi-door-loader">
		<div class="door-panel left">
			<div class="circuit-line top"></div>
			<div class="circuit-line bottom"></div>
		</div>
		<div class="door-panel right">
			<div class="circuit-line top"></div>
			<div class="circuit-line bottom"></div>
		</div>
		<div class="circuit-line vertical"></div>
		<div class="central-lock">
			<div class="lock-outer-ring"></div>
			<div class="lock-middle-ring"></div>
			<div class="lock-inner-core d-flex align-items-center justify-content-center rounded-circle shadow-lg" style="box-shadow: 0 0 30px 10px #10b981, 0 0 60px 20px #3b82f6;">
				<img src="public/assets/img/logo.png" alt="Logo" class="lock-logo rounded-circle border border-3 border-info shadow" style="box-shadow: 0 0 30px 10px #10b981, 0 0 60px 20px #3b82f6; animation: logoTwinkle 0.8s infinite alternate;">
			</div>
			<style>
			@keyframes logoTwinkle {
				0% {
					filter: drop-shadow(0 0 10px #10b981) brightness(1);
				}
				50% {
					filter: drop-shadow(0 0 30px #3b82f6) brightness(1.3);
				}
				100% {
					filter: drop-shadow(0 0 10px #10b981) brightness(1);
				}
			}
			</style>
		</div>
		<div class="status-display">
			<div class="status-title">IPOP SECURITY SYSTEM</div>
			<div class="status-subtitle">Cron System Made by PoPi</div>
			<div class="loading-text">INITIALIZING...</div>
			<div class="progress-container">
				<div class="progress-bar-container">
					<div class="progress-bar" id="scifi-progress-bar" style="width: 0%;"></div>
				</div>
				<div class="progress-percent" id="scifi-progress-text">0%</div>
			</div>
		</div>
	</div>
`;

document.addEventListener('DOMContentLoaded', function() {
	if (!document.getElementById('scifi-door-loader')) {
		document.body.insertAdjacentHTML('afterbegin', loaderHtml);
	}

	// Initialize loader after it is inserted into DOM
	scifiLoader = new SciFiLoader();
	scifiLoader.start();
});

class SciFiLoader {
    constructor() {
        this.progressBar = document.getElementById('scifi-progress-bar');
        this.progressText = document.getElementById('scifi-progress-text');
        this.loadingText = document.querySelector('.loading-text');
        this.centralLock = document.querySelector('.central-lock');
        this.progress = 0;
        this.loadingSteps = [
            'INITIALIZING...',
            'SCANNING CREDENTIALS...',
            'VERIFYING ACCESS...',
            'LOADING MODULES...',
            'ESTABLISHING CONNECTION...',
            'ACCESS GRANTED'
        ];
        this.currentStep = 0;
        this.progressInterval = null;
    }

    start() {
        this.progressInterval = setInterval(() => {
            this.updateProgress();
        }, 200);
    }

     updateProgress() {
        this.progress += Math.random() * 18 + 8; // tăng tốc độ progress
        if (this.progress > 100) this.progress = 100;

        if (this.progressBar) {
            this.progressBar.style.width = this.progress + '%';
        }
        if (this.progressText) {
            this.progressText.textContent = Math.round(this.progress) + '%';
        }

        // Update loading text based on progress
        const stepIndex = Math.floor((this.progress / 100) * (this.loadingSteps.length - 1));
        if (stepIndex !== this.currentStep && stepIndex < this.loadingSteps.length) {
            this.currentStep = stepIndex;
            if (this.loadingText) {
                this.loadingText.textContent = this.loadingSteps[stepIndex];
            }
        }

        if (this.progress >= 100) {
            clearInterval(this.progressInterval);
            this.unlock();
        }
    }

    unlock() {
        // Add unlock animation
        if (this.centralLock) {
            this.centralLock.classList.add('unlocked');
        }
        if (this.loadingText) {
            this.loadingText.textContent = 'ACCESS GRANTED';
            this.loadingText.style.color = '#10b981';
        }

        setTimeout(() => {
            this.openDoors();
        }, 800);
    }

    openDoors() {
        const doorLeft = document.querySelector('.door-panel.left');
        const doorRight = document.querySelector('.door-panel.right');

        if (doorLeft) doorLeft.classList.add('open');
        if (doorRight) doorRight.classList.add('open');

        setTimeout(() => {
            const loader = document.getElementById('scifi-door-loader');
            if (loader) {
                loader.classList.add('hidden');
                loader.style.display = 'none';
            }
        }, 1500);
    }

    hide() {
        const loader = document.getElementById('scifi-door-loader');
        if (loader) {
            loader.classList.add('hidden');
            loader.style.display = 'none';
        }
    }
}

// Initialize loader
let scifiLoader;

// Hide loader when page is fully loaded
window.addEventListener('load', function() {
    setTimeout(() => {
        if (scifiLoader) {
            // Force complete if not already
            if (scifiLoader.progress < 100) {
                scifiLoader.progress = 100;
                scifiLoader.unlock();
            }
        }
    }, 1500); // Minimum loading time for better UX
});

// Handle navigation
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        const loader = document.getElementById('scifi-door-loader');
        if (loader) {
            loader.classList.add('hidden');
            loader.style.display = 'none';
        }
    }
});

// Show loader when navigating to new pages
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"])').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if(e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
            if(link.hasAttribute('download') || link.dataset.noLoader !== undefined) return;
            
            const loader = document.getElementById('scifi-door-loader');
            if(loader) {
                loader.classList.remove('hidden');
                loader.style.display = 'flex';
                
                // Reset doors
                const doorLeft = document.querySelector('.door-panel.left');
                const doorRight = document.querySelector('.door-panel.right');
                const centralLock = document.querySelector('.central-lock');
                const loadingText = document.querySelector('.loading-text');
                
                if (doorLeft) doorLeft.classList.remove('open');
                if (doorRight) doorRight.classList.remove('open');
                if (centralLock) centralLock.classList.remove('unlocked');
                if (loadingText) {
                    loadingText.textContent = 'INITIALIZING...';
                    loadingText.style.color = '#3b82f6';
                }
                
                // Reset progress
                const progressBar = document.getElementById('scifi-progress-bar');
                const progressText = document.getElementById('scifi-progress-text');
                if (progressBar) progressBar.style.width = '0%';
                if (progressText) progressText.textContent = '0%';
                
                // Start new loader instance
                scifiLoader = new SciFiLoader();
                scifiLoader.start();
            }
        });
    });
});