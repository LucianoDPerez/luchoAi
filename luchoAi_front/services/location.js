import * as Location from 'expo-location';

export const getCurrentLocation = async () => {
  let { status } = await Location.requestForegroundPermissionsAsync();
  if (status !== 'granted') {
    throw new Error('Permission to access location was denied');
  }

  let location = await Location.getCurrentPositionAsync({});
  return location;
};

export const fetchCityFromLocation = async (latitude, longitude) => {
  const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`);
  const data = await response.json();
  const city = data.address.town;
  const state = data.address.state;
  const country_code = data.address.country_code;
  return `${city}, ${state}, ${country_code}`;
};
