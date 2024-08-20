import { Audio } from 'expo-av';

export const requestMicrophonePermission = async () => {
  try {
    const { granted } = await Audio.requestPermissionsAsync();
    return granted;
  } catch (error) {
    console.error('Error requesting microphone permission:', error);
    return false;
  }
};

export const startRecording = async ({ onRecordingStopped }) => {
  const recording = new Audio.Recording();

  console.log('Starting recording setup!');
  await Audio.setAudioModeAsync({
    allowsRecordingIOS: true,
    playsInSilentModeIOS: true,
  });  

  await recording.prepareToRecordAsync(Audio.RECORDING_OPTIONS_PRESET_HIGH_QUALITY);
  await recording.startAsync(); // Start recording after preparation
  console.log('Recording started!');

  recording.setOnRecordingStatusUpdate(async (status) => {
    if (status.isDoneRecording) {
      console.log('Grabación detenida');
      const audioFile = await recording.getURI(); // Obtener URI del archivo
      onRecordingStopped(audioFile); // Llamar a la función que maneja el archivo de audio
    }
  });

  return recording; // Retornar la grabación
};




export const checkWebCompatibility = () => {
  return !!(window.MediaRecorder && navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
};