import React, { useState, useEffect } from "react";
import { Text, View, FlatList, Image, Alert, Platform } from "react-native";
import styles from './styles/styles';
import { getCurrentLocation, fetchCityFromLocation } from './services/location';
import { requestMicrophonePermission, startRecording, checkWebCompatibility } from './services/audio';
import Input from "./components/input";
import ActionsScreen from "./components/actions";
import Message from './components/message';
import { sendText, sendAudioToWhisper } from "./services/chatbot-api";

import { getGeminiResponse } from "./components/response";

export default function App() {
  const [listData, setListData] = useState([]);
  const [city, setCity] = useState("");
  const [isRecording, setIsRecording] = useState(false);
  const [mediaRecorder, setMediaRecorder] = useState(null);

  useEffect(() => {
    (async () => {
      try {
        const location = await getCurrentLocation();
        const { latitude, longitude } = location.coords;
        const fetchedCity = await fetchCityFromLocation(latitude, longitude);
        setCity(fetchedCity);
      } catch (error) {
        Alert.alert(error.message);
      }
    })();

    if (Platform.OS !== 'web') {
      requestMicrophonePermission().catch(console.error);
    } else {
      checkWebCompatibility();
    }
  }, []);

  const handleSubmitText = async (text) => {
    if (!city || !text.trim()) return;
    
    setListData(prevList => [...prevList, { text, author: 'user' }]);

    await sendText(text, city, setListData);   
  };

  const handleStartRecording = async () => {
    try {
      const recorder = await startRecording({
        onRecordingStopped: async (audioBlob) => {
          await sendAudioToWhisper(audioBlob, city, setListData);
        }
      });

      setMediaRecorder(recorder);
      setIsRecording(true);
    } catch (error) {
      console.error("Error starting the recording:", error);
    }
  };

  const handleStopRecording = () => {
    if (mediaRecorder) {
      mediaRecorder.stop();
      setIsRecording(false);
    }
  };

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <Image source={require("./assets/icons/robot1.png")} style={styles.icon} />
        <Text style={styles.headerText}>LuchoTest Gemini AI</Text>
      </View>

      <ActionsScreen onEnter={handleSubmitText} />

      <FlatList
        style={{ paddingHorizontal: 16, marginBottom: 80 }}
        data={listData}
        renderItem={({ item }) => (
          <View>
            <Message message={item.text} author={item.author} />
          </View>
        )}
        keyExtractor={(item, index) => index.toString()}
      />

      <Input
        onSubmit={handleSubmitText}
        onStartRecording={handleStartRecording}
        onStopRecording={handleStopRecording}
      />
    </View>
  );
}
