    </main>
    
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 <?php echo SITE_NAME; ?>. Все права защищены.</p>
            <p>Кемеровский Кооперативный Техникум</p>
        </div>
    </footer>
    
    <script>
    (function() {
        // Cursor glow
        const glow = document.getElementById('cursorGlow');
        if (glow) {
            document.addEventListener('mousemove', function(e) {
                glow.style.left = e.clientX + 'px';
                glow.style.top = e.clientY + 'px';
            });
            
            document.addEventListener('mouseleave', function() {
                glow.style.left = '-200px';
                glow.style.top = '-200px';
            });
        }
        
        // Arc sun glares animation
        const container = document.getElementById('arcGlareContainer');
        if (container) {
            const sizes = [180, 140, 100, 70, 50];
            let glareIndex = 0;
            
            function createGlare() {
                const glare = document.createElement('div');
                glare.className = 'arc-glare';
                const size = sizes[glareIndex % sizes.length];
                glare.style.width = size + 'px';
                glare.style.height = size + 'px';
                container.appendChild(glare);
                glareIndex++;
                
                let progress = -0.2;
                const speed = 0.004;
                const screenW = window.innerWidth;
                const y = 20 + Math.random() * 150;
                
                let lastTime = performance.now();
                
                function animate(currentTime) {
                    const delta = currentTime - lastTime;
                    lastTime = currentTime;
                    
                    progress += speed * (delta / 16);
                    
                    if (progress > 1.2) {
                        if (glare.parentNode) container.removeChild(glare);
                        return;
                    }
                    
                    const x = progress * screenW;
                    
                    glare.style.left = x + 'px';
                    glare.style.top = y + 'px';
                    glare.style.opacity = Math.sin(progress * Math.PI) * 0.7;
                    
                    requestAnimationFrame(animate);
                }
                
                requestAnimationFrame(animate);
            }
            
            setInterval(createGlare, 1200);
            
            for (let i = 0; i < 3; i++) {
                setTimeout(createGlare, i * 400);
            }
        }
    })();
    </script>
</body>
</html>
