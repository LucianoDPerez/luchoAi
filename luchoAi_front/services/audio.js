import { Audio } from 'expo-av';

export const requestMicrophonePermission = async () => {
  const { granted } = await Audio.requestPermissionsAsync();
  if (!granted) {
    throw new Error('Permission to access microphone was denied');
  }
};

export const startRecording = async ({ onRecordingStopped }) => {
  const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
  const mediaRecorder = new MediaRecorder(stream);
  const audioChunks = [];

  mediaRecorder.ondataavailable = (event) => {
    audioChunks.push(event.data);
  };

  mediaRecorder.onstop = () => {
    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
    onRecordingStopped(audioBlob);
  };

  mediaRecorder.start();
  return mediaRecorder;
};

export const checkWebCompatibility = async () => {
  if (!('MediaRecorder' in window) || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    Alert.alert("El navegador no es compatible con la grabación de audio.");
  }
};
