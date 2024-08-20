import React from "react";
import { StyleSheet, View, Image, Text, FlatList, TouchableOpacity, Linking } from "react-native";
import MessageHeader from "./messages/MessageHeader";
import MessageText from "./messages/MessageText";
import GroupedList from "./messages/GroupList";
import CategoryList from "./messages/CategoryList";


const date = new Date();

const Message = ({ message, author, onEnter }) => {
  let authorName;
  let iconSource;  

  if (message.author === "Gemini") {
    authorName = "LuchoTest AI.G";
    iconSource = require("../assets/icons/robot.png");
  } else if (message.author === "api") {
    authorName = "LuchoTest API";
    iconSource = require("../assets/icons/robot.png");
  } else {
    authorName = message.author;
    iconSource = require("../assets/icons/user.png");
  }

  const formatTime = (time) => {
    return time < 10 ? `0${time}` : time;
  };

  return (
    <View style={styles.message}>
      <MessageHeader authorName={authorName} iconSource={iconSource} timestamp={formatTime(date.getHours()) + ':' + formatTime(date.getMinutes())} />
      <MessageText text={message.text} />
      {message.categories && message.categories.length > 0 ? (
        <CategoryList categories={message.categories} onEnter={onEnter} />
      ) : null}
      {message.group && message.values ? (
        <GroupedList values={message.values} />
      ) : null}
    </View>
  );
};


const styles = StyleSheet.create({
  message: {
    flexDirection: 'column',
    gap: 8,
    backgroundColor: '#f1f2f3',
    marginBottom: 8,
    borderRadius: 16,    
  },
});

export default Message;