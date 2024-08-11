// styles/components/actionScreenStyles.js
import { StyleSheet } from 'react-native';

const actionScreenStyles = StyleSheet.create({
    welcomeContainer: {
      backgroundColor: '#FFF5E6',
      borderRadius: 12,
      padding: 20,
      marginHorizontal: 6,
      marginVertical: 10,
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.1,
      shadowRadius: 4,
      elevation: 3,
    },
    welcomeText: {
      fontSize: 22,
      fontWeight: '700',
      color: '#2c3e50',
      textAlign: 'center',
      marginBottom: 16,
      letterSpacing: 0.5,
    },
  });

export default actionScreenStyles;