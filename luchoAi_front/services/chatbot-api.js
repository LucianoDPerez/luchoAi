const apiUrl = 'http://192.168.0.109:8000/api';

const handleApiResponse = async (response, setListData, inputText) => {
  if (!response.ok) {
    setListData((prevList) => [...prevList, {
      text: 'Hubo un error intenta nuevamente por favor',
      author: 'api',
      prompt: 'Hubo un error intenta nuevamente por favor'
    }]); 
  }

  const apiResponse = await response.json();    
  setListData((prevList) => [...prevList, {
    text: apiResponse.prompt,    
    author: 'user',
    prompt: apiResponse.prompt
  }]); 
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
    const response = await fetch(`${apiUrl}/text`, {
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
    setListData((prevList) => [...prevList, {
      text: 'Hubo un error intenta nuevamente por favor',
      author: 'api',
      prompt: 'Hubo un error intenta nuevamente por favor'
    }]); 
  }
};

const sendAudioToWhisper = async (audioFile, city, setListData) => {
  try {
    // Crear la instancia de FormData
    const formData = new FormData();

    // Agregar el archivo de audio al FormData
    formData.append('audio', {
      uri: audioFile, // URI del archivo de audio
      type: 'audio/m4a', // Cambia esto según sea necesario
      name: 'recording.m4a' // Nombre del archivo
    });

    // Agregar otros parámetros que necesites
    formData.append('city', city);

    // Hacer una solicitud POST a tu API
    const response = await fetch(`${apiUrl}/whisper`, {
      method: 'POST',
      headers: {
        'Content-Type': 'multipart/form-data', // Este header no es necesario cuando se usa FormData, pero se puede agregar para mayor claridad
      },
      body: formData
    });

    // Verificar la respuesta
    if (!response.ok) {
      setListData((prevList) => [...prevList, {
        text: 'Hubo un error intenta nuevamente por favor',
        author: 'api',
        prompt: 'Hubo un error intenta nuevamente por favor'
      }]); 
    }

    // Llama a la función de manejo de respuesta
    await handleApiResponse(response, setListData, audioFile);
  } catch (error) {
    setListData((prevList) => [...prevList, {
      text: 'Hubo un error intenta nuevamente por favor',
      author: 'api',
      prompt: 'Hubo un error intenta nuevamente por favor'
    }]); 
  }
};

export { sendText, sendAudioToWhisper };