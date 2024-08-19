import React, { useState, useEffect } from "react";
import { Text, View, FlatList, Image, Alert, Platform,SectionList } from "react-native";
import styles from './styles/styles';
import { getCurrentLocation, fetchCityFromLocation } from './services/location';
import { requestMicrophonePermission, startRecording, checkWebCompatibility } from './services/audio';
import Input from "./components/input";
import ActionsScreen from "./components/actions";

import { sendText, sendAudioToWhisper } from "./services/chatbot-api";

import Message from "./components/message";


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

  const sections = listData.reduce((acc, item) => {
    const section = acc.find((section) => section.title === item.author);
    if (!section) {
      acc.push({ title: item.author, data: [item] });
    } else {
      section.data.push(item);
    }
    return acc;
  }, []);

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <Image source={require("./assets/icons/robot1.png")} style={styles.icon} />
        <Text style={styles.headerText}>LuchoTest OpenAI</Text>
      </View>
  
      <View>
        <ActionsScreen onEnter={handleSubmitText} />
      </View>
        
      <FlatList
        style={{ flex: 1, paddingHorizontal: 16, marginBottom: 85 }}
        data={listData}
        renderItem={({ item }) => {
          if (!item) return null; // Add this check
          return <Message message={item} onEnter={handleSubmitText} />;
        }}
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