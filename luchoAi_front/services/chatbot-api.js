import { group } from "console";
import { getGeminiResponse } from "../components/response";

const handleApiResponse = async (response, setListData, inputText) => {
  if (!response.ok) {
    throw new Error(`HTTP error! Status: ${response.status}`);
  }

  const apiResponse = await response.json();
  console.log("API response:", apiResponse);

    console.log('seteo ListData');
    
    setListData((prevList) => [...prevList, {
      text: apiResponse.message,
      categories: apiResponse.categories,
      group: apiResponse.group,
      values: apiResponse.values,
      author: 'api',
      prompt: inputText
    }]); 
};

const sendText = async (inputText, city, setListData) => {
  try {
    const response = await fetch("http://localhost:8000/api/text", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        'text': inputText,
        'city': city
      }),
    });

    await handleApiResponse(response, setListData, inputText);
  } catch (error) {
    console.error("Error sending text:", error);
  }
};

const sendAudioToWhisper = async (audioBlob, city, setListData) => {
  try {
    const formData = new FormData();

    formData.append('audio', audioBlob);
    formData.append('city', city);

    const response = await fetch('http://localhost:8000/api/whisper', {
      method: 'POST',
      body: formData,
    });

    await handleApiResponse(response, setListData, audioBlob);
  } catch (error) {
    console.error("Error sending audio:", error);
  }
};

export { sendText, sendAudioToWhisper };