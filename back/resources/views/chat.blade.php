<!-- chat.blade.php -->

<div class="chat-input-container">
    <input type="text" id="chat-input" placeholder="Type a message...">
    <button id="send-button">Send</button>
    <button id="record-button">Record</button>
</div>

<div class="chat-output-container">
    <p id="chat-output"></p>
</div>

<script>
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const recordButton = document.getElementById('record-button');
    const chatOutput = document.getElementById('chat-output');

    sendButton.addEventListener('click', () => {
        const userInput = chatInput.value.trim();
        if (userInput!== '') {
            // Send the user input to the server
            fetch('/test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ input: userInput })
            })
                .then(response => response.json())
                .then(data => {
                    chatOutput.innerText = data.textoRespuesta;
                })
                .catch(error => console.error(error));
        }
    });

    recordButton.addEventListener('click', () => {
        // Start recording audio from the user's microphone
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                const mediaRecorder = new MediaRecorder(stream);
                let recording = false;

                recordButton.addEventListener('click', () => {
                    if (!recording) {
                        mediaRecorder.start();
                        recording = true;
                        recordButton.innerText = 'Stop';
                    } else {
                        mediaRecorder.stop();
                        recording = false;
                        recordButton.innerText = 'Record';
                    }
                });

                mediaRecorder.onstop = () => {
                    const audioBlob = new Blob([mediaRecorder.recordedBlobs], { type: 'audio/wav' });
                    const formData = new FormData();
                    formData.append('audio', audioBlob);

                    fetch('/recordings', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            chatOutput.innerText = data.textoRespuesta;
                        })
                        .catch(error => console.error(error));
                };
            })
            .catch(error => console.error(error));
    });
</script>
