import React, { useState } from 'react';
import { View, TextInput, TouchableOpacity, Image, TouchableWithoutFeedback } from 'react-native';
import styles from '../styles/styles';

const Input = ({ onSubmit, onStartRecording, onStopRecording }) => {
  const [inputText, setInputText] = useState("");

  return (
    <View style={styles.searchBar}>
      <TextInput
        placeholder="En que te ayudo?"
        style={styles.input}
        value={inputText}
        onChangeText={setInputText}
        onKeyPress={(e) => {
          if (e.nativeEvent.key === 'Enter') {      
            console.log('Estoy enviando desde input... ' + inputText)      
            onSubmit(inputText);   
            setInputText('')         
          }
        }}
      />
      <TouchableOpacity onPress={(e) => {
        onSubmit(inputText);
        setInputText('');
        }}>
          <Image source={require("../assets/icons/right-arrow.png")} style={styles.icon} />
      </TouchableOpacity>
      <TouchableWithoutFeedback
        onLongPress={onStartRecording}
        onPressOut={onStopRecording}>
        <View style={styles.recordButton}>
          <Image source={require("../assets/icons/microphone.png")} style={styles.icon} />
        </View>
      </TouchableWithoutFeedback>
    </View>
  );
};

export default Input;
