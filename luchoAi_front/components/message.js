import React from "react";
import { StyleSheet, View, Image, Text } from "react-native";

const date = new Date();

export default function Message({ message, author }) {
	let authorName;
	let iconSource;
  
	if (author === "Gemini") {
	  authorName = "LuchoTest AI.G";
	  iconSource = require("../assets/icons/robot.png");
	} else if (author === "api") {
		authorName = "LuchoTest API";
	  	iconSource = require("../assets/icons/robot.png");
	} else {
	  authorName = author;
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
			<Text style={{ fontWeight: 500 }}>{authorName}</Text>
		  </View>
		  <Text style={{ fontSize: 10, fontWeight: 600 }}>
		  	{formatTime(date.getHours())}:{formatTime(date.getMinutes())}
		  </Text>
		</View>
		<Text style={{ fontSize: 14, width: "100%", flex: 1, paddingLeft: 0 }}>{message}</Text>
	  </View>
	);
  }

const styles = StyleSheet.create({
	message: {
		flexDirection: "column",
		gap: 8,
		backgroundColor: "#f1f2f3",
		marginBottom: 8,
		padding: 16,
		borderRadius: 16,
	},
	icon: {
		width: 28,
		height: 28,
	},
});
