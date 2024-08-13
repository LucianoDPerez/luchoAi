import React from "react";
import { StyleSheet, View, Image, Text, FlatList, TouchableOpacity, Linking } from "react-native";

const date = new Date();

export default function Message({ message, author, onEnter }) {
  let authorName;
  let iconSource;

  console.log('author es... ' + author);

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
      <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between" }}>
        <View style={{ flexDirection: "row", alignItems: "center", gap: 8 }}>
          <Image source={iconSource} style={styles.icon} />
          <Text style={{ fontWeight: 500, color: 'black' }}>{authorName}</Text>
        </View>
        <Text style={{ fontSize: 10, fontWeight: 600 }}>
          {formatTime(date.getHours())}:{formatTime(date.getMinutes())}
        </Text>
      </View>
      <Text style={{ fontSize: 14, width: "100%", flex: 1, paddingLeft: 0 }}>{message.text}</Text>
      {message.categories && message.categories.length > 0 ? (
        <View>
          <Text style={{ fontSize: 16, fontWeight: 600, marginBottom: 8 }}>
            Escoge una opcion
          </Text>
          <FlatList
            data={message.categories}
            renderItem={({ item }) => (
				<TouchableOpacity 
				style={{
					flex: 1, 				
					marginRight: 6, 				
					flexDirection: 'column', 				
					alignItems: 'center', 				
					justifyContent: 'center', 				
					borderWidth: 1, 				
					backgroundColor: '#34C759',				
					borderColor: '#0569FF', 				
					borderRadius: 8, 				
					marginBottom: 8,				
					height: 40		
				  }}
					onPress={() => {                     
            onEnter(item.url); 
          }}>
				<View>		  
				  <Text style={{ fontSize: 14, color: 'black' }}>		  
					{item.name}		  
				  </Text>		  
				</View>		
			  </TouchableOpacity>
            )}
            keyExtractor={(item, index) => index.toString()}
          />
        </View>
      ) : null}
    </View>
  );
}

const styles = StyleSheet.create({
  message: {
    flexDirection: "column",
    gap: 8,
    backgroundColor: "#f1f2f3",
    marginBottom: 8,
    //padding: 16,
    borderRadius: 16,
  },
  icon: {
    width: 28,
    height: 28,
  },
});