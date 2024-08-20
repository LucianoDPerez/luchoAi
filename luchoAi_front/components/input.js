import React, { useState, useEffect } from 'react';
import { View, TextInput, TouchableOpacity, Image, TouchableWithoutFeedback, Animated } from 'react-native';
import styles from '../styles/styles';

import { Audio } from 'expo-av';

const Input = ({ onSubmit, onStartRecording, onStopRecording }) => {
  const [inputText, setInputText] = useState("");
  const scaleAnim = new Animated.Value(1); 

  const [sound, setSound] = useState(null);

  //const pressSound = new Sound(); // Crear instancia de Sound solo una vez

  useEffect(() => {
    async function loadSound() {
      const sound = new Audio.Sound();
      await sound.loadAsync(require('../assets/sounds/press.mp3'));
      setSound(sound);
    }
    loadSound();
  }, []);

  const playPressSound = async () => {
    if (sound) {
      await sound.playAsync();
    }
  };
  

  const handlePressIn = () => {
    Animated.spring(scaleAnim, {
      toValue: 0.8, // escala al 80% al presionar
      useNativeDriver: true,
    }).start();
  };
        
  return (
    <View style={styles.searchBar}>
      <TextInput
        placeholder="En que te ayudo?"
        style={styles.input}
        value={inputText}
        onChangeText={setInputText}w
        onKeyPress={(e) => {
          if (e.nativeEvent.key === 'Enter') {      
            console.log('Estoy enviando desde input... ' + inputText);      
            onSubmit(inputText);   
            setInputText('');         
          }
        }} />
      <TouchableOpacity onPress={() => {
        onSubmit(inputText);
        setInputText('');
      }}>
        <Image source={require("../assets/icons/right-arrow.png")} style={styles.icon} />
      </TouchableOpacity>
      
      {/* Grabación de audio */}
      <TouchableWithoutFeedback
        onPressIn={() => {
          playPressSound();
          handlePressIn();
        }}
        onLongPress={onStartRecording} // Iniciar grabación al mantener presionado
        onPressOut={onStopRecording} // Detener grabación al soltar
      >
        <View style={styles.recordButton}>
          <Animated.View style={[styles.recordButton, { transform: [{ scale: scaleAnim }] }]}>
            <Image source={require("../assets/icons/microphone.png")} style={styles.icon} />
          </Animated.View>
        </View>
      </TouchableWithoutFeedback>
    </View>
  );
};

export default Input;