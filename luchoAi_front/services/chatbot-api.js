import { getGeminiResponse } from "../components/response";

const sendText = async (inputText, city, setListData) => {
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

  if (!response.ok) {
    throw new Error(`HTTP error! Status: ${response.status}`);
  }

  const result = await response.json();
  console.log("sendText:", result);

  if (result.message && result.found === true) {
    setListData((prevList) => [...prevList,
      { text: `${result.message}`, author: 'api', prompt: inputText}
    ]);
  } else {
    const apiGemini = await getGeminiResponse(inputText);

    if (apiGemini) {
      setListData(prevList => [...prevList, { 
        text: apiGemini, 
        author: 'Gemini',
        prompt: inputText
      }]);
    }     
  }    
};

const sendAudioToWhisper = async (audioBlob, city, setListData) => {
  const formData = new FormData();

  formData.append('audio', audioBlob);
  formData.append('city', city);

  try {
    const response = await fetch('http://localhost:8000/api/whisper', {
      method: 'POST',
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const transcription = await response.json();

    console.log('File uploaded successfully:', transcription);

    if (transcription.message && transcription.found === true) {
      setListData((prevList) => [...prevList,
        { text: `${transcription.message}`, author: 'user', prompt: transcription.message},
        { text: `${transcription.message}`, author: 'api', prompt: transcription.message}
      ]);
    } else {
        const apiGemini = await getGeminiResponse(transcription.message);
    
        if (apiGemini) {
          setListData(prevList => [...prevList, 
            { 
              text: transcription.message, 
              author: 'user',
              prompt: transcription.message
            },
            { 
            text: apiGemini, 
            author: 'Gemini',
            prompt: transcription.message
          }
        ]);
        }     
     }    
  } catch (error) {
    console.error('Error uploading the file:', error);
  }
};

export { sendText, sendAudioToWhisper };