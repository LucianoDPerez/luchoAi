import { Audio } from 'expo-av';
import { Platform } from "react-native";


export const requestMicrophonePermission = async () => {
  try {
    // Comprobamos si estamos en la plataforma web
    if (Platform.OS !== 'web') {
      const { granted } = await Audio.requestPermissionsAsync();
      return granted;
    } else {
      // Para la web no usamos expo-av, verificamos el acceso al micrófono
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      return !!stream; // Si obtuvimos un stream, el acceso fue concedido
    }
  } catch (error) {
    console.error('Error requesting microphone permission:', error);
    return false;
  }
};

export const startRecording = async ({ onRecordingStopped }) => {
  // Comprobamos si estamos en la plataforma web
  if (Platform.OS === 'web') {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    const mediaRecorder = new MediaRecorder(stream);
    const audioChunks = [];

    mediaRecorder.ondataavailable = (event) => {
      audioChunks.push(event.data);
    };

    mediaRecorder.onstop = async () => {
      const audioBlob = new Blob(audioChunks);
      const audioFile = URL.createObjectURL(audioBlob); // Crear URL para el blob de audio
      onRecordingStopped(audioFile); // Llamar a la función que maneja el archivo de audio
    };

    mediaRecorder.start();
    console.log('Recording started in web!');

    // Devolver el mediaRecorder para poder detenerlo más tarde
    return mediaRecorder;
  } else {
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
  }
};

export const handleStopRecording = async (recorder) => {
  if (Platform.OS === 'web') {
    recorder.stop();
    console.log('Grabación detenida en web.');

    // Aquí no necesitas hacer nada porque el onstop manejará la creación de la URL
  } else {
    if (recorder) {
      await recorder.stopAndUnloadAsync();
      console.log("Grabación detenida en móvil.");
    } else {
      console.log("No hay grabación activa.");
    }
  }
};

export const checkWebCompatibility = () => {
  return !!(window.MediaRecorder && navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
};
