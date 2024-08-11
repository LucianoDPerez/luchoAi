import React, { useState, useEffect } from 'react';
import { StyleSheet, View, Image, Text } from 'react-native';
import { GoogleGenerativeAI } from '@google/generative-ai';
import Markdown from 'react-native-markdown-display';
import Message from './message';

const date = new Date();
const API_KEY = "AIzaSyBKnyteMxy6lmekr9IAy5x4aUqj-3InWLE";
const genAI = new GoogleGenerativeAI(API_KEY);


const getGeminiResponse = async (prompt) => {
	try {  
	  const model = genAI.getGenerativeModel({ model: "gemini-pro" });  
	  const result = await model.generateContent(prompt);  
	  const response = await result.response;  
	  const text = await response.text();	  

	  return text;  
	} catch (error) {  
	  console.error(error);  
	  return null;  
	}  
  };

export { getGeminiResponse };  