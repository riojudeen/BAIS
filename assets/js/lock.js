
var autoLockTimer;
        // window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer; // catches touchscreen presses
        window.onclick = resetTimer;     // catches touchpad clicks
        window.onscroll = resetTimer;    // catches scrolling with arrow keys
        window.onkeypress = resetTimer;
 
        function lockScreen() {
            window.location.href = 'http://localhost/BAIS/auth/lock.php';
        }
 
        function resetTimer() {
            clearTimeout(autoLockTimer);
            autoLockTimer = setTimeout(lockScreen, 10000);  // time is in milliseconds
        }

